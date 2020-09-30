<?php
namespace controllers\admin;

require $_SERVER['DOCUMENT_ROOT'] . '/include/controllers/admin/admin.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/admin/products.php';

final class Products extends AdminPages
{
    public function __construct()
    {
        parent::__construct();
        $this -> viewModel['title'] = 'Товары';
    }

    protected function getAccessLevels(): array
    {
        return  [ROLE_ADMIN];
    }

    protected function showContent($params)
    {
        $products = \dataAccess\admin\getProducts();
        require $_SERVER['DOCUMENT_ROOT'] . '/templates/admin/products.php';
    }

    protected function processDelete($params)
    {
        return \dataAccess\admin\deleteProduct(intval($params['body']));
    }
}
