<?php session_start(); ?>
<?php

	if (!isset($_SESSION['bee_admin'])){
		echo '<h1>登入逾時，請重新登入</h1>';
   		echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
   		exit();
	}

	include('../mysql.php');
	require_once('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	include('../simple_html_dom.php');

	$yurl 	=	$_POST['yurl'];
	
	$data 				=	Array();
	$data['main_id']	=	$_POST['main'];
	$data['sub_id']		=	$_POST['sub'];
	$data['stock']		=	$_POST['stock'];
	$data['info']		=	$_POST['info'];

	$eh = curl_init($yurl);
	curl_setopt($eh, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($eh, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($eh, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36');
	$str = curl_exec($eh);
	curl_close($eh);

	$html = str_get_html($str);


	//商品名稱
	$titles			=	$html->find('h1[class=title__3wBva]');

	if (count($titles) == 0){
		exit('<h4>解析錯誤，請確認輸入的網址是否正確</hr>');
	}

	$data['pname'] 	=	$titles[0]->innertext;

	//特價
	$price	=	$html->find('em[class=price__2f7Jw]');
	$price 	=	ltrim($price[0]->innertext, '$');

	//原價
	$oprice	=	$html->find('span[class=originPrice__271Nh]');

	if (count($oprice) > 0){
		$data['price'] 	=	ltrim($oprice[0]->innertext, '$');
		$data['sprice']	=	$price;
	} else {
		$data['sprice'] =	0;
		$data['price']	=	$price;
	}

	$opt_arr	=	Array();

	//規格
	$ul		=	$html->find('ul[class=specList__3TA_I]');
	$lis 	=	$ul[0]->find('li');

	foreach($lis as $li){
		$opt 	=	$li->children(0);
		$o1 	=	$opt->find('div');

		if (count($o1) == 0) continue;

		$oarr 			=	Array();
		$oarr['oname']	=	$o1[0]->innertext;

		$ops = $o1[1]->find('li');

		$opts	=	Array();
		foreach ($ops as $op){
			array_push($opts, $op->plaintext);
		}
		
		$oarr['opts']	=	$opts;
		array_push($opt_arr, $oarr);
	}

	if (count($opt_arr) > 0){
		$data['opts']	=	json_encode($opt_arr);
	}

	//主圖片
	$ibox	=	$html->find('meta[property=og:image]');

	$main_imgs	=	$info_imgs	=	'';
	foreach ($ibox as $img){
		$main_imgs .=  ','.$img->content;
		$info_imgs .=  ','.$img->content;
	}

	$main_imgs 	=	ltrim($main_imgs, ',');
	if (trim($main_imgs) !== '') $data['images']		=	$main_imgs;

	$ibox	=	$html->find('div[class=detailWrap__1T6Ns]');

	$info	=	$ibox[0]->find('img');
	foreach($info as $key=>$img){
		$info_imgs .= ','.$img->src;
	}

	$info_imgs 	=	ltrim($info_imgs, ',');
	if (trim($info_imgs) !== '') $data['info_images']	=	$info_imgs;

	$pnum	=	$html->find('div[class=content__3X3yq]');

	$cnt 	=	count($pnum) - 1;
	foreach($pnum as $key=>$num){
		if ($key == $cnt);
		$pnum	=	$num->innertext;
	}

	$db->where('pnum', $pnum)->getOne('products');

	if ($db->count > 0){
		exit('<h4>-'.$pnum.'-商品編號已存在</h4>');
	}

	$data['pnum']	=	$pnum;

	echo '導入商品-'.$pnum.'-'.$data['pname'].'<br>';

	if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $str, $match)) {
	    $video_id = $match[1];
	    $data['youtube']	=	'https://www.youtube.com/embed/'.$video_id;
	}

	$data['info']	=	$_POST['info'];

	$data['stock']	=	$_POST['stock'];
	$data['cost']	=	0;

	$data['main_id']	=	$_POST['main'];
	$data['sub_id']		=	$_POST['sub'];

	if ($db->insert('products', $data)){
		echo '************ 導入完成 ************<br>';
	} else {
		echo 'DB INSERT ERROR '.$db->getLastError();
	}

	
?>