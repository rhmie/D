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

	$blog 	=	$db->where('id', $_POST['bid'])->getOne('blog', 'main_img');

	$fname =  basename($blog['main_img'], '?' . $_SERVER['QUERY_STRING']);
	if (false !== $pos = strripos($fname, '.')) {
	      $fname = substr($fname, 0, $pos);
	  }

	if (file_exists('../blogs/'.$fname.'.png')){
		unlink('../blogs/'.$fname.'.png');
	}

	if (file_exists('../blogs/'.$fname.'.webp')){
		unlink('../blogs/'.$fname.'.webp');
	}

	if ($db->where('id', $_POST['bid'])->delete('blog')){
		$result['err_msg']	=	'OK';
	} else {
		$result['err_msg']	=	'DB DELETE ERROR '.$db->getLastError();
	}

	echo json_encode($result);


?>