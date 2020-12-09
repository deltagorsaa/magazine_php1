<?php
namespace dataAccess\delivery;

function getDeliveryTypes(): array
{
    $dbConnection = \dataAccess\getDbConnect();
    $dbQuery = 'select * from delivery_types';
    return \dataAccess\executeQuery($dbQuery, $dbConnection);
}

function getDeliveryOffices():array{
    $dbConnection = \dataAccess\getDbConnect();
    $dbQuery = "
        select
            dof.id,
            countries.name as country,
            cities.name as city,
            streets.name as street,
            dof.street_number,
            dof.room
        from delivery_offices dof
        join streets on streets.id = dof.street_id
        join cities on cities.id = streets.city_id
        join countries on countries.id = cities.country_id";
    return \dataAccess\executeQuery($dbQuery, $dbConnection);
}

function getCities():array
{
    return \dataAccess\executeQuery('select id, name from cities', \dataAccess\getDbConnect());
}

function getStreets(int $cityId):array
{
    return \dataAccess\executeQuery("select id, name from streets where city_id = ${cityId}", \dataAccess\getDbConnect());
}

function getDeliveryOffice($officeId): array
{
    $dbConnection = \dataAccess\getDbConnect();
    $dbQuery = "
        select
            dof.id,
            dof.min_delivery_day,
            dof.max_delivery_day,
            dofw.day_number,
            dofw.worktime_from,
            dofw.worktime_to,
            countries.name as country,
            cities.name as city,
            streets.name as street,
            dof.street_number,
            dof.room,
            pt.name as payment_type
        from delivery_offices dof
        join delivery_office_worktime dofw on dof.id = dofw.office_id 
        join delivery_office_payment_type dofp on dof.id = dofp.office_id
        join payment_types pt on dofp.payment_type_id = pt.id
        join streets on streets.id = dof.street_id
        join cities on cities.id = streets.city_id
        join countries on countries.id = cities.country_id
        where dof.id = ${officeId}
        order by dofw.day_number";
    return \dataAccess\executeQuery($dbQuery, $dbConnection);
}

function getPreDaysData($deliveryOfficeDefault): array
{
    foreach ($deliveryOfficeDefault as $dayInfo) {
        $daysInfo[$dayInfo['worktime_from'] . ' - ' . $dayInfo['worktime_to']][] = $dayInfo['day_number'];
    }
    return $daysInfo;
}
