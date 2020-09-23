<?php
namespace controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/include/controllers/admin.php';

final class AdminOrders extends BaseAuth
{
    protected function showContent($params)
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/templates/admin/orders.php';
    }
}
