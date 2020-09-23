<?php
namespace controllers;
require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/delivery.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/controllers/controller.php';

final class Delivery extends BaseController
{
    protected function showContent($params)
    {
        if (($params[0] ?? null) === 'office'){
            $deliveryOfficeDefault = \dataAccess\delivery\getDeliveryOffice(intval(explode('delivery_office_', $_GET['id'])[1]));
            $daysInfo = \dataAccess\delivery\getPreDaysData($deliveryOfficeDefault);

            require $_SERVER['DOCUMENT_ROOT'] . '/templates/orders/deliveryShop.php';
        } else {
            require $_SERVER['DOCUMENT_ROOT'] . '/templates/delivery.php';
        }
    }
}
