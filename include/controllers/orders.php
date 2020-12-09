<?php
namespace controllers;
require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/payments.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/delivery.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/dataAccess/orders.php';

final class Order extends Controller
{
    protected function showHeader($params){}
    protected function showFooter($params){}

    protected function showContent($params)
    {
        if(!empty($params['cityId']) && ($params['part'] ?? null) === 'yes') {
            $streets = \dataAccess\delivery\getStreets(intval($params['cityId']));
            require $_SERVER['DOCUMENT_ROOT'] . '/templates/orders/streets.php';
        }
    }

    public static function showOrder()
    {
        $paymentTypes = \dataAccess\payments\getPaymentTypes();
        $deliveryTypes = \dataAccess\delivery\getDeliveryTypes();
        $deliveryOffices = \dataAccess\delivery\getDeliveryOffices();

        $cities = \dataAccess\delivery\getCities();
        $defaultCityId = $cities[0]['id'];

        $streets = \dataAccess\delivery\getStreets($defaultCityId);

        $deliveryTypeDefault = intval($_GET['deliveryType'] ?? 1);
        $deliveryOfficeDefaultId = intval($_GET['deliveryOffice'] ?? 1) ;
        $paymentTypeDefaultId = intval($_GET['paymentType'] ?? 1);
        $deliveryOfficeDefault = \dataAccess\delivery\getDeliveryOffice($deliveryOfficeDefaultId);

        $daysInfo = \dataAccess\delivery\getPreDaysData($deliveryOfficeDefault);

        require $_SERVER['DOCUMENT_ROOT'] . '/templates/orders/createOrder.php';
    }

    protected function processPost($params)
    {
        parent::processPost($params);
        switch ($params[0]) {
            case 'add':
                \dataAccess\orders\createNewOrder(
                    [
                        'goodId' => !empty($_POST['goodId']) ? intval($_POST['goodId']) : null,
                        'paymentId' => !empty($_POST['pay']) ? intval($_POST['pay']) : null,
                        'email' => htmlspecialchars($_POST['email']) ?? null,
                        'surname' => htmlspecialchars($_POST['surname']) ?? null,
                        'name' => htmlspecialchars($_POST['name']) ?? null,
                        'thirdName' => htmlspecialchars($_POST['thirdName']) ?? null,
                        'deliveryTypeId' => !empty($_POST['delivery']) ? intval($_POST['delivery']) : null,
                        'deliveryOfficeId' => (!empty($_POST['delivery_offices']) ? intval($_POST['delivery_offices']) : null),
                        'streetId' => !empty($_POST['street']) ? intval($_POST['street']) : null,
                        'home' => htmlspecialchars($_POST['home']) ?? null,
                        'aprt' => htmlspecialchars($_POST['aprt']) ?? null,
                        'comment' => htmlspecialchars($_POST['comment']) ?? null,
                        'phone' =>  htmlspecialchars($_POST['phone']) ?? null
                    ]);
        }

    }
}

