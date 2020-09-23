<?php
    require $_SERVER['DOCUMENT_ROOT'] . '/config.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/include/constants.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/include/db.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/include/functions.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/routes.php';

    $route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $urlParts = array_values(array_filter(explode('/', $route), function($elm){ return !empty($elm); }));
    $params = array_slice($urlParts, 1);

    $route = substr($route, -1) === '/' ? substr_replace($route, '', -1) : $route;
    $controllerData = array_filter(getRouteMapping(), function ($value) use ($route) {
        static $flag = false;
        if (!$flag && preg_match($value['match'], $route) > 0) {
            $flag = true;
            return true;
        }
        return false;
    });

    if (empty($controllerData)) {
        \ext\redirectTo('/');
    } else {
        $controllerData = array_shift($controllerData);
        $controllerFullFilePath = $_SERVER['DOCUMENT_ROOT'] . $controllerData['path'] . $controllerData['name'] . '.php';
        require $controllerFullFilePath;

        $controllerClass = '\controllers\\' . ucfirst(strtolower($controllerData['name']));
        $controller = new $controllerClass();
        $controller -> execute(array_slice($urlParts, 1));
    }
