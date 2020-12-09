<?php
define('GOODS_PER_PAGE', 9);
define('STANDARD_DELIVERY_COST', 280);
define('NO_PRICE_MIN_ORDER_COST', 2000);
define('ON_DAY_DELIVERY_COST', 560);
define('WEEK_DAYS', [['понедельник', 'пн'], ['вторник' ,'вт'], ['среда', 'ср'], ['четверг', 'чт'], ['пятница', 'пт'], ['суббота', 'сб'], ['воскресенье', 'вс']]);
define('MONTH', [['январ', 'я'], ['феврал' ,'я'], ['март', 'а'], ['апрел', 'я'], ['ма', 'я'], ['июн', 'я'], ['июл', 'я'] ,['август', 'а'] ,['сентябр', 'я'] ,['октябр', 'я'] ,['ноябр', 'я'] ,['дакабр', 'я']]);
define('PHP_SESSION_NAME', 'diplom_sn');
define('PHP_SESSION_EXPIRE_MIN', 600);
define('PHP_SESSION_COOKIE_LIFETIME_MIN', 30);
define('IMAGE_TYPE_RESTRICS',  ['image/jpeg', 'image/png', 'image/gif', 'image/bmp']);
define('IMAGE_MAX_BYTE_SIZE',  5 * pow(1024, 2));
define('IMAGE_LIST_PATH', '/img/products/');

define('ADMIN_ORDERS_URL', '/admin/orders/');
define('ADMIN_LOGOFF_URL', '/admin?logoff=true');

define('ROLE_OPERATOR', 1);
define('ROLE_ADMIN', 2);
