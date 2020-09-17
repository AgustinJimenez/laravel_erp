<?php

return [
    'productos.categoriaproductos' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ],
    'productos.productos' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'search_producto',
        'index_ajax',
        'inventario_producto_pdf',
        'inventario_producto_performance',
        'productos_vendidos',
        'productos_vendidos_ajax',
        'productos_vendidos_query',
        'productos_vendidos_xls',
        'index_stock_critico',
        'cargar_productos_desde_excel',
        'store_productos_desde_excel'
    ],
    'productos.marcas' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ],
    'productos.altabajaproductos' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'seleccionProductos',
        'indexAjax'
    ],
    "Permisos Especiales Productos" => ["Ver Precios de Compra"]
// append




];
