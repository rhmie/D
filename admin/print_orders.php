<?php session_start(); ?>
<?php

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$result	=	Array();

	if (!isset($_SESSION['bee_admin'])){
		exit('<h1>登入逾期，請重新登入</h1>');
	}

	if (empty($_POST['print_data'])){
		exit('<h1>沒有列印資料</h1>');
	}

?>

<!DOCTYPE html>
<html lang="en">

	<head>
	    <!-- Required meta tags always come first -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <meta content="ie=edge" http-equiv="x-ua-compatible">
	    <title>列印訂單</title>
	    <!-- Font Awesome -->
	    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
	    <!-- Bootstrap core CSS -->
	    <link rel="preconnect" href="https://fonts.gstatic.com">
	    <link href="https://fonts.googleapis.com/css2?family=Josefin+Slab:wght@100&display=swap" rel="stylesheet">
	    <link href="../css/bootstrap.min.css" rel="stylesheet">
	    <link href="../css/mdb.min.css" rel="stylesheet">

	</head>

	<style>
		p {
			line-height: .9rem;
		}
	</style>
	<body>

		<div class="container my-4">
			<div class="row">
				<?=$_POST['print_data']?>
				<!-- <div class="col-12 border-bottom py-2">
					<h5 class="font-weight-bold mb-2">P2021090523121495</h5>
					<p>日期: 2021-09-05 23:12:00</p>
					<p>100741620015/商品名稱&nbsp;&nbsp;&nbsp;&nbsp;紫色/120&nbsp;&nbsp;&nbsp;&nbsp;數量: 2/小計: 200</p>
					<p>付款方式: 超商付款取貨</p>
					<p>訂購人: 韓月希(會員)</p>
					<p>訂購人: 韓月希</p>				
					<p>訂購人電話: 0970334380</p>
					<p>收件人電話: 0970334380</p>
					<p>地址: 【權鑫門市】【982661】台北市大同區民權西路157之1號1樓</p>
					<h5 class="font-weight-bold text-right">總價: 1200</h5>
				</div> -->
			</div>
		</div>


	</body>
</html>