<?php session_start(); ?>
<?php

	date_default_timezone_set("Asia/Taipei");
	include('../mysql.php');
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$result	=	Array();

	if (!isset($_SESSION['bee_admin'])){
		$result['err_msg']	=	'-1';
	    exit(json_encode($result));
	}

	$prod 	=	$db->where('pnum', $_POST['pnum'])->getOne('products');

	if ($db->count == 0){
		$result['err_msg']	=	'商品編號不存在~!';
		exit(json_encode($result));
	}

	if ($prod['stock'] == 0){
		$result['err_msg']	=	'庫存量不足~!';
		exit(json_encode($result));
	}

	$system				=	$db->getOne('system');

	$lan    =   $db->where('id', $system['language'])->getOne('language');
	$lan   	=   json_decode($lan['content'], true);

	$data				=	Array();
	$data['pnum']		=	$_POST['pnum'];
	$data['pid']		=	$prod['id'];
	$data['ship']		=	$_POST['ship'];

	$data['scontact']	=	0;
	$data['cphone']		=	NULL;
	$data['cmail']		=	NULL;
	$data['cfbpage']	=	NULL;
	$data['cline']		=	NULL;
	$data['caddr']		=	NULL;
	$data['comment']	=	0;

	$last = new DateTime();
    $data['cdate']  =   $last->format('Y-m-d H:i');

    //確認最大購買量
    $max 	=	$prod['stock'];
    if ($prod['buy_limited'] > 0){
    	if ($prod['buy_limited'] < $max) $max = $prod['buy_limited'];
    }

	$fb_comment	=	'';

	if (isset($_POST['comment'])){
		 $data['comment']	=	1;

		 $fb_comment	=	'<div id="fb-root"></div>
		 				 <div class="fb-comments" data-href="'.$system['weburl'].$data['pnum'].'.html" data-width="100%" data-numposts="5"></div>
		 				 <script async defer crossorigin="anonymous" src="https://connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v8.0&appId='.$system['fb_app_id'].'&autoLogAppEvents=1"></script>';
	}



	if (!isset($_POST['scontact'])){
		if (!empty($_POST['cphone'])) $data['cphone']	=	$_POST['cphone'];
		if (!empty($_POST['cmail'])) $data['cmail']	=	$_POST['cmail'];
		if (!empty($_POST['cfbpage'])) $data['cfbpage']	=	$_POST['cfbpage'];
		if (!empty($_POST['cline'])) $data['cline']	=	$_POST['cline'];
		if (!empty($_POST['caddr'])) $data['caddr']	=	$_POST['caddr'];
	} else {
		$data['scontact']	=	1;
	}

	if ($db->insert('singles', $data)){
		$result['err_msg']	=	'OK';
	} else {
		$result['err_msg']	=	'DB INSERT ERROR '.$db->getLastError();
		exit(json_encode($result));
	}

	//如果與首頁相同聯絡資訊
	if (isset($_POST['scontact'])){
		$data['cphone']		=	$system['phone'];
		$data['cmail']		=	$system['email'];
		$data['cline']		=	$system['line'];
		$data['cfbpage']	=	$system['fbpage'];
		$data['caddr']		=	$system['addr'];
	}

	$price_display		=	$prod['price'];

	$info	=	strip_tags($prod['info']);

	$imgs		=	explode(',', $prod['images']);

	
	$slides 	=	$figure	=	'';

	foreach ($imgs as $key=>$img){
		$width 	=	$height 	=	800;
		list($width, $height) = @getimagesize($img);

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

	//顯示庫存由 discount.php 控制

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
		
		$map .= '<p class="clabel"><i class="fas fa-map-marker-alt fa-fw fa-lg mr-1"></i>'.$data['caddr'].'</p>';

		if (!is_null($data['cphone'])){
			$map .= '<a href="tel:'.$data['cphone'].'" class="clabel d-block my-2"><i class="fas fa-phone-volume fa-fw fa-lg mr-1"></i>'.$data['cphone'].'</a>';
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
			$map .= '<a href="tel:'.$data['cphone'].'" class="clabel d-block my-3"><i class="fas fa-phone-volume fa-fw fa-lg mr-1"></i>'.$data['cphone'].'</a>';
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

	$msger 	=	'';

	if (isset($_POST['msger']) && !is_null($system['fb_msg'])){
		$msger = 'var chatbox = document.getElementById("fb-customer-chat");
			        chatbox.setAttribute("page_id", "'.$system['fb_msg'].'");
			        chatbox.setAttribute("attribution", "biz_inbox");

			        (function(d, s, id) {
			          var js, fjs = d.getElementsByTagName(s)[0];
			          if (d.getElementById(id)) return;
			          js = d.createElement(s); js.id = id;
			          js.src = "https://connect.facebook.net/zh_TW/sdk/xfbml.customerchat.js";
			          fjs.parentNode.insertBefore(js, fjs);
			        }(document, "script", "facebook-jssdk"));';
	}

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
                    <link href="./css/custom_style.css" rel="stylesheet">
                
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

    	      <div class="d-lg-none text-md-left mb-4">
    	        <h2 id="title" class="h2-responsive text-center text-md-left font-weight-bold prodname">'.$prod['pname'].'</h2>

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

    	      <div class="d-none d-lg-block mb-4 text-left">
    	        <h2 class="h2-responsive text-center text-md-left product-name font-weight-bold prodname">'.$prod['pname'].'</h2>
    	        
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
		    	          <button class="btn btn-md btn-light m-0 px-3 z-depth-0 waves-effect" type="button" data-max="'.$max.'" id="more"><i class="fas fa-plus"></i></button>
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
      	    	        <select id="paymode" class="browser-default custom-select"></select>
	    	      </div>

  	    	      <div id="stbox" class="input-group input-group-sm mb-3 d-none">
    	    	        <div class="input-group-prepend">
    	    	          <label class="input-group-text" for="store">'.$lan['lan148'].'</label>
    	    	        </div>
    	    	        <select id="store" class="browser-default custom-select"></select>
  	    	      </div>

	    	      <div id="pricebox" class="col-12 text-right my-3 px-2">
	    	          	<h4 class="font-weight-bold clabel">'.$lan['lan55'].': $<span id="totalprice">'.$tprice.'</span></h4>
	    	      </div>

	    	      <div class="text-center mb-3">
	    	      		<a target="_blank" href="'.$fb_share.'" class="btn-floating btn-fb"><i class="fab fa-facebook-f fa-lg"></i></a>
	    	      		<a target="_blank" href="'.$tw_share.'" class="btn-floating btn-tw"><i class="fab fa-twitter fa-lg"></i></a>
	    	      		<a target="_blank" href="'.$line_share.'" class="btn-floating btn-slack"><i class="fab fa-line fa-lg"></i></a>
	    	      </div>

	    	      <script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>

	    	      

	    	      <button id="buy_btn" class="btn btn-blue-grey"><i class="fas fa-store mr-1"></i>'.$lan['lan62'].'</button>


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

    	    		<h4 class="font-weight-bold clabel"><i class="far fa-edit mr-1"></i>'.$lan['lan126'].'</h4>

    	    		<hr class="mb-4">

    	    	</div>

    	    	'.$map.'


    	    </div>

    	  </section>
    	  <!--Section: Content-->

    	  <button id="gotop" class="btn btn-floating btn-share"><i class="fas fa-chevron-up fa-lg"></i></button>

    	</div>

    	<div id="fb-customer-chat" class="fb-customerchat"></div>

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

    	<script>
    	'.$msger.'

    	</script>

    </body>
    </html>';

    file_put_contents('../'.$data['pnum'].'.html', $html);

    $result['err_msg']	=	'OK';

    echo json_encode($result);



?>