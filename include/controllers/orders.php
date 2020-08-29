<?php
namespace controllers\orders;
require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/payments.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/delivery.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/orders.php';

function getNewOrderFromData(): array
{
    return [];
}

function showCreateOrder()
{
    $paymentTypes = \dataAccess\payments\getPaymentTypes();
    $deliveryTypes = \dataAccess\delivery\getDeliveryTypes();
    $deliveryOffices = \dataAccess\delivery\getDeliveryOffices();

    $deliveryTypeDefault = intval($_GET['deliveryType'] ?? 1);
    $deliveryOfficeDefaultId = intval($_GET['deliveryOffice'] ?? 1) ;
    $paymentTypeDefaultId = intval($_GET['paymentType'] ?? 1);
    $deliveryOfficeDefault = \dataAccess\delivery\getDeliveryOffice($deliveryOfficeDefaultId);

    $daysInfo = \dataAccess\delivery\getPreDaysData($deliveryOfficeDefault);

    require $_SERVER['DOCUMENT_ROOT'] . '/templates/orders/createOrder.php';
}

function show($urlPartArray)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $urlPartArray[0] === 'add'){
        \dataAccess\orders\insertNewOrder(getNewOrderFromData());
    }
}
