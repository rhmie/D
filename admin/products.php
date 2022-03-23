<?php session_start(); ?>
<?php

	if (!isset($_SESSION['bee_admin'])){
	   echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
	}

	include('../mysql.php');
	require_once('../MysqliDb.php');
	include('./ssl_encrypt.php');

	$db = new MysqliDb($mysqli);

	$mains 	=	$db->orderBy('sort', 'asc')->get('main_class');

	$main_items =	$sub_items	=	 '';

	foreach ($mains as $main){
		$main_items .= '<option  value="'.$main['id'].'">'.$main['cname'].'</option>';
	}

	$subs 	=	$db->where('mid', $mains[0]['id'])->orderBy('sort', 'asc')->get('sub_class');

	foreach ($subs as $sub){
		$sub_items .= '<option value="'.$sub['id'].'">'.$sub['cname'].'</option>';
	}

	$oitems     =	$zitems	=   '';
	$infos  =   $db->get('product_info');

	foreach ($infos as $info){
	    $oitems .= '<a data-iname="'.$info['iname'].'" data-info="'.htmlspecialchars($info['info']).'" class="dropdown-item info-item">'.$info['iname'].'</a>';

	    $zitems .= '<a data-iname="'.$info['iname'].'" data-info="'.htmlspecialchars($info['info']).'" class="dropdown-item zinfo-item">'.$info['iname'].'</a>';
	}

	$f3     =   encrypt_decrypt('encrypt', 'products').'_products.sql';

?>

	<style>

		.hidden {
			background: #dedede;
		}

		.nostock {
			background: #ffcfcf;
		}

	</style>

