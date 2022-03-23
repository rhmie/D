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

	$db->where('language', $_POST['gid'])->getOne('system');

	if ($db->count > 0){
		$result['err_msg']	=	'不能刪除正在使用中的語系~!';
		exit(json_encode($result));
	}

	if ($db->where('id', $_POST['gid'])->delete('language')){
		$result['err_msg']	=	'OK';
	} else {
		$result['err_msg']	=	'DB DELETE ERROR '.$db->getLastError();
	}

	echo json_encode($result);


?>