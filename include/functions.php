<?php
namespace ext;

function isCurrentUrl(string $url): bool
{
    static $currentUrl;
    $currentUrl = $currentUrl ?? strtolower(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

    return $currentUrl === $url;
}

function showMenu(array $menu, string $navClassName,string $ulClassName,bool $isShowActive = true, string $itemClassName = 'main-menu__item')
{
    require $_SERVER['DOCUMENT_ROOT'] . '/templates/menu.php';
}

function redirectTo($url)
{
    header('Location: '. $url,true, 302);
    exit();
}