<section class="section" id="products">

	<div class="row">

		<div class="col-12">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs md-tabs nav-justified primary-color" role="tablist">
			  <li class="nav-item">
			    <a class="nav-link active" data-toggle="tab" href="#prod_tab" role="tab">
			      商品管理</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" data-toggle="tab" href="#import_tab" role="tab">
			      商品導入</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" data-toggle="tab" href="#gifts_tab" role="tab">
			      滿額禮</a>
			  </li>
			</ul>
			<!-- Nav tabs -->
		</div>

		<div class="tab-content w-100">

		  <!-- Panel 1 -->
		<div class="tab-pane fade in show active px-3" id="prod_tab" role="tabpanel">

			<div class="row mt-3">

			<div class="col-lg-3">
				<div class="input-group input-group-sm">
				  <div class="input-group-prepend">
				    <label class="input-group-text" for="main_items">主類別</label>
				  </div>
				  <select class="browser-default custom-select" name="sub_id" id="main_items">
				    <?=$main_items?>
				  </select>
				</div>

			</div>

			<div class="col-lg-3">
				<div class="input-group input-group-sm">
				  <div class="input-group-prepend">
				    <label class="input-group-text" for="sub_items">次類別</label>
				  </div>
				  <select class="browser-default custom-select" id="sub_items">
				    <?=$sub_items?>
				  </select>
				</div>

			</div>

			<div class="col-lg-3">
				<div class="input-group input-group-sm">
				  <div class="input-group-prepend">
				    <label class="input-group-text" for="sort">排序</label>
				  </div>
				  <select class="browser-default custom-select" id="sort">
				    <option value="volume">售出量</option>
				    <option value="views">瀏覽次數</option>
				    <option value="id">上架日期</option>
				  </select>
				</div>

			</div>


			<div class="col-lg-3">
				<button id="class_search" class="btn btn-blue-grey btn-sm mt-0"><i class="fas fa-search mr-1"></i>搜尋</button>
			</div>

			<div class="col-12"><hr></div>
		</div>

			<div class="row">

				<div class="col-lg-3">
					<div class="input-group input-group-sm mb-3">
						  <input type="text" id="namebox" class="form-control" placeholder="商品名稱搜尋"
						    aria-describedby="button-addon2">
						  <div class="input-group-append">
						    <button class="input-group-text btn-blue-grey waves-effect" type="button" id="name_search"><i class="fas fa-search mr-1"></i>搜尋</button>
						  </div>
					</div>
				</div>

				<div class="col-lg-3">
					<div class="input-group input-group-sm mb-3">
						  <input type="text" id="numbox" class="form-control" placeholder="商品編號搜尋"
						    aria-describedby="button-addon2">
						  <div class="input-group-append">
						    <button class="input-group-text btn-blue-grey waves-effect" type="button" id="num_search"><i class="fas fa-search mr-1"></i>搜尋</button>
						  </div>
					</div>
				</div>

				<div class="col-lg-6">
					<form id="excform" method="POST" action="excel_export.php">
						<input name="table" type="hidden" value="products">
					</form>
					<div class="btn-group btn-group-sm">
						<button id="stock_search" class="btn btn-blue-grey btn-sm mt-0"><i class="fas fa-search mr-1"></i>庫存為0的商品</button>
						<a type="button" href="./<?=$f3?>" class="btn btn-blue-grey btn-sm mt-0" download><i class="fas fa-download mt-1"></i> 下載SQL檔</a>
						<button type="button" id="btn_export" class="btn btn-blue-grey btn-sm mt-0"><i class="far fa-file-excel mt-1"></i> 下載excel檔</button>
					</div>
				</div>

				<div class="col-12 text-right">
					<hr>
					<span style="color: #dedede">◼︎</span><span class="mr-2">商品隱藏中</span>
					<span style="color: #ffcfcf">◼︎</span><span class="mr-2">庫存為0</span>
				</div>

			</div>


			<div class="row">

				<div class="col-12">

					<a id="new_main" type="button" href="#" onclick="javascript:edit_prod(0);" class="btn btn-outline-info"><i class="fas fa-plus fa-lg mr-1"></i>新增商品</a>

					<table class="table">
					  <thead>
					    <tr>
					      <th scope="col">ID</th>
					      <th scope="col">縮圖</th>
					      <th scope="col">編號</th>
					      <th scope="col">名稱</th>
					      <th scope="col">價格</th>
					      <th scope="col">優惠價</th>
					      <th scope="col">庫存</th>
					      <th scope="col">瀏覽</th>
					      <th scope="col">售出量</th>
					      <th scope="col" class="text-right">操作</th>
					    </tr>
					  </thead>
					  <tbody id="products_table">

					    
					  </tbody>
					</table>


				</div>


			</div>


				<div id="page_nav" class="row justify-content-center d-none">
					<nav class="text-center my-4" aria-label="Page navigation">
					    <ul class="pagination" id="m_pagination"></ul>
					</nav>
				</div>

		</div>


		<!-- panel 2 -->
		<div class="tab-pane fade in px-3" id="import_tab" role="tabpanel">

			<ul class="nav nav-tabs" id="etab" role="tablist">
			  <li class="nav-item d-none">
			    <a class="nav-link active" id="yahoo-tab" data-toggle="tab" href="#yahoo" role="tab" aria-controls="yahoo"
			      aria-selected="true">YAHOO批次導入</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" id="momo-tab" data-toggle="tab" href="#yahoo_single" role="tab" aria-controls="momo"
			      aria-selected="false">YAHOO商品導入</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" id="excel-tab" data-toggle="tab" href="#excel" role="tab" aria-controls="excel"
			      aria-selected="true">EXCEL批次導入</a>
			  </li>
			</ul>

			<div class="tab-content" id="excontent">

			  <div class="tab-pane fade d-none" id="yahoo" role="tabpanel" aria-labelledby="yahoo-tab">

			  	 		<form id="exform" class="form-row" method="POST" target="_blank" action="yahoo.php">	
				  			<div class="col-md-4 my-3">

				  				<div class="input-group input-group-sm">
				  				  <div class="input-group-prepend">
				  				    <div class="input-group-text">Yahoo賣家ID</div>
				  				  </div>
				  				  <input type="text" class="form-control py-0" id="yname" name="yname" required>
				  				</div>

				  			</div>

				  			<div class="col-md-4 my-3">

				  				<div class="input-group input-group-sm">
				  				  <div class="input-group-prepend">
				  				    <label class="input-group-text" for="main_items">主類別</label>
				  				  </div>
				  				  <select class="browser-default custom-select" id="xmain_items" name="main">
				  				    <?=$main_items?>
				  				  </select>
				  				</div>

				  			</div>

				  			<div class="col-md-4 my-3">

				  				<div class="input-group input-group-sm">
				  				  <div class="input-group-prepend">
				  				    <label class="input-group-text" for="xsub_items">次類別</label>
				  				  </div>
				  				  <select class="browser-default custom-select" id="xsub_items" name="sub">
				  				    <?=$sub_items?>
				  				  </select>
				  				</div>

				  			</div>

				  			<div class="col-md-4 mb-3">

				  				<div class="input-group input-group-sm">
				  				  <div class="input-group-prepend">
				  				    <div class="input-group-text">起始頁</div>
				  				  </div>
				  				  <input type="number" class="form-control py-0" id="spage" name="spage" value="1" required>
				  				</div>

				  			</div>

				  			<div class="col-md-4 mb-3">

				  				<div class="input-group input-group-sm">
				  				  <div class="input-group-prepend">
				  				    <div class="input-group-text">結束頁</div>
				  				  </div>
				  				  <input type="number" class="form-control py-0" id="epage" name="epage" value="3" required>
				  				</div>

				  			</div>

				  			<div class="col-md-4 mb-3">

				  				<div class="input-group input-group-sm">
				  				  <div class="input-group-prepend">
				  				    <div class="input-group-text">庫存量</div>
				  				  </div>
				  				  <input type="number" class="form-control py-0" id="stock" name="stock" value="1000" required>
				  				</div>

				  			</div>

				  			<div class="col-md-6 mb-3">

				  				<div class="input-group input-group-sm">
				  				  <div class="input-group-prepend">
				  				    <div class="input-group-text">bcid參數</div>
				  				  </div>
				  				  <input type="number" class="form-control py-0" id="bcid" name="bcid">
				  				</div>

				  			</div>

				  			<div class="col-md-6 mb-3">

				  				<div class="input-group input-group-sm">
				  				  <div class="input-group-prepend">
				  				    <div class="input-group-text">cid參數</div>
				  				  </div>
				  				  <input type="number" class="form-control py-0" id="cid" name="cid">
				  				</div>

				  			</div>

				  			<div class="col-12">
				  				<p class="note note-primary text-left">
				  					Yahoo 拍賣會bcid或是cid來做為分類參數，請依您實際網址填入分類參數，否則將會從全部商品頁面進行導入
				  				</p>
				  			</div>


				  			<div class="col-12 my-4">

				  				<h4 class="grey-text font-weight-bold"><i class="fab fa-wordpress-simple fa-lg fa-fw mr-2"></i>文字說明</h4>
				  				<hr>
				  				<p class="note note-primary">
				  				    請在此編排文字說明及外部連結，如無特別說明，建議輸入各超商運費及免運費金額
				  				</p>

				  				<div class="text-right">
					  				<button type="button" class="btn btn-blue-grey btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">選擇資訊</button>
					  				<div class="dropdown-menu">
					  				        <?=$oitems?>
					  				</div>
				  				</div>

				  				<textarea id="info" class="mt-3 info" row="5" name="info"></textarea>

				  			</div>

				  			<div class="col-12 text-right">
				  				<button typd="submit" class="btn btn-blue-grey btn-sm">送出</button>
				  			</div>

				  		</form>

			  	
			  </div>


			  <div class="tab-pane fade show active" id="yahoo_single" role="tabpanel" aria-labelledby="momo-tab">
			  	
			  		<form id="ex2form" class="form-row" method="POST" target="_blank" action="yahoo_single.php">

			  			<div class="col-12 my-1">
			  				<div class="input-group input-group-sm">
			  				  <div class="input-group-prepend">
			  				    <div class="input-group-text">網址</div>
			  				  </div>
			  				  <input type="text" class="form-control py-0" id="yurl" name="yurl" required>
			  				</div>
			  			</div>

			  			<div class="col-md-4 mt-1">

			  				<div class="input-group input-group-sm">
			  				  <div class="input-group-prepend">
			  				    <label class="input-group-text" for="main_items">主類別</label>
			  				  </div>
			  				  <select class="browser-default custom-select" id="zmain_items" name="main">
			  				    <?=$main_items?>
			  				  </select>
			  				</div>

			  			</div>

			  			<div class="col-md-4 mt-1">
			  				<div class="input-group input-group-sm">
			  				  <div class="input-group-prepend">
			  				    <label class="input-group-text" for="xsub_items">次類別</label>
			  				  </div>
			  				  <select class="browser-default custom-select" id="zsub_items" name="sub">
			  				    <?=$sub_items?>
			  				  </select>
			  				</div>
			  			</div>

			  			<div class="col-md-4 mt-1">
			  				<div class="input-group input-group-sm">
			  				  <div class="input-group-prepend">
			  				    <div class="input-group-text">庫存量</div>
			  				  </div>
			  				  <input type="number" class="form-control py-0" id="zstock" name="stock" value="1000" required>
			  				</div>
			  			</div>

  			  			<div class="col-12 my-4">

  			  				<h4 class="grey-text font-weight-bold"><i class="fab fa-wordpress-simple fa-lg fa-fw mr-2"></i>文字說明</h4>
  			  				<hr>
  			  				<p class="note note-primary">
  			  				    請在此編排文字說明及外部連結，如無特別說明，建議輸入各超商運費及免運費金額
  			  				</p>

  			  				<div class="text-right">
  				  				<button type="button" class="btn btn-blue-grey btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">選擇資訊</button>
  				  				<div class="dropdown-menu">
  				  				        <?=$zitems?>
  				  				</div>
  			  				</div>

  			  				<textarea id="zinfo" class="mt-3 info" row="5" name="info"></textarea>

  			  			</div>

  			  			<div class="col-12 text-right">
  			  				<button typd="submit" class="btn btn-blue-grey btn-sm">送出</button>
  			  			</div>


			  		</form>	

			  </div>

			  <div class="tab-pane fade" id="excel" role="tabpanel" aria-labelledby="excel-tab">
			  	<form id="ex3form">
			  		<div class="row mt-4 justify-content-center">
			  			<div class="col-6">

			  				<div class="custom-file">
			  				  <input type="file" class="custom-file-input" name="excel_file" id="customFileLang" lang="zh" required>
			  				  <label class="custom-file-label" for="customFileLang">選擇文件</label>
			  				</div>

			  				<div class="custom-control custom-checkbox my-3">
			  				  <input type="checkbox" class="custom-control-input" name="rewrite" id="rewrite">
			  				  <label class="custom-control-label" for="rewrite">覆蓋相同編號之商品，如不勾選則略過相同編號之商品</label>
			  				</div>

			  				<a href="./excel_demo.xlsx" download>下載Excel範例文件</a>

			  				<p class="note note-primary text-left mt-2">
			  					規格請使用半型逗號 , 來區分，如沒有規格可留白，最多兩種規格<br>
			  					圖片網址請使用半型逗號 , 做區分<br>
			  				</p>


			  			</div>
			  			<div class="col-12 text-center mt-4">
			  				<button typd="submit" id="ex_btn" class="btn btn-blue-grey mt-4">送出<i class="fab fa-telegram-plane fa-lg ml-2"></i></button>
			  			</div>
			  		</div>
			  	</form>
			  </div>
			  
			</div>

		</div>

		  <!-- Panel 3 -->
		<div class="tab-pane fade px-3" id="gifts_tab" role="tabpanel">
			<div class="row">
				<div class="col-12">
					<button class="btn btn-outline-info" type="button" id="new_gift"><i class="fas fa-plus fa-lg mr-1"></i>新增滿額禮</button>

					<p class="note note-primary text-left mt-2">
						滿額禮無累計機制，亦即無論消費金額多少，滿額禮只有一份<br>
						會於前端顯示所有符合消費金額之滿額禮供用戶選擇，亦即當用戶有資格領取消費金額3000的滿額禮時，仍可選擇消費金額滿300之滿額禮<br>
						滿額禮於訂單被標示為已出貨時進行庫存扣除，當庫存為0時則不顯示於前端
					</p>

					<table class="table table-striped">
					  <thead>
					    <tr>
					      <th scope="col">縮圖</th>
					      <th scope="col">名稱</th>
					      <th scope="col">額度</th>
					      <th scope="col">庫存</th>
					      <th scope="col" class="text-right">操作</th>
					    </tr>
					  </thead>
					  <tbody id="gifts_table">

					    
					  </tbody>
					</table>

				</div>
			</div>

		</div>


	</div>
