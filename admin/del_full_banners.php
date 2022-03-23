<?php session_start(); ?>
<?php

    $result =   Array();

    if (!isset($_SESSION['bee_admin'])){
        $result['err_msg']  =   '-1';
        exit(json_encode($result));
    } 

    $img =  basename($_POST['img1'], '?' . $_SERVER['QUERY_STRING']);
    if (false !== $pos = strripos($img, '.')) {
          $img = substr($img, 0, $pos);
      }

    if (file_exists('../banners/'.$img.'.png')){
        unlink('../banners/'.$img.'.png');
    }

    if (file_exists('../banners/'.$img.'.webp')){
        unlink('../banners/'.$img.'.webp');
    }

    if (file_exists('../banners/'.$img.'.mp4')){
        unlink('../banners/'.$img.'.mp4');
    }

    $img =  basename($_POST['img2'], '?' . $_SERVER['QUERY_STRING']);
    if (false !== $pos = strripos($img, '.')) {
          $img = substr($img, 0, $pos);
      }

    if (file_exists('../banners/'.$img.'.png')){
        unlink('../banners/'.$img.'.png');
    }

    if (file_exists('../banners/'.$img.'.webp')){
        unlink('../banners/'.$img.'.webp');
    }

    if (file_exists('../banners/'.$img.'.mp4')){
        unlink('../banners/'.$img.'.mp4');
    }

    $img =  basename($_POST['img3'], '?' . $_SERVER['QUERY_STRING']);
    if (false !== $pos = strripos($img, '.')) {
          $img = substr($img, 0, $pos);
      }

    if (file_exists('../banners/'.$img.'.png')){
        unlink('../banners/'.$img.'.png');
    }

    if (file_exists('../banners/'.$img.'.webp')){
        unlink('../banners/'.$img.'.webp');
    }

    if (file_exists('../banners/'.$img.'.mp4')){
        unlink('../banners/'.$img.'.mp4');
    }

    $result['err_msg']  =   'OK';

    echo json_encode($result);


?>