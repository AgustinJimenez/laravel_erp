<?php namespace Modules\Compras\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Contracts\Authentication;

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
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('Compras'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(1);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('Compras'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    //$item->append('admin.compras.compra.create');
                    $item->route('admin.compras.compra.index');
                    $item->authorize(
                        $this->auth->hasAccess('compras.compras.index')
                    );
                });

                $item->item(trans('Compra Producto'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(1);
                    $item->route('admin.compras.compra.create',['isProducto=1']);
                    $item->authorize(
                        $this->auth->hasAccess('compras.compras.index')
                    );
                });

                $item->item(trans('Compra Cristal'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(2);
                    $item->route('admin.compras.compra.create',['isCristal=1']);
                    $item->authorize(
                        $this->auth->hasAccess('compras.compras.index')
                    );
                });

                $item->item(trans('Compra Otros'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(3);
                    $item->route('admin.compras.compra.create',['isOtro=1']);
                    $item->authorize(
                        $this->auth->hasAccess('compras.compras.index')
                    );
                });

                $item->item(trans('Pago Servicio'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(4);
                    $item->route('admin.compras.compra.create',['isServicio=1']);
                    $item->authorize(
                        $this->auth->hasAccess('compras.compras.index')
                    );
                });

                $item->item(trans('Facturas Pendientes'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(5);
                    $item->route('admin.compras.compra.index_pendientes');
                    $item->authorize(
                        $this->auth->hasAccess('compras.compras.index')
                    );
                });
                
// append       
                
/*
                $item->item(trans('Reporte de Gastos Concepto'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->route('admin.compras.compra.reporte_gastos_performance');
                    $item->authorize(
                        $this->auth->hasAccess('compras.compras.reporte_gastos_performance')
                    );
                });
*/




                
/*                $item->item(trans('Editar Nro Factura'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    //$item->append('admin.compras.compra.create');
                    $item->route('admin.compras.compra.edit_config_factura');
                    $item->authorize(
                        $this->auth->hasAccess('compras.compras.index')
                    );
                });
*/

            });
        });

        return $menu;
    }
}
