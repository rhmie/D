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


	$subs 	=	$db->where('mid', $_POST['mid'])->orderBy('sort', 'asc')->get('sub_class');

	$sub_items	=	'';

	foreach ($subs as $sub) {
		$sub_items .= '<option value="'.$sub['id'].'">'.$sub['cname'].'</option>';
	}

	$result['err_msg']	=	'OK';
	$result['sub_items']	=	$sub_items;

	echo json_encode($result);

?>