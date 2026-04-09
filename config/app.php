<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('APP_NAME', 'ESAE Bénin Course Registration Portal');
define('MAX_CREDIT_UNITS', 24);

date_default_timezone_set('Africa/Lagos');

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/helpers.php';
