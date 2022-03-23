<?php session_start(); ?>
<?php

	date_default_timezone_set("Asia/Taipei");

	include("../mysql.php");
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$result	=	Array();

	if (!isset($_SESSION['bee_admin'])){
		$result['err_msg']	=	'-1';
	    exit(json_encode($result));
	}

	$system	=	$db->getOne('system');

	$lan    =   $db->where('id', $system['language'])->getOne('language');
	$lan   	=   json_decode($lan['content'], true);

	$order 	=	$db->where('id', $_POST['oid'])->getOne('orders');

	if ($db->count == 0){
		$result['err_msg']	=	'訂單不存在，請重新整理';
	    exit(json_encode($result));
	}

	//增加商品銷售量並減少庫存
	$items			=	json_decode($order['content'], true);

	foreach($items['prods'] as $item){
		$sql	=	'UPDATE products SET volume = volume + '.$item['cnt'].', stock = stock - '.$item['cnt'].' WHERE id = '.$item['pid'];
		$db->rawQuery($sql);
	}

	foreach($items['adds'] as $item){
		$sql	=	'UPDATE products SET volume = volume + '.$item['cnt'].', stock = stock - '.$item['cnt'].' WHERE id = '.$item['pid'];
		$db->rawQuery($sql);
	}

	//更新滿額禮
	if ($order['gift'] > 0){
		$db->rawQuery('UPDATE gifts SET stock = stock - 1 WHERE id = '.$order['gift']);
	}

	$last = new DateTime();
	$db->rawQuery('UPDATE orders SET pdate = "'.$last->format('Y-m-d H:i').'" WHERE id = '.$_POST['oid']);

	if ($system['sms_ship'] == 1 && !is_null($system['sms_account']) && !is_null($system['sms_pass'])){
		$msg 	=	$lan['lan147'];
		send_sms($order['mphone'], $msg, '0', $system['sms_account'], $system['sms_pass']);
	}

	function send_sms($phone, $msg, $longsms, $acc, $pass){
		$msg = urlencode($msg);
		$ch = curl_init();
		$url = 'http://api.message.net.tw/send.php?longsms='.$longsms.'&id='.$acc.'&password='.$pass.'&tel='.$phone.'&msg='.$msg.'&mtype=G&encoding=utf8';
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$content= curl_exec($ch);
		curl_close($ch);

		return $content;

	}

	$result['err_msg']	=	'OK';
	echo json_encode($result);

?>