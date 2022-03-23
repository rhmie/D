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
	$data['oname']	=	$_POST['oname'];
	$data['onick']	=	$_POST['onick'];
	$data['opts']	=	$_POST['opts'];

	$oid			=	(int)$_POST['oid'];

	if ($oid > 0){

		if ($db->where('id', $oid)->update('options', $data)){
			$result['err_msg']	=	'OK';
		} else {
			$result['err_msg']	=	'DB UPDATE ERROR '.$db->getLastError();
		}

	} else {

		if ($db->insert('options', $data)){
				$result['err_msg']	=	'OK';
			} else {
				$result['err_msg']	=	'DB INSERT ERROR '.$db->getLastError();
			}
	}

	echo json_encode($result);


?>