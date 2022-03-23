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

	$page 	=	$db->where('id', $_POST['sid'])->getOne('pages');

	if ($db->where('id', $_POST['sid'])->delete('pages')){
		$result['err_msg']	=	'OK';
		if (file_exists('../'.$page['pagename'].'.html')){
			unlink('../'.$page['pagename'].'.html');
		}
	} else {
		$result['err_msg'] = 'DB DELETE ERROR '.$db->getLastError();
	}

	echo json_encode($result);

?>