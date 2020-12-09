<?php
namespace dataAccess\admin;

function getOrders(): array
{
    $dbQuery = "
    select 
        ord.id, 
        ord.delivery_type_id, 
        ord.street_number, 
        ord.room, 
        ord.comment, 
        ord.status,
        usr.full_name,
        usr.phone,
        dt.name as delivery_type_name,
        pt.name as payment_type_name,
        ifnull(streets.name, streets1.name) as street,
        ifnull(cities.name, cities1.name) as city,
        ifnull(countries.name, countries1.name) as country,
        ifnull(ord.room, doff.room) as room_number,
        ifnull(ord.street_number, doff.street_number) as street_number,
        sum(og.count * gh.price) as summa
    from orders ord
    join order_good og on og.order_id = ord.id
    join goods_history gh on gh.id = og.good_id
    join users usr on usr.id = ord.create_by 
    join delivery_types dt on dt.id = ord.delivery_type_id
    join payment_types pt on ord.payment_type_id = pt.id
    left join streets on streets.id = ord.street_id
    left join cities on cities.id = streets.city_id
    left join countries on countries.id = cities.country_id
    left join delivery_offices doff on doff.id = ord.delivery_office_id
    left join streets streets1 on streets1.id = doff.street_id
    left join cities cities1 on cities1.id = streets1.city_id
    left join countries countries1 on countries1.id = cities1.country_id
    group by
        ord.id, 
        ord.delivery_type_id, 
        ord.street_number, 
        ord.room, 
        ord.comment, 
        ord.status,
        usr.full_name,
        usr.phone,
        dt.name,
        pt.name,
        streets.name,
        cities.name,
        streets1.name,
        cities1.name,
        countries.name,
        countries1.name,
        doff.street_number,
        doff.room
    order by  ord.id desc";

    return \dataAccess\executeQuery($dbQuery, \dataAccess\getDbConnect());
}

function toggleOrderState(int $orderId)
{
    return \dataAccess\executeQuery("update orders set status=not status where id=${orderId}", \dataAccess\getDbConnect());
}
