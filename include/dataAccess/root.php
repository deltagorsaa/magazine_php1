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
            'link' => '/?checked=new'
        ],
        [
            'name' => 'Sale',
            'link' => '/?checked=sale'
        ],
        [
            'name' => 'Доставка',
            'link' => '/delivery/'
        ]
    ];
}
