<?php
    require $_SERVER['DOCUMENT_ROOT'] . '/config.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/include/constants.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/db.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/include/functions.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/routes.php';

    $route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $urlParts = array_values(array_filter(explode('/', $route), function($elm){ return !empty($elm); }));
    $params = array_slice($urlParts, 1);

    $queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) . '&';
    array_map(function($elm) use (&$params){
        if ($elm != null) {
            $kv = explode('=', $elm);
            $params[$kv[0]] = $kv[1];
        }
    }, explode('&', $queryString));
    $params['body'] = htmlspecialchars(file_get_contents('php://input'));

    $route = \ext\remoteLastSplash($route);
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
        $controllerFullFilePath = $_SERVER['DOCUMENT_ROOT'] . $controllerData['path'];
        require $controllerFullFilePath;

        $controllerClass = '\controllers' . ucfirst(strtolower($controllerData['name']));
        $controller = new $controllerClass();
        $controller -> execute($params);
    }
