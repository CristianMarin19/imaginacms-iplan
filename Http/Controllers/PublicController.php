<?php

namespace Modules\Iplan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;
use Modules\Icommerce\Entities\Currency;
use Modules\Icommerce\Repositories\CartRepository;
use Modules\Icommerce\Repositories\CartProductRepository;
use Route;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Core\Http\Controllers\BasePublicController;
use Mockery\CountValidator\Exception;

//Entities
use Modules\Iplan\Repositories\PlanRepository;

class PublicController extends BaseApiController
{
  private $plan;
  private $cart;
  private $cartProduct;

  public function __construct(
    PlanRepository $plan,
    CartRepository $cart,
    CartProductRepository $cartProduct
  )
  {
    parent::__construct();
    $this->plan = $plan;
    $this->cart = $cart;
    $this->cartProduct = $cartProduct;
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

  public function checkoutPlan($planId, Request $request)
  {
    $params = $this->getParamsRequest($request);

    $plan = $this->plan->getItem($planId, $params);
    if (!$plan)
      abort(404);

    $data = [];
    $data["ip"] = request()->ip();
    $data["session_id"] = session('_token');

    $user = Auth::user();

    if(isset($user->id))
       $data["user_id"] = $user->id;

    $cart = request()->session()->get('cart');

    if(!$cart)
        $cart = $this->cart->create($data);

    $cartProductData = ['cart_id'=>$cart->id,'product_id'=>$plan->productable,'quantity' => 0];

    $this->cartProduct->create($cartProductData);

    $cart = $this->cart->getItem($cart->id, false);

    $tpl = 'iplan::frontend.plan.checkout';
    $ttpl = 'iplan.plan.checkout';

    $currency = Currency::where("default_currency",1)->first();

    if(setting("icommerce::customCheckoutTitle")){
        $title = setting("icommerce::customCheckoutTitle");
    }else{
        $title =  trans('icommerce::checkout.title');
    }

    request()->session()->put('cart', $cart);

    if (view()->exists($ttpl)) $tpl = $ttpl;
    return view($tpl, compact('plan', 'title', 'currency', 'cart', 'user'));
  }//createAd

}
