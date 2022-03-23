<?php session_start(); ?>
<?php

	if (!isset($_SESSION['bee_admin'])){
	   echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
	}


	include('../mysql.php');
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$count = $db->getValue('hot_products', 'count(*)');
	$h_total_pages = ceil($count / 8);
	if ($h_total_pages == 0) $h_total_pages = 1;

	$count = $db->getValue('discount_products', 'count(*)');
	$d_total_pages = ceil($count / 8);
	if ($d_total_pages == 0) $d_total_pages = 1;

	$system	=	$db->getOne('system');

	$b1	=	$b2	=	$links	=	$full 	=		'';

	if (!is_null($system['banners'])){

		$banners 		=	json_decode($system['banners'], true);

		foreach ($banners as $key=>$banner){

			$active	=	'';
			if ($key == 0) $active = 'active';

			$b1 .= '<div class="carousel-item '.$active.'">
	 		  	      <img class="d-block w-100" src="'.$banner['url'].'"
	 		  	        alt="slide">
	 		  	    </div>';

	 		$b2 .= '<li data-target="#carousel-thumb" data-slide-to="'.$key.'" class="'.$active.'">
	 		  	      <img src="'.$banner['url'].'" width="100">
	 		  	    </li>';


			$links .=	'<div class="form-row w-100">

							<div class="col-md-4 plink mt-2">

								<div class="input-group">
								  <div class="input-group-prepend">
								    <div class="input-group-text">連結商品</div>
								  </div>
								  <input type="text" class="form-control py-0" value="'.$banner['link'].'">

							 </div></div>

							 <div class="col-md-8 purl mt-2">

								 <div class="input-group">
								   <div class="input-group-prepend">
								     <div class="input-group-text">URL</div>
								   </div>
								   <input type="text" class="form-control py-0 img_path" value="'.$banner['url'].'">
		 						

		 						  <div class="input-group-append">
		 						    <div class="btn btn-md m-0 btn-pink del_link" type="button"><i class="fas fa-trash-alt"></i></div>
		 						  </div>

		 						  <div class="input-group-append">
		 						      <div class="file-field">
		 						          <button class="btn btn-md btn-primary m-0 z-depth-0 waves-effect" type="button">
		 						            <span class="upbtn"><i class="fas fa-upload mr-1"></i>上傳檔案</span>
		 						            <form class="largeform">
		 						            	<input class="up_large_img" name="large_img" type="file" accept="image/png, image/jpeg">
		 						            	<input class="oname" type="hidden" name="oname">
		 						            </form>
		 						          </button>
		 						      </div>
		 						  </div>

	 					 		</div>
	 					 	</div>

	 					 </div>';
		}

		

	}

	if (!is_null($system['full_banners'])){

		$banners 		=	json_decode($system['full_banners'], true);

		foreach ($banners as $key=>$banner){

			$fname =  basename($banner['mobile'], '?' . $_SERVER['QUERY_STRING']);
			$img1 	=	'<img alt="" style="max-width: 120px" class="mr-2" src="'.$banner['mobile'].'">';

			if (false !== $pos = strripos($fname, '.mp4')) {
				$img1 	=	'<video class="mr-2" style="max-width: 120px" autoplay="" loop="" muted="">
      							<source class="img1" src="'.$banner['mobile'].'" type="video/mp4" style="object-fit: cover;">
    							</video>';
			  }

			$fname =  basename($banner['pad'], '?' . $_SERVER['QUERY_STRING']);
			$img2 	=	'<img alt="" style="max-width: 200px" class="mr-2" src="'.$banner['pad'].'">';

			if (false !== $pos = strripos($fname, '.mp4')) {
				$img2 	=	'<video class="mr-2" style="max-width: 200px" autoplay="" loop="" muted="">
  							<source class="img2" src="'.$banner['pad'].'" type="video/mp4" style="object-fit: cover;">
							</video>';
			  }

			$fname =  basename($banner['computer'], '?' . $_SERVER['QUERY_STRING']);
			$img3 	=	'<img alt="" style="max-width: 300px" class="mr-2" src="'.$banner['computer'].'">';

			if (false !== $pos = strripos($fname, '.mp4')) {
				$img3 	=	'<video class="mr-2" style="max-width: 300px" autoplay="" loop="" muted="">
  							<source class="img3" src="'.$banner['computer'].'" type="video/mp4" style="object-fit: cover;">
							</video>';
			  }

			
			$full 	.=	'<div class="row banner_row border py-3">

											<div class="col-12 mb-2 imgbox">
													'.$img1.$img2.$img3.'
											</div>

											<div class="col-md-6 mt-2">
													<div class="input-group input-group-sm">
													  <div class="input-group-prepend">
													    <div class="input-group-text">手機</div>
													  </div>
													  <input type="text" class="form-control img_path mobile py-0" value="'.$banner['mobile'].'">

													  <div class="input-group-append">
													      <div class="file-field">
													          <button class="btn btn-sm btn-primary m-0 z-depth-0 waves-effect" type="button">
													            <span class="upbtn"><i class="fas fa-upload mr-1"></i>上傳檔案</span>
													            <form class="largeform">
													            	<input type="file" class="up_large_img" name="large_img" accept="image/png, image/jpeg, video/mp4">
													            	<input class="oname" type="hidden" name="oname">
													            </form>
													          </button>
													      </div>
													  </div>

												 </div>
											</div>

											<div class="col-md-6 mt-2">
													<div class="input-group input-group-sm">
													  <div class="input-group-prepend">
													    <div class="input-group-text">平板</div>
													  </div>
													  <input type="text" class="form-control img_path pad py-0" value="'.$banner['pad'].'">

													  <div class="input-group-append">
													      <div class="file-field">
													          <button class="btn btn-sm btn-primary m-0 z-depth-0 waves-effect" type="button">
													            <span class="upbtn"><i class="fas fa-upload mr-1"></i>上傳檔案</span>
													            <form class="largeform">
													            	<input type="file" class="up_large_img" name="large_img" accept="image/png, image/jpeg, video/mp4">
													            	<input class="oname" type="hidden" name="oname">
													            </form>
													          </button>
													      </div>
													  </div>

												 </div>
											</div>

											<div class="col-md-6 mt-2">
													<div class="input-group input-group-sm">
													  <div class="input-group-prepend">
													    <div class="input-group-text">電腦</div>
													  </div>
													  <input type="text" class="form-control img_path computer py-0" value="'.$banner['computer'].'">

													  <div class="input-group-append">
													      <div class="file-field">
													          <button class="btn btn-sm btn-primary m-0 z-depth-0 waves-effect" type="button">
													            <span class="upbtn"><i class="fas fa-upload mr-1"></i>上傳檔案</span>
													            <form class="largeform">
													            	<input type="file" class="up_large_img" name="large_img" accept="image/png, image/jpeg, video/mp4">
													            	<input class="oname" type="hidden" name="oname">
													            </form>
													          </button>
													      </div>
													  </div>

												 </div>
											</div>


											<div class="col-md-6 mt-2">
													<div class="input-group input-group-sm">
													  <div class="input-group-prepend">
													    <div class="input-group-text">標題</div>
													  </div>
													  <input type="text" class="form-control title py-0" value="'.htmlspecialchars($banner['title']).'">
												 </div>
											</div>

											<div class="col-md-6 mt-2"></div>

											<div class="col-md-6 mt-2">
												<div class="row">
													<div class="col-6">
														<input type="text" class="form-control form-control-sm py-0 mb-2 title_color colorpick" value="'.$banner['title_color'].'"/>
													</div>
													<div class="col-6">
														<div class="input-group input-group-sm">
														  <div class="input-group-prepend">
														    <div class="input-group-text">字體大小</div>
														  </div>
														  <input type="number" min="1" max="5" value="1" class="form-control title_size py-0" value="'.$banner['title_size'].'">
													 	</div>
													 </div>
												</div>
											</div>

											<div class="col-12 mt-2">
												<div class="form-group">
												  <label for="content">內文</label>
												  <textarea class="form-control content" rows="3">'.$banner['content'].'</textarea>
												</div>
											</div>

											<div class="col-md-6 mt-2">
												<div class="row">
													<div class="col-6">
														<input type="text" class="form-control form-control-sm py-0 mb-2 content_color colorpick" value="'.$banner['content_color'].'"/>
													</div>
													<div class="col-6">
														<div class="input-group input-group-sm">
														  <div class="input-group-prepend">
														    <div class="input-group-text">內文字體大小</div>
														  </div>
														  <input type="number" min="1.0" max="2.0" step="0.1" class="form-control content_size py-0" value="'.$banner['content_size'].'">
													 	</div>
													 </div>
												</div>
											</div>

											<div class="col-12 mt-2 text-right">
												<div class="btn-group btn-group-sm">
													<button type="button" class="btn btn-info btn-sm update_full"><i class="fas fa-redo mr-1"></i>更新</button>
													<button type="button" class="btn btn-danger btn-sm del_full"><i class="fas fa-trash-alt mr-1"></i>刪除</button>
												</div>
											</div>

								</div>';
		}


	}




