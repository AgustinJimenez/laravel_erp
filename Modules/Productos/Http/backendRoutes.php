<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/productos'], function (Router $router) {
    $router->bind('categoriaproducto', function ($id) {
        return app('Modules\Productos\Repositories\CategoriaProductoRepository')->find($id);
    });
    $router->get('categoriaproductos', [
        'as' => 'admin.productos.categoriaproducto.index',
        'uses' => 'CategoriaProductoController@index',
        'middleware' => 'can:productos.categoriaproductos.index'
    ]);
    $router->get('categoriaproductos/create', [
        'as' => 'admin.productos.categoriaproducto.create',
        'uses' => 'CategoriaProductoController@create',
        'middleware' => 'can:productos.categoriaproductos.create'
    ]);
    $router->post('categoriaproductos', [
        'as' => 'admin.productos.categoriaproducto.store',
        'uses' => 'CategoriaProductoController@store',
        'middleware' => 'can:productos.categoriaproductos.store'
    ]);
    $router->get('categoriaproductos/{categoriaproducto}/edit', [
        'as' => 'admin.productos.categoriaproducto.edit',
        'uses' => 'CategoriaProductoController@edit',
        'middleware' => 'can:productos.categoriaproductos.edit'
    ]);
    $router->put('categoriaproductos/{categoriaproducto}', [
        'as' => 'admin.productos.categoriaproducto.update',
        'uses' => 'CategoriaProductoController@update',
        'middleware' => 'can:productos.categoriaproductos.update'
    ]);
    $router->delete('categoriaproductos/{categoriaproducto}', [
        'as' => 'admin.productos.categoriaproducto.destroy',
        'uses' => 'CategoriaProductoController@destroy',
        'middleware' => 'can:productos.categoriaproductos.destroy'
    ]);
    $router->bind('producto', function ($id) {
        return app('Modules\Productos\Repositories\ProductoRepository')->find($id);
    });
    $router->get('productos', [
        'as' => 'admin.productos.producto.index',
        'uses' => 'ProductoController@index',
        'middleware' => 'can:productos.productos.index'
    ]);

    $router->get('productos/index_stock_critico', [
        'as' => 'admin.productos.producto.index_stock_critico',
        'uses' => 'ProductoController@index_stock_critico',
        'middleware' => 'can:productos.productos.index_stock_critico'
    ]);

    $router->get('productos/cargar_producto', [
        'as' => 'admin.productos.producto.cargar_producto',
        'uses' => 'ProductoController@cargar_productos_desde_excel',
        'middleware' => 'can:productos.productos.cargar_productos_desde_excel'
    ]);
    $router->post('productos/store_productos_desde_excel', [
        'as' => 'admin.productos.producto.store_productos_desde_excel',
        'uses' => 'ProductoController@store_productos_desde_excel',
        'middleware' => 'can:productos.productos.store_productos_desde_excel'
    ]);

    $router->post('productos/index_ajax', [
        'as' => 'admin.productos.producto.index_ajax',
        'uses' => 'ProductoController@index_ajax',
        'middleware' => 'can:productos.productos.index_ajax'
    ]);

    $router->post('productos/index_ajax', [
        'as' => 'admin.productos.producto.index_ajax',
        'uses' => 'ProductoController@index_ajax',
        'middleware' => 'can:productos.productos.index_ajax'
    ]);

    $router->get('productos/search_producto', [
        'as' => 'admin.productos.producto.search_producto',
        'uses' => 'ProductoController@search_producto',
        'middleware' => 'can:productos.productos.search_producto'
    ]);

    $router->get('productos/productos_vendidos', [
        'as' => 'admin.productos.producto.productos_vendidos',
        'uses' => 'ProductoController@productos_vendidos',
        'middleware' => 'can:productos.productos.productos_vendidos'
    ]);

    $router->post('productos/productos_vendidos_ajax', [
        'as' => 'admin.productos.producto.productos_vendidos_ajax',
        'uses' => 'ProductoController@productos_vendidos_ajax',
        'middleware' => 'can:productos.productos.productos_vendidos_ajax'
    ]);

    $router->get('productos/productos_vendidos_query', [
        'as' => 'admin.productos.producto.productos_vendidos_query',
        'uses' => 'ProductoController@productos_vendidos_query',
        'middleware' => 'can:productos.productos.productos_vendidos_query'
    ]);

    $router->get('productos/productos_vendidos_xls', [
        'as' => 'admin.productos.producto.productos_vendidos_xls',
        'uses' => 'ProductoController@productos_vendidos_xls',
        'middleware' => 'can:productos.productos.productos_vendidos_xls'
    ]);

    $router->get('productos/create', [
        'as' => 'admin.productos.producto.create',
        'uses' => 'ProductoController@create',
        'middleware' => 'can:productos.productos.create'
    ]);
    $router->post('productos', [
        'as' => 'admin.productos.producto.store',
        'uses' => 'ProductoController@store',
        'middleware' => 'can:productos.productos.store'
    ]);
    $router->get('productos/{producto}/edit', [
        'as' => 'admin.productos.producto.edit',
        'uses' => 'ProductoController@edit',
        'middleware' => 'can:productos.productos.edit'
    ]);
    $router->put('productos/{producto}', [
        'as' => 'admin.productos.producto.update',
        'uses' => 'ProductoController@update',
        'middleware' => 'can:productos.productos.update'
    ]);
    $router->delete('productos/{producto}', [
        'as' => 'admin.productos.producto.destroy',
        'uses' => 'ProductoController@destroy',
        'middleware' => 'can:productos.productos.destroy'
    ]);

    //------------------------------PDF Productos-------------------------------------------//
    $router->get('productos/inventario_producto_performance', [
        'as' => 'admin.productos.producto.inventario_producto_performance',
        'uses' => 'ProductoController@inventario_producto_performance',
        'middleware' => 'can:productos.productos.inventario_producto_performance'
    ]);

    $router->post('productos/inventario_producto_pdf', [
        'as' => 'admin.productos.producto.inventario_producto_pdf',
        'uses' => 'ProductoController@inventario_producto_pdf',
        'middleware' => 'can:productos.productos.inventario_producto_pdf'
    ]);
