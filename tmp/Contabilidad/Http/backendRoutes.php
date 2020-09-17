<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/contabilidad'], function (Router $router) {
    $router->bind('cuenta', function ($id) {
        return app('Modules\Contabilidad\Repositories\CuentaRepository')->find($id);
    });
    $router->get('cuentas', [
        'as' => 'admin.contabilidad.cuenta.index',
        'uses' => 'CuentaController@index',
        'middleware' => 'can:contabilidad.cuentas.index'
    ]);
    $router->get('cuentas/create', [
        'as' => 'admin.contabilidad.cuenta.create',
        'uses' => 'CuentaController@create',
        'middleware' => 'can:contabilidad.cuentas.create'
    ]);
    $router->get('cuentas/search_padre', [
        'as' => 'admin.contabilidad.cuenta.search_padre',
        'uses' => 'CuentaController@search_padre',
        'middleware' => 'can:contabilidad.cuentas.search_padre'
    ]);
    $router->post('cuentas', [
        'as' => 'admin.contabilidad.cuenta.store',
        'uses' => 'CuentaController@store',
        'middleware' => 'can:contabilidad.cuentas.store'
    ]);
    $router->get('cuentas/{cuenta}/edit', [
        'as' => 'admin.contabilidad.cuenta.edit',
        'uses' => 'CuentaController@edit',
        'middleware' => 'can:contabilidad.cuentas.edit'
    ]);
    $router->put('cuentas/{cuenta}', [
        'as' => 'admin.contabilidad.cuenta.update',
        'uses' => 'CuentaController@update',
        'middleware' => 'can:contabilidad.cuentas.update'
    ]);
    $router->delete('cuentas/{cuenta}', [
        'as' => 'admin.contabilidad.cuenta.destroy',
        'uses' => 'CuentaController@destroy',
        'middleware' => 'can:contabilidad.cuentas.destroy'
    ]);
    $router->bind('asiento', function ($id) {
        return app('Modules\Contabilidad\Repositories\AsientoRepository')->find($id);
    });
    $router->get('asientos', [
        'as' => 'admin.contabilidad.asiento.index',
        'uses' => 'AsientoController@index',
        'middleware' => 'can:contabilidad.asientos.index'
    ]);
    $router->get('asientos/create', [
        'as' => 'admin.contabilidad.asiento.create',
        'uses' => 'AsientoController@create',
        'middleware' => 'can:contabilidad.asientos.create'
    ]);
    $router->post('asientos', [
        'as' => 'admin.contabilidad.asiento.store',
        'uses' => 'AsientoController@store',
        'middleware' => 'can:contabilidad.asientos.store'
    ]);
    $router->get('asientos/{asiento}/edit', [
        'as' => 'admin.contabilidad.asiento.edit',
        'uses' => 'AsientoController@edit',
        'middleware' => 'can:contabilidad.asientos.edit'
    ]);
    $router->put('asientos/{asiento}', [
        'as' => 'admin.contabilidad.asiento.update',
        'uses' => 'AsientoController@update',
        'middleware' => 'can:contabilidad.asientos.update'
    ]);
    $router->delete('asientos/{asiento}', [
        'as' => 'admin.contabilidad.asiento.destroy',
        'uses' => 'AsientoController@destroy',
        'middleware' => 'can:contabilidad.asientos.destroy'
    ]);
    $router->bind('asientodetalle', function ($id) {
        return app('Modules\Contabilidad\Repositories\AsientoDetalleRepository')->find($id);
    });
    $router->get('asientodetalles', [
        'as' => 'admin.contabilidad.asientodetalle.index',
        'uses' => 'AsientoDetalleController@index',
        'middleware' => 'can:contabilidad.asientodetalles.index'
    ]);
    $router->get('asientodetalles/create', [
        'as' => 'admin.contabilidad.asientodetalle.create',
        'uses' => 'AsientoDetalleController@create',
        'middleware' => 'can:contabilidad.asientodetalles.create'
    ]);
    $router->post('asientodetalles', [
        'as' => 'admin.contabilidad.asientodetalle.store',
        'uses' => 'AsientoDetalleController@store',
        'middleware' => 'can:contabilidad.asientodetalles.store'
    ]);
    $router->get('asientodetalles/{asientodetalle}/edit', [
        'as' => 'admin.contabilidad.asientodetalle.edit',
        'uses' => 'AsientoDetalleController@edit',
        'middleware' => 'can:contabilidad.asientodetalles.edit'
    ]);
    $router->put('asientodetalles/{asientodetalle}', [
        'as' => 'admin.contabilidad.asientodetalle.update',
        'uses' => 'AsientoDetalleController@update',
        'middleware' => 'can:contabilidad.asientodetalles.update'
    ]);
    $router->delete('asientodetalles/{asientodetalle}', [
        'as' => 'admin.contabilidad.asientodetalle.destroy',
        'uses' => 'AsientoDetalleController@destroy',
        'middleware' => 'can:contabilidad.asientodetalles.destroy'
    ]);
// append



});
