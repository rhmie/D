<?php
require_once('include.php');
require_once('securimage/securimage.php');
date_default_timezone_set("Asia/Taipei");
$securimage = new Securimage();
$checkacc = $db->where('account', $_POST['account'])->getOne('members');
if(!isset($_POST['name']))
{
	$result = '未填寫姓名';
	echo $result;
	exit;
}
if(!isset($_POST['account']))
{
	$result = '未填寫帳號';
	echo $result;
	exit;
}
if($checkacc !== NULL)
{
	$result = "帳號".$checkacc['account']."已存在";
	echo $result;
	exit;
}
if(!isset($_POST['password']))
{
	$result = '未填寫密碼';
	echo $result;
	exit;
}
if(!isset($_POST['phone']))
{
	$result = '未填寫手機';
	echo $result;
	exit;
}
if(!isset($_POST['email']))
{
	$result = '未填寫Email';
	echo $result;
	exit;
}
if ($securimage->check($_POST['captcha_code']) == false) {
  $result = '圖形碼不正確';
}else{
	$result = 'OK';
	$post = array(
		"mname"   => $_POST['name'],
		"account" => $_POST['account'],
		"password" => md5($_POST['password']),
		"phone" => $_POST['phone'],
		"email" => $_POST['email'],
		"cdate" => date('Y-m-d H:i:s', time()),
	);
	$db->insert('members',$post);
}

echo $result;
?>
