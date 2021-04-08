<?php

namespace Modules\Iplan\Events\Handlers;


class RegisterNewSubscription
{

    public function __construct()
    {

    }

    public function handle($event)
    {

        $planRepository = app('Modules\\Iplan\\Repositories\\PlanRepository');
        $subscriptionRepository = app('Modules\\Iplan\\Repositories\\SubscriptionRepository');
        $subscriptionLimitRepository = app('Modules\\Iplan\\Repositories\\SubscriptionLimitRepository');

        $user = $event->user;

        $defaultPlanId = setting('iplan::defaultPlanToNewUsers');

        $plan = $planRepository->getItem($defaultPlanId, []);

        $endDate = Carbon::now()->addDays($plan->frequency_id);

        $userDriver = config('asgard.user.config.driver');

        $subscriptionData = [
            'name' => $plan->name,
            'description' => $plan->description,
            'category_name' => $plan->category->title,
            'start_date' => Carbon::now(),
            'end_date' => $endDate,
            'entity_id' => $user->id,
            'entity_type' => "Modules\\User\\Entities\\{$userDriver}\\User"
        ];

        //Create item
        $entity = $subscriptionRepository->create($subscriptionData);

        foreach($plan->limits as $limit){
            $limitData = [
                'name' => $limit->name,
                'entity' => $limit->entity,
                'quantity' => $limit->quantity,
                'quantity_used' => 0,
                'attribute' => $limit->attribute,
                'attribute_value' => $limit->attribute_value,
                'subscription_id' => $entity->id,
            ];
            $subscriptionLimitRepository->create($limitData);
        }


    }// If handle



}
