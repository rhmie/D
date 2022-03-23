<?php session_start(); ?>
<?php

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$result	=	Array();

	if (!isset($_SESSION['bee_admin'])){
		$result['err_msg']	=	'-1';
	    exit(json_encode($result));
	}

	$system 	=	$db->getOne('system');

	$result['ocount']	=	$system['new_ocount'];

	$result['err_msg']	=	'OK';
	echo json_encode($result);

?>