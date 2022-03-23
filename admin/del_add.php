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

	if ($db->where('id', $_POST['oid'])->delete('sub_products')){
		$result['err_msg']	=	'OK';
	} else {
		$result['err_msg'] = 'DB DELETE ERROR '.$db->getLastError();
	}

	$count = $db->getValue('sub_products', 'count(*)');
	$m_total_pages = ceil($count / 8);
	if ($m_total_pages == 0) $m_total_pages = 1;

	$result['total_page']	=	$m_total_pages;

	echo json_encode($result);

?>