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

$router->group(['prefix' => 'todos'], function ($router) {
    $router->post('/', 'TodoController@postTodo');
    $router->post('/{id}/status/{status}', 'TodoController@postTodoStatus');
    $router->get('/{todo}', 'TodoController@getTodo');
    $router->delete('/{id}', 'TodoController@deleteTodo');
    $router->put('/{id}', 'TodoController@updateTodo');
});

