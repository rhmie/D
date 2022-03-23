<?php session_start(); ?>
<?php

    $result =   Array();

    if (!isset($_SESSION['bee_admin'])){
        $result['err_msg']  =   '-1';
        exit(json_encode($result));
    } 

    include('../check_ref.php');
    include('../mysql.php');   
    require_once ('../MysqliDb.php');

    $db = new MysqliDb($mysqli);
    $mid = $_POST['mid'];

    if($db->where('id', $mid)->delete('members')){
        $result['err_msg']  =   'OK';

        $db->where('mid', $mid)->delete('orders');
        $db->where('mid', $mid)->delete('prod_alert');

    } else {
    	$result['err_msg'] =   'DB DELETE ERROR: ' . $db->getLastError();
    }

    echo json_encode($result);

 ?>