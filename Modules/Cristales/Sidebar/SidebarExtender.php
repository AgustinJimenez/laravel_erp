<?php namespace Modules\Cristales\Sidebar;

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
            $group->item(trans('Cristales'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(8);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('Categoría de Cristales'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.cristales.categoriacristales.create');
                    $item->route('admin.cristales.categoriacristales.index');
                    $item->authorize(
                        $this->auth->hasAccess('cristales.categoriacristales.index')
                    );
                });
                $item->item(trans('Cristales'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(1);
                    $item->append('admin.cristales.cristales.create');
                    $item->route('admin.cristales.cristales.index');
                    $item->authorize(
                        $this->auth->hasAccess('cristales.cristales.index')
                    );
                });
                $item->item(trans('Tipos/Graduaciones'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(2);
                    $item->append('admin.cristales.tipocristales.create');
                    $item->route('admin.cristales.tipocristales.index');
                    $item->authorize(
                        $this->auth->hasAccess('cristales.tipocristales.index')
                    );
                });
// append



            });
        });

        return $menu;
    }
}
