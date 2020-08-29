<?php
namespace dataAccess\payments;

function getPaymentTypes(): array
{
    $dbConnection = \db\getDbConnect();
    $dbQuery = 'select * from payment_types';
    return \db\executeQuery($dbQuery, $dbConnection);
}
