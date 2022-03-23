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

	$data	=	Array();
	$data['cname']	=	$_POST['cname'];
	$data['sort']	=	$_POST['sort'];
	$data['content']	=	NULL;

	if (!empty($_POST['icon'])){
		$data['icon']	=	$_POST['icon'];
	}

	if (!empty($_POST['content'])){
		$data['content']	=	$_POST['content'];
	}

	$cid	=	(int)$_POST['cid'];

	if ($cid > 0){

		if ($db->where('id', $_POST['cid'])->update('main_class', $data)){
			$result['err_msg']	=	'OK';
		} else {
			$result['err_msg']	=	'DB UPDATE ERROR '.$db->getLastError();
		}

	} else {

		if ($db->insert('main_class', $data)){
				$result['err_msg']	=	'OK';
			} else {
				$result['err_msg']	=	'DB INSERT ERROR '.$db->getLastError();
			}
	}

	echo json_encode($result);


?>