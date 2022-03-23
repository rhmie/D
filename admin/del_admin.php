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
    $aid = $_POST['aid'];

    $db->where('id', $aid);
    if($db->delete('admins')){
        if (file_exists('./avt/'.$aid.'.png')){
            unlink('avt/'.$aid.'.png');
        }
    	$result['err_msg']  =   'OK';
    } else {
    	$result['err_msg'] =   'delete failed: ' . $db->getLastError();
    }

    echo json_encode($result);

 ?>