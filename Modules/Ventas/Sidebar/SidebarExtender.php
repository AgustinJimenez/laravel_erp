<?php namespace Modules\Ventas\Sidebar;

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
            $group->item(trans('Ventas'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(0);
                $item->authorize(
                     /* append */
                );

                $item->item(trans('Crear Preventa'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->route('admin.ventas.venta.create',['isPreventa'=>1]);
                    $item->authorize(
                        $this->auth->hasAccess('ventas.ventas.index')
                    );
                });

                $item->item(trans('Crear Venta'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(1);
                    $item->route('admin.ventas.venta.create',['isVenta'=>1]);
                    $item->authorize(
                        $this->auth->hasAccess('ventas.ventas.index')
                    );
                });

                $item->item(trans('Preventas'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(2);
                    $item->route('admin.ventas.venta.index_preventa');
                    $item->authorize(
                        $this->auth->hasAccess('ventas.ventas.index')
                    );
                });

                $item->item(trans('Ventas'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(3);
                    $item->route('admin.ventas.venta.index');
                    $item->authorize(
                        $this->auth->hasAccess('ventas.ventas.index')
                    );
                });

                $item->item(trans('Facturas'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(4);
                    $item->route('admin.ventas.facturaventa.index');
                    $item->authorize(
                        $this->auth->hasAccess('ventas.ventas.index')
                    );
                });

                $item->item(trans('Facturas Pendientes'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(5);
                    $item->route('admin.ventas.facturaventa.index',['pendiente=1']);
                    $item->authorize(
                        $this->auth->hasAccess('ventas.ventas.index')
                    );
                });
                $item->item(trans('Crear Otras Ventas'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(6);
                    $item->route('admin.ventas.venta.create',['isOtros'=>1]);
                    $item->authorize(
                        $this->auth->hasAccess('ventas.ventas.index')
                    );
                });
                $item->item(trans('Otras Ventas'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(7);
                    //$item->route('admin.ventas.facturaventa.index',['isOtros'=>1]); 
                    $item->route('admin.ventas.otras_ventas.index');
                    $item->authorize(
                        $this->auth->hasAccess('ventas.ventas.index')
                    );
                });

                $item->item(trans('Editar N° de Factura'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(8);
                    $item->route('admin.ventas.facturaventa.edit_nro_factura');
                    $item->authorize(
                        $this->auth->hasAccess('ventas.ventas.index')
                    );
                });

                $item->item(trans('Editar N° de Sobre'), function (Item $item) 
                {
                    $item->icon('fa fa-copy');
                    $item->weight(9);
                    $item->route('admin.ventas.venta.edit_nro_seguimiento');
                    $item->authorize(
                        $this->auth->hasAccess('ventas.ventas.index')
                    );
                });

                $item->item(trans('Historial Caja Ita'), function (Item $item) 
                {
                    $item->icon('fa fa-copy');
                    $item->weight(10);
                    $item->route('admin.contabilidad.cuenta.historial', ['id' => \Cuenta::where('codigo', "01.01.01.02.01")->first()->id,'fecha_inicio_historial' => date('d/m/Y'), 'fecha_fin_historial' => date('d/m/Y')]);
                    $item->authorize
                    (
                        $this->auth->hasAccess('contabilidad.cuentas.historial-solo-caja-ita')
                    );
                });
            });
        });

        return $menu;
    }
}
