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

	$main	=	$db->where('pnum', $_POST['mnum'])->getOne('products', 'id');

	if ($db->count == 0){
		$result['err_msg']	=	'主商品不存在~!';
		exit(json_encode($result));
	}

	$sub	=	$db->where('pnum', $_POST['pnum'])->getOne('products');

	if ($db->count == 0){
		$result['err_msg']	=	'加購品不存在~!';
		exit(json_encode($result));
	}

	$price	=	(int)$_POST['price'];

	if ($sub['sprice'] > 0){
		if ($price > $sub['sprice']){
			$result['err_msg']	=	'加購品價格不可高於加購品原價~!';
			exit(json_encode($result));
		}
	}

	if ($price > $sub['price']){
		$result['err_msg']	=	'加購品價格不可高於加購品原價~!';
		exit(json_encode($result));
	}

	$data	=	Array();
	$data['mid']	=	$main['id'];
	$data['pid']	=	$sub['id'];
	$data['price']	=	$price;
	$data['cnt']	=	$_POST['pcnt'];

	$oid			=	(int)$_POST['oid'];

	if ($oid > 0){

		if ($db->where('id', $oid)->update('sub_products', $data)){
			$result['err_msg']	=	'OK';
		} else {
			$result['err_msg']	=	'DB UPDATE ERROR '.$db->getLastError();
		}

	} else {

		if ($db->insert('sub_products', $data)){
				$result['err_msg']	=	'OK';
			} else {
				$result['err_msg']	=	'DB INSERT ERROR '.$db->getLastError();
			}
	}

	echo json_encode($result);


?>