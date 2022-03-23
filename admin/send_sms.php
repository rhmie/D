<?php session_start(); ?>
<?php

	include('../check_ref.php');

	if (!isset($_SESSION['bee_admin'])){
	    exit('-1');
	}

	function send_sms($phone, $msg, $longsms, $acc, $pass){
		$msg = urlencode(mb_convert_encoding($msg, 'big5', 'utf-8'));
		$ch = curl_init();
		$url = 'http://api.message.net.tw/send.php?longsms='.$longsms.'&id='.$acc.'&password='.$pass.'&tel='.$phone.'&msg='.$msg.'&mtype=G';
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$content= curl_exec($ch);
		curl_close($ch);

		return $content;

	}

	$result	=	Array();

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$system	=	$db->getOne('system');

	if (is_null($system['sms_account']) || is_null($system['sms_pass'])){
		$result['err_msg']	=	'簡訊帳號密碼錯誤~!';
		exit(json_encode($result));
	}

	$content 	= 	$_POST['content'];
	$target 	=	$_POST['target'];


	$longsms = '0';

	if (mb_strlen(trim($content)) > 70){
		$longsms = '1';
	}

	if ($target == '4'){

		$result['sms']	=	send_sms($_POST['phone'], $content, $longsms, $system['sms_account'], $system['sms_pass']);
		$result['err_msg']	=	'OK';

	} else {

		$sql	=	'SELECT phone FROM members';

		if ($_POST['residence'] !== '0'){
			$sql .= ' WHERE county = '.$_POST['residence'];
		}

		$members = $db->rawQuery($sql);

		$result['sql'] = $sql;

		$phones = '';

		if ($db->count == 0){
			$result['err_msg'] = 'NO MEMBERS';
			exit(json_encode($result));
		}

		foreach ($members as $member){
			$phones .= $member['mobile'].';';
		}

		$result['phones']	=	$phones;
		$result['err_msg']	=	'OK';

		$result['sms'] = send_sms($phones, $content, $longsms, $system['sms_account'], $system['sms_pass']);
	}




	echo json_encode($result);


?>