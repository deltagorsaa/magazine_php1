<?php
namespace ext;

function isCurrentUrl(string $url): bool
{
    static $currentUrl;
    $currentUrl = $currentUrl ?? remoteLastSplash(strtolower(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));

    return $currentUrl === remoteLastSplash($url);
}

function remoteLastSplash($url)
{
    return substr($url, -1) === '/' ? substr_replace($url, '', -1) : $url;
}

function showMenu(array $menu, string $navClassName,string $ulClassName, bool $isShowActive = true, array $userRoles = [], string $itemClassName = 'main-menu__item')
{
    require $_SERVER['DOCUMENT_ROOT'] . '/templates/menu.php';
}

function redirectTo($url)
{
    header('Location: '. $url,true, 302);
    exit();
}

function createNewGuid()
{
    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}
