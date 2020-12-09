<?php
namespace controllers\admin;

require $_SERVER['DOCUMENT_ROOT'] . '/include/controllers/admin/admin.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/admin/products.php';

final class ProductsAdd extends AdminPages
{
    public function __construct()
    {
        parent::__construct();
        $this -> viewModel['title'] = 'Добавление товара';
    }

    protected function getAccessLevels(): array
    {
        return  [ROLE_ADMIN];
    }

    protected function showContent($params)
    {
        $groups = \dataAccess\admin\getProductsGroups();
        if (in_array('change', $params)  && !empty($params['id'])) {
            $productId = intval($params['id']);
            $changedProduct = \dataAccess\admin\getProducts($productId)[0];
            $changedProductGroups = \dataAccess\admin\getProductsGroups($productId);
        }
        require $_SERVER['DOCUMENT_ROOT'] . '/templates/admin/add.php';
    }

    protected function processPost($params)
    {
        parent::processPost($params);
        $product = [
          'id' => !empty($_POST['id']) ? intval($_POST['id']) : null,
          'shortName' =>  htmlspecialchars($_POST['name']),
          'price' => isset($_POST['price']) ? floatval($_POST['price']) : null,
          'groups' => json_decode($_POST['groups']),
          'image' => $_POST['photo'] ?? $_FILES['photo']
        ];

        \dataAccess\admin\saveProduct($product);
    }

    private function checkInGroup(array $groups, string $groupCode): bool
    {
        return sizeof(array_filter($groups, function ($elm) use ($groupCode) { return ($elm['code'] ?? null) === $groupCode;})) > 0;
    }
}