</div>


<div class="modal fade" id="new_gift_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">新增滿額禮</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-0 mx-3">

      	<form id="giftform">

      	  <div class="modal-body">

      	    <div class="input-group my-3">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">名稱</div>
      	      </div>
      	      <input type="text" class="form-control py-0 gifts" name="gname" id="gname" required>
      	    </div>

      	    <div class="input-group mb-3">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">額度</div>
      	      </div>
      	      <input type="number" min="0" class="form-control py-0 gifts" name="price" id="gprice" required>
      	    </div>

      	    <div class="input-group mb-3">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">庫存</div>
      	      </div>
      	      <input type="number" min="0" class="form-control py-0 gifts" name="stock" id="gstock" required>
      	    </div>

      	    <input type="hidden" id="gid" name="gid">

      	    <div class="input-group">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">圖片</div>
      	      </div>
      	      <input type="text" class="form-control py-0 gifts" id="gurl">
      	      <input type="hidden" class="gifts" id="gimg" name="gimg">
      	      <div class="input-group-append">
      	          <div class="file-field">
      	              <button class="btn btn-md btn-primary m-0 z-depth-0 waves-effect" type="button">
      	                <span><i class="fas fa-upload mr-1"></i>選擇圖片</span>
      	                <input id="gift_img" type="file" accept="image/png, image/jpeg">
      	              </button>
      	          </div>
      	      </div>

      	    </div>

      	    <div class="row mt-3">
      	    	<div class="col-12 text-center">
      	    		<img id="gpic" src="" style="max-width: 300px; max-height: 300px;">
      	    	</div>
      	    </div>

      	  </div>
      	  <!--Footer-->
      	  <div class="modal-footer py-4">
      	    <div class="btn-group m-auto">
      	      <button type="button" class="btn btn-outline-info" data-dismiss="modal"><i class="fas fa-times fa-lg mr-1"></i>關閉</button>
      	      <button type="submit" id="gbtn" class="btn btn-outline-info">送出<i class="fas fa-paper-plane fa-lg ml-1"></i></button>           
      	    </div>
      	  </div>

      	</form>

      </div>

    </div>
  </div>
