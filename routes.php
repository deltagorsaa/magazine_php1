<?php
function getRouteMapping()
{
    return [
        ['match' => "/^\/admin\/orders$/u", 'name' => 'AdminOrders', 'path' => "/include/controllers/"],
        ['match' => "/^\/admin$/u", 'name' => 'Admin', 'path' => "/include/controllers/"],
        ['match' => "/^\/delivery$/u" , 'name' => 'Delivery', 'path' => "/include/controllers/"],
        ['match' => "/^\/goods\/[^\/]+$/u", 'name' => 'Goods' , 'path' => "/include/controllers/"],
        ['match' => "/^$/u", 'name' => 'Goods' , 'path' => "/include/controllers/"]
    ];
}
