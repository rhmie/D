<?php session_start(); ?>
<?php

	date_default_timezone_set("Asia/Taipei");

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$result	=	Array();

	if (!isset($_SESSION['bee_admin'])){
		$result['err_msg']	=	'-1';
	    exit(json_encode($result));
	}

	$fname =  basename($_POST['url'], '?' . $_SERVER['QUERY_STRING']);
	if (false !== $pos = strripos($fname, '.')) {
	      $fname = substr($fname, 0, $pos);
	  }

	if (file_exists('../'.$_POST['dir'].'/'.$fname.'.png')){
		unlink('../'.$_POST['dir'].'/'.$fname.'.png');
	}

	if (file_exists('../'.$_POST['dir'].'/'.$fname.'.webp')){
		unlink('../'.$_POST['dir'].'/'.$fname.'.webp');
	}

	$result['err_msg']	=	'OK';
	echo json_encode($result);

?>