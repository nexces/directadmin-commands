<?php

/**
 * Defines constants:
 * DIRECTADMIN_URL
 * MASTER_ADMIN_USERNAME
 * MASTER_ADMIN_PASSWORD
 */
if (file_exists(__DIR__ . '/credentials.php')) {
    require_once __DIR__ . '/credentials.php';
}
define('PASSWORD_LENGTH', 16);
/**
 * @return string
 */
function generateTemporaryPassword()
{
    static $base = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $result = '';
    for($i = 0; $i < PASSWORD_LENGTH; $i++)
        $result .= $base[mt_rand(0, strlen($base)-1)];
    for($i = 0; $i < 100; $i++)
        $result = str_shuffle($result);
    return $result;
}
!defined('ADMIN_USERNAME') && define('ADMIN_USERNAME', 'testadmin');
!defined('ADMIN_PASSWORD') && define('ADMIN_PASSWORD', generateTemporaryPassword());
!defined('RESELLER_USERNAME') && define('RESELLER_USERNAME', 'testresell');
!defined('RESELLER_PASSWORD') && define('RESELLER_PASSWORD', generateTemporaryPassword());
!defined('USER_USERNAME') && define('USER_USERNAME', 'testuser');
!defined('USER_PASSWORD') && define('USER_PASSWORD', generateTemporaryPassword());
!defined('TEST_EMAIL') && define('TEST_EMAIL', 'example@test.dev');
!defined('TEST_RESELLER_DOMAIN') && define('TEST_RESELLER_DOMAIN', 'reseller.test.dev');
!defined('TEST_USER_DOMAIN') && define('TEST_USER_DOMAIN', 'user.test.dev');

// Include composer autoload
require __DIR__ . '/../vendor/autoload.php';
