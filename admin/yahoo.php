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

	$yid 	=	$_POST['yname'];
	$spage 	=	(int)$_POST['spage'];
	$epage 	=	(int)$_POST['epage'];

	$clf 	=	'';

	// if (isset($_POST['clf_param'])){
	// 	$clf 	=	'clf='.$_POST['clf_param'].'&apg=';
	// }

	// if (isset($_POST['catid'])){
	// 	$clf 	=	'catId='.$_POST['catid'].'&bfe=';
	// }

	if (!empty($_POST['bcid'])){
		$clf 	=	'bcid='.$_POST['bcid'];
	}

	if (!empty($_POST['cid'])){
		$clf 	=	'cid='.$_POST['cid'];
	}

	$item_cnt	=	0;

	 echo 'https://tw.bid.yahoo.com/tw/booth/'.$yid.'?'.$clf.'&pg='.$i;

	 exit();


	for ($i=$spage; $i <= $epage; $i++) { 
		$url 	=	'https://tw.bid.yahoo.com/tw/booth/'.$yid.'?'.$clf.'&pg='.$i;
		//$url 	=	'https://tw.bid.yahoo.com/booth/'.$yid.'?'.$clf.'&pg='.$i;
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$str = curl_exec($ch);

		curl_close($ch);

		$html = str_get_html($str);

		$link_arr	=	Array();

		echo '************ 取得頁面'.$i.' ************<br>';
		echo str_pad('',4096)."\n";   
		ob_flush();
		flush();
		
		if (isset($_POST['clf_param'])){
			$links	=	$html->find('p[class=listing-title]');
		}

		if (isset($_POST['catid'])){
			$links	=	$html->find('div[class=item-title]');
		}

		foreach ($links as $key=>$link){
			$urls = $link->find('a');

			foreach ($urls as $aurl){
				if (!in_array($aurl->href, $link_arr)){
					array_push($link_arr, $aurl->href);
				}
			}
		
		}

		if (count($link_arr) == 0){
			echo '沒有商品資訊-結束導入';
			exit();
		}

		sleep(1);

		$item_cnt	=	$item_cnt + count($link_arr);

		foreach ($link_arr as $key=>$link){

			$eh = curl_init($link);
			curl_setopt($eh, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($eh, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($eh, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36');
			$str = curl_exec($eh);
			curl_close($eh);

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

			$data['pnum']	=	$pnum;

			$db->where('pnum', $pnum)->getOne('products');

			if ($db->count > 0){
				echo '商品編號-'.$pnum.'-已存在，略過導入<br>';
				echo str_pad('',4096)."\n";   
				ob_flush();
				flush();
				continue;
			}

			echo '導入商品-'.$pnum.'-'.$data['pname'].'<br>';
			echo str_pad('',4096)."\n";   
			ob_flush();
			flush();

			if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $str, $match)) {
			    $video_id = $match[1];
			    if (strpos($video_id, 'itemPage') === false){
			    	$data['youtube']	=	'https://www.youtube.com/embed/'.$video_id;
			    }
			}

			$data['info']	=	$_POST['info'];

			$data['stock']	=	$_POST['stock'];
			$data['cost']	=	0;

			$data['main_id']	=	$_POST['main'];
			$data['sub_id']		=	$_POST['sub'];

			$db->insert('products', $data);

			sleep(1);

		}

	}

	echo '************ 導入完成 共導入'.$item_cnt.'項商品資料 ************<br>';


?>