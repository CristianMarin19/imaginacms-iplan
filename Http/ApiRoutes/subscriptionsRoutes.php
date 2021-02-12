<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => 'subscriptions'], function (Router $router) {


  $router->post('/', [
    'as' => 'api.iplan.subscriptions.create',
    'uses' => 'SubscriptionController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => 'api.iplan.subscriptions.index',
    'uses' => 'SubscriptionController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => 'api.iplan.subscriptions.update',
    'uses' => 'SubscriptionController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => 'api.iplan.subscriptions.delete',
    'uses' => 'SubscriptionController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => 'api.iplan.subscriptions.show',
    'uses' => 'SubscriptionController@show',
  ]);

});
