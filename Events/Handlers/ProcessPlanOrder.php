<?php

namespace Modules\Iplan\Events\Handlers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ProcessPlanOrder
{
    private $logtitle;

    private $planRepository;

    public function __construct()
    {
        $this->logtitle = '[IPLAN-SUBSCRIPTION]::';
        $this->planRepository = app("Modules\Iplan\Repositories\PlanRepository");
    }

    public function handle($event)
    {
        $order = $event->order;
        //Order is Proccesed
        if ($order->status_id == 13) {
            foreach ($order->orderItems as $item) {
                switch ($item->entity_type) {
                    case 'Modules\Iplan\Entities\Plan':
                        $userDriver = config('asgard.user.config.driver');
                        //Get plan Id form setting
                        $planIdInOrderItem = $item->entity_id;
                        //Get user registered data
                        $user = $order->customer;

                        $plan = $this->planRepository->getItem($planIdInOrderItem);

                        //Create subscription | si la orden no tiene un suscription id (Es decir no es recurrente o es la primera vez de una recurrente)
                        if ($planIdInOrderItem && $user && is_null($order->suscription_id)) {
                            //Init subscription controller
                            $subscriptionController = app('Modules\Iplan\Http\Controllers\Api\SubscriptionController');
                            //Create subscription
                            request()->session()->put('subscriptedUser.id', $user->id);
                            $newSubscription = $subscriptionController->create(new Request([
                                'attributes' => [
                                    'entity' => "Modules\\User\\Entities\\{$userDriver}\\User",
                                    'entity_id' => $user->id,
                                    'plan_id' => $planIdInOrderItem,
                                    'options' => $item->options,
                                ],
                            ]));
                            //Log
                            \Log::info("{$this->logtitle}Order Completed | Register subscription, Plan: {$plan->id} - {$plan->name} to user ID {$user->id}");

                            //Only this case, we save the subscription id in order
                            if($plan->is_recurring){
                              //\Log::info(json_encode($newSubscription));
                              $newSubscriptionArray = json_decode($newSubscription->getContent(), true);
                              $order->suscription_id = $newSubscriptionArray["data"]["id"];
                              $order->save();
                            }

                        }else{

                          //Es una renovacion
                          $params = ['include' => []];
                          $subscriptionToRenew = app('Modules\Iplan\Repositories\SubscriptionRepository')->getItem($order->suscription_id,json_decode(json_encode($params)));
                          if(isset($subscriptionToRenew)){
                            \Log::info($this->logtitle." RENEW a subscriptionId: ".$subscriptionToRenew->id);

                            //Update the dates
                            $startDate = Carbon::now();
                            $endDate = Carbon::now()->addDays($plan->frequency_id);

                            $subscriptionToRenew->start_date = $startDate;
                            $subscriptionToRenew->end_date = $endDate;

                            $subscriptionToRenew->save();

                          }


                        }
                        break;
                }
            }
        }// end If
    }// If handle
}
