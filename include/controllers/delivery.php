<?php
namespace controllers;
require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/delivery.php';

final class Delivery extends BaseController
{
    protected function showContent($params)
    {
        if (($params[0] ?? null) === 'office'){
            $deliveryOfficeDefault = \dataAccess\delivery\getDeliveryOffice(intval($_GET['id']));
            $daysInfo = \dataAccess\delivery\getPreDaysData($deliveryOfficeDefault);

            require $_SERVER['DOCUMENT_ROOT'] . '/templates/orders/deliveryShop.php';
        } else {
            require $_SERVER['DOCUMENT_ROOT'] . '/templates/delivery.php';
        }
    }
}
