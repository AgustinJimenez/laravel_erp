<?php

return [
    'empleados.empleados' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'indexAjax',
    ],
    'empleados.pagoempleados' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'indexAjax',
        'seleccionEmpleado',
        'anular_asientos'
    ],
    "empleados.anticipos" =>
    [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'anular'
    ],
    'Permisos Especiales Empleados' => ['Ver Empleados en Sidebar']

];
