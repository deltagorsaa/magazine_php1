<?php
namespace dataAccess\admin;

function getAdminMenu(): array
{
    return [
        [
            'name' => 'Главная',
            'link' => '/'
        ],
        [
            'name' => 'Новинки',
            'link' => '/goods/new/'
        ],
        [
            'name' => 'Sale',
            'link' => '/goods/sale/'
        ],
        [
            'name' => 'Доставка',
            'link' => '/delivery/'
        ]
    ];
}

