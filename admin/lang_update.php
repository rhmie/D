<?php session_start(); ?>
<?php

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	include('../simple_html_dom.php');
	$db = new MysqliDb($mysqli);

	$result	=	Array();

	if (!isset($_SESSION['bee_admin'])){
		$result['err_msg']	=	'-1';
	    exit(json_encode($result));
	}

	if (empty($_POST['content']) || empty($_POST['gname'])){
		$result['err_msg'] = '欄位錯誤';
		exit(json_encode($result));
	}

	$data 	=	Array();
	$data['gname']		=	$_POST['gname'];
	$data['content']	=	$_POST['content'];

	$sid			=	(int)$_POST['sid'];

	if ($sid > 0){

		if ($db->where('id', $sid)->update('language', $data)){
			$result['err_msg']	=	'OK';
		} else {
			$result['err_msg']	=	'DB UPDATE ERROR '.$db->getLastError();
		}

	} else {

		if ($db->insert('language', $data)){
				$result['err_msg']	=	'OK';
			} else {
				$result['err_msg']	=	'DB INSERT ERROR '.$db->getLastError();
			}
	}

	echo json_encode($result);


?>