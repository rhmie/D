<?php session_start(); ?>
<?php

	date_default_timezone_set("Asia/Taipei");

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	include('./class.upload.php');

	$db = new MysqliDb($mysqli);

	$system 	=	$db->getOne('system');

	$result	=	Array();

	if (!isset($_SESSION['bee_admin'])){
		$result['err_msg']	=	'-1';
	    exit(json_encode($result));
	}

	$oname =	preg_replace('/\s+/', '', $_POST['oname']);

	$pwidth = 800;

	if ($_POST['dir'] == 'images'){
		 $pwidth = 256;
		 $oname = 'logo';
	} else {
		$pwidth = 800;
	}

	$file = '../'.$_POST['dir'].'/'.$oname.'.png';

	$pic = new Upload($_FILES['img']);

	if ($pic->uploaded) {
	    $pic->file_overwrite = true;
	    $pic->file_new_name_body = $oname;   
	    $pic->image_convert = 'png';
	    $pic->image_resize = true;
	    $pic->image_x = $pwidth;
	    $pic->image_ratio_y = true;
	    
	    $pic->Process('../'.$_POST['dir'].'/');

	    $result['err_msg']  =   'OK';
	    
	    if ($pic->processed) {
	        $pic->Clean(); 
	        create_webp($file);
	        
	    } else {
	        $result['err_msg']  =   $pic->error;
	        exit(json_encode($result));
	    }

	} else {
	    $result['err_msg']  =   $pic->error;
	    exit(json_encode($result));
	}



	
	function create_webp($file){
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

	}
	

	

	$result['err_msg']	=	'OK';
	$result['img']	=	$system['weburl'].$_POST['dir'].'/'.$oname.'.png';

	echo json_encode($result);



?>