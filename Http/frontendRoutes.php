<?php
use Illuminate\Routing\Router;

$locale = LaravelLocalization::setLocale() ?: App::getLocale();

/** @var Router $router */
Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localize']], function (Router $router) use ($locale) {

    $router->get(trans('iplan::routes.plan.index'), [
        'as' => $locale . '.iplan.plan.index',
        'uses' => 'PublicController@index',
    ]);

});
