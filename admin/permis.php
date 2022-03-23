<?php

$admin = (int)$_SESSION['bee_admin'];
$admin_name = $_SESSION['bee_admin_name'];
include('../mysql.php');
require_once('../MysqliDb.php');
$db = new MysqliDb($mysqli);

$me = $db->where('id', $admin)->getOne('admins');
$system     =   $db->getOne('system');

$auth_1 = '';
$auth_2 = '';
$auth_3 = '';
$auth_4 = '';
$auth_5 = '';
$auth_6 = '';
$auth_7 = '';
$auth_8 = '';
$auth_9 = '';
$auth_10 = '';
$auth_11 = '';
$auth_12 = '';
$auth_13 = '';


if ($me['auth_1'] == '0') $auth_1 = 'style="display:none"';
if ($me['auth_2'] == '0') $auth_2 = 'style="display:none"';
if ($me['auth_3'] == '0') $auth_3 = 'style="display:none"';
if ($me['auth_4'] == '0') $auth_4 = 'style="display:none"';
if ($me['auth_5'] == '0') $auth_5 = 'style="display:none"';
if ($me['auth_6'] == '0') $auth_6 = 'style="display:none"';
if ($me['auth_7'] == '0') $auth_7 = 'style="display:none"';
if ($me['auth_8'] == '0') $auth_8 = 'style="display:none"';
if ($me['auth_9'] == '0') $auth_9 = 'style="display:none"';
if ($me['auth_10'] == '0') $auth_10 = 'style="display:none"';
if ($me['auth_11'] == '0') $auth_11 = 'style="display:none"';
if ($me['auth_12'] == '0') $auth_12 = 'style="display:none"';
if ($me['auth_13'] == '0') $auth_13 = 'style="display:none"';



?>