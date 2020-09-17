<?php namespace Modules\Caja\Sidebar;

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
/*
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('Caja'), function (Item $item) {
                $item->icon('fa fa-copy');
                //$item->append('admin.caja.caja.create');
                $item->route('admin.caja.caja.index');
                $item->weight(5);
                $item->authorize(
                     
                );
                
                

                $item->item(trans('Otros Movimientos'), function (Item $item) 
                {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.caja.caja.create_movimiento');
                    $item->route('admin.caja.caja.index_movimientos_activo');
                    $item->authorize(
                        $this->auth->hasAccess('caja.cajas.index')
                    );
                });
            
                $item->item(trans('caja::cajas.title.cajas'), function (Item $item) 
                {
                    $item->icon('fa fa-copy');
                    $item->weight(1);
                    $item->append('admin.caja.caja.create');
                    $item->route('admin.caja.caja.index');
                    $item->authorize(
                        $this->auth->hasAccess('caja.cajas.index')
                    );
                });

                
            });
        });
*/
        return $menu;
    }
}
