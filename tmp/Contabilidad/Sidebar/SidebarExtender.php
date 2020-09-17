<?php namespace Modules\Contabilidad\Sidebar;

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
            $group->item(trans('Contabilidad'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
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
                /*
                $item->item(trans('contabilidad::asientodetalles.title.asientodetalles'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.contabilidad.asientodetalle.create');
                    $item->route('admin.contabilidad.asientodetalle.index');
                    $item->authorize(
                        $this->auth->hasAccess('contabilidad.asientodetalles.index')
                    );
                });
                */  



            });
        });

        return $menu;
    }
}
