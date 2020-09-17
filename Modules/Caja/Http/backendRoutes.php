<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/caja'], function (Router $router) {
    $router->bind('caja', function ($id) {
        return app('Modules\Caja\Repositories\CajaRepository')->find($id);
    });
    $router->get('cajas', [
        'as' => 'admin.caja.caja.index',
        'uses' => 'CajaController@index',
        'middleware' => 'can:caja.cajas.index'
    ]);

    $router->post('cajas/index_ajax', [
        'as' => 'admin.caja.caja.index_ajax',
        'uses' => 'CajaController@index_ajax',
        'middleware' => 'can:caja.cajas.index_ajax'
    ]);
    $router->get('cajas/create', [
        'as' => 'admin.caja.caja.create',
        'uses' => 'CajaController@create',
        'middleware' => 'can:caja.cajas.create'
    ]);
    $router->get('cajas/{caja}/pdf', [
        'as' => 'admin.caja.caja.pdf',
        'uses' => 'CajaController@pdf',
        'middleware' => 'can:caja.cajas.pdf'
    ]);
    $router->post('cajas', [
        'as' => 'admin.caja.caja.store',
        'uses' => 'CajaController@store',
        'middleware' => 'can:caja.cajas.store'
    ]);
    $router->get('cajas/{caja}/edit', [
        'as' => 'admin.caja.caja.edit',
        'uses' => 'CajaController@edit',
        'middleware' => 'can:caja.cajas.edit'
    ]);
    $router->put('cajas/{caja}', [
        'as' => 'admin.caja.caja.update',
        'uses' => 'CajaController@update',
        'middleware' => 'can:caja.cajas.update'
    ]);
    $router->delete('cajas/{caja}', [
        'as' => 'admin.caja.caja.destroy',
        'uses' => 'CajaController@destroy',
        'middleware' => 'can:caja.cajas.destroy'
    ]);
// ------------------------------------------
    $router->get('cajas/movimientos/index/{caja}', [
        'as' => 'admin.caja.caja.index_movimientos',
        'uses' => 'CajaController@index_movimientos',
        'middleware' => 'can:caja.cajas.index_movimientos'
    ]);

    $router->get('cajas/movimientos/index', [
        'as' => 'admin.caja.caja.index_movimientos_activo',
        'uses' => 'CajaController@index_movimientos_activo',
        'middleware' => 'can:caja.cajas.index_movimientos_activo'
    ]);

    $router->get('cajas/movimientos/create', [
        'as' => 'admin.caja.caja.create_movimiento',
        'uses' => 'CajaController@create_movimiento',
        'middleware' => 'can:caja.cajas.create_movimiento'
    ]);

    $router->post('cajas/movimientos/store', [
        'as' => 'admin.caja.caja.store_movimiento',
        'uses' => 'CajaController@store_movimiento',
        'middleware' => 'can:caja.cajas.store_movimiento'
    ]);

    $router->get('cajas/movimientos/edit', [
        'as' => 'admin.caja.caja.edit_movimiento',
        'uses' => 'CajaController@edit_movimiento',
        'middleware' => 'can:caja.cajas.edit_movimiento'
    ]);

    $router->put('cajas/movimientos/{caja}/update', [
        'as' => 'admin.caja.caja.update_movimiento',
        'uses' => 'CajaController@update_movimiento',
        'middleware' => 'can:caja.cajas.update_movimiento'
    ]);

    $router->post('cajas/index_cajas', [
        'as' => 'admin.caja.caja.index_cajas',
        'uses' => 'CajaController@index_cajas',
        'middleware' => 'can:caja.cajas.index_cajas'
    ]);

    


});
