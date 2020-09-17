<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/servicios'], function (Router $router) {
    $router->bind('servicio', function ($id) {
        return app('Modules\Servicios\Repositories\ServicioRepository')->find($id);
    });
    $router->get('servicios', [
        'as' => 'admin.servicios.servicio.index',
        'uses' => 'ServicioController@index',
        'middleware' => 'can:servicios.servicios.index'
    ]);
    $router->get('servicios/search_servicio', [
        'as' => 'admin.servicios.servicio.search_servicio',
        'uses' => 'ServicioController@search_servicio',
        'middleware' => 'can:servicios.servicios.search_servicio'
    ]);

    $router->get('servicios/indexAjax', [
        'as' => 'admin.servicios.servicio.indexAjax',
        'uses' => 'ServicioController@indexAjax',
        'middleware' => 'can:servicios.servicios.indexAjax'
    ]);

    $router->get('servicios/create', [
        'as' => 'admin.servicios.servicio.create',
        'uses' => 'ServicioController@create',
        'middleware' => 'can:servicios.servicios.create'
    ]);
    $router->post('servicios', [
        'as' => 'admin.servicios.servicio.store',
        'uses' => 'ServicioController@store',
        'middleware' => 'can:servicios.servicios.store'
    ]);
    $router->get('servicios/{servicio}/edit', [
        'as' => 'admin.servicios.servicio.edit',
        'uses' => 'ServicioController@edit',
        'middleware' => 'can:servicios.servicios.edit'
    ]);
    $router->put('servicios/{servicio}', [
        'as' => 'admin.servicios.servicio.update',
        'uses' => 'ServicioController@update',
        'middleware' => 'can:servicios.servicios.update'
    ]);
    $router->delete('servicios/{servicio}', [
        'as' => 'admin.servicios.servicio.destroy',
        'uses' => 'ServicioController@destroy',
        'middleware' => 'can:servicios.servicios.destroy'
    ]);
// append

});
