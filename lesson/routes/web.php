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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router -> group(['prefix' => 'api'], function ($router){
    $router-> get('ads', 'PostController@showAll');
    $router-> get('ad/{id}', 'PostController@show');
    $router-> post('ad/add', 'PostController@addPost');
    $router-> post('ad/{id}/edit/data', 'PostController@editPost');
    $router-> post('ad/{id}/proverka', 'PostController@proverka');
    $router-> post('ad/{id}/edit/date', 'PostController@editDate');
    $router-> post('ad/{id}/delete', 'PostController@delete');
    $router-> post('ad/{id}/edit/file/delete', 'PostController@deleteFile');
});


