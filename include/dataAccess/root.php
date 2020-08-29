<?php
namespace dataAccess\root;

function getMenu(): array
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

