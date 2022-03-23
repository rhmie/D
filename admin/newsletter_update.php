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

	$data					=	Array();
	$data['title']			=	$_POST['title'];
	$data['content']		=	$_POST['content'];
	$data['pdate']			=	$_POST['pdate'];
	$data['ptime']			=	$_POST['ptime'];
	$data['cdate']			=	$_POST['pdate'].' '.$_POST['ptime'];

	$bid					=	(int)$_POST['bid'];

	if ($bid == 0){
		if ($db->insert('news_letters', $data)){
		    $result['err_msg']  =   'OK';
		} else {
		    $result['err_msg'] = 'DB INSERT ERROR '.$db->getLastError();;
		}
	} else {
		if ($db->where('id', $bid)->update('news_letters', $data)){
		    $result['err_msg']  =   'OK';
		} else {
		    $result['err_msg'] = 'DB UPDATE ERROR '.$db->getLastError();;
		}
	}

	echo json_encode($result);


?>