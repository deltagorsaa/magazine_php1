<?php
function getRouteMapping()
{
    return [
        ['match' => "/^\/admin\/products\/change$/u", 'name' => '\admin\ProductsAdd', 'path' => "/include/controllers/admin/add.php"],
        ['match' => "/^\/admin\/products\/add$/u", 'name' => '\admin\ProductsAdd', 'path' => "/include/controllers/admin/add.php"],
        ['match' => "/^\/admin\/products$/u", 'name' => '\admin\Products', 'path' => "/include/controllers/admin/products.php"],
        ['match' => "/^\/admin\/orders\/state\/change$/u", 'name' => '\admin\Orders', 'path' => "/include/controllers/admin/orders.php"],
        ['match' => "/^\/admin\/orders$/u", 'name' => '\admin\Orders', 'path' => "/include/controllers/admin/orders.php"],
        ['match' => "/^\/admin$/u", 'name' => '\admin\Admin', 'path' => "/include/controllers/admin/admin.php"],
        ['match' => "/^\/orders\/streets$/u" , 'name' => '\Order', 'path' => "/include/controllers/orders.php"],
        ['match' => "/^\/orders\/user/u" , 'name' => '\Order', 'path' => "/include/controllers/orders.php"],
        ['match' => "/^\/orders\/add$/u" , 'name' => '\Order', 'path' => "/include/controllers/orders.php"],
        ['match' => "/^\/delivery\/office$/u" , 'name' => '\Delivery', 'path' => "/include/controllers/delivery.php"],
        ['match' => "/^\/delivery$/u" , 'name' => '\Delivery', 'path' => "/include/controllers/delivery.php"],
        ['match' => "/^\/goods\/[^\/]+$/u", 'name' => '\Goods' , 'path' => "/include/controllers/goods.php"],
        ['match' => "/^\/goods$/u", 'name' => '\Goods' , 'path' => "/include/controllers/goods.php"],
        ['match' => "/^$/u", 'name' => '\Goods' , 'path' => "/include/controllers/goods.php"]
    ];
}
