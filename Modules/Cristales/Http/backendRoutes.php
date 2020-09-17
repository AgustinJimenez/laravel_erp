<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/cristales'], function (Router $router) {
    $router->bind('categoriacristales', function ($id) {
        return app('Modules\Cristales\Repositories\CategoriaCristalesRepository')->find($id);
    });
    $router->get('categoriacristales', [
        'as' => 'admin.cristales.categoriacristales.index',
        'uses' => 'CategoriaCristalesController@index',
        'middleware' => 'can:cristales.categoriacristales.index'
    ]);

    $router->get('categoriacristales/create', [
        'as' => 'admin.cristales.categoriacristales.create',
        'uses' => 'CategoriaCristalesController@create',
        'middleware' => 'can:cristales.categoriacristales.create'
    ]);
    $router->post('categoriacristales', [
        'as' => 'admin.cristales.categoriacristales.store',
        'uses' => 'CategoriaCristalesController@store',
        'middleware' => 'can:cristales.categoriacristales.store'
    ]);
    $router->get('categoriacristales/{categoriacristales}/edit', [
        'as' => 'admin.cristales.categoriacristales.edit',
        'uses' => 'CategoriaCristalesController@edit',
        'middleware' => 'can:cristales.categoriacristales.edit'
    ]);
    $router->put('categoriacristales/{categoriacristales}', [
        'as' => 'admin.cristales.categoriacristales.update',
        'uses' => 'CategoriaCristalesController@update',
        'middleware' => 'can:cristales.categoriacristales.update'
    ]);
    $router->delete('categoriacristales/{categoriacristales}', [
        'as' => 'admin.cristales.categoriacristales.destroy',
        'uses' => 'CategoriaCristalesController@destroy',
        'middleware' => 'can:cristales.categoriacristales.destroy'
    ]);
    $router->bind('cristales', function ($id) {
        return app('Modules\Cristales\Repositories\CristalesRepository')->find($id);
    });
    $router->get('cristales', [
        'as' => 'admin.cristales.cristales.index',
        'uses' => 'CristalesController@index',
        'middleware' => 'can:cristales.cristales.index'
    ]);
    $router->get('cristales/create', [
        'as' => 'admin.cristales.cristales.create',
        'uses' => 'CristalesController@create',
        'middleware' => 'can:cristales.cristales.create'
    ]);
    $router->post('cristales', [
        'as' => 'admin.cristales.cristales.store',
        'uses' => 'CristalesController@store',
        'middleware' => 'can:cristales.cristales.store'
    ]);
    $router->get('cristales/{cristales}/edit', [
        'as' => 'admin.cristales.cristales.edit',
        'uses' => 'CristalesController@edit',
        'middleware' => 'can:cristales.cristales.edit'
    ]);
    $router->put('cristales/{cristales}', [
        'as' => 'admin.cristales.cristales.update',
        'uses' => 'CristalesController@update',
        'middleware' => 'can:cristales.cristales.update'
    ]);
    $router->delete('cristales/{cristales}', [
        'as' => 'admin.cristales.cristales.destroy',
        'uses' => 'CristalesController@destroy',
        'middleware' => 'can:cristales.cristales.destroy'
    ]);
    $router->bind('tipocristales', function ($id) {
        return app('Modules\Cristales\Repositories\TipoCristalesRepository')->find($id);
    });
    $router->get('tipocristales', [
        'as' => 'admin.cristales.tipocristales.index',
        'uses' => 'TipoCristalesController@index',
        'middleware' => 'can:cristales.tipocristales.index'
    ]);
    $router->get('tipocristales/create', [
        'as' => 'admin.cristales.tipocristales.create',
        'uses' => 'TipoCristalesController@create',
        'middleware' => 'can:cristales.tipocristales.create'
    ]);
    $router->post('tipocristales', [
        'as' => 'admin.cristales.tipocristales.store',
        'uses' => 'TipoCristalesController@store',
        'middleware' => 'can:cristales.tipocristales.store'
    ]);
    $router->get('tipocristales/{tipocristales}/edit', [
        'as' => 'admin.cristales.tipocristales.edit',
        'uses' => 'TipoCristalesController@edit',
        'middleware' => 'can:cristales.tipocristales.edit'
    ]);
    $router->put('tipocristales/{tipocristales}', [
        'as' => 'admin.cristales.tipocristales.update',
        'uses' => 'TipoCristalesController@update',
        'middleware' => 'can:cristales.tipocristales.update'
    ]);
    $router->delete('tipocristales/{tipocristales}', [
        'as' => 'admin.cristales.tipocristales.destroy',
        'uses' => 'TipoCristalesController@destroy',
        'middleware' => 'can:cristales.tipocristales.destroy'
    ]);
    $router->get('tipocristales/search_cristal', [
        'as' => 'admin.cristales.tipocristales.search_cristal',
        'uses' => 'TipoCristalesController@search_cristal',
        'middleware' => 'can:cristales.tipocristales.search_cristal'
    ]);
// appenss


});
