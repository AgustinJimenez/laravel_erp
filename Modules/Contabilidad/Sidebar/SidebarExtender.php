<?php namespace Modules\Contabilidad\Sidebar; 
 
use Maatwebsite\Sidebar\Group; 
use Maatwebsite\Sidebar\Item; 
use Maatwebsite\Sidebar\Menu; 
use Modules\Core\Contracts\Authentication; 
use Maatwebsite\Sidebar\Badge; 
use Modules\Page\Repositories\PageRepository; 
 
class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender 
{ 
    /** 
     * @var Authentication 
     */ 
    protected $auth; 
 
    /** 
     * @param Authentication $auth 
     * 
     * @internal param Guard $guard 
     */ 
    public function __construct(Authentication $auth) 
    { 
        $this->auth = $auth; 
    } 
 
    /** 
     * @param Menu $menu 
     * 
     * @return Menu 
     */ 
    public function extendWith(Menu $menu) 
    { 
  
        $menu->group(trans('core::sidebar.content'), function (Group $group)  
        { 
            
            $user = $this->auth->check();
            if($user and $user->get_full_permisos)
                $permisos_especiales_modulo = isset($user->get_full_permisos)?$user->get_full_permisos->get("Permisos Especiales Contabilidad"):null;
            else
                $permisos_especiales_modulo = false;

            if( isset($permisos_especiales_modulo) and $permisos_especiales_modulo and isset($permisos_especiales_modulo['Ver Contabilidad en Sidebar']) and $permisos_especiales_modulo['Ver Contabilidad en Sidebar'])
            {
                $group->item(trans('Contabilidad'), function (Item $item) { 
                    $item->icon('fa fa-copy'); 
                    $item->weight(4); 
                    $item->authorize( 
                    ); 
                    



                    $item->item(trans('Cajas'), function (Item $item) 
                    {       $codigo_cuenta_padre = \CuentasFijas::get('caja_padre')->codigo;
                            $titulo = "Cajas";
                            $hay_cuenta = true;

                        $item->icon('fa fa-copy');
                        $item->weight(0);
                        $item->route('admin.contabilidad.reportes.cajas', compact('codigo_cuenta_padre', 'titulo', 'hay_cuenta') );
                        $item->badge(function (Badge $badge) 
                        { 
                            $badge->setClass('cuentas_cajas'); 
                        }); 
                        $item->authorize(
                            $this->auth->hasAccess('contabilidad.reportes.cajas')
                        );
                    });

                    $item->item(trans('Cuentas'), function (Item $item) { 
                        $item->icon('fa fa-copy'); 
                        $item->weight(0); 
                        $item->append('admin.contabilidad.cuenta.create'); 
                        $item->route('admin.contabilidad.cuenta.index'); 
                        $item->authorize( 
                            $this->auth->hasAccess('contabilidad.cuentas.index') 
                        ); 
                    }); 
                    $item->item(trans('Asientos'), function (Item $item) { 
                        $item->icon('fa fa-copy'); 
                        $item->weight(0); 
                        $item->append('admin.contabilidad.asiento.create'); 
                        $item->route('admin.contabilidad.asiento.index'); 
                        $item->authorize( 
                            $this->auth->hasAccess('contabilidad.asientos.index') 
                        ); 
                    }); 
     
                    $item->item(trans('Libro Mayor'), function (Item $item) { 
                        $item->icon('fa fa-copy'); 
                        $item->weight(0); 
                        $item->append('admin.contabilidad.reportes.libro_mayor'); 
                        $item->route('admin.contabilidad.reportes.libro_mayor'); 
                        $item->authorize( 
                            $this->auth->hasAccess('contabilidad.reportes.libro_mayor') 
                        ); 
                    }); 
     
                    $item->item(trans('Balance'), function (Item $item) { 
                        $item->icon('fa fa-copy'); 
                        $item->weight(0); 
                        $item->append('admin.contabilidad.reportes.balance'); 
                        $item->route('admin.contabilidad.reportes.balance'); 
                        $item->authorize( 
                            $this->auth->hasAccess('contabilidad.reportes.balance') 
                        ); 
                    }); 
     
                    $item->item(trans('Estado Resultado'), function (Item $item) { 
                        $item->icon('fa fa-copy'); 
                        $item->weight(0); 
                        $item->append('admin.contabilidad.reportes.estado_resultado'); 
                        $item->route('admin.contabilidad.reportes.estado_resultado'); 
                        $item->authorize( 
                            $this->auth->hasAccess('contabilidad.reportes.estado_resultado') 
                        ); 
                    }); 
     
                    $item->item(trans('Libro de Ventas'), function (Item $item) { 
                        $item->icon('fa fa-copy'); 
                        $item->weight(0); 
                        $item->append('admin.contabilidad.reportes.libro_venta_performance'); 
                        $item->route('admin.contabilidad.reportes.libro_venta_performance'); 
                        $item->badge(function (Badge $badge) { 
                            $badge->setClass('pdf-for-venta'); 
                        }); 
                        $item->authorize( 
                            $this->auth->hasAccess('contabilidad.reportes.libro_venta_performance') 
                        ); 
                    }); 
     
                    $item->item(trans('Libro de Compras'), function (Item $item) { 
                        $item->icon('fa fa-copy'); 
                        $item->weight(0); 
                        $item->append('admin.contabilidad.reportes.libro_compra_performance'); 
                        $item->route('admin.contabilidad.reportes.libro_compra_performance'); 
                        $item->badge(function (Badge $badge) { 
                            $badge->setClass('pdf-for-compra'); 
                        }); 
                        $item->authorize( 
                            $this->auth->hasAccess('contabilidad.reportes.libro_compra_performance') 
                        ); 
                    }); 
                }); 
            }

            if($user and $user->get_full_permisos)
                $permisos_especiales_modulo = $user->get_full_permisos?$user->get_full_permisos->get("Permisos Especiales Reportes"):null;
            else
                $permisos_especiales_modulo = false;
            if( isset($permisos_especiales_modulo) and $permisos_especiales_modulo and isset($permisos_especiales_modulo['Ver Reportes en Sidebar']) and $permisos_especiales_modulo['Ver Reportes en Sidebar'])
            {
                $group->item(trans('Reportes'), function (Item $item)  
                { 
                    $item->icon('fa fa-copy'); 
                    $item->weight(6); 
                    $item->authorize( 
               
                    ); 
     
                    $item->item(trans('Compras y Gastos'), function (Item $item) { 
                        $item->icon('fa fa-copy'); 
                        $item->weight(0); 
                        $item->route('admin.compras.compra.reporte_gastos_performance'); 
                        $item->authorize( 
                            $this->auth->hasAccess('compras.compras.reporte_gastos_performance') 
                        ); 
                    }); 
     
                     $item->item(trans('Ventas'), function (Item $item) { 
                        $item->icon('fa fa-copy'); 
                        $item->weight(0); 
                        $item->route('admin.ventas.venta.reporte'); 
                        $item->authorize( 
                            $this->auth->hasAccess('ventas.ventas.reporte') 
                        ); 
                    }); 
     
                    $item->item(trans('Inventario de  Productos'), function (Item $item) { 
                        $item->icon('fa fa-copy'); 
                        $item->weight(0); 
                        $item->route('admin.productos.producto.inventario_producto_performance'); 
                        // $item->badge(function (Badge $badge) { 
                        //     $badge->setClass('pdf-to-blank'); 
                        // }); 
                        $item->authorize( 
                            $this->auth->hasAccess('productos.productos.inventario_producto_performance') 
                        ); 
                    }); 
     
                    $item->item(trans('Productos Vendidos'), function (Item $item) { 
                        $item->icon('fa fa-copy'); 
                        $item->weight(0); 
                        $item->route('admin.productos.producto.productos_vendidos'); 
                        $item->authorize( 
                            $this->auth->hasAccess('productos.productos.index') 
                        ); 
                    });            
                    $item->item(trans('Flujo de Efectivo'), function (Item $item) { 
                        $item->icon('fa fa-copy'); 
                        $item->weight(0); 
                        $item->route('admin.contabilidad.reportes.flujo_efectivo'); 
                        $item->authorize( 
                            $this->auth->hasAccess('contabilidad.reportes.flujo_caja_config') 
                        ); 
                    }); 
                    

                    $item->item(trans('Ingresos y Egresos'), function (Item $item) { 
                        $item->icon('fa fa-copy'); 
                        $item->weight(0); 
                        //$item->append('admin.contabilidad.reportes.ingreso_egreso_config'); 
                        $item->route('admin.contabilidad.reportes.ingreso_egreso_config'); 
                        $item->authorize( 
                            $this->auth->hasAccess('contabilidad.reportes.ingreso_egreso_config') 
                        ); 
                    }); 
     
                  });
                }
            });
        return $menu;
    }
}
        
