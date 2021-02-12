<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/iplan'], function (Router $router) {
    $router->bind('plan', function ($id) {
        return app('Modules\Iplan\Repositories\PlanRepository')->find($id);
    });
    $router->get('plans', [
        'as' => 'admin.iplan.plan.index',
        'uses' => 'PlanController@index',
        'middleware' => 'can:iplan.plans.index'
    ]);
    $router->get('plans/create', [
        'as' => 'admin.iplan.plan.create',
        'uses' => 'PlanController@create',
        'middleware' => 'can:iplan.plans.create'
    ]);
    $router->post('plans', [
        'as' => 'admin.iplan.plan.store',
        'uses' => 'PlanController@store',
        'middleware' => 'can:iplan.plans.create'
    ]);
    $router->get('plans/{plan}/edit', [
        'as' => 'admin.iplan.plan.edit',
        'uses' => 'PlanController@edit',
        'middleware' => 'can:iplan.plans.edit'
    ]);
    $router->put('plans/{plan}', [
        'as' => 'admin.iplan.plan.update',
        'uses' => 'PlanController@update',
        'middleware' => 'can:iplan.plans.edit'
    ]);
    $router->delete('plans/{plan}', [
        'as' => 'admin.iplan.plan.destroy',
        'uses' => 'PlanController@destroy',
        'middleware' => 'can:iplan.plans.destroy'
    ]);
    $router->bind('limit', function ($id) {
        return app('Modules\Iplan\Repositories\LimitRepository')->find($id);
    });
    $router->get('limits', [
        'as' => 'admin.iplan.limit.index',
        'uses' => 'LimitController@index',
        'middleware' => 'can:iplan.limits.index'
    ]);
    $router->get('limits/create', [
        'as' => 'admin.iplan.limit.create',
        'uses' => 'LimitController@create',
        'middleware' => 'can:iplan.limits.create'
    ]);
    $router->post('limits', [
        'as' => 'admin.Iplan.limit.store',
        'uses' => 'LimitController@store',
        'middleware' => 'can:iplans.limits.create'
    ]);
    $router->get('limits/{limit}/edit', [
        'as' => 'admin.Iplan.limit.edit',
        'uses' => 'LimitController@edit',
        'middleware' => 'can:iplans.limits.edit'
    ]);
    $router->put('limits/{limit}', [
        'as' => 'admin.Iplan.limit.update',
        'uses' => 'LimitController@update',
        'middleware' => 'can:iplans.limits.edit'
    ]);
    $router->delete('limits/{limit}', [
        'as' => 'admin.Iplan.limit.destroy',
        'uses' => 'LimitController@destroy',
        'middleware' => 'can:iplans.limits.destroy'
    ]);
    $router->bind('planuser', function ($id) {
        return app('Modules\Iplan\Repositories\PlanuserRepository')->find($id);
    });
    $router->get('planusers', [
        'as' => 'admin.Iplan.planuser.index',
        'uses' => 'PlanuserController@index',
        'middleware' => 'can:iplans.planusers.index'
    ]);
    $router->get('planusers/create', [
        'as' => 'admin.Iplan.planuser.create',
        'uses' => 'PlanuserController@create',
        'middleware' => 'can:iplans.planusers.create'
    ]);
    $router->post('planusers', [
        'as' => 'admin.Iplan.planuser.store',
        'uses' => 'PlanuserController@store',
        'middleware' => 'can:iplans.planusers.create'
    ]);
    $router->get('planusers/{planuser}/edit', [
        'as' => 'admin.Iplan.planuser.edit',
        'uses' => 'PlanuserController@edit',
        'middleware' => 'can:iplans.planusers.edit'
    ]);
    $router->put('planusers/{planuser}', [
        'as' => 'admin.Iplan.planuser.update',
        'uses' => 'PlanuserController@update',
        'middleware' => 'can:iplans.planusers.edit'
    ]);
    $router->delete('planusers/{planuser}', [
        'as' => 'admin.Iplan.planuser.destroy',
        'uses' => 'PlanuserController@destroy',
        'middleware' => 'can:iplans.planusers.destroy'
    ]);
    $router->bind('subscription', function ($id) {
        return app('Modules\Iplan\Repositories\SubscriptionRepository')->find($id);
    });
    $router->get('subscriptions', [
        'as' => 'admin.Iplan.subscription.index',
        'uses' => 'SubscriptionController@index',
        'middleware' => 'can:iplans.subscriptions.index'
    ]);
    $router->get('subscriptions/create', [
        'as' => 'admin.Iplan.subscription.create',
        'uses' => 'SubscriptionController@create',
        'middleware' => 'can:iplans.subscriptions.create'
    ]);
    $router->post('subscriptions', [
        'as' => 'admin.Iplan.subscription.store',
        'uses' => 'SubscriptionController@store',
        'middleware' => 'can:iplans.subscriptions.create'
    ]);
    $router->get('subscriptions/{subscription}/edit', [
        'as' => 'admin.Iplan.subscription.edit',
        'uses' => 'SubscriptionController@edit',
        'middleware' => 'can:iplans.subscriptions.edit'
    ]);
    $router->put('subscriptions/{subscription}', [
        'as' => 'admin.Iplan.subscription.update',
        'uses' => 'SubscriptionController@update',
        'middleware' => 'can:iplans.subscriptions.edit'
    ]);
    $router->delete('subscriptions/{subscription}', [
        'as' => 'admin.Iplan.subscription.destroy',
        'uses' => 'SubscriptionController@destroy',
        'middleware' => 'can:iplans.subscriptions.destroy'
    ]);
    $router->bind('subscriptionlimit', function ($id) {
        return app('Modules\Iplan\Repositories\SubscriptionLimitRepository')->find($id);
    });
    $router->get('subscriptionlimits', [
        'as' => 'admin.Iplan.subscriptionlimit.index',
        'uses' => 'SubscriptionLimitController@index',
        'middleware' => 'can:iplans.subscriptionlimits.index'
    ]);
    $router->get('subscriptionlimits/create', [
        'as' => 'admin.Iplan.subscriptionlimit.create',
        'uses' => 'SubscriptionLimitController@create',
        'middleware' => 'can:iplans.subscriptionlimits.create'
    ]);
    $router->post('subscriptionlimits', [
        'as' => 'admin.Iplan.subscriptionlimit.store',
        'uses' => 'SubscriptionLimitController@store',
        'middleware' => 'can:iplans.subscriptionlimits.create'
    ]);
    $router->get('subscriptionlimits/{subscriptionlimit}/edit', [
        'as' => 'admin.Iplan.subscriptionlimit.edit',
        'uses' => 'SubscriptionLimitController@edit',
        'middleware' => 'can:iplans.subscriptionlimits.edit'
    ]);
    $router->put('subscriptionlimits/{subscriptionlimit}', [
        'as' => 'admin.Iplan.subscriptionlimit.update',
        'uses' => 'SubscriptionLimitController@update',
        'middleware' => 'can:iplans.subscriptionlimits.edit'
    ]);
    $router->delete('subscriptionlimits/{subscriptionlimit}', [
        'as' => 'admin.Iplan.subscriptionlimit.destroy',
        'uses' => 'SubscriptionLimitController@destroy',
        'middleware' => 'can:iplans.subscriptionlimits.destroy'
    ]);
    $router->bind('userlimit', function ($id) {
        return app('Modules\Iplan\Repositories\UserLimitRepository')->find($id);
    });
    $router->get('userlimits', [
        'as' => 'admin.Iplan.userlimit.index',
        'uses' => 'UserLimitController@index',
        'middleware' => 'can:iplans.userlimits.index'
    ]);
    $router->get('userlimits/create', [
        'as' => 'admin.Iplan.userlimit.create',
        'uses' => 'UserLimitController@create',
        'middleware' => 'can:iplans.userlimits.create'
    ]);
    $router->post('userlimits', [
        'as' => 'admin.Iplan.userlimit.store',
        'uses' => 'UserLimitController@store',
        'middleware' => 'can:iplans.userlimits.create'
    ]);
    $router->get('userlimits/{userlimit}/edit', [
        'as' => 'admin.Iplan.userlimit.edit',
        'uses' => 'UserLimitController@edit',
        'middleware' => 'can:iplans.userlimits.edit'
    ]);
    $router->put('userlimits/{userlimit}', [
        'as' => 'admin.Iplan.userlimit.update',
        'uses' => 'UserLimitController@update',
        'middleware' => 'can:iplans.userlimits.edit'
    ]);
    $router->delete('userlimits/{userlimit}', [
        'as' => 'admin.Iplan.userlimit.destroy',
        'uses' => 'UserLimitController@destroy',
        'middleware' => 'can:iplans.userlimits.destroy'
    ]);
// append






});
