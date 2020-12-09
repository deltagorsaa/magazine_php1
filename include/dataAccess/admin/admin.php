<?php
namespace dataAccess\admin;

use function db\executeQuery;
use function db\getDbConnect;

function getAdminMenu(): array
{
    return [
        [
            'name' => 'Главная',
            'link' => '/'
        ],
        [
            'name' => 'Товары',
            'link' => '/admin/products/',
            'accessRoles' => [ROLE_ADMIN]
        ],
        [
            'name' => 'Заказы',
            'link' => ADMIN_ORDERS_URL,
            'accessRoles' => [ROLE_ADMIN, ROLE_OPERATOR]
        ],
        [
            'name' => 'Выйти',
            'link' => ADMIN_LOGOFF_URL
        ]
    ];
}

function getAuthData(string $login, string $password)
{
    $dbConnect = \dataAccess\getDbConnect();
    $login = mysqli_real_escape_string($dbConnect, $login);
    $password = hash('sha256', mysqli_real_escape_string($dbConnect, $password));

    $dbQuery = "
        select * from user_group ug
        join users on ug.user_id = users.id and users.email = '${login}' and users.password='${password}' and users.is_active = 1 and users.is_client = 0";

    return \dataAccess\executeQuery($dbQuery, $dbConnect);
}
