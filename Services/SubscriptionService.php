<?php

namespace Modules\Iplan\Services;

use Carbon\Carbon;
use Modules\Iplan\Entities\Subscription;

class SubscriptionService
{

    private $log = "Iplan::SubscriptionService|| ";

    public function validate($model, $user = null)
    {
        //Get entity attributes

        $userDriver = config('asgard.user.config.driver');

        $entityNamespace = get_class($model);
        $entityNamespaceExploded = explode('\\', strtolower($entityNamespace));
        $moduleName = $entityNamespaceExploded[1]; //Get module name
        $entityName = $entityNamespaceExploded[3]; //Get entity name
        //Get current full date
        $now = Carbon::now()->format('Y-m-d h:i:s');
        $subscription = Subscription::whereHas('limits', function ($q) use ($entityNamespace) {
            //filter limits
            $q->where('entity', $entityNamespace);
        })->whereDate('end_date', '>', $now)->whereDate('start_date', '<=', $now)->where(function ($query) use ($userDriver, $user) {
            $query->whereNull('entity')->orWhere(function ($query) use ($userDriver, $user) {
                $query->where('entity_id', ($user ? $user->id : auth()->user()->id))->where('entity', "Modules\\User\\Entities\\{$userDriver}\\User");
            });
        })->where('status', 1)
            ->orderBy('id')
            ->first();
        if (! empty($subscription)) {
            $limitsDisabled = 0;
            $subLimits = $subscription->limits;
            foreach ($subLimits as $limit) {
                $validateLimit = true;
                $modelValue = null;
                //Validate if limit has attribute
                if ($validateLimit) {
                    if ((int) $limit->quantity > 0) {
                        if ((int) $limit->quantity_used >= (int) $limit->quantity) {
                            $limitsDisabled++;
                        }
                    }
                }
            }
            if ($limitsDisabled == count($subLimits)) {
                return false;
            }

            return $subscription;
        }

        return false;
    }

    /*
    * Get if user has active subscription
    */
    public function checkHasUserSuscription($data)
    {
        \Log::info('Iplan: Services|SubscriptionService|checkHasUserSuscription');

        //Get Last Active Subscription
        $oldSubscription = Subscription::where('entity_id', '=', $data['entity_id'])
            ->where('entity', '=', $data['entity'])
            ->where('status', '=', 1)
            ->orderBy('created_at', 'desc')
            ->first();

        if (! is_null($oldSubscription) && $oldSubscription->isAvailable) {
            return $oldSubscription;
        }

        return null;
    }

    /*
    * Add limits to old subscription when plan frenquency is Unique
    */
    public function addLimitsWhenIsUniqueFrequency($plan, $oldSubscription)
    {
        // All limits from new plan
        foreach ($plan->limits as $key => $planLimit) {
            // Get limit in old subscription
            $limitSubscription = $oldSubscription->limits->where('entity', '=', $planLimit->entity)->where('attribute', '=', $planLimit->attribute)->first();

            //Exist the plan limit in old subscription
            if (! is_null($limitSubscription)) {
                //Get new quantity
                //$newQuantity = $limitSubscription->quantityAvailable + $planLimit->quantity;
                $newQuantity = $limitSubscription->quantity + $planLimit->quantity;

                // Save new limit in old subscription
                $limitSubscription->quantity = $newQuantity;
                $limitSubscription->save();
            } else {
                //Not exist so create the new limit in old Subscription
                $limitData = [
                    'name' => $planLimit->name,
                    'entity' => $planLimit->entity,
                    'quantity' => $planLimit->quantity,
                    'quantity_used' => 0,
                    'attribute' => $planLimit->attribute,
                    'attribute_value' => $planLimit->attribute_value,
                    'subscription_id' => $oldSubscription->id,
                ];

                $oldSubscription->limits()->create($limitData);
            }
        }

        return $oldSubscription;
    }

    /**
     * Process to cancel subscription whe plan is recurring
     */
    public function cancelSubscription($subscription)
    {

      \Log::info($this->log . "cancelSubscription");

      //Validate only subscription with recurrence plan
      if(!$subscription->status)
        throw new \Exception(trans("iplan::subscriptions.messages.subscription is already inactive"), 422); //unprocessable entity

      //Validate only subscription with recurrence plan
      if(!$subscription->plan->is_recurring)
        throw new \Exception(trans("iplan::subscriptions.messages.plan is not recurrence"), 422); //unprocessable entity

      //Get order for this suscription
      $params = json_decode(json_encode(['filter' => ['field' => 'suscription_id']]));
      $order = app( 'Modules\Icommerce\Repositories\OrderRepository')->getItem($subscription->id, $params);
      if(is_null($order))
        throw new \Exception(trans( "iplan::subscriptions.messages.Order not found"), 404);

      //Get payment method used for this Order
      $paymentMethod = app( 'Modules\Icommerce\Repositories\PaymentMethodRepository')->getItem($order->payment_code);
      if(is_null($paymentMethod))
        throw new \Exception(trans("iplan::subscriptions.messages.Payment method not found"), 404);

      $nameSpace = $paymentMethod->name;

      //Validation Class
      $baseClass = "Modules\\".ucfirst($nameSpace)."\Services\RecurrenceService";
      if(!class_exists($baseClass))
        throw new \Exception(trans("iplan::subscriptions.messages.Recurrence Service Not found"), 404);

      //Validation Method
      $service = app($baseClass);
      if(!method_exists($service, "cancelSubscription"))
        throw new \Exception(trans( "iplan::subscriptions.messages.Cancel Subscription Not found for the payment method"), 404);

      //Payment Method Cancel Subscription
      $result = $service->cancelSubscription($order,$paymentMethod);

      if(!$result['success'])
        throw new \Exception('Error when the payment method ['.$nameSpace.'] tries to cancel the subscription (check the log)', 422);

      $this->setSubscritionToInactive($subscription);

      //Response Final
      return [
        "success" => true,
        "msj" => "Subscription canceled successfuly"
      ];
    }

    /**
     * set subscription and send notification to user
     * Method Used by API and Confirmation Response in Payment Method
     */
    public function setSubscritionToInactive($subscription)
    {

      \Log::info($this->log . "setSubscritionToInactive");

      if(is_numeric($subscription))
        $subscription = Subscription::find($subscription);

      //The subscription is Active
      if($subscription->status==1){

        $subscription->status = 0;
        $subscription->save();
        \Log::info($this->log . "setSubscritionToInactive|ID:".$subscription->id);

        //Extra Validation
        if($subscription->entity=="Modules\User\Entities\Sentinel\User"){
          $user = $subscription->entityData;

          $notificationService = app("Modules\Notification\Services\Inotification");

          $notificationService->to([
            'email' => $user->email,
            'broadcast' => $subscription->entity_id,
            'push' => $subscription->entity_id,
          ])->push(
            [
              'title' => trans('iplan::subscriptions.alerts.subInactive'),
              'message' => trans('iplan::subscriptions.messages.subInactive', ['name' => $subscription->name])
            ]
          );
        }

      }

    }


}