?>

<section class="section" id="main_index">

	<div class="row">

	 	<div class="col-12 mt-2 px-0">

	 		<!-- Nav tabs -->
	 		<ul class="nav nav-tabs md-tabs nav-justified primary-color" role="tablist">
	 		  <li class="nav-item">
	 		    <a class="nav-link active" data-toggle="tab" href="#hot_class" role="tab">
	 		      熱門商品</a>
	 		  </li>
	 		  <li class="nav-item">
	 		    <a class="nav-link" data-toggle="tab" href="#discount_class" role="tab">
	 		      特價商品</a>
	 		  </li>
	 		  <li class="nav-item">
	 		    <a class="nav-link" data-toggle="tab" href="#banner_class" role="tab">
	 		      首頁輪播</a>
	 		  </li>
	 		  <li class="nav-item">
	 		    <a class="nav-link" data-toggle="tab" href="#news_class" role="tab">
	 		      最新消息</a>
	 		  </li>
	 		</ul>
	 		<!-- Nav tabs -->

	 		<!-- Tab panels -->
	 		<div class="tab-content">

	 		  <!-- Panel 1 -->
	 		  <div class="tab-pane fade in show active px-3" id="hot_class" role="tabpanel">

	 		  	<button id="new_hot" type="button" class="btn btn-outline-info"><i class="fas fa-plus fa-lg mr-1"></i>新增熱門商品</button>

	 		  	<table class="table table-striped">
	 		  	  <thead>
	 		  	    <tr>
	 		  	      <th scope="col">縮圖</th>
	 		  	      <th scope="col">編號</th>
	 		  	      <th scope="col">名稱</th>
	 		  	      <th scope="col">原價</th>
	 		  	      <th scope="col">優惠價</th>
	 		  	      <th scope="col" class="text-right">操作</th>
	 		  	    </tr>
	 		  	  </thead>
	 		  	  <tbody id="hot_table">

	 		  	    
	 		  	  </tbody>
	 		  	</table>


	 		  	<div id="hot_nav" class="row justify-content-center">
	 		  		<nav class="text-center my-4" aria-label="Page navigation">
	 		  		    <ul class="pagination" id="h_pagination"></ul>
	 		  		</nav>
	 		  	</div>

	 		   

	 		  </div>
	 		  <!-- Panel 1 -->

	 		  <!-- Panel 2 -->
	 		  <div class="tab-pane fade px-3" id="discount_class" role="tabpanel">

	 		  	<button id="new_discount" type="button" class="btn btn-outline-warning"><i class="fas fa-plus fa-lg mr-1"></i>新增優惠商品</button>

	 		  	<table class="table table-striped">
	 		  	  <thead>
	 		  	    <tr>
	 		  	      <th scope="col">縮圖</th>
	 		  	      <th scope="col">編號</th>
	 		  	      <th scope="col">名稱</th>
	 		  	      <th scope="col">原價</th>
	 		  	      <th scope="col">優惠價</th>
	 		  	      <th scope="col" class="text-right">操作</th>
	 		  	    </tr>
	 		  	  </thead>
	 		  	  <tbody id="discount_table">

	 		  	    
	 		  	  </tbody>
	 		  	</table>


	 		  	<div id="dis_nav" class="row justify-content-center">
	 		  		<nav class="text-center my-4" aria-label="Page navigation">
	 		  		    <ul class="pagination" id="d_pagination"></ul>
	 		  		</nav>
	 		  	</div>

	 		    

	 		  </div>
	 		  <!-- Panel 2 -->


	 		  <!-- Panel 3 -->
	 		  <div class="tab-pane fade px-3" id="banner_class" role="tabpanel">

	 		  	<ul class="nav nav-tabs" id="myTab" role="tablist">
	 		  	  <li class="nav-item">
	 		  	    <a class="nav-link active" id="single-tab" data-toggle="tab" href="#single" role="tab" aria-controls="single"
	 		  	      aria-selected="true">單圖輪播</a>
	 		  	  </li>
	 		  	  <li class="nav-item">
	 		  	    <a class="nav-link" id="full-tab" data-toggle="tab" href="#full" role="tab" aria-controls="full"
	 		  	      aria-selected="false">滿版輪播</a>
	 		  	  </li>
	 		  	</ul>

	 		  	<div class="tab-content">

	 		  		<div class="tab-pane fade show active" id="single" role="tabpanel" aria-labelledby="single-tab">

	 		  			<p class="note note-primary text-left">
	 		  				圖片建議尺寸為 1700 x 700 <br>
	 		  				<strong>刪除或新增後請記得按儲存</strong>
	 		  			</p>

				 		  	<!--Carousel Wrapper-->
				 		  	<div id="carousel-thumb" class="carousel slide carousel-fade carousel-thumbnails" data-ride="carousel">
				 		  		
				 		  	  <!--Slides-->
				 		  	  <div class="carousel-inner" role="listbox">
				 		  	  	<?=$b1?>
				 		  	  </div>
				 		  	  <!--/.Slides-->

				 		  	  <ol class="carousel-indicators">
				 		  	  	<?=$b2?>
				 		  	  </ol>

				 		  	</div>
				 		  	<!--/.Carousel Wrapper-->

	 		  			<div class="row">

					 		  		<div class="col-12 my-2">
					 		  		    <div class="custom-control custom-checkbox custom-control-inline">
					 		  		      <input type="checkbox" class="custom-control-input" id="google_cloud">
					 		  		      <label class="custom-control-label" for="google_cloud">使用Google雲端圖片(按下新增時將轉換Google連結)</label>
					 		  		    </div>

					 		  		    <div class="custom-control custom-checkbox custom-control-inline ml-4">
					 		  		      <input type="checkbox" class="custom-control-input" id="banners_all" <?php if ($system['banners_all'] == 1) echo 'checked';?>>
					 		  		      <label class="custom-control-label" for="banners_all">於所有頁面顯示輪播(不選擇則輪播僅顯示於首頁)</label>
					 		  		    </div>
					 		  		</div>

					 		  		<div id="link_area" class="w-100 px-3">
					 		  			<?=$links?>
					 		  		</div>

					 		  		<div class="col-12 text-right mt-3">
					 		  			<div class="btn-group">
					 		  				<button type="button" id="ref_banners" class="btn btn-primary"><i class="fas fa-redo mr-1"></i>更新</button>
					 		  				<button type="button" id="new_link" class="btn btn-primary"><i class="fas fa-plus mr-1"></i>新增</button>
					 		  			</div>
					 		  		</div>

					 		  		<div class="col-12 text-center mt-4">

					 		  			<p class="note note-primary text-left">
					 		  				複製圖片網址後按下新增即可增加輪播，每一個輪播可搭配一個商品連結，輸入商品編號(可不輸入)，用戶在點擊輪播時即可連結至商品頁面
					 		  			</p>

					 		  			
					 		  				<button type="button" id="save_banners" class="btn btn-blue-grey mt-4"><i class="far fa-save mr-1"></i>儲存</button>


					 		  		</div>

					 		</div>

	 		  		
	 		  	</div>


	 		  	<div class="tab-pane fade" id="full" role="tabpanel" aria-labelledby="full-tab">

	 		  		<p class="note note-primary text-left">
	 		  			滿版輪播需準備三種尺寸圖片分別對應 手機、平板、電腦<br>
	 		  			手機建議尺寸為 414 x 736<br>
	 		  			平板建議尺寸為 768 x 1024<br>
	 		  			電腦建議尺寸為 1920 x 1080<br>
	 		  			如果您的文字內容已做在圖片內，則標題及內文皆可留白<br>
	 		  			內文可使用HTML標籤，需要斷行可鍵入&lt;br&gt;<br>
	 		  			<strong>刪除或新增後請記得按儲存</strong>
	 		  		</p>

	 		  		<div id="banner_block">
	 		  			<?=$full?>
	 		  		</div>

	 		  		<div class="row mt-3">
	 		  			<div class="col-12 text-right">
	 		  				<div class="btn-group">
	 		  					<button type="button" id="new_full" class="btn btn-primary"><i class="fas fa-plus mr-1"></i>新增</button>
	 		  					<button type="button" id="save_full" class="btn btn-primary"><i class="far fa-save mr-1"></i>儲存</button>
	 		  				</div>
	 		  			</div>
	 		  		</div>

	 		  	</div>

	 		  </div>

	 		  </div>


	 		  <!-- Panel 4 -->
	 		  <div class="tab-pane fade px-3" id="news_class" role="tabpanel">

	 		  	<textarea id="news" row="5" name="news"><?=htmlspecialchars($system['news'])?></textarea>

	 		  	<div class="input-group mt-3">
	 		  	  <div class="input-group-prepend">
	 		  	    <div class="input-group-text">跳出式廣告圖片</div>
	 		  	  </div>
	 		  	  <input type="text" class="form-control py-0" id="burl" name="burl" value="<?=$system['bannerurl']?>">
	 		  	</div>

	 		  	<div class="text-center">
	 		  		<button type="button" id="save_news" class="btn btn-blue-grey mt-4"><i class="far fa-save mr-1"></i>儲存</button>
	 		  	</div>
	 		  </div>


	 		</div>
	 		<!-- Tab panels -->

	 	</div>
	</div>


