<?php

use Illuminate\Routing\Router;


$router->group(['prefix' => 'iplan/v1'], function (Router $router) {

    //======  CATEGORIES
    require('ApiRoutes/categoriesRoutes.php');
    //======  PLANS
    require('ApiRoutes/plansRoutes.php');
    //======  ENTITY PLANS
    require('ApiRoutes/entityPlansRoutes.php');
    //======  LIMITS
    require('ApiRoutes/limitsRoutes.php');

    //======  SUBSCRIPTIONS
    require('ApiRoutes/subscriptionsRoutes.php');
    //======  SUBSCRIPTION LIMITS
    require('ApiRoutes/subscriptionLimitsRoutes.php');

});
