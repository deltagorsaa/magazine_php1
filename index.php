<?php
    require $_SERVER['DOCUMENT_ROOT'] . '/config.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/include/constants.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/include/db.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/include/functions.php';

    $urlParts = array_values(array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), function($elm){ return !empty($elm); }));

    if (empty($_GET['part'])) {
        require $_SERVER['DOCUMENT_ROOT'] . '/templates/rootHeader.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
    }

    $controller = $urlParts[0] ?? 'goods';

    require $_SERVER['DOCUMENT_ROOT'] . "/include/controllers/${controller}.php";
    call_user_func("\\controllers\\${controller}\\show", array_slice($urlParts, 1));

    if (empty($_GET['part'])) {
        require $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/templates/rootFooter.php';
    }
