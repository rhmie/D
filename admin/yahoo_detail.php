<?php

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	
	$db = new MysqliDb($mysqli);

	include('../simple_html_dom.php');

	$ch = curl_init('https://tw.bid.yahoo.com/item/100428662746');
	//$ch = curl_init('https://faith.tw/admin/yahoo.html');
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36');
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$str = curl_exec($ch);
	$html = str_get_html($str);

	$data		=	Array();
	
	//商品名稱
	$titles			=	$html->find('h1[class=title__3wBva]');
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
			//echo $op->plaintext.'<br>';
			array_push($opts, $op->plaintext);
		}
		
		$oarr['opts']	=	$opts;
		array_push($opt_arr, $oarr);
	}

	if (count($opt_arr) > 0){
		$data['opts']	=	json_encode($opt_arr);
	}

	//https://ct.yimg.com/xd/api/res/1.2/RTdxq92dxtKkzIJT_sY2Ig--/YXBwaWQ9eXR3YXVjdGlvbnNlcnZpY2U7aD03MDA7cT04NTtyb3RhdGU9YXV0bzt3PTcwMA--/https://s.yimg.com/ob/image/e83ae4b2-3d2b-409a-849d-5d1738fb4a9b.jpg



	//主圖片
	$ibox	=	$html->find('meta[property=og:image]');
	//$xbox	=	$ibox[0]->find('section');

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
	//echo $ibox[0]->innertext;

	$pnum	=	$html->find('div[class=content__3X3yq]');

	$cnt 	=	count($pnum) - 1;
	foreach($pnum as $key=>$num){
		if ($key == $cnt);
		$pnum	=	$num->innertext;
	}

	$data['pnum']	=	$pnum;

	if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $str, $match)) {
	    $video_id = $match[1];
	    $data['youtube']	=	'https://www.youtube.com/embed/'.$video_id;
	}

	$data['info']	=	'<h2 style="text-align: center; "><ul style="margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; list-style: none; color: rgb(38, 40, 42); font-family: system-ui, &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Microsoft JhengHei&quot;, 微軟正黑體, sans-serif; font-size: 16px; text-align: start;"><li class="shippingListItem__nXE5U" style="margin: 0px 0px 0.25em; padding: 0px 0px 0.5em; position: relative; border-bottom: 1px solid var(--color-monochrome-weaker);"><p class="shippingOutline__TS5lE" style="margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px 6em 0px 0px; font-size: 0.938em; display: inline-block;"><span class="shippingName__1DTON" style="font-weight: 700;">全家取貨付款</span><span class="hyphen__ZHkue">&nbsp;—&nbsp;</span><span class="outline__3F58h">單件運費$65、消費滿$1500免運費</span></p><br></li><li class="shippingListItem__nXE5U" style="margin: 0px 0px 0.25em; padding: 0px 0px 0.5em; position: relative; border-bottom: 1px solid var(--color-monochrome-weaker);"><p class="shippingOutline__TS5lE" style="margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px 6em 0px 0px; font-size: 0.938em; display: inline-block;"><span class="shippingName__1DTON" style="font-weight: 700;">萊爾富取貨付款</span><span class="hyphen__ZHkue">&nbsp;—&nbsp;</span><span class="outline__3F58h">單件運費$60、消費滿$1500免運費</span></p></li><li class="shippingListItem__nXE5U" style="margin: 0px 0px 0.25em; padding: 0px 0px 0.5em; position: relative; border-bottom: 1px solid var(--color-monochrome-weaker);"><p class="shippingOutline__TS5lE" style="margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px 6em 0px 0px; font-size: 0.938em; display: inline-block;"><span class="shippingName__1DTON" style="font-weight: 700;">7-ELEVEN取貨付款</span><span class="hyphen__ZHkue">&nbsp;—&nbsp;</span><span class="outline__3F58h">單件運費$65、消費滿$1500免運費</span></p></li><li class="shippingListItem__nXE5U" style="margin: 0px 0px 0.25em; padding: 0px 0px 0.5em; position: relative; border-bottom: 1px solid var(--color-monochrome-weaker);"><p class="shippingOutline__TS5lE" style="margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px 6em 0px 0px; font-size: 0.938em; display: inline-block;"><span class="shippingName__1DTON" style="font-weight: 700;">郵寄掛號</span><span class="hyphen__ZHkue">&nbsp;—&nbsp;</span><span class="outline__3F58h">單件運費$65、消費滿$1500免運費</span></p></li></ul></h2>';

	$data['stock']	=	1000;
	$data['cost']	=	0;

	$data['main_id']	=	1;
	$data['sub_id']		=	1;

	// echo $title.'<br>';
	// echo $oprice.'<br>';
	// echo $price.'<br>';
	// echo json_encode($opt_arr).'<br>';
	// echo $main_imgs.'<br>';
	// echo $info_imgs;
	$db->insert('products', $data);

	echo 'FINISHED';

?>
