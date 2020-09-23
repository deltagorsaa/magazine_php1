<?php
namespace controllers;

require $_SERVER['DOCUMENT_ROOT'] . '/include/controllers/controller.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/goods.php';

final class Goods extends BaseController
{
    protected function showContent($params)
    {
        $this -> setGoodsGroup(htmlspecialchars($params[0] ?? 'all'));

        if (!empty($_GET['part'])){
            self::showGoods();
        } else {
            require $_SERVER['DOCUMENT_ROOT'] . '/templates/main.php';
        }
    }

    private static function setGoodsGroup($groupId)
    {
        $_GET['cat'] = $groupId;
    }

    private static function getGoodsGroupId()
    {
        return $_GET['cat'];
    }

    public static function createGoodsFilterFromUrl(): array
    {
        $groups[] = isset($_GET['cat']) ? htmlspecialchars($_GET['cat']) : 'all';
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

    public static function showGoods()
    {
        $filters = self::createGoodsFilterFromUrl();
        $goods =\dataAccess\goods\getGoods($filters);
        $allCount = isset($goods[0]) ? $goods[0]['count'] : 0;

        require $_SERVER['DOCUMENT_ROOT'] . '/templates/goods/goods.php';
    }

    public static function showFilters()
    {
        $filters = \dataAccess\goods\getFilters(self::getGoodsGroupId());

        $getFilterCallback = function($filterType) {
            return function($value) use ($filterType) {
                return $value['type'] === $filterType;
            };
        };

        $categoryFilters = array_filter($filters, $getFilterCallback('category'));
        $rangeFilters = array_filter($filters, $getFilterCallback('range'));
        $checkedFilters = array_filter($filters, $getFilterCallback('checked'));

        require $_SERVER['DOCUMENT_ROOT'] . '/templates/goods/goodFilters.php';
    }

    public static function showSorting($allCount, $filters)
    {
        $sorting = \dataAccess\goods\getSorting();
        require $_SERVER['DOCUMENT_ROOT'] . '/templates/goods/goodSorting.php';
    }
}
