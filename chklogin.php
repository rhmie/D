<?php include('./include.php');?>
<?php require_once('securimage/securimage.php');?>
<?php
	$securimage = new Securimage();

	$result = Array();

	if (empty($_POST['account']) || empty($_POST['password'])){
		$result['err_msg'] = 'FIELD POST ERROR.';
		echo $result['err_msg'];
		exit;
	}

	$mobile = $mysqli->real_escape_string(htmlspecialchars($_POST['account']));
	$password = md5($mysqli->real_escape_string(htmlspecialchars($_POST['password'])));

	$member = $db->where('account', $mobile)->where('password', $password)->getOne('members');

	if ($db->count == 0){
		$result['err_msg'] = '＊帳號或密碼錯誤＊';
		echo $result['err_msg'];
		exit;
	}

	$_SESSION['bee_member']  = $member['id'];
	$_SESSION['bee_name']    = $member['mname'];
	$_SESSION['bee_email']   = $member['email'];
	$_SESSION['bee_phone']   = $member['phone'];
	if ($securimage->check($_POST['captcha_code']) == false) {
	  $result['err_msg'] = '圖形碼不正確';
	}else{
		$result['err_msg'] = 'OK';
	}
	echo $result['err_msg'];


?>
