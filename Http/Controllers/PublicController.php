<?php

namespace Modules\Iplan\Http\Controllers;

use Illuminate\Http\Request;
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
  private $category;

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

  public function checkoutPlan($planId)
  {
    $params = json_decode(json_encode(
      [
        "include" => [],
        "filter" => [
          "field" => "id",
        ]
      ]
    ));
    $plan = $this->plan->getItem($planId, $params);
    if (!$plan)
      abort(404);
    $tpl = 'iplan::frontend.plan.checkout';
    $ttpl = 'iplan.adForm.edit.view';
    if (view()->exists($ttpl)) $tpl = $ttpl;
    return view($tpl, [
      "planId" => $planId,
    ]);
  }//createAd

}
