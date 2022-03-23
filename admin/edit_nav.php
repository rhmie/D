<?php session_start(); ?>
<?php

	include("../mysql.php");
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$result	=	Array();

	if (!isset($_SESSION['bee_admin'])){
		$result['err_msg']	=	'-1';
	    exit(json_encode($result));
	} 

	$data 					=	Array();
	$data['nav_name']		=	$_POST['nav_name'];
	$data['sort']			=	$_POST['sort'];

	$sid					=	(int)$_POST['sid'];

	if ($sid > 0){

		if ($db->where('id', $sid)->update('nav_items', $data)){
			$result['err_msg']	=	'OK';
		} else {
			$result['err_msg']	=	'DB UPDATE ERROR '.$db->getLastError();
		}

	} else {

		if ($db->insert('nav_items', $data)){
				$result['err_msg']	=	'OK';
			} else {
				$result['err_msg']	=	'DB INSERT ERROR '.$db->getLastError();
			}
	}

	echo json_encode($result);

?>