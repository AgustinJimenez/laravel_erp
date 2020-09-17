<?php namespace Modules\Productos\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Badge;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Contracts\Authentication;
use Modules\Page\Repositories\PageRepository;
use Modules\Productos\Entities\Producto;

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
            $group->item(trans('Productos'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(3);
                $item->authorize(
                     /* append */
                );
                
                $item->item(trans('Categorias'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.productos.categoriaproducto.create');
                    $item->route('admin.productos.categoriaproducto.index');
                    $item->authorize(
                        $this->auth->hasAccess('productos.categoriaproductos.index')
                    );
                });
                
                $item->item(trans('Marcas'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(1);
                    $item->append('admin.productos.marca.create');
                    $item->route('admin.productos.marca.index');
                    $item->authorize(
                        $this->auth->hasAccess('productos.marcas.index')
                    );
                });

                $item->item(trans('Productos'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(2);
                    $item->append('admin.productos.producto.create');
                    $item->route('admin.productos.producto.index');
                    $item->authorize(
                        $this->auth->hasAccess('productos.productos.index')
                    );
                });

                $item->item(trans('Stock Crítico'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(3);
                    $item->route('admin.productos.producto.index_stock_critico');

                    $count_stock_critico = count(Producto::whereRaw('productos__productos.stock <= productos__productos.stock_minimo')->get());
                    if($count_stock_critico>0)
                    {
                        $item->badge(function (Badge $badge) use ($count_stock_critico) 
                        {
                            $badge->setClass('bg-red')->setValue( $count_stock_critico );
                        });
                    }

                    $item->authorize(
                        $this->auth->hasAccess('productos.altabajaproductos.index')
                    );
                });

                $item->item(trans('Alta-Baja'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(4);
                    $item->append('admin.productos.altabajaproducto.seleccionProductos');
                    $item->route('admin.productos.altabajaproducto.index');
                    $item->authorize(
                        $this->auth->hasAccess('productos.altabajaproductos.index')
                    );
                });
/*
                $item->item(trans('Inventario de Productos'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.productos.producto.inventario_producto_performance');
                    $item->route('admin.productos.producto.inventario_producto_performance');
                    $item->authorize(
                        $this->auth->hasAccess('productos.productos.inventario_producto_performance')
                    );
                });
*/
                // $item->item(trans('Productos Vendidos'), function (Item $item) {
                //     $item->icon('fa fa-copy');
                //     $item->weight(0);
                //     $item->route('admin.productos.producto.productos_vendidos');
                //     $item->authorize(
                //         $this->auth->hasAccess('productos.productos.index')
                //     );
                // });

            });
        });

        return $menu;
    }
}
