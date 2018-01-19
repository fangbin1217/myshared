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


$router->get( 'travel/index/{id}', [
    'uses' => 'TravelController@index',
] );

$router->get( '/travelmore', [
    'uses' => 'TravelController@more',
] );

$router->get( '/login', [
    'uses' => 'LoginController@index',
] );

$router->post( 'login/verify', [
    'uses' => 'LoginController@verify',
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