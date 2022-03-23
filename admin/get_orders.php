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

	if ($_POST['sid'] == '0'){
		$orders	=	$db->orderBy('id', 'desc')->get('orders', Array((int)$_POST['icount'], 8));
	}

	if ($_POST['sid'] == '1'){
		$orders	=	$db->where('pdate', NULL, 'IS')->orderBy('id', 'desc')->get('orders');
	}

	if ($_POST['sid'] == '2'){
		$f1 = new DateTime($_POST['range1']);
		$f2 = new DateTime($_POST['range2']);
		$f1->modify('-1 day');
		$f2->modify('+1 day');

		$orders = $db->where('cdate', $f1->format('Y-m-d'), '>')->where('cdate', $f2->format('Y-m-d'), '<')->get('orders');
	}

	$oitems	=	$pdata 	=	'';

	foreach ($orders as $order){
		$pitems	=	'';

		$pdata 	.=	'<div class="col-12 border-bottom py-4">';
		$pdata 	.=	'<h5 class="font-weight-bold mb-2">'.$order['oid'].'</h5>';
		$pdata 	.=	'<p>日期: '.$order['cdate'].'</p>';

		$prods	=	json_decode($order['content'], true);

		$gift_label 	=	'無';
		if ($order['gift'] > 0){
			$gift 	=	$db->where('id', $order['gift'])->getOne('gifts', Array('gname'));
			if ($db->count > 0){
				$gift_label = $gift['gname'];
			}
		}

		foreach ($prods['prods'] as $prod){
			$p 	=	$db->where('id', $prod['pid'])->getOne('products');
			if ($db->count == 0) continue;

			$imgs	=	explode(',', $p['images']);

			$pdata 	.=	'<p>'.$p['pnum'].'/'.$prod['pname'].'&nbsp;&nbsp;&nbsp;&nbsp;';

			$opts	=	'';
			$opts_data = '';
			foreach ($prod['opts'] as $opt){
				$opts .= '<span class="badge badge-secondary mr-1">'.$opt.'</span>';
				$opts_data .= '/'.$opt;
			}

			$pstock 	=	'<span class="badge badge-secondary float-right">庫存: '.$p['stock'].'</span>';

			if ($p['stock'] < 10){
				$pstock 	=	'<span class="badge badge-danger float-right">庫存: '.$p['stock'].'</span>';
			}

			$pdata .= $opts_data.'&nbsp;&nbsp;&nbsp;&nbsp;數量: '.$prod['cnt'].'/小計: '.$prod['cnt_price'].'</p>';

			$pitems	.=	'<div class="media py-3 border-bottom">
	 		  	            	  <img class="d-flex mr-3" height="80" src="'.$imgs[0].'" alt="'.$p['pname'].'">
	 		  	            	  <div class="media-body align-self-center">
	 		  	            	    <h6 class="mt-0 font-weight-bold">'.$p['pnum'].'/'.$p['pname'].'</h6>
	 		  	            	    <span class="d-block">'.$opts.'</span>
	 		  	            	    <span class="d-block mt-2">數量: '.$prod['cnt'].' / 小計: $'.$prod['cnt_price'].$pstock.'</span>
	 		  	            	  </div>
	 		  	            	</div>';
		}

		if (isset($prods['adds'])){

			if (count($prods['adds']) > 0){
					foreach ($prods['adds'] as $prod){
						$p 	=	$db->where('id', $prod['pid'])->getOne('products');
						if ($db->count == 0) continue;

						$pstock 	=	'<span class="badge badge-secondary float-right">庫存: '.$p['stock'].'</span>';

						if ($p['stock'] < 10){
							$pstock 	=	'<span class="badge badge-danger float-right">庫存: '.$p['stock'].'</span>';
						}

						$imgs	=	explode(',', $p['images']);

						$pdata 	.=	'<p>【加購品】'.$p['pnum'].'/'.$p['pname'].'&nbsp;&nbsp;&nbsp;&nbsp;';

						$opts	=	'';
						foreach ($prod['opts'] as $opt){
							$opts .= '<span class="badge badge-secondary mr-1">'.$opt.'</span>';
							$pdata .= '/'.$opt;
						}

						$pdata .= '&nbsp;&nbsp;&nbsp;&nbsp;數量: '.$prod['cnt'].'小計: '.$prod['cnt_price'].'</p>';

						$pitems	.=	'<div class="media py-3 border-bottom adds">
				 		  	            	  <img class="d-flex mr-3" height="80" src="'.$imgs[0].'" alt="'.$p['pname'].'">
				 		  	            	  <div class="media-body align-self-center">
				 		  	            	    <h6 class="mt-0 font-weight-bold">【加購品】'.$p['pnum'].'/'.$p['pname'].'</h6>
				 		  	            	    <span class="d-block">'.$opts.'</span>
				 		  	            	    <span class="d-block mt-2">數量: '.$prod['cnt'].' / 小計: $'.$prod['cnt_price'].$pstock.'</span>
				 		  	            	  </div>
				 		  	            	</div>';
					}
			}

		}

		$paymode	=	'宅配貨到付款';
		if ($order['pay_method'] == 2) $paymode = '宅配線上付款';
		if ($order['pay_method'] == 3) $paymode = '線上付款超商取貨';
		if ($order['pay_method'] == 4) $paymode = '超商付款取貨';

		$pdata 	.=	'<p>付款方式: '.$paymode.'</p>';


		$time_limited	=	'<p><span class="font-weight-bold">收件時段:</span> 不限制</p>';
		if ($order['time_limited'] == 1) $time_limited = '<p><span class="font-weight-bold">收件時段:</span> 非上班時間送達</p>';

		if ($order['pay_method'] == 3 || $order['pay_method'] == 4){
			$time_limited = '';
		}

		$memo	=	'';
		if (!is_null($order['memo'])){
			$memo	=	'<p><span class="font-weight-bold">其他事項:</span> '.$order['memo'].'</p>';
		}

		$green_info	=	'';
		$color		=	'blue lighten-3';

		$opbtn		=	'';
		if (is_null($order['pdate'])){
			$color	=	'pink lighten-3';
			$opbtn	=	'<button data-oid="'.$order['id'].'" class="btn btn-sm btn-blue-grey do_order"><i class="fas fa-tag mr-2"></i>標示為已出貨</button>';
		}

		if ($order['pay_method'] == 2 || $order['pay_method'] == 3){
			if ($order['rtncode'] !== 1){
				$color	=	'grey';
			}
			$info 	=	'<p class="card-text text-white">用戶選擇金流付款但未完成金流操作</p>';
			if (!is_null($order['green_info'])){
				$info = '';
				$gitems	=	explode(',', $order['green_info']);
				$info .= '<small class="card-text text-white d-block">MerchantID: '.$gitems[0].'</small>';
				$info .= '<small class="card-text text-white d-block">PaymentType: '.$gitems[1].'</small>';
				$info .= '<small class="card-text text-white d-block">PaymentDate: '.$gitems[2].'</small>';
				$info .= '<small class="card-text text-white d-block">RtnCode: '.$gitems[3].'</small>';
				$info .= '<small class="card-text text-white d-block">TradeNo: '.$gitems[4].'</small>';
				$info .= '<small class="card-text text-white d-block">TradeAmt: '.$gitems[5].'</small>';
				$info .= '<small class="card-text text-white d-block">SimulatePaid: '.$gitems[6].'</small>';
			}

			$green_info	=	'<div class="card text-white bg-info my-3">
								  <div class="card-header py-3 border-bottom blue">金流資訊</div>
								  <div class="card-body">
								    '.$info.'
								  </div>
								</div>';
		}

		$user	=	'(非會員)';
		if ($order['mid'] > 0) $user = '(<a href="member_detail.php?mid='.$order['mid'].'" target="_blank">會員</a>)';

		$pdata 	.=	'<p>訂購人: '.$order['mname'].'</p>';
		$pdata 	.=	'<p>收件人: '.$order['oname'].'</p>';
		$pdata 	.=	'<p>訂購人電話: '.$order['mphone'].'</p>';
		$pdata 	.=	'<p>收件人電話: '.$order['ophone'].'</p>';
		$pdata 	.=	'<p>地址: '.$order['addr'].'</p>';
		$pdata 	.=	'<h5 class="font-weight-bold text-right">總價: '.$order['total'].'</h5></div>';

		$oitems .= '<div class="card">
	 		  	    <div class="card-header '.$color.' z-depth-1" role="tab" id="heading'.$order['id'].'">
	 		  	      <h6 class="font-weight-bold mb-0 py-1">
	 		  	        <a class="white-text font-weight-bold d-block" data-toggle="collapse" href="#collapse'.$order['id'].'" aria-expanded="true"
	 		  	          aria-controls="collapse1">
	 		  	          '.$order['oid'].'
	 		  	        </a>
	 		  	      </h6>
	 		  	      <small class="float-right text-white font-weight-bold odate">'.$order['cdate'].'</small>
	 		  	    </div>

	 		  	      <div id="collapse'.$order['id'].'" class="collapse" role="tabpanel" aria-labelledby="heading'.$order['id'].'"
	 		  	        data-parent="#order_accordion">
	 		  	        <div class="card-body">
	 		  	          <div class="row">
	 		  	            <div class="col-md-6 border-right">

	 		  	            	'.$pitems.'
	 		  	              
	 		  	            </div>
	 		  	            <div class="col-md-6 pl-4 pt-3">
	 		  	              <p><span class="font-weight-bold">訂購人:</span> '.$order['mname'].$user.'</p>
	 		  	              <p><span class="font-weight-bold">收件人:</span> '.$order['oname'].'</p>
	 		  	              <p><span class="font-weight-bold">付款方式:</span> '.$paymode.'</p>
	 		  	              <p><span class="font-weight-bold">訂購人電話:</span> '.$order['mphone'].'</p>
	 		  	              <p><span class="font-weight-bold">收件人電話:</span> '.$order['ophone'].'</p>
	 		  	              '.$time_limited.$memo.'
	 		  	              <p><span class="font-weight-bold">地址:</span> '.$order['addr'].'</p>
	 		  	              <p><span class="font-weight-bold">滿額禮:</span> '.$gift_label.'</p>
	 		  	              <p class="font-weight-bold text-right">總金額: '.$order['total'].'</p>
	 		  	              '.$green_info.'
	 		  	              <hr>  	
 		  	              	 	<div class="btn-group btn-block">
 		  	              	 		<button data-oid="'.$order['id'].'" class="btn btn-sm btn-blue-grey del_order"><i class="fas fa-trash-alt mr-2"></i>刪除訂單</button>
 		  	              	 		'.$opbtn.'
 		  	              	 	</div>
	 		  	              	
	 		  	            </div>

	 		  	          </div>
	 		  	        </div>
	 		  	      </div>
	 		  	    </div>';
	}


	$result['err_msg']	=	'OK';
	$result['oitems']	=	$oitems;
	$result['pdata']	=	$pdata;

	echo json_encode($result);

?>