<?php namespace Modules\Clientes\Sidebar;

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
        $menu->group(trans('core::sidebar.content'), function (Group $group) 
        {
            $group->item(trans('Clientes'), function (Item $item) 
            {
                $item->icon('fa fa-copy');
                $item->weight(2);
                    $item->append('admin.clientes.cliente.create');
                    $item->route('admin.clientes.cliente.index');
                    $item->authorize(
                        $this->auth->hasAccess('clientes.clientes.index')
                    );

                // append

            });
            /*
            $group->item(trans('Test'), function (Item $item) 
            {
                $item->icon('fa fa-copy');
                $item->weight(10);
                    $item->append('admin.clientes.cliente.create');
                    $item->route('admin.clientes.cliente.indexDatatable');
                    $item->authorize(
                        $this->auth->hasAccess('clientes.clientes.index')
                    );

                // append

            });
            */
        });

        return $menu;
    }
}
