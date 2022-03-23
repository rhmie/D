<?php 
session_start();
include('./mysql.php');
require_once ('./MysqliDb.php');

$db = new MysqliDb($mysqli);


?>
