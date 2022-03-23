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

    $count = $db->where('pnum', $_POST['pnum'])->getValue('products', 'count(*)');

    if ($count == 0){
        $result['err_msg']  =   '商品不存在~!';
    } else {
        $result['err_msg']  =   'OK';
    }

    echo json_encode($result);


?>