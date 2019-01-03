<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/*
$router->get('/', function () use ($router) {
    return $router->app->version();
});
*/

$router->get( '/', [
    'uses' => 'IndexController@index',
] );

$router->get( '/resume', [
    'uses' => 'IndexController@resume',
] );

$router->get( '/baby', [
    'uses' => 'IndexController@baby',
] );

$router->get( '/babymore', [
    'uses' => 'IndexController@more',
] );

$router->get( '/travel', [
    'uses' => 'TravelController@index',
] );

$router->get( '/article/babystory', [
    'uses' => 'ArticleController@babystory',
] );

$router->get( '/article/study', [
    'uses' => 'ArticleController@study',
] );

$router->get( 'travel/detail/{id}', [
    'uses' => 'TravelController@detail',
] );

$router->get( '/travelmore', [
    'uses' => 'TravelController@more',
] );

$router->get( '/login', [
    'uses' => 'LoginController@index',
] );

$router->get( '/register', [
    'uses' => 'RegisterController@index',
] );

$router->post( 'register/verify', [
    'uses' => 'RegisterController@verify',
] );

$router->post( 'login/verify', [
    'uses' => 'LoginController@verify',
] );

$router->get( 'login/loginout', [
    'uses' => 'LoginController@loginout',
] );

$router->get( '/admin', [
    'uses' => 'AdminController@index',
] );

$router->get( '/admin/addbaby', [
    'uses' => 'AdminController@addbaby',
] );

$router->post( '/admin/savebaby', [
    'uses' => 'AdminController@savebaby',
] );

$router->get( 'example/test', [
    'uses' => 'ExampleController@test',
] );

$router->get( '/admin/mytravel', [
    'uses' => 'AdminController@mytravel',
] );

$router->get( '/admin/addtravelfirst', [
    'uses' => 'AdminController@addtravelfirst',
] );

$router->post( '/admin/savetravelfirst', [
    'uses' => 'AdminController@savetravelfirst',
] );

$router->get( '/admin/addtraveldetail/{id}', [
    'uses' => 'AdminController@addtraveldetail',
] );

$router->post( '/admin/savetraveldetail', [
    'uses' => 'AdminController@savetraveldetail',
] );

$router->get( '/admin/look/{id}', [
    'uses' => 'AdminController@look',
] );

$router->get( '/admin/checktravel/{id}', [
    'uses' => 'AdminController@checktravel',
] );

$router->get( 'travel/test', [
    'uses' => 'TravelController@test',
] );

$router->get( '/weather', [
    'uses' => 'IndexController@getweatherinfo',
] );

$router->get( '/article/nav/{id}', [
    'uses' => 'ArticleController@nav',
] );

$router->get( '/article/detail/{id}', [
    'uses' => 'ArticleController@detail',
] );