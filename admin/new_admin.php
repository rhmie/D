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
    include('./class.upload.php');
    $db = new MysqliDb($mysqli);

    foreach($_REQUEST as $k=>$v){
    	$$k = $mysqli->real_escape_string($v);
    }

    $data['admin_name'] = $admin_name;
    $data['auth_1'] = '0';
    $data['auth_2'] = '0';
    $data['auth_3'] = '0';
    $data['auth_4'] = '0';
    $data['auth_5'] = '0';
    $data['auth_6'] = '0';
    $data['auth_7'] = '0';
    $data['auth_8'] = '0';
    $data['auth_9'] = '0';
    $data['auth_10'] = '0';
    $data['auth_11'] = '0';
    $data['auth_12'] = '0';
    $data['auth_13'] = '0';



    if (!empty($password)) $data['password'] = md5($password);

    if (isset($auth_1)) $data['auth_1'] = '1';
    if (isset($auth_2)) $data['auth_2'] = '1';
    if (isset($auth_3)) $data['auth_3'] = '1';
    if (isset($auth_4)) $data['auth_4'] = '1';
    if (isset($auth_5)) $data['auth_5'] = '1';
    if (isset($auth_6)) $data['auth_6'] = '1';
    if (isset($auth_7)) $data['auth_7'] = '1';
    if (isset($auth_8)) $data['auth_8'] = '1';
    if (isset($auth_9)) $data['auth_9'] = '1';
    if (isset($auth_10)) $data['auth_10'] = '1';
    if (isset($auth_11)) $data['auth_11'] = '1';
    if (isset($auth_12)) $data['auth_12'] = '1';
    if (isset($auth_12)) $data['auth_13'] = '1';

    if ($aid == '0'){
    	$aid = $db->insert('admins', $data);
    } else {
        $aid = $_POST['aid'];
    	$db->where('id', $aid)->update('admins', $data);
    }

    $upload_dir = './avt/';
    $pic = new Upload($_FILES['avt']);
    if ($pic->uploaded) {
        $pic->file_overwrite = true;
        $pic->file_new_name_body = $aid;   
        $pic->image_convert = 'png';
        $pic->image_resize = true;
        $pic->image_ratio = true;
        $pic->image_x = 300;
        
        $pic->Process($upload_dir);
        
        if ($pic->processed) {
            $pic->Clean();      
        } 
        
    }

    if ($aid){
    	$result['err_msg']  =   'OK';
    } else {
    	$result['err_msg'] =   'DB UPDATE ERROR ' . $db->getLastError();
    }

    echo json_encode($result);


 ?>