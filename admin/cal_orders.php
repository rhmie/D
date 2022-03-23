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

	$total	=	$profit	=	$cost	=	$prod_cnt	=	0;

	$first = new DateTime($_POST['sdate']);
	$first->modify('-1 day');

	$last = new DateTime($_POST['edate']);
	$last->modify('+1 day');

	$orders	=	$db->where('pdate', NULL, 'IS NOT')->where('cdate', $first->format('Y-m-d'), '>=')->where('cdate', $last->format('Y-m-d'), '<=')->get('orders');

	$order_count	=	$db->count;

	foreach ($orders as $order){
		$total	=	$total + $order['total'];
		$cart 	=	json_decode($order['content'], true);

		foreach ($cart['prods'] as $item){
			$prod_cnt	=	$prod_cnt + (int)$item['cnt'];
			$prod 		=	$db->where('id', $item['pid'])->getOne('products', 'cost');
			$prod_cost	=	$prod['cost'] * (int)$item['cnt'];
			$profit		=	$profit + (int)$item['cnt_price'] - $prod_cost;
			$cost 		=	$cost + $prod_cost;
		}
	}

	$ship_cnt	=	$total - $cost - $profit;

	$result['cal_result']	=	'<div class="card text-white bg-info mb-3 mx-auto" style="max-width:30rem;">
								  <h5 class="card-header border-bottom">計算結果</h5>
								  <div class="card-body">
								  	<h5 class="py-3 border-bottom text-white">訂單總量: '.$order_count.'</h5>
								    <h5 class="py-3 border-bottom text-white">總營業額: $'.$total.'</h5>
								    <h5 class="py-3 border-bottom text-white">總銷售量: '.$prod_cnt.' 件</h5>
								    <h5 class="py-3 border-bottom text-white">總成本: $'.$cost.'</h5>
								    <h5 class="py-3 border-bottom text-white">總運費: $'.$ship_cnt.'</h5>
								    <h5 class="py-3 border-bottom text-white">總獲利: $'.$profit.'</h5>
								  </div>
								</div>';

	$result['err_msg']	=	'OK';

	$end 	=	new DateTime($_POST['edate']);
	//$end->modify('-1 days');

	$data1 	=	$data2 	=	$data3 	=	Array();
	//日期, 訪客數, 訂單數

	while($first < $end){
		$first->modify('+1 days');
		$vcount 	=	$db->where('Date(cdate)', $first->format('Y-m-d'))->getValue('visitors', 'count(*)');
		$ocount 	=	$db->where('Date(cdate)', $first->format('Y-m-d'))->where('pdate', NULL, 'IS NOT')->getValue('orders', 'count(*)');
		$data1[]	=	'';
		$data2[]	=	$vcount;
		$data3[]	=	$ocount;
	}

	$label1	=	new DateTime($_POST['sdate']);
	$label2	=	new DateTime($_POST['edate']);

	$data1[0]	=	$label1->format('Y/m/d');
	$data1[count($data1)-1]	=	$label2->format('Y/m/d');

	$result['date'] 		=	$data1;
	$result['visitors'] 	=	$data2;
	$result['orders']		=	$data3;

	echo json_encode($result);

?>