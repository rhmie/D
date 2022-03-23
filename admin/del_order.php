<?php session_start(); ?>
<?php

	include('../check_ref.php');
	include('../mysql.php');
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$result	=	Array();

	if (!isset($_SESSION['bee_admin'])){
		$result['err_msg']	=	'-1';
	    exit(json_encode($result));
	}

	$order	=	$db->where('id', $_POST['oid'])->getOne('orders');

	if ($db->count == 0){
		$result['err_msg']	=	'訂單不存在，請重新整理';
	    exit(json_encode($result));
	}

	if ($db->where('id', $_POST['oid'])->delete('orders')){
		$result['err_msg']	=	'OK';
	} else {
		$result['err_msg'] = 'DB UPDATE ERROR '.$db->getLastError();
	}

	echo json_encode($result);

?>