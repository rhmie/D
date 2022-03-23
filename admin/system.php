<?php session_start(); ?>
<?php

	if (!isset($_SESSION['bee_admin'])){
	   echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
	   exit();
	}

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$system	=	$db->getOne('system');
	$cols = Array ('id', 'gname');
	$lans 	=	$db->get('language', null, $cols);

	$lan_items	= '';

	foreach ($lans as $lan){
		$selected = '';
		if ($lan['id'] == $system['language']) $selected = 'selected';
		$lan_items .= '<option value="'.$lan['id'].'" '.$selected.'>'.$lan['gname'].'</option>';
	}

?>


<style>

	.paymode {
		border: 1px solid #cccccc;
		padding: 10px;
	}

	.trumbowyg-editor {
		max-height: 400px;
	}

	#mail_row {
		border: 1px solid gainsboro;
		border-radius: 8px;
	}

</style>

<section class="section" id="system">

	<div class="row">

		<div class="col-12 mt-2 px-0">

			<!-- Nav tabs -->
			<ul class="nav nav-tabs md-tabs nav-justified primary-color" role="tablist">
			  <li class="nav-item">
			    <a class="nav-link active" data-toggle="tab" href="#set1" role="tab">
			      基本設定</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" data-toggle="tab" href="#set2" role="tab">
			      聯絡資訊</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" data-toggle="tab" href="#set3" role="tab">
			      運費折扣</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" data-toggle="tab" href="#set4" role="tab">
			      訊息通知</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" data-toggle="tab" href="#set5" role="tab">
			      金流物流</a>
			  </li>
			</ul>



			<!-- Tab panels -->
			<div class="tab-content">

			  <!-- Panel 1 -->
			  <div class="tab-pane fade in show active px-3 text-center" id="set1" role="tabpanel">

			  	<form class="sysform">

			  		<input type="hidden" name="fid" value="1">

				  	<div class="input-group mt-3">
				  	  <div class="input-group-prepend">
				  	    <div class="input-group-text">網站名稱</div>
				  	  </div>
				  	  <input type="text" class="form-control py-0" name="wname" value="<?=$system['wname']?>" required>
				  	</div>

				  	<div class="input-group mt-3">
				  	  <div class="input-group-prepend">
				  	    <div class="input-group-text">網址</div>
				  	  </div>
				  	  <input type="text" class="form-control py-0" name="weburl" value="<?=$system['weburl']?>" required>
				  	</div>

				  	<div class="input-group mt-3">
				  	  <div class="input-group-prepend">
				  	    <label class="input-group-text" for="lan_items">語系</label>
				  	  </div>
				  	  <select class="browser-default custom-select" name="language">
				  	    <?=$lan_items?>
				  	  </select>
				  	</div>

				  	<div class="row mt-3">
				  		<div class="col-4">
				  			<img id="main_logo" alt="" src="<?=$system['logo_url']?>" class="img-fluid">
				  		</div>

				  		<div class="col-8 my-auto">
				  			<div class="input-group">
				  			  <div class="input-group-prepend">
				  			    <div class="input-group-text">Logo</div>
				  			  </div>
				  			  <input type="text" class="form-control py-0 img_path" name="logo_url" id="logo_url" value="<?=$system['logo_url']?>">
				  			  <div class="input-group-append">
				  			      <div class="file-field">
				  			          <button class="btn btn-md btn-primary m-0 z-depth-0 waves-effect" type="button">
				  			            <span class="upbtn"><i class="fas fa-upload mr-1"></i>上傳檔案</span>
				  			            <input class="up_img" type="file" accept="image/png, image/jpeg">
				  			          </button>
				  			      </div>
				  			  </div>

				  			</div>
				  		</div>
				  	</div>

				  	<div class="form-group purple-border mt-5 text-left">
				  	  <label for="header">首頁Header (修改前請與工程師確認)</label>
				  	  <textarea class="form-control" name="header" rows="9" required><?=html_entity_decode($system['header'])?></textarea>
				  	</div>

				  	<div class="form-group purple-border mt-2 text-left">
				  	  <label for="keywords">SEO關鍵字(請使用半型逗號分隔關鍵字)</label>
				  	  <textarea class="form-control" name="keywords" rows="4"><?=$system['keywords']?></textarea>
				  	</div>


				  	<div class="form-group mt-4 text-left paymode">
				  		<span class="mr-3">商品結構</span>

				  		<div class="custom-control custom-radio custom-control-inline">
				  		  <input type="radio" class="custom-control-input" id="l3" value="3" name="level" <?php if ($system['level'] == 3) echo 'checked';?>>
				  		  <label class="custom-control-label" for="l3">三層</label>
				  		</div>

				  		<div class="custom-control custom-radio custom-control-inline">
				  		  <input type="radio" class="custom-control-input" id="l2" value="2" name="level" <?php if ($system['level'] == 2) echo 'checked';?>>
				  		  <label class="custom-control-label" for="l2">二層</label>
				  		</div>

				  		<div class="custom-control custom-radio custom-control-inline">
				  		  <input type="radio" class="custom-control-input" id="l1" value="1" name="level" <?php if ($system['level'] == 1) echo 'checked';?>>
				  		  <label class="custom-control-label" for="l1">一層(所有商品顯示於首頁)</label>
				  		</div>

				  		<!-- <div class="custom-control custom-radio custom-control-inline">
				  		  <input type="radio" class="custom-control-input" id="l0" value="0" name="level" <?php if ($system['level'] == 0) echo 'checked';?>>
				  		  <label class="custom-control-label" for="l0">單品</label>
				  		</div> -->

				  	</div>

				  	<p class="note note-primary text-left mt-2">
				  		三層式商品結構舉例 <strong>3C -> 手機 -> iPhone</strong><br>
				  		二層式商品結構舉例 <strong>手機 -> iPhone</strong><br>
				  		一層式商品結構舉例 <strong>於首頁顯示全部商品</strong><br>
				  		當您設定為二層式商品結構時，程式將會自動忽略主類別，而以次類別作為主要分類
				  	</p>


				  	<div class="form-group mt-4 text-left paymode">
				  		<span class="mr-3">網站狀態</span>

				  		<div class="custom-control custom-radio custom-control-inline">
				  		  <input type="radio" class="custom-control-input" id="status0" value="0" name="status" <?php if ($system['status'] == 0) echo 'checked';?>>
				  		  <label class="custom-control-label" for="status0">正常運作</label>
				  		</div>

				  		<div class="custom-control custom-radio custom-control-inline">
				  		  <input type="radio" class="custom-control-input" id="status1" value="1" name="status" <?php if ($system['status'] == 1) echo 'checked';?>>
				  		  <label class="custom-control-label" for="status1">維護中</label>
				  		</div>

				  	</div>

				  	<p class="note note-primary text-left mt-2">
				  		當您要大量修改商品時，可暫時設定為維護中，以避免會員瀏覽到不正確的商品資訊
				  	</p>

				  	<div class="row mt-3">
				  		<div class="col-6">
				  			<div class="input-group">
				  			  <div class="input-group-prepend">
				  			    <div class="input-group-text">簡訊帳號</div>
				  			  </div>
				  			  <input type="text" class="form-control py-0" name="sms_account" id="sms_account" value="<?=$system['sms_account']?>">
				  			</div>
				  		</div>

				  		<div class="col-6">
				  			<div class="input-group">
				  			  <div class="input-group-prepend">
				  			    <div class="input-group-text">簡訊密碼</div>
				  			  </div>
				  			  <input type="password" class="form-control py-0" name="sms_pass" id="sms_pass" value="<?=$system['sms_pass']?>">
				  			</div>
				  		</div>

				  	</div>

				  	<div class="form-group mt-3 text-left paymode">
				  		<span class="mr-3">會員註冊驗證</span>

				  		<div class="custom-control custom-radio custom-control-inline">
				  		  <input type="radio" class="custom-control-input" id="reg1" value="0" name="reg_mode" <?php if ($system['reg_mode'] == 0) echo 'checked';?>>
				  		  <label class="custom-control-label" for="reg1">無需驗證</label>
				  		</div>

				  		<div class="custom-control custom-radio custom-control-inline">
				  		  <input type="radio" class="custom-control-input" id="reg2" value="1" name="reg_mode" <?php if ($system['reg_mode'] == 1) echo 'checked';?>>
				  		  <label class="custom-control-label" for="reg2">簡訊驗證</label>
				  		</div>

				  	</div>


				  	<div class="form-group mt-3 text-left paymode">
				  		<span class="mr-3">用戶需註冊成為會員才能購買</span>

				  		<div class="custom-control custom-radio custom-control-inline">
				  		  <input type="radio" class="custom-control-input" id="force1" value="0" name="need_reg" <?php if ($system['need_reg'] == 0) echo 'checked';?>>
				  		  <label class="custom-control-label" for="force1">否</label>
				  		</div>

				  		<div class="custom-control custom-radio custom-control-inline">
				  		  <input type="radio" class="custom-control-input" id="force2" value="1" name="need_reg" <?php if ($system['need_reg'] == 1) echo 'checked';?>>
				  		  <label class="custom-control-label" for="force2">是</label>
				  		</div>

				  	</div>

				  	<div class="input-group mt-3">
				  	  <div class="input-group-prepend">
				  	    <div class="input-group-text">facebook APP ID</div>
				  	  </div>
				  	  <input type="text" class="form-control py-0" name="fb_app_id" id="fb_app_id" value="<?=$system['fb_app_id']?>">
				  	</div>
				  	<p class="note note-primary text-left mt-2">
				  		網站專用facebook APP ID, 主要用於會員使用臉書登入，如尚未建立，請聯繫工程師
				  	</p>

				  	<div class="input-group mt-3">
				  	  <div class="input-group-prepend">
				  	    <div class="input-group-text">粉絲專頁 ID</div>
				  	  </div>
				  	  <input type="text" class="form-control py-0" name="fb_msg" id="fb_msg" value="<?=$system['fb_msg']?>">
				  	</div>
				  	<p class="note note-primary text-left mt-2">
				  		輸入粉絲專頁ID, 將自動導入FB線上客服系統
				  	</p>

				  	<div class="form-group mt-4 text-left paymode">
				  		<span class="mr-3">facebook 留言版</span>

				  		<div class="custom-control custom-checkbox custom-control-inline">
				  		  <input type="checkbox" class="custom-control-input" name="comment1" id="comment1" <?php if ($system['comment1'] == 1) echo 'checked';?>>
				  		  <label class="custom-control-label" for="comment1">於商品下使用</label>
				  		</div>

				  		<div class="custom-control custom-checkbox custom-control-inline">
				  		  <input type="checkbox" class="custom-control-input" name="comment2" id="comment2" <?php if ($system['comment2'] == 1) echo 'checked';?>>
				  		  <label class="custom-control-label" for="comment2">於專欄內使用</label>
				  		</div>

				  	</div>

				  	<div class="row mt-3">
				  		<div class="col-6">
				  			<div class="input-group">
				  			  <div class="input-group-prepend">
				  			    <div class="input-group-text">LINE Channel ID</div>
				  			  </div>
				  			  <input type="text" class="form-control py-0" name="line_channel" id="line_channel" value="<?=$system['line_channel']?>">
				  			</div>
				  		</div>

				  		<div class="col-6">
				  			<div class="input-group">
				  			  <div class="input-group-prepend">
				  			    <div class="input-group-text">LINE Secret</div>
				  			  </div>
				  			  <input type="password" class="form-control py-0" name="line_secret" id="line_secret" value="<?=$system['line_secret']?>">
				  			</div>
				  		</div>
				  	</div>

				  	<p class="note note-primary text-left mt-2">
				  		用於LINE登入
				  	</p>

				  	<div class="input-group mt-3">
				  	  <div class="input-group-prepend">
				  	    <div class="input-group-text">推播ID</div>
				  	  </div>
				  	  <input type="text" class="form-control py-0" name="signal_id" id="signal_id" value="<?=$system['signal_id']?>">
				  	</div>
				  	<p class="note note-primary text-left mt-2">
				  		用於向訪客推播訊息
				  	</p>

				  	<div class="input-group mt-3">
				  	  <div class="input-group-prepend">
				  	    <div class="input-group-text">每頁商品數量</div>
				  	  </div>
				  	  <input type="number" min="6" class="form-control py-0" name="page_items" id="page_items" value="<?=$system['page_items']?>">
				  	</div>
				  	<p class="note note-primary text-left mt-2">
				  		次類別每頁所顯示的商品數量，請依您的商品數量進行調整
				  	</p>

				  	<div class="input-group mt-3">
				  	  <div class="input-group-prepend">
				  	    <div class="input-group-text">關聯商品數量</div>
				  	  </div>
				  	  <input type="number" min="0" class="form-control py-0" name="related_items" id="related_items" value="<?=$system['related_items']?>">
				  	</div>
				  	<p class="note note-primary text-left mt-2">
				  		您可以在建立商品時單獨設定其相關商品，若不設定則系統自動隨機取出此處所設定數量之同類別商品，建議值為4，請注意獨立頁面將不會有關聯商品
				  	</p>

				  	<div class="custom-control custom-checkbox mt-3 text-left">
				  	  <input type="checkbox" class="custom-control-input" name="show_cat" id="show_cat" <?php if ($system['show_cat'] == 1) echo 'checked';?>>
				  	  <label class="custom-control-label" for="show_cat">於行動裝置下在首頁顯示商品分類按鈕</label>
				  	</div>

				  	<div class="form-group mt-3 text-left paymode">
				  		<span class="mr-3">行動裝置下，網站連結將顯示於</span>

				  		<div class="custom-control custom-radio custom-control-inline">
				  		  <input type="radio" class="custom-control-input" id="side1" value="0" name="side_menu" <?php if ($system['side_menu'] == 0) echo 'checked';?>>
				  		  <label class="custom-control-label" for="side1">下拉清單</label>
				  		</div>

				  		<div class="custom-control custom-radio custom-control-inline">
				  		  <input type="radio" class="custom-control-input" id="side2" value="1" name="side_menu" <?php if ($system['side_menu'] == 1) echo 'checked';?>>
				  		  <label class="custom-control-label" for="side2">左側面板</label>
				  		</div>

				  	</div>

				  	<div class="form-group mt-3 text-left paymode">
				  		<span class="mr-3">大螢幕裝置下，商品分類導覽</span>

				  		<div class="custom-control custom-radio custom-control-inline">
				  		  <input type="radio" class="custom-control-input" id="nav1" value="0" name="nav_mode" <?php if ($system['nav_mode'] == 0) echo 'checked';?>>
				  		  <label class="custom-control-label" for="nav1">顯示於左側樹狀清單(適合分類數量多)</label>
				  		</div>

				  		<div class="custom-control custom-radio custom-control-inline">
				  		  <input type="radio" class="custom-control-input" id="nav2" value="1" name="nav_mode" <?php if ($system['nav_mode'] == 1) echo 'checked';?>>
				  		  <label class="custom-control-label" for="nav2">顯示於上方下拉清單(適合分類數量少）</label>
				  		</div>

				  	</div>


				  	<div class="form-group mt-4 text-left paymode">
				  		<span class="mr-3">首頁區塊顯示</span>

				  		<div class="custom-control custom-checkbox custom-control-inline">
				  		  <input type="checkbox" class="custom-control-input" name="show_banners" id="show_banners" <?php if ($system['show_banners'] == 1) echo 'checked';?>>
				  		  <label class="custom-control-label" for="show_banners">輪播</label>
				  		</div>

				  		<div class="custom-control custom-checkbox custom-control-inline">
				  		  <input type="checkbox" class="custom-control-input" name="show_dis" id="show_dis" <?php if ($system['show_dis'] == 1) echo 'checked';?>>
				  		  <label class="custom-control-label" for="show_dis">優惠商品</label>
				  		</div>

				  		<div class="custom-control custom-checkbox custom-control-inline">
				  		  <input type="checkbox" class="custom-control-input" name="show_news" id="show_news" <?php if ($system['show_news'] == 1) echo 'checked';?>>
				  		  <label class="custom-control-label" for="show_news">最新消息</label>
				  		</div>

				  		<div class="custom-control custom-checkbox custom-control-inline">
				  		  <input type="checkbox" class="custom-control-input" name="show_hot" id="show_hot" <?php if ($system['show_hot'] == 1) echo 'checked';?>>
				  		  <label class="custom-control-label" for="show_hot">熱門商品</label>
				  		</div>

				  		<div class="custom-control custom-checkbox custom-control-inline">
				  		  <input type="checkbox" class="custom-control-input" name="show_art" id="show_art" <?php if ($system['show_art'] == 1) echo 'checked';?>>
				  		  <label class="custom-control-label" for="show_art">精選專欄</label>
				  		</div>

				  		<div class="custom-control custom-checkbox custom-control-inline">
				  		  <input type="checkbox" class="custom-control-input" name="show_his" id="show_his" <?php if ($system['show_his'] == 1) echo 'checked';?>>
				  		  <label class="custom-control-label" for="show_his">瀏覽紀錄</label>
				  		</div>

				  	</div>

				  	<p class="note note-primary text-left mt-2">
				  		您可以在此決定首頁顯示哪些區塊，如全部取消勾選，首頁僅會顯示您自訂的區塊，亦即您可以透過編輯自訂區塊，將首頁打造成純粹的形象頁面。
				  	</p>

				  	<div class="form-group mt-3 text-left paymode">
				  		<span class="mr-3">輪播模式</span>

				  		<div class="custom-control custom-radio custom-control-inline">
				  		  <input type="radio" class="custom-control-input" id="bmode1" value="0" name="banner_mode" <?php if ($system['banner_mode'] == 0) echo 'checked';?>>
				  		  <label class="custom-control-label" for="bmode1">單圖</label>
				  		</div>

				  		<div class="custom-control custom-radio custom-control-inline">
				  		  <input type="radio" class="custom-control-input" id="bmode2" value="1" name="banner_mode" <?php if ($system['banner_mode'] == 1) echo 'checked';?>>
				  		  <label class="custom-control-label" for="bmode2">滿版</label>
				  		</div>

				  	</div>


				  	<div class="row">
					  	<div class="col-12 text-left mt-4">
					  	    <h3 class="grey-text font-weight-bold"><i class="fas fa-list-ol fa-lg fa-fw mr-2"></i>服務條款</h3>
					  	    <hr>

					  	    <textarea id="announce" row="5" name="announce"><?=htmlspecialchars($system['announce'])?></textarea>
					  	</div>
					 </div>


				  	<button type="submit" class="btn btn-blue-grey mt-4"><i class="far fa-save mr-1"></i>儲存</button>

			  	</form>
			   

			  </div>
			  <!-- Panel 1 -->



			    <!-- Panel 2 -->
			    <div class="tab-pane fade in px-3 text-center" id="set2" role="tabpanel">

			    	<form class="sysform">

			    		<input type="hidden" name="fid" value="2">

				  	  	<div class="input-group mt-4">
				  	  	  <div class="input-group-prepend">
				  	  	    <div class="input-group-text">聯絡Email</div>
				  	  	  </div>
				  	  	  <input type="text" class="form-control py-0" name="email" value="<?=$system['email']?>">
				  	  	</div>

				  	  	<div class="input-group mt-3">
				  	  	  <div class="input-group-prepend">
				  	  	    <div class="input-group-text">Line</div>
				  	  	  </div>
				  	  	  <input type="text" class="form-control py-0" name="line" value="<?=$system['line']?>">
				  	  	</div>


			  	  	    <div class="input-group mt-3">
			  	  	      <div class="input-group-prepend">
			  	  	        <div class="input-group-text">微信</div>
			  	  	      </div>
			  	  	      <input type="text" class="form-control py-0" name="wechat" value="<?=$system['wechat']?>">
			  	  	    </div>



			  	  	    <div class="input-group mt-3">
			  	  	      <div class="input-group-prepend">
			  	  	        <div class="input-group-text">Telegram</div>
			  	  	      </div>
			  	  	      <input type="text" class="form-control py-0" name="tele" value="<?=$system['tele']?>">
			  	  	    </div>


			  	  	    <div class="input-group mt-3">
			  	  	      <div class="input-group-prepend">
			  	  	        <div class="input-group-text">twitter</div>
			  	  	      </div>
			  	  	      <input type="text" class="form-control py-0" name="twitter" value="<?=$system['twitter']?>">
			  	  	    </div>

			  	  	    <div class="input-group mt-3">
			  	  	      <div class="input-group-prepend">
			  	  	        <div class="input-group-text">Instagram</div>
			  	  	      </div>
			  	  	      <input type="text" class="form-control py-0" name="instagram" value="<?=$system['instagram']?>">
			  	  	    </div>

			  	  	    <div class="input-group mt-3">
			  	  	      <div class="input-group-prepend">
			  	  	        <div class="input-group-text">粉絲專頁</div>
			  	  	      </div>
			  	  	      <input type="text" class="form-control py-0" name="fbpage" value="<?=$system['fbpage']?>">
			  	  	    </div>



			  	  	    <div class="input-group mt-3">
			  	  	      <div class="input-group-prepend">
			  	  	        <div class="input-group-text">店面地址</div>
			  	  	      </div>
			  	  	      <input type="text" class="form-control py-0" name="addr" value="<?=$system['addr']?>">
			  	  	    </div>

			  	  	    <div class="input-group mt-3">
			  	  	      <div class="input-group-prepend">
			  	  	        <div class="input-group-text">聯絡電話</div>
			  	  	      </div>
			  	  	      <input type="text" class="form-control py-0" name="phone" value="<?=$system['phone']?>">
			  	  	    </div>



				  	  	<button type="submit" class="btn btn-blue-grey mt-4"><i class="far fa-save mr-1"></i>儲存</button>

			    	</form>
			     

			    </div>
			    <!-- Panel 2 -->



			   <!-- Panel 3 -->
			    <div class="tab-pane fade in px-3 text-center" id="set3" role="tabpanel">

			    	<form class="sysform">

			    		<input type="hidden" name="fid" value="3">

			    		<div class="form-group mt-4 text-left paymode">
			    			<span class="mr-3">全站折扣模式</span>

			    			<div class="custom-control custom-radio custom-control-inline">
			    			  <input type="radio" class="custom-control-input" id="dismode1" value="0" name="dismode" <?php if ($system['dismode'] == 0) echo 'checked';?>>
			    			  <label class="custom-control-label" for="dismode1">不使用</label>
			    			</div>

			    			<div class="custom-control custom-radio custom-control-inline">
			    			  <input type="radio" class="custom-control-input" id="dismode2" value="1" name="dismode" <?php if ($system['dismode'] == 1) echo 'checked';?>>
			    			  <label class="custom-control-label" for="dismode2">加價模式</label>
			    			</div>

			    			<div class="custom-control custom-radio custom-control-inline">
			    			  <input type="radio" class="custom-control-input" id="dismode3" value="2" name="dismode" <?php if ($system['dismode'] == 2) echo 'checked';?>>
			    			  <label class="custom-control-label" for="dismode3">原價模式</label>
			    			</div>

			    		</div>



				    	<div class="input-group mt-3">
				    	  <div class="input-group-prepend">
				    	    <div class="input-group-text">全站折扣百分比</div>
				    	  </div>
				    	  <input type="number" class="form-control py-0" name="discount" value="<?=$system['discount']?>" required>
				    	  <div class="input-group-append">
				    	    <div class="input-group-text"> % </div>
				    	  </div>
				    	</div>

				    	<p class="note note-primary text-left mt-2">
				    		在此輸入百分比並選擇模式<br>
				    		加價模式: 調高價格後打折回原價<br>
				    		原價模式: 以原價進行打折<br>
				    		<strong>請注意全站折扣僅作用於無優惠價設定之商品</strong>
				    	</p>


				    	<div class="custom-control custom-checkbox mt-3 text-left">
				    	  <input type="checkbox" class="custom-control-input" name="gift" id="gift" <?php if ($system['gift'] == 1) echo 'checked';?>>
				    	  <label class="custom-control-label" for="gift">開啟送禮模式</label>
				    	</div>

				    	<p class="note note-primary mt-2 text-left">
				    		此模式開啟下，買家可在結帳時勾選"這是一份禮物"，您必須附上卡片並將買家在 其他事項 內的文字撰寫於卡片上
				    	</p>



				    	<div class="input-group mb-2 d-none">
				    	  <div class="input-group-prepend">
				    	    <div class="input-group-text">紅利百分比</div>
				    	  </div>
				    	  <input type="number" class="form-control py-0" name="bonus" value="<?=$system['bonus']?>" required>

				    	  <div class="input-group-append">
				    	    <div class="input-group-text"> % </div>
				    	  </div>
				    	</div>

				    	<p class="note note-primary text-left mt-2 d-none">
				    		在此輸入百分比，商品將於出貨時計算會員紅利，如輸入 10, 則會員購買價值 100 元之商品，即贈送 10 紅利
				    	</p>

			    	<div class="row">

				    	<div class="col-6">
					    	<div class="input-group mt-3">
					    	  <div class="input-group-prepend">
					    	    <div class="input-group-text">免運費門檻</div>
					    	  </div>
					    	  <input type="number" class="form-control py-0" name="free_ship" value="<?=$system['free_ship']?>" required>
					    	</div>
					    </div>


					    <div class="col-6">
					    	<div class="input-group mt-3">
					    	  <div class="input-group-prepend">
					    	    <div class="input-group-text">運費</div>
					    	  </div>
					    	  <input type="number" class="form-control py-0" name="ship" value="<?=$system['ship']?>" required>
					    	</div>
					    </div>

			        	<div class="col-6">
			    	    	<div class="input-group mt-3">
			    	    	  <div class="input-group-prepend">
			    	    	    <div class="input-group-text">離島免運費門檻</div>
			    	    	  </div>
			    	    	  <input type="number" class="form-control py-0" name="free_ship2" value="<?=$system['free_ship2']?>" required>
			    	    	</div>
			    	    </div>

			    	    <div class="col-6">
			    	    	<div class="input-group mt-3">
			    	    	  <div class="input-group-prepend">
			    	    	    <div class="input-group-text">離島運費</div>
			    	    	  </div>
			    	    	  <input type="number" class="form-control py-0" name="ship2" value="<?=$system['ship2']?>" required>
			    	    	</div>
			    	    </div>

	    	        	<div class="col-6">
	    	    	    	<div class="input-group mt-3">
	    	    	    	  <div class="input-group-prepend">
	    	    	    	    <div class="input-group-text">海外免運費門檻</div>
	    	    	    	  </div>
	    	    	    	  <input type="number" class="form-control py-0" name="free_ship3" value="<?=$system['free_ship3']?>" required>
	    	    	    	</div>
	    	    	    </div>

	    	    	    <div class="col-6">
	    	    	    	<div class="input-group mt-3">
	    	    	    	  <div class="input-group-prepend">
	    	    	    	    <div class="input-group-text">海外運費</div>
	    	    	    	  </div>
	    	    	    	  <input type="number" class="form-control py-0" name="ship3" value="<?=$system['ship3']?>" required>
	    	    	    	</div>
	    	    	    </div>

					   </div>

				    	<div class="custom-control custom-checkbox mt-3 text-left">
				    	  <input type="checkbox" class="custom-control-input" name="show_stock" id="show_stock" <?php if ($system['show_stock'] == 1) echo 'checked';?>>
				    	  <label class="custom-control-label" for="show_stock">顯示庫存數量</label>
				    	</div>

				    	<button type="submit" class="btn btn-blue-grey mt-4"><i class="far fa-save mr-1"></i>儲存</button>


				    </form>

			    </div>
			     <!-- Panel 3 -->



		        <!-- Panel 4 -->
		         <div class="tab-pane fade in px-3 text-center" id="set4" role="tabpanel">

		         	<form class="sysform">

		         		<input type="hidden" name="fid" value="4">

		     	    	
		         		<div class="form-group purple-border mt-3 text-left">
		         		  <label for="sms_order">新訂單簡訊提示</label>
		         		  <textarea class="form-control" name="sms_order" rows="3"><?=$system['sms_order']?></textarea>
		         		</div>
		         		<p class="note note-primary text-left mt-2">
		         			當有新的訂單時，以簡訊通知管理員，請使用<strong class="red-text">分號</strong>分隔電話號碼，如 0912123123;0977233233...最多可輸入五組電話，如只有一組號碼則不用打入分號
		         		</p>


		         		<div class="custom-control custom-checkbox mt-3 text-left">
		         		  <input type="checkbox" class="custom-control-input" name="sms_ship" id="sms_ship" <?php if ($system['sms_ship'] == 1) echo 'checked';?>>
		         		  <label class="custom-control-label" for="sms_ship">出貨時發送簡訊通知</label>
		         		</div>

		         		<p class="note note-primary mt-2 text-left">
		         			當訂單被標示為已出貨時，發送簡訊給訂購會員
		         		</p>

		         		<div class="custom-control custom-checkbox mt-3 text-left">
		         		  <input type="checkbox" class="custom-control-input" name="newsletter" id="newsletter" <?php if ($system['newsletter'] == 1) echo 'checked';?>>
		         		  <label class="custom-control-label" for="newsletter">開放訂閱電子報</label>
		         		</div>

		         		<div id="mail_row" class="row mt-4 mx-2 p-4 <?php if ($system['newsletter'] == 0) echo 'd-none';?>">

		         			<div class="col-md-6 col-lg-4 my-2">

		         				<div class="input-group input-group-sm">
		         				  <div class="input-group-prepend">
		         				    <div class="input-group-text">SMTP伺服器</div>
		         				  </div>
		         				  <input type="text" class="form-control py-0 mail" id="smtp" name="smtp" value="<?=$system['smtp']?>">
		         				</div>

		         			</div>

		         			<div class="col-md-6 col-lg-4 my-2">

		         				<div class="input-group input-group-sm">
		         				  <div class="input-group-prepend">
		         				    <div class="input-group-text">帳號</div>
		         				  </div>
		         				  <input type="text" class="form-control py-0 mail" id="mail_usrname" name="mail_usrname" value="<?=$system['mail_usrname']?>">
		         				</div>

		         			</div>

		         			<div class="col-md-6 col-lg-4 my-2">

		         				<div class="input-group input-group-sm">
		         				  <div class="input-group-prepend">
		         				    <div class="input-group-text">密碼</div>
		         				  </div>
		         				  <input type="password" class="form-control py-0 mail" id="mail_usrpass" name="mail_usrpass" value="<?=$system['mail_usrpass']?>">
		         				</div>

		         			</div>

		         			<div class="col-md-6 col-lg-4 my-2">

		         				<div class="input-group input-group-sm">
		         				  <div class="input-group-prepend">
		         				    <div class="input-group-text">PORT</div>
		         				  </div>
		         				  <input type="number" class="form-control py-0 mail" id="mailport" name="mailport" value="<?=$system['mailport']?>">
		         				</div>

		         			</div>

		         			<div class="col-md-6 col-lg-4 my-2">

		         				<div class="input-group input-group-sm">
		         				  <div class="input-group-prepend">
		         				    <div class="input-group-text">寄件者信箱</div>
		         				  </div>
		         				  <input type="text" class="form-control py-0 mail" id="mail_from" name="mail_from" value="<?=$system['mail_from']?>">
		         				</div>

		         			</div>


		         			<div class="col-md-6 col-lg-4 text-left my-auto">

		         				<div class="custom-control custom-checkbox">
		         				  <input type="checkbox" class="custom-control-input" name="mail_ssl" id="mail_ssl" <?php if ($system['mail_ssl'] == 1) echo 'checked';?>>
		         				  <label class="custom-control-label" for="mail_ssl">SSL</label>
		         				</div>

		         			</div>

		         			<div class="col-12 text-left">
			         			<p class="note note-primary mt-2">
			         				如果您希望使用Gmail作為電子報發送伺服器，請先登入您的 Google 帳號，然後依序按下方的連結<br>
			         				SMTP伺服器填入: smtp.gmail.com<br>
			         				PORT填入: 587<br>
			         				不勾選 SSL <br>
			         				填入您的GMail帳號密碼
			         			</p>
			         			<ul>
			         				<li><a href="https://www.google.com/settings/u/1/security/lesssecureapps" target="_blank">將允許低安全性應用程式設定為開啟</a></li>
			         				<li><a href="https://accounts.google.com/b/0/DisplayUnlockCaptcha" target="_blank">授權存取您的Google帳戶</a></li>
			         			</ul>
		         			</div>

		         		</div>

		         		


		     	    	<button type="submit" class="btn btn-blue-grey mt-4"><i class="far fa-save mr-1"></i>儲存</button>


		     	    </form>

		         </div>
		          <!-- Panel 4 -->



		          <!-- Panel 5 -->
		           <div class="tab-pane fade in px-3 text-center" id="set5" role="tabpanel">

		           	<form class="sysform">

		           		<input type="hidden" name="fid" value="5">

		       	    	
		           		<div class="form-group mt-4 text-left paymode">
		           		  <div class="custom-control custom-checkbox custom-control-inline">
		           		    <input type="checkbox" class="custom-control-input" name="mod1" id="mod1" <?php if ($system['mod1'] == 1) echo 'checked';?>>
		           		    <label class="custom-control-label" for="mod1">宅配貨到付款</label>
		           		  </div>

		           		  <div class="custom-control custom-checkbox custom-control-inline">
		           		    <input type="checkbox" class="custom-control-input" name="mod2" id="mod2" <?php if ($system['mod2'] == 1) echo 'checked';?>>
		           		    <label class="custom-control-label" for="mod2">宅配線上付款</label>
		           		  </div>

		           		  <div class="custom-control custom-checkbox custom-control-inline">
		           		    <input type="checkbox" class="custom-control-input" name="mod3" id="mod3" <?php if ($system['mod3'] == 1) echo 'checked';?>>
		           		    <label class="custom-control-label" for="mod3">線上付款超商取貨</label>
		           		  </div>

		           		  <div class="custom-control custom-checkbox custom-control-inline">
		           		    <input type="checkbox" class="custom-control-input" name="mod4" id="mod4" <?php if ($system['mod4'] == 1) echo 'checked';?>>
		           		    <label class="custom-control-label" for="mod4">超商付款取貨</label>
		           		  </div>
		           		</div>

		           		<div class="input-group">
		           		  <div class="input-group-prepend">
		           		    <label class="input-group-text" for="g_language">金流語系</label>
		           		  </div>
		           		  <select class="browser-default custom-select" id="g_language" name="g_language">
		           		    <option value="CHT" <?php if ($system['g_language'] == 'CHT') echo 'selected' ?>>繁體中文</option>
		           		    <option value="CHI" <?php if ($system['g_language'] == 'CHI') echo 'selected' ?>>簡體中文</option>
		           		    <option value="ENG" <?php if ($system['g_language'] == 'ENG') echo 'selected' ?>>英文</option>
		           		    <option value="JPN" <?php if ($system['g_language'] == 'JPN') echo 'selected' ?>>日文</option>
		           		    <option value="KOR" <?php if ($system['g_language'] == 'KOR') echo 'selected' ?>>韓文</option>
		           		  </select>
		           		</div>


		           		<div class="form-group mt-4 text-left paymode">
		           			<span class="mr-3">金流環境</span>

		           			<div class="custom-control custom-radio custom-control-inline">
		           			  <input type="radio" class="custom-control-input" id="gstatus1" value="0" name="gstatus" <?php if ($system['gstatus'] == 0) echo 'checked';?>>
		           			  <label class="custom-control-label" for="gstatus1">測試</label>
		           			</div>

		           			<div class="custom-control custom-radio custom-control-inline">
		           			  <input type="radio" class="custom-control-input" id="gstatus2" value="1" name="gstatus" <?php if ($system['gstatus'] == 1) echo 'checked';?>>
		           			  <label class="custom-control-label" for="gstatus2">正式</label>
		           			</div>

		           			<p class="note note-primary text-left mt-4">
		           				網站正式營運時，請切換至正式環境<br>
		           				信用卡測試卡號: 4311-9522-2222-2222<br>
		           				有效年月: 大於當前日期<br>
		           				安全碼: 222<br>
		           				WebATM 繳款測試: 選擇台新銀行進行模擬付款即可
		           			</p>

		           		</div>

		           		<div class="input-group mt-4">
		           		  <div class="input-group-prepend">
		           		    <div class="input-group-text">HashKey</div>
		           		  </div>
		           		  <input type="password" class="form-control py-0" id="m1" name="hashkey" value="<?=$system['hashkey']?>" <?php if ($system['mod2'] == 1 || $system['mod3'] == 1) echo 'required';?>>
		           		</div>

		           		<div class="input-group mt-4">
		           		  <div class="input-group-prepend">
		           		    <div class="input-group-text">HashIV</div>
		           		  </div>
		           		  <input type="password" class="form-control py-0" id="m2" name="hashiv" value="<?=$system['hashiv']?>" <?php if ($system['mod2'] == 1 || $system['mod3'] == 1) echo 'required';?>>
		           		</div>

		           		<div class="input-group mt-4">
		           		  <div class="input-group-prepend">
		           		    <div class="input-group-text">MerchantID</div>
		           		  </div>
		           		  <input type="text" class="form-control py-0" id="m3" name="merchantid" value="<?=$system['merchantid']?>" <?php if ($system['mod2'] == 1 || $system['mod3'] == 1) echo 'required';?>>
		           		</div>


		           		<div id="stbox" class="form-group mt-4 text-left paymode mt-3">
		           		  <span class="mr-3">請選擇超商</span>

		           		  <div class="custom-control custom-checkbox custom-control-inline">
		           		    <input type="checkbox" class="custom-control-input" name="st1" id="st1" <?php if ($system['st1'] == 1) echo 'checked';?>>
		           		    <label class="custom-control-label" for="st1">7-11</label>
		           		  </div>

		           		  <div class="custom-control custom-checkbox custom-control-inline">
		           		    <input type="checkbox" class="custom-control-input" name="st2" id="st2" <?php if ($system['st2'] == 1) echo 'checked';?>>
		           		    <label class="custom-control-label" for="st2">全家</label>
		           		  </div>

		           		  <div class="custom-control custom-checkbox custom-control-inline">
		           		    <input type="checkbox" class="custom-control-input" name="st3" id="st3" <?php if ($system['st3'] == 1) echo 'checked';?>>
		           		    <label class="custom-control-label" for="st3">萊爾富</label>
		           		  </div>

		           		  <div class="custom-control custom-checkbox custom-control-inline">
		           		    <input type="checkbox" class="custom-control-input" name="st4" id="st4" <?php if ($system['st4'] == 1) echo 'checked';?>>
		           		    <label class="custom-control-label" for="st4">OK</label>
		           		  </div>
		           		</div>

		       	    	<button type="submit" class="btn btn-blue-grey mt-4"><i class="far fa-save mr-1"></i>儲存</button>


		       	    </form>

		           </div>
		            <!-- Panel 4 -->



			</div> <!-- End tab-content -->


		</div><!--  End col-12 -->

	</div><!--  End row -->


</section>

<script>

	 $(document).ready(function() {
	    $('#announce')
	    .trumbowyg({
	      lang: 'zh_tw',
	      autogrow: true,
	        btnsDef: {
	            image: {
	                dropdown: ['insertImage', 'base64'],
	                ico: 'insertImage'
	            }
	        },

	        btns: [
	        	['viewHTML'],
	            ['formatting'],              
	            ['foreColor'],
	            ['emoji'],
	            ['link'],
	            ['image'], 
	            ['strong'],
	            ['justifyLeft', 'justifyCenter', 'justifyFull'],
	            ['horizontalRule'],
	            ['fullscreen']
	        ]
	    });

	});

	// $('#mod3, #mod4').on('change', function(){
	// 	if ($('#mod3').is(':checked') || $('#mod4').is(':checked')){
	// 		$('#stbox').removeClass('d-none');
	// 	} else {
	// 		$('#stbox').addClass('d-none');
	// 	}
	// });


	$('#mod2, #mod3').on('change', function(){
		if ($('#mod2').is(':checked') || $('#mod3').is(':checked')){
			$('#m1, #m2, #m3').prop('required', true);
		} else {
			$('#m1, #m2, #m3').prop('required', false);
		}
	})



	$('.sysform').on('submit', (function (e) {
		e.preventDefault();

		$.ajax({
			url: 'system_update.php',
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){
				var result = JSON.parse(data);

				//console.log(data);

				if (result.err_msg === '-1'){
					alert('登入逾時，請重新登入~!');
					window.location = 'login.php';
				}

				if (result.err_msg !== 'OK'){
				    toastr.error(result.err_msg);
				    return false;
				}

				toastr.success('設定已儲存~!');
			}
		});

	}));


	$('#logo_url').on('blur', function(){
		var logo = $.trim($(this).val());
		if (logo === '') return;
		var id = Math.floor(Math.random() * 100);
		$('#main_logo').prop('src', logo+'?id='+id);
	});


	$('input[type=radio][name=reg_mode]').on('change', function(e){
		if ($(this).val() === '1'){
			$('#sms_account, #sms_pass').prop('required', true);
		} else {
			$('#sms_account, #sms_pass').prop('required', false);
		}
	});


	$('#newsletter').on('change', function(){
		if ($(this).is(':checked')){
			$('.mail').prop('required', true);
			$('#mail_row').removeClass('d-none');
		} else {
			$('.mail').prop('required', false);
			$('#mail_row').addClass('d-none');
		}
	});

	function getFileName(path) {
	    return path.match(/[-_\w]+[.][\w]+$/i)[0];
	}

	$('#system').on('change', '.up_img', function(e){
	    var fname = getFileName($(this).val());
	    var oname = fname.split('.');

	    var parent = $(this).closest('.input-group');
	    $('.img_path', parent).val(fname);
	    $('.upbtn', parent).html('<i class="fas fa-circle-notch fa-spin fa-lg ml-1"></i>上傳中');

	    var formData = new FormData;

	    formData.append('img', $(this)[0].files[0]);
	    formData.append('oname', oname[0]);
	    formData.append('dir', 'images');

	    $.ajax({
	        url: 'upload_img.php',
	        enctype: 'multipart/form-data',
	        type: "POST",
	        data:  formData,
	        contentType: false,
	        cache: false,
	        processData:false,
	        error: function (xhr, status, error) {
	            console.log(xhr);
	        },
	        success: function(data){

	            $('.upbtn', parent).html('<i class="fas fa-upload mr-1"></i>上傳檔案');
	            var result = JSON.parse(data);

	            if (result['err_msg'] === '-1'){
	                alert('登入逾時，請重新登入~!');
	                return;
	            }

	            if (result.err_msg !== 'OK'){
	                toastr.error(result.err_msg);
	                return;
	            }

	            $('.img_path', parent).val(result.img);
	            var id = Math.floor(Math.random() * 100);
	            $('#main_logo').prop('src', result.img+'?id='+id);

	        }
	    });

	});

</script>