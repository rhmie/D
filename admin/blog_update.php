<?php session_start(); ?>
<?php

	date_default_timezone_set("Asia/Taipei");

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	include('./class.upload.php');
	$db = new MysqliDb($mysqli);

	$result	=	Array();

	if (!isset($_SESSION['bee_admin'])){
		$result['err_msg']	=	'-1';
	    exit(json_encode($result));
	}

	$system 	=	$db->getOne('system', 'weburl');

	$data					=	Array();
	$data['title']			=	$_POST['title'];
	$data['sub_title']		=	$_POST['sub_title'];
	$data['main_img']		=	$_POST['main_img'];
	$data['content']		=	$_POST['content'];
	$data['status']			=	$_POST['status'];
	$data['related']		=	NULL;

	if (!empty($_POST['related'])){
		$prods = explode(',', $_POST['related']);

		foreach($prods as $prod){
			$db->where('pnum', $prod)->getOne('products');
			if ($db->count == 0){
				$result['err_msg']	=	'商品'.$prod.'不存在~!';
				exit(json_encode($result));
			}
		}

		$data['related']		=	$_POST['related'];
	}

	if(file_exists($_FILES['main_upimg']['tmp_name']) || is_uploaded_file($_FILES['main_upimg']['tmp_name'])) {
		$oname =    $_POST['main_img'];

		if (false !== $pos = strripos($oname, '.')) {
		      $oname = substr($oname, 0, $pos);
		  }
		$upload_dir = '../blogs/';

		$pic = new Upload($_FILES['main_upimg']);

		if ($pic->uploaded) {
		    $pic->file_overwrite = true;
		    $pic->file_new_name_body = $oname;   
		    $pic->image_convert = 'png';
		    $pic->image_resize = false;
		    
		    $pic->Process($upload_dir);

		    $result['err_msg']  =   'OK';
		    
		    if ($pic->processed) {
		        $pic->Clean(); 

		        $file = '../blogs/'.$oname.'.png';

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
		        $data['main_img']	=   $system['weburl'].'blogs/'.$oname.'.png';
		        
		    } else {
		        $result['err_msg']  =   $pic->error;
		    }

		} else {
		    $result['err_msg']  =   $pic->error;
		}
	}

	$bid					=	(int)$_POST['bid'];

	$today = new DateTime();
	$data['cdate']  =   $today->format('Y-m-d H:i');

	if ($bid == 0){
		if ($db->insert('blog', $data)){
		    $result['err_msg']  =   'OK';
		} else {
		    $result['err_msg'] = 'DB INSERT ERROR '.$db->getLastError();;
		}
	} else {
		if ($db->where('id', $bid)->update('blog', $data)){
		    $result['err_msg']  =   'OK';
		} else {
		    $result['err_msg'] = 'DB UPDATE ERROR '.$db->getLastError();;
		}
	}

	echo json_encode($result);


?>