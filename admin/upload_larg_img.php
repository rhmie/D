<?php session_start(); ?>
<?php

    $result =   Array();

    if (!isset($_SESSION['bee_admin'])){
        $result['err_msg']  =   '-1';
        exit(json_encode($result));
    } 

    include('../mysql.php');
    require_once ('../MysqliDb.php');
    include('./class.upload.php');
    $db = new MysqliDb($mysqli);


    $system     =   $db->getOne('system');

    $oname =    preg_replace('/\s+/', '', $_POST['oname']);

    $result['oname']    =   $oname;

    $upload_dir = '../banners/';

    if ($_FILES['large_img']['error'] > 0){
        $result['err_msg']  =   $_FILES['large_img']['error'];
        exit(json_encode($result));
    }

    if ($_FILES['large_img']['type'] == 'video/mp4'){
        $moved = move_uploaded_file($_FILES["large_img"]["tmp_name"], "../banners/".$oname.'.mp4');
        if (!$moved){
            $result['err_msg']  =   $_FILES["large_img"]["error"];
            exit(json_encode($result));
        }

        $result['err_msg']  =   'OK';     
        $result['img']  =   $system['weburl'].'banners/'.$oname.'.mp4';

        exit(json_encode($result));

    }

    $pic = new Upload($_FILES['large_img']);

    if ($pic->uploaded) {
        $pic->file_overwrite = true;
        $pic->file_new_name_body = $oname;   
        $pic->image_convert = 'png';
        $pic->image_resize = false;
        
        $pic->Process($upload_dir);
        
        if ($pic->processed) {
            $pic->Clean(); 

            $file = '../banners/'.$oname.'.png';

            $pngimg = imagecreatefrompng($file);

            $w = imagesx($pngimg);
            $h = imagesy($pngimg);;

            $im = imagecreatetruecolor ($w, $h);
            imageAlphaBlending($im, false);
            imageSaveAlpha($im, true);

            $trans = imagecolorallocatealpha($im, 0, 0, 0, 127);
            imagefilledrectangle($im, 0, 0, $w - 1, $h - 1, $trans);

            imagecopy($im, $pngimg, 0, 0, 0, 0, $w, $h);

            imagewebp($im, str_replace('png', 'webp', $file));

            $result['err_msg']  =   'OK';
            $result['img']  =   $system['weburl'].'banners/'.$oname.'.png';
            
        } else {
            $result['err_msg']  =   $pic->error;
        }

    } else {
        $result['err_msg']  =   $pic->error;
    }


   echo json_encode($result); 
    
    


?>