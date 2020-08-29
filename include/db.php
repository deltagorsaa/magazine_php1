<?php
namespace db;

function getDbConnect()
{
    $dbConnect = mysqli_connect(DB_HOST,DB_LOGIN,DB_PASSWORD,DB_NAME );
    $dbConnect->set_charset('utf8');
    return $dbConnect;
}

function executeQuery($dbQuery, $dbConnect):array
{
    $dbQueryResult = mysqli_query($dbConnect, $dbQuery);
    mysqli_close($dbConnect);
    return $dbQueryResult ? mysqli_fetch_all($dbQueryResult, MYSQLI_ASSOC) : [];
}
