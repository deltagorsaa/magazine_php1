<?php
namespace dataAccess\orders;

function createNewOrder(array $orderData)
{
    $dbConnect = \dataAccess\getDbConnect();
    $dbConnect->autocommit(false);

    try {
        $user = getUserInfo(mysqli_real_escape_string($dbConnect, $orderData['email']));
        if (empty($user)) {
            $dbQuery = "insert into users (full_name, email, password, phone, is_active, is_client) values ("
                . "'" . mysqli_real_escape_string($dbConnect, $orderData['surname']) . ' ' . mysqli_real_escape_string($dbConnect, $orderData['name']) . ' ' . mysqli_real_escape_string($dbConnect, $orderData['thirdName']) . "', "
                . "'" . mysqli_real_escape_string($dbConnect, $orderData['email']) . "', "
                . "'" . hash('sha256', 'qwertyQWERTY123') . "', "
                . "${orderData['phone']}, 1, 1)";
            \dataAccess\executeQuery($dbQuery, $dbConnect, false);
            $userId = mysqli_insert_id($dbConnect);
        }

        $dbQuery = "insert into orders (payment_type_id, delivery_type_id, delivery_office_id, street_id, street_number, room, comment, create_by, status) values (".
            "${orderData['paymentId']}, ${orderData['deliveryTypeId']}, ${orderData['deliveryOfficeId']},"
            . ($orderData['streetId'] ?? 'null') . ","
            . (!empty($orderData['home']) ? ("'" . mysqli_real_escape_string($dbConnect, $orderData['home']) . "'") : 'null') . ","
            . (!empty($orderData['aprt']) ? ( "'" . mysqli_real_escape_string($dbConnect, $orderData['aprt']) . "'") : 'null') . ","
            . (!empty($orderData['comment']) ? ("'" . mysqli_real_escape_string($dbConnect, $orderData['comment']) . "'") : 'null') . ","
            . ($userId ?? $user[0]['id']) . ","
            . "0)";
        \dataAccess\executeQuery($dbQuery, $dbConnect, false);

        $newOrderId = mysqli_insert_id($dbConnect);

        $dbQueryGoodId = "(SELECT id FROM goods_history where good_id=${orderData['goodId']} and change_at = (select max(change_at) from goods_history where good_id=${orderData['goodId']}))";
        $dbQuery = "insert into order_good values (${newOrderId}, ${dbQueryGoodId}, 1)";
        \dataAccess\executeQuery($dbQuery, $dbConnect, false);

        $dbConnect->commit();
    }
    catch (\Exception $ex) {
        $dbConnect->rollback();
        $dbConnect->close();
        throw $ex;
    }

    $dbConnect->close();
}

function getUserInfo($email): array
{
    $dbConnect = \dataAccess\getDbConnect();
    $email = mysqli_real_escape_string($dbConnect, $email);
    return \dataAccess\executeQuery("select id, full_name as fullName, phone from users where is_active=1 and email='${email}'", $dbConnect);
}