<!-- fullbanners -->
	<div id="linkbox" class="row banner_row border py-3 d-none">

		<div class="col-12 mb-2 imgbox">
				<!-- <img alt="" style="max-width: 120px" class="img1">
				<img alt="" style="max-width: 200px" class="img2">
				<img alt="" style="max-width: 300px" class="img3"> -->
		</div>

		<div class="col-md-6 mt-2">
				<div class="input-group input-group-sm">
				  <div class="input-group-prepend">
				    <div class="input-group-text">手機</div>
				  </div>
				  <input type="text" class="form-control img_path mobile py-0">

				  <div class="input-group-append">
				      <div class="file-field">
				          <button class="btn btn-sm btn-primary m-0 z-depth-0 waves-effect" type="button">
				            <span class="upbtn"><i class="fas fa-upload mr-1"></i>上傳檔案</span>
				            <form class="largeform">
				            	<input type="file" class="up_large_img" name="large_img" accept="image/png, image/jpeg, video/mp4">
				            	<input class="oname" type="hidden" name="oname">
				            </form>
				          </button>
				      </div>
				  </div>

			 </div>
		</div>

		<div class="col-md-6 mt-2">
				<div class="input-group input-group-sm">
				  <div class="input-group-prepend">
				    <div class="input-group-text">平板</div>
				  </div>
				  <input type="text" class="form-control img_path pad py-0">

				  <div class="input-group-append">
				      <div class="file-field">
				          <button class="btn btn-sm btn-primary m-0 z-depth-0 waves-effect" type="button">
				            <span class="upbtn"><i class="fas fa-upload mr-1"></i>上傳檔案</span>
				            <form class="largeform">
				            	<input type="file" class="up_large_img" name="large_img" accept="image/png, image/jpeg, video/mp4">
				            	<input class="oname" type="hidden" name="oname">
				            </form>
				          </button>
				      </div>
				  </div>

			 </div>
		</div>

		<div class="col-md-6 mt-2">
				<div class="input-group input-group-sm">
				  <div class="input-group-prepend">
				    <div class="input-group-text">電腦</div>
				  </div>
				  <input type="text" class="form-control img_path computer py-0">

				  <div class="input-group-append">
				      <div class="file-field">
				          <button class="btn btn-sm btn-primary m-0 z-depth-0 waves-effect" type="button">
				            <span class="upbtn"><i class="fas fa-upload mr-1"></i>上傳檔案</span>
				            <form class="largeform">
				            	<input type="file" class="up_large_img" name="large_img" accept="image/png, image/jpeg, video/mp4">
				            	<input class="oname" type="hidden" name="oname">
				            </form>
				          </button>
				      </div>
				  </div>

			 </div>
		</div>

		<div class="col-md-6 mt-2">
				<div class="input-group input-group-sm">
				  <div class="input-group-prepend">
				    <div class="input-group-text">標題</div>
				  </div>
				  <input type="text" class="form-control title py-0">
			 </div>
		</div>

		<div class="col-md-6 mt-2"></div>

		<div class="col-md-6 mt-2">
			<div class="row">
				<div class="col-6">
					<input type="text" class="form-control form-control-sm py-0 mb-2 title_color" value="black"/>
				</div>
				<div class="col-6">
					<div class="input-group input-group-sm">
					  <div class="input-group-prepend">
					    <div class="input-group-text">字體大小</div>
					  </div>
					  <input type="number" min="1" max="5" value="1" class="form-control title_size py-0">
				 	</div>
				 </div>
			</div>
		</div>


		<div class="col-12 mt-2">
			<div class="form-group">
			  <label for="content">內文</label>
			  <textarea class="form-control content" rows="3"></textarea>
			</div>
		</div>

		<div class="col-md-6 mt-2">
			<div class="row">
				<div class="col-6">
					<input type="text" class="form-control form-control-sm py-0 mb-2 content_color" value="black"/>
				</div>
				<div class="col-6">
					<div class="input-group input-group-sm">
					  <div class="input-group-prepend">
					    <div class="input-group-text">內文字體大小</div>
					  </div>
					  <input type="number" min="1.0" max="2.0" value="1.0" step="0.1" class="form-control content_size py-0">
				 	</div>
				 </div>
			</div>
		</div>

		<div class="col-12 mt-2 text-right">
			<div class="btn-group btn-group-sm">
				<button type="button" class="btn btn-info btn-sm update_full"><i class="fas fa-redo mr-1"></i>更新</button>
				<button type="button" class="btn btn-danger btn-sm del_full"><i class="fas fa-trash-alt mr-1"></i>刪除</button>
			</div>
		</div>

	</div>



