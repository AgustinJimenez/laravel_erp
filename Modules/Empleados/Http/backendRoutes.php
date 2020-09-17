<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/empleados'], function (Router $router) {
    $router->bind('empleado', function ($id) {
        return app('Modules\Empleados\Repositories\EmpleadoRepository')->find($id);
    });
    $router->get('empleados', [
        'as' => 'admin.empleados.empleado.index',
        'uses' => 'EmpleadoController@index',
        'middleware' => 'can:empleados.empleados.index'
    ]);

    $router->post('empleados/indexAjax', [
        'as' => 'admin.empleados.empleado.indexAjax',
        'uses' => 'EmpleadoController@indexAjax',
        'middleware' => 'can:empleados.empleados.indexAjax'
    ]);

    $router->get('empleados/create', [
        'as' => 'admin.empleados.empleado.create',
        'uses' => 'EmpleadoController@create',
        'middleware' => 'can:empleados.empleados.create'
    ]);
    $router->post('empleados', [
        'as' => 'admin.empleados.empleado.store',
        'uses' => 'EmpleadoController@store',
        'middleware' => 'can:empleados.empleados.store'
    ]);
    $router->get('empleados/{empleado}/edit', [
        'as' => 'admin.empleados.empleado.edit',
        'uses' => 'EmpleadoController@edit',
        'middleware' => 'can:empleados.empleados.edit'
    ]);
    $router->put('empleados/{empleado}', [
        'as' => 'admin.empleados.empleado.update',
        'uses' => 'EmpleadoController@update',
        'middleware' => 'can:empleados.empleados.update'
    ]);
    $router->delete('empleados/{empleado}', [
        'as' => 'admin.empleados.empleado.destroy',
        'uses' => 'EmpleadoController@destroy',
        'middleware' => 'can:empleados.empleados.destroy'
    ]);
    $router->bind('pagoempleado', function ($id) 
    {
        $pago = app('Modules\Empleados\Repositories\PagoEmpleadoRepository')->find($id);
        return $pago;
    });
    $router->get('pagoempleados', [
        'as' => 'admin.empleados.pagoempleado.index',
        'uses' => 'PagoEmpleadoController@index',
        'middleware' => 'can:empleados.pagoempleados.index'
    ]);

    $router->post('pagoempleados/indexAjax', [
        'as' => 'admin.empleados.pagoempleado.indexAjax',
        'uses' => 'PagoEmpleadoController@indexAjax',
        'middleware' => 'can:empleados.pagoempleados.indexAjax'
    ]);

    $router->get('pagoempleados/seleccionEmpleado', [
        'as' => 'admin.empleados.pagoempleado.seleccionEmpleado',
        'uses' => 'PagoEmpleadoController@seleccionEmpleado',
        'middleware' => 'can:empleados.pagoempleados.seleccionEmpleado'
    ]);

    $router->get('pagoempleados/{empleado}/create', [
        'as' => 'admin.empleados.pagoempleado.create',
        'uses' => 'PagoEmpleadoController@create',
        'middleware' => 'can:empleados.pagoempleados.create'
    ]);
    
    $router->post('pagoempleados', [
        'as' => 'admin.empleados.pagoempleado.store',
        'uses' => 'PagoEmpleadoController@store',
        'middleware' => 'can:empleados.pagoempleados.store'
    ]);
    $router->get('pagoempleados/{pagoempleado}/edit', [
        'as' => 'admin.empleados.pagoempleado.edit',
        'uses' => 'PagoEmpleadoController@edit',
        'middleware' => 'can:empleados.pagoempleados.edit'
    ]);
    $router->put('pagoempleados/{pagoempleado}', [
        'as' => 'admin.empleados.pagoempleado.update',
        'uses' => 'PagoEmpleadoController@update',
        'middleware' => 'can:empleados.pagoempleados.update'
    ]);
    $router->delete('pagoempleados/{pagoempleado}', [
        'as' => 'admin.empleados.pagoempleado.destroy',
        'uses' => 'PagoEmpleadoController@destroy',
        'middleware' => 'can:empleados.pagoempleados.destroy'
    ]);
    $router->get('pagoempleados/anular_asientos/{pagoempleado}', [
        'as' => 'admin.empleados.pagoempleado.anular_asientos',
        'uses' => 'PagoEmpleadoController@anular_asientos',
        'middleware' => 'can:empleados.pagoempleados.anular_asientos'
    ]);

    $router->bind('anticipo', function ($id) 
    {
        return \Anticipo::find($id);
    });

    $router->get('anticipos/index', 
    [
        'as' => 'admin.empleados.anticipos.index',
        'uses' => 'AnticiposController@index',
        'middleware' => 'can:empleados.anticipos.index'
    ]);

    $router->get('anticipos/create', 
    [
        'as' => 'admin.empleados.anticipos.create',
        'uses' => 'AnticiposController@create',
        'middleware' => 'can:empleados.anticipos.create'
    ]);

    $router->post('anticipos/store', 
    [
        'as' => 'admin.empleados.anticipos.store',
        'uses' => 'AnticiposController@store',
        'middleware' => 'can:empleados.anticipos.store'
    ]);

    $router->get('anticipos/{anticipo}/edit', 
    [
        'as' => 'admin.empleados.anticipos.edit',
        'uses' => 'AnticiposController@edit',
        'middleware' => 'can:empleados.anticipos.edit'
    ]);
    $router->put('anticipos/{anticipo}', 
    [
        'as' => 'admin.empleados.anticipos.update',
        'uses' => 'AnticiposController@update',
        'middleware' => 'can:empleados.anticipos.update'
    ]);
    $router->delete('anticipos/{anticipo}', 
    [
        'as' => 'admin.empleados.anticipos.anular',
        'uses' => 'AnticiposController@anular',
        'middleware' => 'can:empleados.anticipos.anular'
    ]);


});
