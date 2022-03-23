<?php

	include('../mysql.php');
	require_once('../MysqliDb.php');

	$db = new MysqliDb($mysqli);

	$system	=	$db->getOne('system');

    $allpay_ip = array('175.99.72.1', '175.99.72.11', '175.99.72.24', '175.99.72.28', '175.99.72.32');
	$ip = getenv('HTTP_CLIENT_IP')?:
	getenv('HTTP_X_FORWARDED_FOR')?:
	getenv('HTTP_X_FORWARDED')?:
	getenv('HTTP_FORWARDED_FOR')?:
	getenv('HTTP_FORWARDED')?:
	getenv('REMOTE_ADDR');

	if (!in_array($ip, $allpay_ip)){
		exit('<h1>NOT ALLOWED</h1>');
	}

	if (!isset($_POST['RtnCode']) || !isset($_POST['CustomField1'])){
		exit();
	}

	$RtnCode 			= 	$_POST['RtnCode'];

	if ((int)$RtnCode !== 1){
		exit();
	}

	if ($_POST['CustomField1'] == 'month'){
		$db->rawQuery('UPDATE system SET sys_date = DATE_ADD(sys_date, INTERVAL 1 MONTH)');
	}

	if ($_POST['CustomField1'] == 'year'){
		$db->rawQuery('UPDATE system SET sys_date = DATE_ADD(sys_date, INTERVAL 1 YEAR)');
	}


?>