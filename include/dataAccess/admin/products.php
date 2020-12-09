<?php
namespace dataAccess\admin;

use mysql_xdevapi\Exception;

function getProducts(int $id = null)
{
    $dbQuery = "
        select 
            goods.id,
            goods.short_name,
            goods.price,
            goods.image_path,
            goods.is_active,
            ggs.id as group_id,
            ggs.short_name as group_name
        from goods
        left join good_group gg on gg.good_id = goods.id and gg.is_main=1  
        left join good_groups ggs on ggs.id = gg.group_id
        where is_active=1" .
        ($id !== null ? " and goods.id = ${id}" : '')
        . ' order by goods.id desc';
    return \dataAccess\executeQuery($dbQuery, \dataAccess\getDbConnect());
}

function getProductsGroups(int $productId = null)
{
    $dbQuery = ($productId === null
        ? "select * from good_groups gg where gg.id > 1 and gg.gui_filter_type != 'checked'"
        : "
            select
                gg1.id,
                gg1.code,
                gg1.short_name 
            from good_group gg
            join good_groups gg1 on gg.group_id = gg1.id 
            where gg.good_id = ${productId}");
    return \dataAccess\executeQuery($dbQuery, \dataAccess\getDbConnect());
}

function deleteProduct(int $productId)
{
    $dbQuery = "update goods set is_active=0 where id=${productId}";
    return \dataAccess\executeQuery($dbQuery, \dataAccess\getDbConnect());
}

function saveProductImage(array $imageData)
{
    if ($imageData['size'] > IMAGE_MAX_BYTE_SIZE){
        throw new \Exception('Привышение максимального размера');
    }

    if (!in_array(mime_content_type($imageData['tmp_name']), IMAGE_TYPE_RESTRICS)){
        throw new \Exception('Не корректный тип файла');
    }

    $filePath = IMAGE_LIST_PATH . \ext\createNewGuid() . '_' . $imageData['name'];
    return move_uploaded_file($imageData['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $filePath) ? $filePath : null;
}

function saveProduct(array $productData)
{
    $dbConnect = \dataAccess\getDbConnect();
    $dbConnect->autocommit(false);

    try {
        if (isset($productData['image']) && is_array($productData['image'])) {
            $filePath = saveProductImage($productData['image']);
        }

        $name = mysqli_real_escape_string($dbConnect, $productData['shortName']);

        $dbQuery = empty($productData['id']) ?
            "insert into goods (short_name, price, image_path, is_active) values ('${name}', ${productData['price']}, '${filePath}', 1)" :
            "update goods set short_name='${name}', price=${productData['price']}," . (isset($filePath) ? "image_path='${filePath}'," : '') . "is_active=1 where id=${productData['id']}";

       \dataAccess\executeQuery($dbQuery, $dbConnect, false);

        $id = $productData['id'] ?? mysqli_insert_id($dbConnect);
        if ($id === false) {
            throw new \Exception();
        }

        if (!empty($productData['id'])) {
            \dataAccess\executeQuery("delete from good_group where good_id=${productData['id']}", $dbConnect, false);
        }

        array_push($productData['groups'], 'all');
        foreach ($productData['groups'] as $index => $code) {
            $tmpCode = mysqli_real_escape_string($dbConnect, $code);
            \dataAccess\executeQuery("
                insert into good_group 
                select 
	            ${id}
                ,gg.id
                ," .($index === 0 ? '1' : '0')
                . " from good_groups gg where gg.code = '${tmpCode}'", $dbConnect, false);
        }

        $filePathH = $filePath ?? "( select image_path from goods where id = ${id} )";
        $dbQuery = "Insert INTO goods_history (good_id, short_name, price, image_path, is_active) values ($id, '${name}', ${productData['price']}, "
            . (isset($filePath) ? "'${filePath}'" : $filePathH) . ", 1);";
        \dataAccess\executeQuery($dbQuery, $dbConnect, false);

        $dbConnect->commit();
    }
    catch (Exception $ex) {
        if (isset($filePath)) {
            unlink($filePath);
        }

        $dbConnect->rollback();
        http_response_code(500);
        throw $ex;
    }

    $dbConnect->close();
}