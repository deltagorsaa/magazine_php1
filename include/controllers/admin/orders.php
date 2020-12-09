<?php
namespace controllers\admin;

require $_SERVER['DOCUMENT_ROOT'] . '/include/controllers/admin/admin.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/admin/orders.php';

final class Orders extends AdminPages
{
    public function __construct()
    {
        parent::__construct();
        $this -> viewModel['title'] = 'Добавление товара';
    }

    protected function getAccessLevels(): array
    {
        return  [];
    }

    protected function processPost($params)
    {
        parent::processPost($params);
        if($params[1] === 'state' && $params[2] === 'change') {
            \dataAccess\admin\toggleOrderState($params['body']);
        }
    }

    protected function showContent($params)
    {
        $orders = \dataAccess\admin\getOrders();
        require $_SERVER['DOCUMENT_ROOT'] . '/templates/admin/orders.php';
    }
}
