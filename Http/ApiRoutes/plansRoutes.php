<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => 'plans'], function (Router $router) {

  $router->get('/modules', [
    'as' => 'api.iplan.plans.modules',
    'uses' => 'PlanController@modules',
  ]);

  $router->get('/frequencies', [
    'as' => 'api.iplan.plans.frequencies',
    'uses' => 'PlanController@frequencies',
  ]);
  $router->post('/', [
    'as' => 'api.iplan.plans.create',
    'uses' => 'PlanController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => 'api.iplan.plans.index',
    'uses' => 'PlanController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => 'api.iplan.plans.update',
    'uses' => 'PlanController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => 'api.iplan.plans.delete',
    'uses' => 'PlanController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => 'api.iplan.plans.show',
    'uses' => 'PlanController@show',
  ]);

});
