<?php session_start(); ?>
<?php

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$result	=	Array();

	if (!isset($_SESSION['bee_admin'])){
		$result['err_msg']	=	'-1';
	    exit(json_encode($result));
	}

	$prod 	=	$db->where('id', $_POST['pid'])->getOne('products');

	if ($db->count == 0){
		$result['err_msg']	=	'此商品已不存在，請重新整理~!';
		exit(json_encode($result));
	}

	//取出關聯商品
	$all	=	$db->get('products', null, Array('id', 'related_items'));

	foreach ($all as $item){
		if (is_null($item['related_items'])) continue;
		$ritems 	=	explode(',', $item['related_items']);
		if (($key = array_search($prod['pnum'], $ritems)) !== false) {
		    unset($ritems[$key]);
		}
		
		$data = Array();
		$data['related_items']	=	NULL;

		if (count($ritems) > 0){
			$data['related_items']	=	implode(',', $ritems);
		}

		$db->where('id', $item['id'])->update('products', $data);
	}

	$db->where('pnum', $prod['pnum'])->delete('hot_products');
	$db->where('pnum', $prod['pnum'])->delete('discount_products');
	$db->where('mid', $_POST['pid'])->delete('sub_products');

	$imgs		=	explode(',', $prod['images']);

	foreach ($imgs as $key=>$img){
		$fname =  basename($img, '?' . $_SERVER['QUERY_STRING']);
		  if (false !== $pos = strripos($fname, '.')) {
		      $fname = substr($fname, 0, $pos);
		  }

		  if (file_exists('../products/'.$fname.'.png')){
		  	unlink('../products/'.$fname.'.png');
		  }

		  if (file_exists('../products/'.$fname.'.webp')){
		  	unlink('../products/'.$fname.'.webp');
		  }

	}

	$info_images		=	explode(',', $prod['info_images']);

	foreach ($info_images as $key=>$img){
		$fname =  basename($img, '?' . $_SERVER['QUERY_STRING']);
		  if (false !== $pos = strripos($fname, '.')) {
		      $fname = substr($fname, 0, $pos);
		  }

		  if (file_exists('../products/'.$fname.'.png')){
		  	unlink('../products/'.$fname.'.png');
		  }

		  if (file_exists('../products/'.$fname.'.webp')){
		  	unlink('../products/'.$fname.'.webp');
		  }

	}

	if ($db->where('id', $_POST['pid'])->delete('products')){
		if (file_exists('../'.$prod['pnum'].'.html')) unlink('../'.$prod['pnum'].'.html');
		$result['err_msg']	=	'OK';
	} else {
		$result['err_msg']	=	'DB DELETE ERROR '.$db->getLastError();
	}

	echo json_encode($result);
?>