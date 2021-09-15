<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => 'plans'], function (Router $router) {
  
  $router->get('/frequencies', [
    'as' => 'api.iplan.plans.frequencies',
    'uses' => 'PlanApiController@frequencies',
  ]);
 

});
