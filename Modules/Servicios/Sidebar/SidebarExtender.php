<?php namespace Modules\Servicios\Sidebar;

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
            $group->item(trans('Servicios'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(9);
                    $item->append('admin.servicios.servicio.create');
                    $item->route('admin.servicios.servicio.index');
                    $item->authorize(
                        $this->auth->hasAccess('servicios.servicios.index')
                    );
                /*
                $item->item(trans('servicios::servicios.title.servicios'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.servicios.servicio.create');
                    $item->route('admin.servicios.servicio.index');
                    $item->authorize(
                        $this->auth->hasAccess('servicios.servicios.index')
                    );
                });
                */
// append

            });
        });

        return $menu;
    }
}
