<?php
namespace dataAccess\goods;

function getGoodsSelectSqlQuery($dbConnect, $filter): string
{
    $addGroupsCode =implode(',', array_map(function ($val) use ($dbConnect) {return "'" . mysqli_real_escape_string($dbConnect, $val) . "'";}, $filter['groups']));
    $codeCount = sizeof($filter['groups']);
    $skip = !empty($filter['page']) ? ($filter['page']- 1) * GOODS_PER_PAGE : null;
    $take = GOODS_PER_PAGE;
    $sort = !empty($filter['sorting']) ? mysqli_real_escape_string($dbConnect, $filter['sorting']['sort']) : null;
    $sortDirection = !empty($filter['sorting']) ? mysqli_real_escape_string($dbConnect, $filter['sorting']['direction']) : null;

    /* Для MySql 8  Уже нужно доделывать
    $dbQuery = "
        with filtredGoods as
        (
            select gg.good_id from good_groups ggr
            join good_group gg on gg.group_id = ggr.id
            join goods on goods.id = gg.good_id and goods.is_active = ${filter['isActive']} and goods.price between ${filter['minPrice']} and ${filter['maxPrice']}
            where " .
        ($codeCount === 1 ? "ggr.code = ${addGroupsCode}" :
            " ggr.code in (${addGroupsCode})
            group by
	            gg.good_id
            having
	            count(gg.good_id) = ${codeCount} ") .
        ")
        select
            (select count(*) from filtredGoods) as count,
            goods.id,
            goods.short_name,
            goods.price,
            goods.image_path
        from filtredGoods
        join goods on goods.id=filtredGoods.good_id " .
        (!empty($sort) && !empty($sortDirection) ?
            "order by
         goods.${sort} ${sortDirection} " : ' ') .
        "limit ${skip}, ${take}";
*/

    $withQuery = "
            select gg.good_id from good_groups ggr 
            join good_group gg on gg.group_id = ggr.id
            join goods on 
                goods.id = gg.good_id 
                and goods.is_active = ${filter['isActive']} "
                . ((!empty($filter['minPrice']) && !empty($filter['maxPrice'])) ? " and goods.price between ${filter['minPrice']} and ${filter['maxPrice']}" : '')
                . " where " .
        ($codeCount === 1 ? "ggr.code = ${addGroupsCode}" :
            " ggr.code in (${addGroupsCode})
            group by
	            gg.good_id
            having
	            count(gg.good_id) = ${codeCount} ");

    return "
        select 
            (select count(*) from (${withQuery}) tmp) as count,
            goods.id,
            goods.short_name,
            goods.price,
            goods.image_path
        from (${withQuery}) as filtredGoods
        join goods on goods.id=filtredGoods.good_id " .
        (!empty($sort) && !empty($sortDirection) ?
            " order by 
         goods.${sort} ${sortDirection} " : ' ') .
        (isset($skip) && isset($take) ? " limit ${skip}, ${take} " : '');
}

function getGoods(array $filter)
{
    $dbConnect = \dataAccess\getDbConnect();
    $dbQuery = getGoodsSelectSqlQuery($dbConnect, $filter);
    return \dataAccess\executeQuery($dbQuery, $dbConnect);
}

function getRangeFilters(array $groupsCode)
{
    $dbConnect = \dataAccess\getDbConnect();
    $baseQuery = getGoodsSelectSqlQuery($dbConnect, ['groups' => $groupsCode, 'isActive' => true]);
    $dbQuery =
        "Select
            'Цена' as name,
            'руб' as dimension,
            'min-price' as min_id,
            'max-price' as max_id,
            MIN(goods.price) as min_value,
            MAX(goods.price) as max_value
        from (
            ${baseQuery}
        ) as goods"
        ;
    return \dataAccess\executeQuery($dbQuery, $dbConnect);
}

function getFilters(array $groupsCode): array
{
    $categories = [];
    $categoryItemFunctions = [
        'category' => function($categoryItem){
            return [
                'name' => $categoryItem['name'],
                'link' => $categoryItem['code'] !== 'all' ? '/goods/' . $categoryItem['code'] . '/' : '/',
                'type' => $categoryItem['type']
            ];
        },
        'checked' => function($categoryItem){
            return [
                'name' => $categoryItem['name'],
                'id' => $categoryItem['code'],
                'type' => $categoryItem['type']
            ];
        },
        'range' => function($categoryItem){
            return [
                'name' => $categoryItem['name'],
                'minValue' => $categoryItem['min_value'] ?? 0,
                'minValueClass' => $categoryItem['min_id'],
                'maxValue' => $categoryItem['max_value'] ?? 0,
                'maxValueClass' => $categoryItem['max_id'],
                'dimension' => $categoryItem['dimension'],
                'type' => 'range'
            ];
        }
    ];

    $dbQuery = "
        select 
            gg.id,
            gg.code,
            gg.short_name as 'name',
            gg.gui_filter_type as 'type'
        from good_groups gg
        where gg.is_gui_visible = true and gg.gui_filter_type is not null
    ";

    foreach(\dataAccess\executeQuery($dbQuery, \dataAccess\getDbConnect()) as $categoryItem){
        array_push($categories, $categoryItemFunctions[$categoryItem['type']]($categoryItem));
    }

    array_push($categories, $categoryItemFunctions['range'](getRangeFilters($groupsCode)[0]));
    return $categories;
}

function getSorting(): array
{
    return [
        [
            'name' => 'Сортировка',
            'id' => 'sort',
            'values' => [
                ['id' => 'price', 'name' => 'По цене'],
                ['id' => 'short_name', 'name' => 'По названию'],
            ]
        ],
        [
            'name' => 'Порядок',
            'id' => 'direction',
            'values' => [
                ['id' => 'asc', 'name' => 'По возрастанию'],
                ['id' => 'desc', 'name' => 'По убыванию']
            ]
        ]
    ];
}