</div>


</section>


<script>


	$('#main_items').on('change', function(){
		var mid = $(this).val();

		$.post('get_sub_class.php', {mid: mid}, function(data){

			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

			if (result['err_msg'] !== 'OK'){
			    toastr.error(result.err_msg);
			    return false;
			}

			$('#sub_items').html(result.sub_items);

		})
	});

	$('#xmain_items').on('change', function(){
		var mid = $(this).val();

		$.post('get_sub_class.php', {mid: mid}, function(data){

			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

			if (result['err_msg'] !== 'OK'){
			    toastr.error(result.err_msg);
			    return false;
			}

			$('#xsub_items').html(result.sub_items);

		})
	});

	$('#zmain_items').on('change', function(){
		var mid = $(this).val();

		$.post('get_sub_class.php', {mid: mid}, function(data){

			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

			if (result['err_msg'] !== 'OK'){
			    toastr.error(result.err_msg);
			    return false;
			}

			$('#zsub_items').html(result.sub_items);

		})
	});



	$('#class_search').on('click', function(){
		var sid 	= $('#main_items').val();
		$('#namebox, #numbox').val('');
		var sort 	=	$('#sort').val();
		get_products(sid, 0, 0, 0, sort);
	});


	$('#name_search').on('click', function(){
		var pname 	= $('#namebox').val();
		if ($.trim(pname) === ''){
			toastr.error('請輸入名稱~!');
			return;
		}

		get_products(0, pname, 0, 0);
	});


	$('#num_search').on('click', function(){
		var pnum 	= $('#numbox').val();
		if ($.trim(pnum) === ''){
			toastr.error('請輸入編號~!');
			return;
		}

		get_products(0, 0, pnum, 0);
	});


	$('#stock_search').on('click', function(){
		get_products(0, 'stock', 0, 0);
	});


	var total = 1;
	var mpage = 1;


	function get_products(sid, pname, pnum, icount, sort = 'volume'){

		$.post('search_products.php', {sid: sid, pname: pname, pnum: pnum, icount: icount, sort: sort}, function(data){

			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

			if (result['err_msg'] !== 'OK'){
			    toastr.error(result.err_msg);
			    return false;
			}

			if ($.trim(result.products) === ''){
				toastr.error('沒有搜尋結果~!');
				return;
			}

			$('#products_table').html(result.products);

			$('[data-toggle="tooltip"]').tooltip();

			$('#page_nav').addClass('d-none');

			if (sid !== 0){
				$('#m_pagination').twbsPagination('destroy');
				total = result.totalpages;
				window.pagObj = $('#m_pagination').twbsPagination({
				            totalPages: total,
				            startPage: mpage,
				            visiblePages: 8,
				            onPageClick: function (event, page) {

				            }
				        }).on('page', function (event, page) {
				        	var icount = (parseInt(page) - 1) * 6;
				        	mpage 	=	page;
				        	//console.log(icount);
				            get_products(sid, pname, pnum, icount, sort);
				        });

				$('#page_nav').removeClass('d-none');
			}

		});

	}


	function edit_prod(pid){
		window.open('./edit_product.php?id='+pid, "connectWindow", "width=850,height=900, scrollbars=yes");
	}


	$('#products_table').on('click', '.del_prod', function(){
		var msg = "確定要刪除這個商品？"; 
		if (confirm(msg)==true){ 

			var pid =	$(this).data('pid');

			var tr = $(this).parent().parent().parent();

			$.post('del_prod.php', {pid: pid}, function(data){

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

				if ($('#page_nav').hasClass('d-none')) return;

				if ($('#products_table').html() === ''){
					if (total > 1) total = total - 1;
					$('#m_pagination').twbsPagination('destroy');

					$('#m_pagination').twbsPagination({
						totalPages: total,
						startPage: total,
						visiblePages: 8
					});

					var icount = (parseInt(total) - 1) * 6;
					var sid 	= $('#sub_items').val();
				    get_products(sid, 0, 0, icount);
				}

			});
		}
	});


	 $(document).ready(function() {
	    $('.info')
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
	            // ['image'], 
	            ['strong'],
	            ['justifyLeft', 'justifyCenter', 'justifyFull'],
	            ['horizontalRule'],
	            ['fullscreen']
	        ]
	    });

	});

	 $('.info-item').on('click', function(){
	     $('#info').trumbowyg('html', $(this).data('info'));
	 });

	 $('.zinfo-item').on('click', function(){
	     $('#zinfo').trumbowyg('html', $(this).data('info'));
	 });


 	 $('#ex3form').on('submit', (function (e) {
             e.preventDefault();

             $('#ex_btn').html('傳送中<i class="fas fa-circle-notch fa-spin fa-lg ml-2 amber-text"></i>').parent().addClass('disabled');

             $.ajax({
                 url: 'excel_products.php',
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
                     var result = JSON.parse($.trim(data));
                     //console.log(result);
                     $('#ex_btn').html('送出<i class="fab fa-telegram-plane fa-lg ml-2"></i>').parent().removeClass('disabled');

                     if (result.err_msg === '-1') {
                         toastr.error('登入逾時，請重新登入~!');
                         location.reload();
                     }

                     if (result.err_msg !== 'OK') {
                         toastr.error(result.err_msg);
                         return;
                     }


                    toastr.success('導入完成~!，共導入'+result.cnt+'筆資料');


                 }
             });


         }));

 	 $('#btn_export').on('click', function(){
 	 	$('#excform').submit();
 	 });



 	 $('#new_gift').on('click', function(){
 	 	$('#new_gift_modal h4').text('新增滿額禮');
 	 	$('#giftform')[0].reset();
 	 	$('#gid').val('0');
 	 	$('#gpic').prop('src', '');
 	 	$('#new_gift_modal').modal();
 	 })



 	 function get_gifts(){
 	 	$.post('get_gifts.php', function(data){

 	 		//console.log(data);
 	 		var result = JSON.parse(data);

 	 		if (result['err_msg'] === '-1'){
 	 			alert('登入逾時，請重新登入~!');
 	 			window.location = 'login.php';
 	 		}

 	 	    $('#gifts_table').html(result.gifts);	 	                                
 	 	});
 	 }

 	 get_gifts();

 	 function convertImgToBase64(url, callback, outputFormat){
 	     var canvas = document.createElement('CANVAS');
 	     var ctx = canvas.getContext('2d');
 	     var img = new Image;
 	     img.crossOrigin = 'Anonymous';
 	     
 	     img.onload = function(){

 	         if (img.width > 800){
 	             var scale = 800 / img.width;
 	             img.width = 800;
 	             img.height = Math.round(img.height * scale);
 	         }

 	         if (img.height > 800){
 	             var scale = 800 / img.height;
 	             img.height = 800;
 	             img.width = Math.round(img.width * scale);
 	         }
 	         canvas.height = img.height;
 	         canvas.width = img.width;

 	         ctx.drawImage(img, 0, 0, img.width, img.height);
 	         var dataURL = canvas.toDataURL(outputFormat || 'image/png');
 	         callback.call(this, dataURL);
 	         // Clean up
 	         canvas = null; 
 	     };
 	     img.src = url;
 	 }

 	 function getFileName(path) {
 	     return path.match(/[-_\w]+[.][\w]+$/i)[0];
 	 }

 	 $('#gift_img').on('change', function(e){
 	     var fname = getFileName($(this).val());
 	     var oname = fname.split('.');

 	     $('#gurl').val(fname);

 	     if (this.files && this.files[0]) {
 	         var FR= new FileReader();

 	         FR.addEventListener("load", function(e) {

 	           convertImgToBase64(e.target.result, function(base64Img){

 	             $('#gpic').prop('src', base64Img);
 	             $('#gimg').val(base64Img);

 	           }, 'image/png');

 	         }); 

 	         FR.readAsDataURL( this.files[0] );

 	     }
 	     
 	 });


 	 $('#giftform').on('submit', (function (e) {
 	 	e.preventDefault();

 	 	$('#gbtn').html('<i class="fas fa-circle-notch fa-spin fa-lg ml-1"></i>上傳中').addClass('disabled');

 	 	$.ajax({
 	 		url: 'gift_update.php',
 	 		type: "POST",
 	 		data:  new FormData(this),
 	 		contentType: false,
 	 		cache: false,
 	 		processData:false,
 	 		success: function(data){
 	 			var result = JSON.parse(data);

 	 			//console.log(data);

 	 			$('#gbtn').html('送出<i class="fas fa-paper-plane fa-lg ml-1"></i>').removeClass('disabled');

 	 			if (result.err_msg === '-1'){
 	 				alert('登入逾時，請重新登入~!');
 	 				window.location = 'login.php';
 	 			}

 	 			if (result['err_msg'] !== 'OK'){
 	 			    toastr.error(result.err_msg);
 	 			    return false;
 	 			}

 	 			get_gifts();
 	 			$('#new_gift_modal').modal('hide');

 	 		}
 	 	});

 	 }));


 	 $('#gifts_table').on('click', '.edit_gift', function(){
 	 	$('#new_gift_modal h4').text('編輯滿額禮');
 	 	$('#gname').val($(this).data('gname'));
 	 	$('#gstock').val($(this).data('gstock'));
 	 	$('#gprice').val($(this).data('gprice'));
 	 	$('#gid').val($(this).data('gid'));

 	 	var tr = $(this).closest('tr');
 	 	$('#gpic').prop('src', $('img', tr).prop('src'));
 	 	$('#new_gift_modal').modal();
 	 });


 	 $('#gifts_table').on('click', '.del_gift', function(){
 	 	var msg = "確定要移除這個滿額禮？"; 
 	 	if (confirm(msg)==true){ 
 	 		var gid = $(this).data('gid');
 	 		$.post('del_gift.php', {gid: gid}, function(data){
 	 			
 	 			var result = JSON.parse(data);
 	 			if (result.err_msg === '-1'){
 	 				alert('登入逾時，請重新登入~!');
 	 				window.location = 'login.php';
 	 			}

 	 			if (result['err_msg'] !== 'OK'){
 	 			    toastr.error(result.err_msg);
 	 			    return false;
 	 			}

 	 			get_gifts();

 	 		})
 	 	}
 	 });

</script>