</section>

<div class="modal fade" id="new_hot_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">新增熱門商品</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-0 mx-3">

      	  <div class="modal-body">

      	    <div class="input-group mb-2">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">商品編號</div>
      	      </div>
      	      <input type="text" class="form-control py-0" id="hnum">
      	    </div>

      	  </div>
      	  <!--Footer-->
      	  <div class="modal-footer py-4">
      	    <div class="btn-group m-auto">
      	      <button type="button" class="btn btn-outline-info" data-dismiss="modal"><i class="fas fa-times fa-lg mr-1"></i>關閉</button>
      	      <button type="button" id="send_hot" class="btn btn-outline-info">送出<i class="fas fa-paper-plane fa-lg ml-1"></i></button>           
      	    </div>
      	  </div>

      </div>

    </div>
  </div>
</div>



<div class="modal fade" id="new_dis_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">新增特價商品</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-0 mx-3">

      	  <div class="modal-body">

      	    <div class="input-group my-3">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">商品編號</div>
      	      </div>
      	      <input type="text" class="form-control py-0" id="dnum">
      	    </div>

      	  </div>
      	  <!--Footer-->
      	  <div class="modal-footer py-4">
      	    <div class="btn-group m-auto">
      	      <button type="button" class="btn btn-outline-info" data-dismiss="modal"><i class="fas fa-times fa-lg mr-1"></i>關閉</button>
      	      <button type="button" id="send_dis" class="btn btn-outline-info">送出<i class="fas fa-paper-plane fa-lg ml-1"></i></button>           
      	    </div>
      	  </div>

      </div>

    </div>
  </div>
