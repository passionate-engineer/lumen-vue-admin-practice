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

$router->group(['prefix' => '/api'], function () use ($router) {
  $router->get('articles', 'ArticlesController@index');
  $router->get('articles/{id}', 'ArticlesController@show');
  $router->post('articles', 'ArticlesController@create');
  $router->put('articles/{id}', 'ArticlesController@update');
  $router->delete('articles/{id}', 'ArticlesController@delete');

  $router->get('articles/preview/{id}', 'ArticlesController@preview');
  $router->get('articles/public/{hash_id}', 'ArticlesController@public');
});

$router->get('/key', function() {
    return str_random(32);
});
