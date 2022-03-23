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

	$prod	=	$db->where('pnum', $_POST['dnum'])->getOne('products');

	if ($db->count == 0){
		$result['err_msg']	=	'不存在此編號商品~!';
		exit(json_encode($result));
	}

	$db->where('pid', $prod['id'])->getOne('discount_products');

	if ($db->count > 0){
		$result['err_msg']	=	'此商品已在特價商品內~!';
		exit(json_encode($result));
	}

	if ($prod['sprice'] == 0){
		$result['err_msg']	=	'此商品尚未有特價~!';
		exit(json_encode($result));
	}

	$data	=	Array();
	$data['pid']	=	$prod['id'];
	$data['pnum']	=	$_POST['dnum'];

	if ($db->insert('discount_products', $data)){
		$result['err_msg']	=	'OK';
	} else {
		$result['err_msg']	=	'DB INSERT ERROR '.$db->getLastError();
	}

	echo json_encode($result);


?>