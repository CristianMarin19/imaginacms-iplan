<?php

namespace Modules\Iplan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;
use Route;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Core\Http\Controllers\BasePublicController;
use Mockery\CountValidator\Exception;

//Entities
use Modules\Iplan\Repositories\PlanRepository;

class PublicController extends BaseApiController
{
  private $plan;

  public function __construct(
    PlanRepository $plan
  )
  {
    parent::__construct();
    $this->plan = $plan;
  }

  // view products by category
  public function index(Request $request)
  {

    $params = $this->getParamsRequest($request);

    $tpl = 'iplan::frontend.plan.index';
    $ttpl = 'iplan.plan.index';

    if (view()->exists($ttpl)) $tpl = $ttpl;

    $plans = $this->plan->getItemsBy($params);

    //$dataRequest = $request->all();

    return view($tpl, compact('plans'));
  }

    public function buyPlan(Request $request, $planId)
    {
        $cartService = app("Modules\Icommerce\Services\CartService");

        $data = $request->all();

        $params = json_decode(json_encode(
            [
                "include" => ["product"],
                "filter" => [
                    "status" => 1
                ]
            ]
        ));
        $plan = $this->plan->getItem($planId, $params);

        $products =   [[
            "id" => $plan->product->id,
            "quantity" => 1,
            "options" => array_merge($data,["planId" => $planId])
        ]];

        if(isset($data["featured"])){
            array_push($products,[
                "id" => config("asgard.iad.config.featuredProductId"),
                "quantity" => 1,
                "options" => ["planId" => $planId]
            ]);
        }
        $cartService->create([
            "products" => $products
        ]);

        $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
        return redirect()->route($locale . '.icommerce.store.checkout');
    }

}
