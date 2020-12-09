<?php
namespace controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/goods.php';

final class Goods extends BaseController
{
    protected function showContent($params)
    {
        $filters = self::createGoodsFilterFromUrl($params);

        if (isset($_GET['part']) && $_GET['part'] === 'true'){
            require $_SERVER['DOCUMENT_ROOT'] . '/templates/mainShopContainer.php';
        } else {
            require $_SERVER['DOCUMENT_ROOT'] . '/templates/main.php';
        }
    }

    public static function createGoodsFilterFromUrl($params = null): array
    {
        $groups[] = htmlspecialchars($params[0] ?? 'all');;
        if (isset($_GET['checked'])) {
            $groups = array_merge($groups, explode('%', htmlspecialchars($_GET['checked'])));
        }

        return [
            'isActive' => true,
            'groups' => array_unique($groups),
            'minPrice' => isset($_GET['min-price']) ? floatval(htmlspecialchars($_GET['min-price'])) : 0,
            'maxPrice' => isset($_GET['max-price']) ? floatval(htmlspecialchars($_GET['max-price'])) : 9999999999999999,
            'sorting' => [
                'sort' => isset($_GET['sort']) ? htmlspecialchars($_GET['sort']) : null,
                'direction' => isset($_GET['direction']) ? htmlspecialchars($_GET['direction']) : null
            ],
            'page' => intval(isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 1)
        ];
    }

    public static function showGoods(array $goods)
    {
        $allCount = isset($goods[0]) ? $goods[0]['count'] : 0;
        require $_SERVER['DOCUMENT_ROOT'] . '/templates/goods/goods.php';
    }

    public static function showFilters(array $filters, $getCustomValues = null)
    {
        $getFilterCallback = function($filterType) {
            return function($value) use ($filterType) {
                return $value['type'] === $filterType;
            };
        };

        $categoryFilters = array_filter($filters, $getFilterCallback('category'));
        $rangeFilters = array_filter($filters, $getFilterCallback('range'));
        $checkedFilters = array_filter($filters, $getFilterCallback('checked'));
        $groupsInput = self::createGoodsFilterFromUrl()['groups'];

        require $_SERVER['DOCUMENT_ROOT'] . '/templates/goods/goodFilters.php';
    }

    public static function showSorting($allCount, $filters)
    {
        $sorting = \dataAccess\goods\getSorting();
        require $_SERVER['DOCUMENT_ROOT'] . '/templates/goods/goodSorting.php';
    }
}