</div>

<script>

	var h_page = 1;
	var d_page = 1;

	$('.colorpick').spectrum({
	  type: "component",
	  showPalette: false,
	  showButtons: false,
	  allowEmpty: false
	});

	 $(document).ready(function() {
	    $('#news')
	    .trumbowyg({
	      lang: 'zh_tw',
	      autogrow: true,
	      semantic: false,
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


	function edit_prod(pid){
		window.open('./edit_product.php?id='+pid, "connectWindow", "width=850,height=900, scrollbars=yes");
	}


	window.h_pagObj = $('#h_pagination').twbsPagination({
	            totalPages: <?php echo $h_total_pages ?>,
	            visiblePages: 10,
	            onPageClick: function (event, page) {

	            }
	        }).on('page', function (event, page) {
	        	//console.log(page);
	            h_page = page;
	            get_hot();
	        });


	window.d_pagObj = $('#d_pagination').twbsPagination({
	            totalPages: <?php echo $d_total_pages ?>,
	            visiblePages: 10,
	            onPageClick: function (event, page) {

	            }
	        }).on('page', function (event, page) {
	        	//console.log(page);
	            d_page = page;
	            get_discount();
	        });




	function get_hot(){
		var icount = (parseInt(h_page) - 1) * 6;
		$.post('get_hot.php', {icount: icount}, function(data){
			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

		    $('#hot_table').html(result.products);

		    $('[data-toggle="tooltip"]').tooltip();
		                                
		});
	}


	function get_discount(){
		var icount = (parseInt(d_page) - 1) * 6;
		$.post('get_discount.php', {icount: icount}, function(data){
			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

		    $('#discount_table').html(result.products);

		    $('[data-toggle="tooltip"]').tooltip();
		                                
		});
	}


	get_hot();
	get_discount();


	$('#hot_table').on('click', '.del_hot', function(){
		
		var msg = "確定要從熱門商品內移除？"; 
		if (confirm(msg)==true){ 

			var pid =	$(this).data('pid');
			var tr = $(this).parent().parent().parent();

			$.post('del_hot.php', {pid: pid}, function(data){

				var result = JSON.parse(data);

				if (result['err_msg'] === '-1'){
					alert('登入逾時，請重新登入~!');
					window.location = 'login.php';
				}

				if (result['err_msg'] !== 'OK'){
				    toastr.error(result.err_msg);
				    return false;
				}

				$(tr).remove();

				if ($('#hot_table').html() === ''){

					if (h_page > 1) h_page = h_page - 1;
					$('#h_pagination').twbsPagination('destroy');

					$('#h_pagination').twbsPagination({
						totalPages: h_page,
						startPage: h_page,
						visiblePages: 8
					});

					get_hot();
				}

			});
		}

	});


	$('#discount_table').on('click', '.del_dis', function(){
		
		var msg = "確定要從特價商品內移除？"; 
		if (confirm(msg)==true){ 

			var pid =	$(this).data('pid');
			var tr = $(this).parent().parent().parent();

			$.post('del_discount.php', {pid: pid}, function(data){

				var result = JSON.parse(data);

				if (result['err_msg'] === '-1'){
					alert('登入逾時，請重新登入~!');
					window.location = 'login.php';
				}

				if (result['err_msg'] !== 'OK'){
				    toastr.error(result.err_msg);
				    return false;
				}

				$(tr).remove();

				if ($('#discount_table').html() === ''){

					if (d_page > 1) d_page = d_page - 1;
					$('#d_pagination').twbsPagination('destroy');

					$('#d_pagination').twbsPagination({
						totalPages: d_page,
						startPage: d_page,
						visiblePages: 8
					});

					get_discount();
				}

			});
		}

	});






	$('#send_hot').on('click', function(){
		var hnum = $('#hnum').val();
		if ($.trim(hnum) === ''){
			toastr.error('請輸入商品編號~!');
			return;
		}

		$.post('new_hot.php', {hnum: hnum}, function(data){

			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

			if (result['err_msg'] !== 'OK'){
			    toastr.error(result.err_msg);
			    return false;
			}

			$('#new_hot_modal').modal('hide');

			get_hot();

		});
	});


	$('#send_dis').on('click', function(){
		var dnum = $('#dnum').val();
		if ($.trim(dnum) === ''){
			toastr.error('請輸入名稱~!');
			return;
		}

		$.post('new_discount.php', {dnum: dnum}, function(data){

			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

			if (result['err_msg'] !== 'OK'){
			    toastr.error(result.err_msg);
			    return false;
			}

			$('#new_dis_modal').modal('hide');

			get_discount();

		});
	});


	$('#new_hot').on('click', function(){
		$('#hnum').val('');
		$('#new_hot_modal').modal();
	});


	$('#new_discount').on('click', function(){
		$('#dnum').val('');
		$('#new_dis_modal').modal();
	});

	function validURL(str) {
	  var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
	    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
	    '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
	    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
	    '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
	    '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
	  return !!pattern.test(str);
	}


	function create_field(text){
	    return `<div class="form-row w-100">

		        		<div class="col-md-4 plink mt-2">

							<div class="input-group">
							  <div class="input-group-prepend">
							    <div class="input-group-text">連結商品</div>
							  </div>
							  <input type="text" class="form-control py-0">

						 </div></div>

						 <div class="col-md-8 purl mt-2">

							 <div class="input-group">
							   <div class="input-group-prepend">
							     <div class="input-group-text">URL</div>
							   </div>
							   <input type="text" class="form-control py-0 img_path" value="`+text+`">
	 						

	 						  <div class="input-group-append">
	 						    <div class="btn btn-md m-0 btn-pink del_link" type="button"><i class="fas fa-trash-alt"></i></div>
	 						  </div>

	 						  <div class="input-group-append">
	 						      <div class="file-field">
	 						          <button class="btn btn-md btn-primary m-0 z-depth-0 waves-effect" type="button">
	 						            <span class="upbtn"><i class="fas fa-upload mr-1"></i>上傳檔案</span>
	 						            <form class="largeform">
	 						            	<input class="up_large_img" name="large_img" type="file" accept="image/png, image/jpeg">
	 						            	<input class="oname" type="hidden" name="oname">
	 						            </form>
	 						          </button>
	 						      </div>
	 						  </div>

	 					 </div></div></div>`;
	}


	$('#new_link').on('click', function(){

		if (typeof(navigator.clipboard)=='undefined') {
		    $('#link_area').append(create_field(''));
		    return;
		}
		
			navigator.clipboard.readText().then(text => {

		       var url = text.split('/');

		       if (url[0] !== 'https:' && url[0] !== 'http:'){
		           text = '';
		       }

		       if ($('#google_cloud').is(':checked')){
		           if (url[2] !== 'drive.google.com' || url.length < 5){
		               toastr.error('請複製正確的Google的雲端連結~!');
		               return;
		           }

		           text = 'https://drive.google.com/uc?export=download&id='+url[5];
		       }

		        $('#link_area').append(create_field(text));
		        if (text !== '') reset_banner();
		    })
				.catch(err => {
				      $('#link_area').append(create_field(''));
				});
	});


	function reset_banner(){
		var b1 = '', b2 = '';
		$('.purl').each(function(key, value){
		    var img = $('input', this).val();
		    var active = '';

		    if ($.trim(img) === '') return;

		    if (key === 0) active = 'active';

		    b1 += `<div class="carousel-item">
	 		  	      <img class="d-block w-100" src="`+img+`"
	 		  	        alt="slide">
	 		  	    </div>`;


	 		 b2 += `<li data-target="#carousel-thumb" data-slide-to="`+key+`">
	 		  	      <img src="`+img+`" width="100">
	 		  	    </li>`;
		});

		$('#banner_class .carousel-inner').html(b1);
		$('#banner_class .carousel-indicators').html(b2);

		$('.carousel-inner .carousel-item').first().addClass('active');
	}


	$('#save_banners').on('click', function(){
		var opts = [];

		var blank = false;

		$('.plink').each(function(){
			var p1 = $(this).parent();
			var plink = $('input', this).val();

			var p2 = $('.purl', p1);
			var purl = $('input', p2).val();

			if ($.trim(purl) === ''){
				blank = true;
				return false;
			}

		    var obj = {'url': purl, 'link': plink};

		    opts.push(obj);

		});

		if (blank){
			toastr.error('圖片網址不能空白~!');
			return false;
		}

		// if (opts.length === 0){
		// 	toastr.error('沒有輪播資料~!');
		// 	return false;
		// }

		var banners = JSON.stringify(opts);
		var banners_all = 0;
		if ($('#banners_all').is(':checked')) banners_all = 1;

		$.post('update_banners.php', {banners: banners, banners_all: banners_all}, function(data){

			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

			if (result['err_msg'] !== 'OK'){
			    toastr.error(result.err_msg);
			    return false;
			}

			toastr.success('輪播已更新~!');
		});
	});



	$('#link_area').on('click', '.del_link', function(){
		var p = $(this).parent().parent().parent().parent();
		$(p).remove();

		var url = $('.img_path', p).val();

		if ($.trim(url) !== ''){
			$.post('del_img.php', {url: url, dir: 'banners'}, function(data){
				if (result.err_msg === '-1'){
				    alert('登入逾時，請重新登入~!');
				    window.location = 'login.php';
				}
			});
		}

		reset_banner();
	});

	$('#ref_banners').on('click', function(){
			reset_banner();
	})
	// $('#link_area').on('blur', '.purl', function(){
	// 	reset_banner();
	// });


	$('#link_area').on('blur', '.plink', function(){
		var field = $('input', this);
		var pnum = $(field).val();
		if ($.trim(pnum) === '') return;

		$.post('check_prod_exists.php', {pnum: pnum}, function(data){

			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

			if (result['err_msg'] !== 'OK'){
			    toastr.error(result.err_msg);
			    $(field).val('');
			}

		});
	});


	$('#save_news').on('click', function(){
		var news 	=	$('#news').trumbowyg('html');
		var burl	=	$('#burl').val();

		$.post('news_update.php', {news: news, burl: burl}, function(data){
			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

			if (result['err_msg'] !== 'OK'){
			    toastr.error(result.err_msg);
			    return;
			}

			toastr.success('資訊已更新~!');

		})
	});
	

	function getFileName(path) {
	    return path.match(/[-_\w]+[.][\w]+$/i)[0];
	}

	$('#main_index').on('change', '.up_large_img', function(e){
	    var fname = getFileName($(this).val());
	    var oname = fname.split('.');

	    var parent = $(this).closest('.input-group');
	    $('.img_path', parent).val(fname);
	   

	    var form = $(this).closest('form');
	    $('.oname', form).val(oname[0]);

	    $('.upbtn', parent).html('<i class="fas fa-circle-notch fa-spin fa-lg ml-1"></i>上傳中');

	    $(form).submit();
	    
	})

		 $('body').on('submit', '.largeform', (function (e) {
	            e.preventDefault();

	            var form = $(this);
	            var parent = $(this).closest('.input-group');

	            $('.upbtn', parent).html('<i class="fas fa-circle-notch fa-spin fa-lg ml-1"></i>上傳中');

	            $.ajax({
	                url: 'upload_larg_img.php',
	                enctype: 'multipart/form-data',
	                type: "POST",
	                data:  new FormData(this),
	                contentType: false,
	                cache: false,
	                processData:false,
	                error: function (xhr, status, error) {
	                    console.log(xhr);
	                },
	                success: function(data){
	                	//console.log(data);

	                    var result = JSON.parse(data);
	                    $('.upbtn', parent).html('<i class="fas fa-upload mr-1"></i>上傳檔案');

	                    if (result.err_msg !== 'OK'){
	                    	toastr.error(result.err_msg);
	                    	return;
	                    }
	                    
	                    $('.img_path', parent).val(result.img);
	                    //reset_banner();
	                   
	                }
	            });


	        }));


 $('#new_full').on('click', function(){
 	 var box = $('#linkbox').clone(true);
 	 $('.title_color', box).addClass('colorpick');
 	 $('.content_color', box).addClass('colorpick');
 	 $(box).removeAttr('id').removeClass('d-none').appendTo($('#banner_block'));

 	 $('.colorpick').spectrum({
 	   type: "component",
 	   showPalette: false,
 	   showButtons: false,
 	   allowEmpty: false
 	 });
 });


 $('#banner_block').on('click', '.del_full', function(){
	 	var msg = "確定要刪除這個輪播組合？"; 
	 	if (confirm(msg)==true){ 
	 		var row = $(this).closest('.row');
	 		var img1 = $('.mobile', row).val();
	 		var img2 = $('.pad', row).val();
	 		var img3 = $('.computer', row).val();

	 		$.post('del_full_banners.php', {img1: img1, img2: img2, img3: img3}, function(data){
	 				var result = JSON.parse(data);

	 				if (result['err_msg'] === '-1'){
	 					alert('登入逾時，請重新登入~!');
	 					window.location = 'login.php';
	 				}

	 				if (result.err_msg !== 'OK'){
	 					toastr.error(result.err_msg);
	 					return;
	 				}

	 				$(row).remove();


	 		})
	 	}
 });

 function getRandom(min,max){
     return Math.floor(Math.random()*(max-min+1))+min;
 };

 function getFileHtml(path, width) {

 	if ($.trim(path) === ''){
 		return '';
 	}

     var fname = path.match(/[-_\w]+[.][\w]+$/i)[0];

     var farr  = fname.split('.');

     if (farr[1] === 'png'){
     	return '<img alt="" style="max-width: '+width+'px" class="mr-2" src="'+path+'?id='+getRandom(1000, 1000000)+'">';
     }

     if (farr[1] === 'jpg'){
     	return '<img alt="" style="max-width: '+width+'px" class="mr-2" src="'+path+'?id='+getRandom(1000, 1000000)+'">';
     }

     if (farr[1] === 'mp4'){
     	return '<video class="mr-2" style="max-width: '+width+'px" autoplay="" loop="" muted=""><source src="'+path+'?id='+getRandom(1000, 1000000)+'" type="video/mp4" style="object-fit: cover;"></video>';
     }
 }


  $('#banner_block').on('click', '.update_full', function(){
  	var row = $(this).closest('.row');
  	var img1 = $('.mobile', row).val();
  	var img2 = $('.pad', row).val();
  	var img3 = $('.computer', row).val();

  	var imgbox = '';

  	imgbox += getFileHtml(img1, 120);
  	imgbox += getFileHtml(img2, 200);
  	imgbox += getFileHtml(img3, 300);

  	$('.imgbox', row).html(imgbox);

  	// $('.img1', row).prop('src', img1 + '?id='+getRandom(1000, 1000000));
  	// $('.img2', row).prop('src', img2 + '?id='+getRandom(1000, 1000000));
  	// $('.img3', row).prop('src', img3 + '?id='+getRandom(1000, 1000000));

  });


 $('#save_full').on('click', function(){
 	var opts = [];
 	var blank = false;

 		$('#banner_block .banner_row').each(function(key, value){
 			var mobile = $('.mobile', this).val();
 			var pad = $('.pad', this).val();
 			var computer = $('.computer', this).val();
 			var title = $('.title', this).val();
 			var content = $('.content', this).val();
 			var title_size = $('.title_size', this).val();
 			var title_color = $('.title_color', this).val();
 			var content_size = $('.content_size', this).val();
 			var content_color = $('.content_color', this).val();


 			if ($.trim(mobile) === '' || $.trim(pad) === '' || $.trim(computer) === ''){
 				blank = true;
 				return false;
 			}

 			
 			var obj = {'mobile': mobile, 'pad': pad, 'computer': computer, title: title, title_size: title_size, title_color: title_color, content: content, content_size: content_size, content_color: content_color};

 			opts.push(obj);

 		});

 		if (blank){
 			toastr.error('圖片網址不能空白~!');
 			return false;
 		}

 		var banners = JSON.stringify(opts);

 		$.post('update_full_banners.php', {banners: banners}, function(data){

 			var result = JSON.parse(data);

 			if (result['err_msg'] === '-1'){
 				alert('登入逾時，請重新登入~!');
 				window.location = 'login.php';
 			}

 			if (result['err_msg'] !== 'OK'){
 			    toastr.error(result.err_msg);
 			    return false;
 			}

 			toastr.success('輪播已更新~!');
 		});

 })


</script>