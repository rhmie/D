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

    $data			=	Array();

    $data['full_banners']    =   NULL;

    if ($_POST['banners'] !== '[]')  $data['full_banners']    =   $_POST['banners'];

    if ($db->update('system', $data)){
        $result['err_msg']  =   'OK';
    } else {
        $result['err_msg'] = 'DB UPDATE ERROR '.$db->getLastError();;
    }

    echo json_encode($result);


?>