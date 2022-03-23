<?php session_start(); ?>
<?php
	date_default_timezone_set("Asia/Taipei");
	include('../check_ref.php');
	include_once('../ECPay.Payment.Integration.php');

	if (!isset($_SESSION['bee_admin'])){
		echo '<h1>登入逾期，請重新登入<h1>';
		echo '<meta http-equiv=REFRESH CONTENT=1;url=./login.php>';
		exit();
	}

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$system	=	$db->getOne('system');

	$test_mode = true; //正式環境改為 false

	// $HashKey				=	'y1ibQ2LTRHhkHZpm';
	// $HashIV					=	'UPBTUf6ZqMBn6M76';
	// $MerchantID				=	'3132933';


	$HashKey		=	"5294y06JbISpM5x9";
	$HashIV			=	"v77hoKGq4kWxNNIS";
	$MerchantID		=	"2000132";
	$ServiceURL		=	'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';	//測試環境
	//$ServiceURL		=	'https://payment.ecpay.com.tw/Cashier/AioCheckOut/V5';	//正視環境
	$order_finished_server	=	$system['weburl'].'admin/gods_finished_server.php';
	$order_finished_client	= 	$system['weburl'].'admin/gods_finished_client.php';
	$redirect_button_url	=	'https://gods.tw/';


	$t 			= 	microtime(true);
	$x 			= 	floor(($t - floor($t)) * 100);
	$micro 		= 	sprintf("%02d",$x);
	$vtime		=	new DateTime();
	$trad_num	=	'P'.$vtime->format('YmdHis').$micro;

	$pname 	=	'諸神之站年繳';

	try
	{
	    $oPayment = new ECPay_AllInOne();
	    /* 服務參數 */
	    $oPayment->ServiceURL 	=	$ServiceURL;
	    $oPayment->HashKey		=	$HashKey;
	    $oPayment->HashIV 		=	$HashIV	;
	    $oPayment->MerchantID	=	$MerchantID;
	    $oPayment->EncryptType 	= 	'1';   
	    /* 基本參數 */
	    $oPayment->Send['ReturnURL']			=	$order_finished_server;			//[您要收到付款完成通知的伺服器端網址]
	    $oPayment->Send['ClientBackURL']		=	$redirect_button_url;  		//[您要返回按鈕導向的瀏覽器端網址]
	    $oPayment->Send['OrderResultURL']		=	$order_finished_client;  	//[您要收到付款完成通知的瀏覽器端網址]"
	    $oPayment->Send['MerchantTradeNo']		=	$trad_num;					//[您此筆訂單交易編號]
	    $oPayment->Send['MerchantTradeDate']	=	date('Y/m/d H:i:s');
	    $oPayment->Send['TotalAmount']			=	6999;				//[您此筆訂單的交易總金額]
	    $oPayment->Send['TradeDesc']			=	$pname;					//[您該筆訂單的描述]
	    $oPayment->Send['ChoosePayment']		=	ECPay_PaymentMethod::ALL;			//付款方式				//[您要填寫的其他備註]
	    $oPayment->Send['IgnorePayment']		=	""; 					// [您不要顯示的付款方式] 例(財富通):Tenpay
	    $oPayment->Send['CustomField1']			=	"year"; 	//會員ID
	    // 加入選購商品資料。

		array_push($oPayment->Send['Items'], array('Name' => $pname, 'Price' => 6999,
		    	'Currency' => "元", 'Quantity' => 1, 'URL' => ""));
	    

	    /* 產生訂單 */
	    $oPayment->CheckOut();
	    /* 產生產生訂單 Html Code 的方法 */
	    $szHtml = $oPayment->CheckOutString();

	    //echo $szHtml;
	}
	catch (Exception $e){
	    // 例外錯誤處理。
	    throw $e;
	    
	}



?>