<?php
namespace controllers\admin;

require $_SERVER['DOCUMENT_ROOT'] . '/include/controllers/admin/admin.php';

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

    protected function showContent($params)
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/templates/admin/orders.php';
    }
}
