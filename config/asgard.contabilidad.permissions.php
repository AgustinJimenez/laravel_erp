<?php

return [
    'contabilidad.tipocuentas' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ],
    'contabilidad.cuentas' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'search_padre',
        'search_cuenta_asiento',
        'index_ajax_filter',
        'historial',
        'historial_ajax',
        'historial_excel',
        'historial-solo-caja-ita',
        'cuenta_exist'
        
    ],
    'contabilidad.asientos' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'index_ajax_asientos',
        'anular'
    ],
    'contabilidad.asientodetalles' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy'
    ],
    'contabilidad.ejercicio' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy'
    ],
    'contabilidad.reportes' => [
        'libro_mayor',
        'libro_mayor_index',
        'libro_mayor_pdf',
        'libro_mayor_xls',
        'balance',
        'balance_activos',
        'balance_pasivos',
        'balance_patrimonio',
        'balance_pdf',
        'estado_resultado',
        'estado_resultado_ingresos', 
        'estado_resultado_egresos', 
        'estado_resultado_pdf',
        'libro_venta',
        'libro_venta_pdf',
        'libro_venta_excel',
        'libro_compra',
        'libro_compra_pdf',
        'libro_compra_excel',
        'ingreso_egreso',
        'ingreso_egreso_ajax',
        'ingreso_egreso_xls',
        'ingreso_egreso_config',
        'flujo_caja',
        'flujo_caja_config',
        'libro_compra_performance',
        'libro_venta_performance',
        'cajas',
        'flujo_efectivo',
        'flujo_efectivo_ajax',
        'flujo_efectivo_excel',
        'flujo_efectivo_detalles',
        'flujo_efectivo_detalles_ajax',
        'flujo_efectivo_detalles_excel'

    ],
    'Permisos Especiales Contabilidad' => ['Ver Contabilidad en Sidebar'],
    'Permisos Especiales Reportes' => ['Ver Reportes en Sidebar']




];
