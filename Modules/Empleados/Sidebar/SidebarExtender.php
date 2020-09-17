<?php namespace Modules\Empleados\Sidebar;

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
            $user = $this->auth->check();
            if($user and $user->get_full_permisos)
                $permisos_especiales_modulo = $user->get_full_permisos->get("Permisos Especiales Empleados");
            else
                $permisos_especiales_modulo = false;
       
            if( isset($permisos_especiales_modulo) and $permisos_especiales_modulo and isset($permisos_especiales_modulo['Ver Empleados en Sidebar']) and $permisos_especiales_modulo['Ver Empleados en Sidebar'])
            {
  
                $group->item(trans('Empleados'), function (Item $item) 
                {
                    $item->icon('fa fa-copy');
                    $item->weight(7);
                    $item->authorize(
                         /* append */
                    );
                    $item->item(trans('Empleado'), function (Item $item) 
                    {
                        $item->icon('fa fa-copy');
                        $item->weight(1);
                        $item->append('admin.empleados.empleado.create');
                        $item->route('admin.empleados.empleado.index');
                        $item->authorize(
                            $this->auth->hasAccess('empleados.empleados.index')
                        );
                    });
                    $item->item(trans('Pago Empleado'), function (Item $item) 
                    {
                        $item->icon('fa fa-copy');
                        $item->weight(0);
                        //$item->append('admin.empleados.pagoempleado.create');
                        $item->route('admin.empleados.pagoempleado.index');
                        $item->authorize(
                            $this->auth->hasAccess('empleados.pagoempleados.index')
                        );
                    });

                    $item->item(trans('Anticipos'), function (Item $item) 
                    {
                        $item->icon('fa fa-copy');
                        $item->weight(0);
                        $item->append('admin.empleados.anticipos.create');
                        $item->route('admin.empleados.anticipos.index');
                        $item->authorize(
                            $this->auth->hasAccess('empleados.anticipos.index')
                        );
                    });
                });

            }

        });

        return $menu;
    }
}
