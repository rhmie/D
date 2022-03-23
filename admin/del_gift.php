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

	if ($db->where('id', $_POST['gid'])->delete('gifts')){
		$result['err_msg']	=	'OK';
	} else {
		$result['err_msg']	=	'DB DELETE ERROR '.$db->getLastError();
	}

	echo json_encode($result);

?>