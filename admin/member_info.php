<?php session_start(); ?>
<?php

	include('../check_ref.php');
	include('../mysql.php');
	require_once ('../MysqliDb.php');

	$result = Array();

	if (!isset($_SESSION['bee_admin'])){
	    $result['err_msg']  =   '-1';
	    exit(json_encode($result));
	}

	$db = new MysqliDb($mysqli);
	$data = Array();

	$data['mname']		=	$_POST['mname'];
	$data['phone']		=	$_POST['phone'];
	$mid 				=	(int)$_POST['mid'];

	if (isset($_POST['password'])){
		$data['password']	=	md5($_POST['password']);
	}

	if ($mid == 0){
		$mid = $db->insert('members', $data);
	} else {
		$db->where('id', $mid)->update('members', $data);
	}

	$result['err_msg'] = 'OK';

	echo json_encode($result);

?>