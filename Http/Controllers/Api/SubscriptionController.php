<?php


namespace Modules\Iplan\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iplan\Events\SubscriptionHasStarted;
use Modules\Iplan\Http\Requests\CreateSubscriptionRequest;
use Modules\Iplan\Http\Requests\UpdateSubscriptionRequest;
use Modules\Iplan\Repositories\SubscriptionLimitRepository;
use Modules\Iplan\Repositories\SubscriptionRepository;
use Modules\Iplan\Repositories\PlanRepository;
use Modules\Iplan\Transformers\SubscriptionTransformer;
use Route;
use Carbon\Carbon;

class SubscriptionController extends BaseApiController
{
  private $subscription;
  private $plan;
  private $subscriptionLimit;

  private $subscriptionService;

  public function __construct(SubscriptionRepository      $subscription,
                              PlanRepository              $plan,
                              SubscriptionLimitRepository $subscriptionLimit)
  {
    parent::__construct();
    $this->subscription = $subscription;
    $this->plan = $plan;
    $this->subscriptionLimit = $subscriptionLimit;

    $this->subscriptionService = app('Modules\Iplan\Services\SubscriptionService');
  }


  /**
   * GET ITEMS
   *
   * @return mixed
   */
  public function index(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $dataEntity = $this->subscription->getItemsBy($params);

      //Response
      $response = [
        "data" => SubscriptionTransformer::collection($dataEntity)
      ];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

  /**
   * GET A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function show($criteria, Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $dataEntity = $this->subscription->getItem($criteria, $params);

      //Break if no found item
      if (!$dataEntity) throw new \Exception('Item not found', 404);

      //Response
      $response = ["data" => new SubscriptionTransformer($dataEntity)];

    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

  /**
   * CREATE A ITEM
   *
   * @param Request $request
   * @return mixed
   */
  public function create(Request $request)
  {
    \DB::beginTransaction();
    try {
      //Get data
      $data = $request->input('attributes');
      $params = $this->getParamsRequest($request);
      $params->include = ['category', 'limits'];
      //Validate Request

      // Check if user has another subscription and if exist change the status to 0 (inactive)
      $this->subscriptionService->checkHasUserSuscription($data);

      $plan = $this->plan->getItem($data['plan_id'], $params);

      $endDate = Carbon::now()->addDays($plan->frequency_id);

      $subscriptionData = [
        'name' => $plan->name,
        'description' => $plan->description,
        'category_name' => $plan->category->title,
        'start_date' => Carbon::now(),
        'end_date' => $endDate,
        'status' => 1,
      ];

      $data = array_merge($subscriptionData, $data);

      //Create item
      $entity = $this->subscription->create($data);

      foreach ($plan->limits as $limit) {
        $limitData = [
          'name' => $limit->name,
          'entity' => $limit->entity,
          'quantity' => $limit->quantity,
          'quantity_used' => 0,
          'attribute' => $limit->attribute,
          'attribute_value' => $limit->attribute_value,
          'subscription_id' => $entity->id,
        ];
        $this->subscriptionLimit->create($limitData);
      }

      event(new SubscriptionHasStarted($entity));
      //Response
      $response = ["data" => $entity];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response, $status ?? 200);
  }

  /**
   * UPDATE ITEM
   *
   * @param $criteria
   * @param Request $request
   * @return mixed
   */
  public function update($criteria, Request $request)
  {
    \DB::beginTransaction(); //DB Transaction
    try {
      //Get data
      $data = $request->input('attributes');

      //Validate Request
      $this->validateRequestApi(new UpdateSubscriptionRequest((array)$data));

      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $entity = $this->subscription->updateBy($criteria, $data, $params);

      //Response
      $response = ["data" => 'Item Updated'];
      \DB::commit();//Commit to DataBase
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }


  /**
   * DELETE A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function delete($criteria, Request $request)
  {
    \DB::beginTransaction();
    try {
      //Get params
      $params = $this->getParamsRequest($request);

      //call Method delete
      $this->subscription->deleteBy($criteria, $params);

      //Response
      $response = ["data" => ""];
      \DB::commit();//Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

  /**
   * GET ITEMS
   *
   * @return mixed
   */
  public function entities(Request $request)
  {
    try {

      $data = config('asgard.iplan.config.subscriptionEntities');

      //Response
      $response = [
        "data" => $data,
      ];
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

  /**
   * GET ITEMS
   *
   * @return mixed
   */
  public function me(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      $params->filter->user = auth()->user()->id;

      //Request to Repository
      $dataEntity = $this->subscription->getItemsBy($params);

      //Response
      $response = [
        "data" => SubscriptionTransformer::collection($dataEntity)
      ];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

  /**
   * Buy subscription
   *
   * @param Request $request
   * @return void
   */
  public function buy(Request $request)
  {
    \DB::beginTransaction();
    try {
      $params = $this->getParamsRequest($request);//Get params
      $data = $request->input('attributes');//Get data

      //Get Plan
      $plan = $this->plan->getItem($data['plan_id'], json_decode(json_encode([
        "include" => ["product"],
        "filter" => ["status" => 1]
      ])));

      //Validate if exist plan
      if (!$plan) {
        $status = 500;
        $response = ["messages" => [["message" => trans('iplan::common.planNotFound'), "type" => "error"]]];
      } else {
        //Get user
        $user = \Auth::user();
        //Create subscription
        if (!isset($plan->product) || !$plan->product->price) {
          $this->create(new Request([
            'attributes' => [
              'entity' => "Modules\\User\\Entities\\" . config('asgard.user.config.driver') . "\\User",
              'entity_id' => $user->id,
              'plan_id' => $plan->id,
              'options' => $data,
            ]
          ]));
        } //Create cart to pay
        else {
          //Instance cart service
          $cartService = app("Modules\Icommerce\Services\CartService");
          //Create cart
          $cartService->create([
            "products" => [["id" => $plan->product->id, "quantity" => 1, "options" => $data]]
          ]);
          //Set redirect to cart
          $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
          $redirectTo = route($locale . '.icommerce.store.checkout');
        }

        \DB::commit(); //Commit to Data Base
        $response = ["data" => ["redirectTo" => $redirectTo ?? null]];
      }
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
      dd($response, $e->getLine(), $e->getFile());
    }
    //Return response
    return response()->json($response, $status ?? 200);
  }
}
