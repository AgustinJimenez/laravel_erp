<?php

return [
    'ventas.ventas' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'search_venta_cliente',
        'search_venta_producto',
        'search_venta_servicio',
        'search_venta_cristal',
        'detalle_venta_ajax',
        'seleccion',
        'indexAjax',
        'nro_seguimiento_exist',
        'edit_nro_seguimiento',
        'update_nro_seguimiento',
        'reporte',
        'reporte_ajax',
        'reporte_pdf',
        'reporte_xls',
        'query_reporte',
        'reporte_ganancias',
        'reporte_ganancias_ajax',
        'reporte_ganancias_query',
        'reporte_ganancias_xls',
        'index_preventa',
        'anular_factura',
        'cuenta_change'
    ],
    'ventas.detalleventas' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ],
    'ventas.facturaventas' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'edit_nro_factura',
        'update_nro_factura',
        'index_ajax',
        'generar_facturas_vacias',
        'crear_facturas_vacias'
    ],
    'ventas.otras_ventas' => 
    [
        'index',
        'index_ajax'
    ]



];