//------------------------------PDF Productos-------------------------------------------//
    $router->bind('marca', function ($id) {
        return app('Modules\Productos\Repositories\MarcaRepository')->find($id);
    });
    $router->get('marcas', [
        'as' => 'admin.productos.marca.index',
        'uses' => 'MarcaController@index',
        'middleware' => 'can:productos.marcas.index'
    ]);
    $router->get('marcas/create', [
        'as' => 'admin.productos.marca.create',
        'uses' => 'MarcaController@create',
        'middleware' => 'can:productos.marcas.create'
    ]);
    $router->post('marcas', [
        'as' => 'admin.productos.marca.store',
        'uses' => 'MarcaController@store',
        'middleware' => 'can:productos.marcas.store'
    ]);
    $router->get('marcas/{marca}/edit', [
        'as' => 'admin.productos.marca.edit',
        'uses' => 'MarcaController@edit',
        'middleware' => 'can:productos.marcas.edit'
    ]);
    $router->put('marcas/{marca}', [
        'as' => 'admin.productos.marca.update',
        'uses' => 'MarcaController@update',
        'middleware' => 'can:productos.marcas.update'
    ]);
    $router->delete('marcas/{marca}', [
        'as' => 'admin.productos.marca.destroy',
        'uses' => 'MarcaController@destroy',
        'middleware' => 'can:productos.marcas.destroy'
    ]);
    $router->bind('altabajaproducto', function ($id) {
        return app('Modules\Productos\Repositories\AltabajaProductoRepository')->find($id);
    });
    $router->get('altabajaproductos', [
        'as' => 'admin.productos.altabajaproducto.index',
        'uses' => 'AltabajaProductoController@index',
        'middleware' => 'can:productos.altabajaproductos.index'
    ]);
    $router->post('altabajaproductos/indexAjax', [
        'as' => 'admin.productos.altabajaproducto.indexAjax',
        'uses' => 'AltabajaProductoController@indexAjax',
        'middleware' => 'can:productos.altabajaproductos.indexAjax'
    ]);
    $router->get('altabajaproductos/{producto}/create', [
        'as' => 'admin.productos.altabajaproducto.create',
        'uses' => 'AltabajaProductoController@create',
        'middleware' => 'can:productos.altabajaproductos.create'
    ]);
    $router->post('altabajaproductos', [
        'as' => 'admin.productos.altabajaproducto.store',
        'uses' => 'AltabajaProductoController@store',
        'middleware' => 'can:productos.altabajaproductos.store'
    ]);
    $router->get('altabajaproductos/{altabajaproducto}/edit', [
        'as' => 'admin.productos.altabajaproducto.edit',
        'uses' => 'AltabajaProductoController@edit',
        'middleware' => 'can:productos.altabajaproductos.edit'
    ]);
    $router->put('altabajaproductos/{altabajaproducto}', [
        'as' => 'admin.productos.altabajaproducto.update',
        'uses' => 'AltabajaProductoController@update',
        'middleware' => 'can:productos.altabajaproductos.update'
    ]);
    $router->delete('altabajaproductos/{altabajaproducto}/delete', [
        'as' => 'admin.productos.altabajaproducto.destroy',
        'uses' => 'AltabajaProductoController@destroy',
        'middleware' => 'can:productos.altabajaproductos.destroy'
    ]);
    $router->get('altabajaproductos/seleccionProductos', [
        'as' => 'admin.productos.altabajaproducto.seleccionProductos',
        'uses' => 'AltabajaProductoController@seleccionProductos',
        'middleware' => 'can:productos.altabajaproductos.seleccionProductos'
    ]);


});
