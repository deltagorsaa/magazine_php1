<?php
namespace controllers\ext\root;
require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/root.php';

function showMenu(string $navClassName,string $ulClassName,bool $isShowActive = true, string $itemClassName = 'main-menu__item')
{
    $menu = \dataAccess\root\getMenu();
    require $_SERVER['DOCUMENT_ROOT'] . '/templates/menu.php';
}
