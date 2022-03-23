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

	$data 				=	Array();
	$data['gname']		=	$_POST['gname'];
	$data['price']		=	$_POST['price'];
	$data['stock']		=	$_POST['stock'];

	if (!empty($_POST['gimg']))
		$data['pic']		=	$_POST['gimg'];

	if ((int)$_POST['gid'] > 0){
		if ($db->where('id', $_POST['gid'])->update('gifts', $data)){
			$result['err_msg']	=	'OK';
		} else {
			$result['err_msg']	=	'DB UPDATE ERROR '.$db->getLastError();
		}
	} else {
		if ($db->insert('gifts', $data)){
			$result['err_msg']	=	'OK';
		} else {
			$result['err_msg']	=	'DB INSERT ERROR '.$db->getLastError();
		}
	}

	echo json_encode($result);


?>