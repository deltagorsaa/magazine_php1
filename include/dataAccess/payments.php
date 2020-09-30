<?php
namespace dataAccess\payments;

function getPaymentTypes(): array
{
    $dbConnection = \dataAccess\getDbConnect();
    $dbQuery = 'select * from payment_types';
    return \dataAccess\executeQuery($dbQuery, $dbConnection);
}
