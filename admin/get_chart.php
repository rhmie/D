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

	$visitors 	=	 $db->orderBy('id', 'asc')->get('visitors');

	$first 		= 	new DateTime($visitors[0]['cdate']);
	$last 		=	new DateTime();

	$first->modify('-1 days');
	$last->modify('-1 days');

	//$days 		= 	$first->diff($last)->format('%r%a');

	$data1 	=	$data2 	=	$data3 	=	Array();
	//日期, 訪客數, 訂單數

	while($first < $last){
		$first->modify('+1 days');
		$vcount 	=	$db->where('Date(cdate)', $first->format('Y-m-d'))->getValue('visitors', 'count(*)');
		$ocount 	=	$db->where('Date(cdate)', $first->format('Y-m-d'))->where('pdate', NULL, 'IS NOT')->getValue('orders', 'count(*)');
		$data1[]	=	'';
		$data2[]	=	$vcount;
		$data3[]	=	$ocount;
	}

	$label1	=	new DateTime($visitors[0]['cdate']);
	$label2	=	new DateTime();

	$data1[0]	=	$label1->format('Y/m/d');
	$data1[count($data1)-1]	=	$label2->format('Y/m/d');

	$result['date'] 		=	$data1;
	$result['visitors'] 	=	$data2;
	$result['orders']		=	$data3;

	echo json_encode($result);


?>