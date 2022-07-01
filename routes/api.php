<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['prefix' => 'api'], function ($router) {

    $router->group(['prefix' => 'auth'], function ($router) {
        $router->get('user', 'AuthController@me');
        $router->post('login', 'AuthController@login');
        $router->post('logout', 'AuthController@logout');
        $router->post('refresh', 'AuthController@refresh');
    });

    $router->group(['prefix' => 'book'], function ($router) {
        $router->get('/', 'BookController@index');
        $router->post('/', 'BookController@store');
        $router->get('/{id}', 'BookController@show');
        $router->put('/{id}', 'BookController@update');
        $router->delete('/{id}', 'BookController@destroy');
    });
});
