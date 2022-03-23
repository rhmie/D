<?php session_start(); ?>
<?php

	include('../check_ref.php');

	if (!isset($_SESSION['bee_admin'])){
	   echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
	}

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$count = $db->getValue('sub_products', 'count(*)');
	$m_total_pages = ceil($count / 8);
	if ($m_total_pages == 0) $m_total_pages = 1;

?>

<section class="section" id="options">

	<div class="row">
	 	<div class="col-12 mt-2 px-0">

	 		<ul class="nav nav-tabs md-tabs nav-justified primary-color" role="tablist">
	 		  <li class="nav-item">
	 		    <a class="nav-link active" data-toggle="tab" href="#opt_tab" role="tab">
	 		      商品規格</a>
	 		  </li>
	 		  <li class="nav-item">
	 		    <a class="nav-link" data-toggle="tab" href="#info_tab" role="tab">
	 		      商品資訊</a>
	 		  </li>
	 		  <li class="nav-item">
	 		    <a class="nav-link" data-toggle="tab" href="#add_tab" role="tab">
	 		      單品加購</a>
	 		  </li>
	 		</ul>

	 		<!-- Tab panels -->
	 		<div class="tab-content">

	 		  <!-- Panel 1 -->
	 		  <div class="tab-pane fade in show active px-3" id="opt_tab" role="tabpanel">

			 		<p class="note note-primary">
			 			當多種商品具備相同規格屬性時，可在此進行編輯，例如服飾尺寸 S/M/L/XL 等，之後在新增商品時，可快速選取規格，一種商品可套用多種規格，當規格僅給一種商品使用時，請在新增商品時手動建立即可（舉例，特定型號手機顏色名為璀璨紅、翡翠綠等等）
			 		</p>

			 		<p class="note note-danger">
			 			<strong>規格名稱</strong>將顯示在前端，例如 尺寸、顏色等，<strong>規格別名</strong>僅顯示在後台讓管理員選擇，舉例來說 服飾的常見尺寸規格為 S/M/L/XL, 但您有某些服飾尺寸缺少 S，此時您可將<strong>規格別名</strong>命名為 沒有S的尺寸，規格名稱命名為 尺寸，那麼您就可以快速地利用別名來賦予商品規格，又不影響到前端名稱的正確顯示
			 		</p>

			 		<p class="note note-success">
			 			請注意，刪除或編輯規格，並不會自動改變商品已有之規格，要修改商品規格，請手動修改。
			 		</p>
			 	
			 		<button id="new_options" type="button" class="btn btn-outline-warning"><i class="fas fa-plus fa-lg mr-1"></i>建立新規格</button>

			 		<table class="table table-striped">
			 		  <thead>
			 		    <tr>
			 		      <th scope="col">規格名稱</th>
			 		      <th scope="col">規格別名</th>
			 		      <th scope="col">規格項目</th>
			 		      <th scope="col" class="text-right">操作</th>
			 		    </tr>
			 		  </thead>
			 		  <tbody id="opt_table"></tbody>
	 				</table>

	 			</div> <!-- panel 1 -->


		 		  <!-- Panel 2 -->
		 		  <div class="tab-pane fade in px-3" id="info_tab" role="tabpanel">

				 		<p class="note note-primary">
				 			當多種商品具備相同規格資訊時，可在此進行編輯，後續在新增商品時，即可快速地使用已編輯好的資訊，資訊名稱僅作為後台顯示用，前端不會出現此名稱
				 		</p>

				 		<p class="note note-success">
				 			請注意，刪除或編輯資訊，並不會自動改變商品已有之資訊，要修改商品資訊，請手動修改。
				 		</p>
				 	
				 		<button id="new_info" type="button" class="btn btn-outline-warning"><i class="fas fa-plus fa-lg mr-1"></i>建立新資訊</button>

				 		<table class="table table-striped">
				 		  <thead>
				 		    <tr>
				 		      <th scope="col">資訊名稱</th>
				 		      <th scope="col">資訊內容</th>
				 		      <th scope="col" class="text-right">操作</th>
				 		    </tr>
				 		  </thead>
				 		  <tbody id="info_table"></tbody>
		 				</table>

		 			</div> <!-- panel 2 -->

		 			<!-- Panel 3 -->
		 			<div class="tab-pane fade in px-3" id="add_tab" role="tabpanel">

				 		<button id="new_add" type="button" class="btn btn-outline-warning"><i class="fas fa-plus fa-lg mr-1"></i>單品加購</button>

				 		<table class="table table-striped">
				 		  <thead>
				 		    <tr>
				 		      <th scope="col">主商品</th>
				 		      <th scope="col">主商品編號</th>
				 		      <th scope="col">加購品</th>
				 		      <th scope="col">加購品編號</th>
				 		      <th scope="col">加購價</th>
				 		      <th scope="col">可加購數量</th>
				 		      <th scope="col" class="text-right">操作</th>
				 		    </tr>
				 		  </thead>
				 		  <tbody id="add_table"></tbody>
		 				</table>

		 				<div id="page_nav" class="row justify-content-center">
		 					<nav class="text-center my-4" aria-label="Page navigation">
		 					    <ul class="pagination" id="m_pagination"></ul>
		 					</nav>
		 				</div>

		 			</div> <!-- panel 3 -->

	 		</div> <!-- tab content -->

		 </div>  <!-- end col -->

	 </div> <!-- end row -->

</section>


<div class="modal fade" id="edit_options" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">編輯規格</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-0 mx-3">

      	  <div class="modal-body">

      	    <div class="input-group my-3">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">規格名稱</div>
      	      </div>
      	      <input type="text" class="form-control py-0" id="oname">
      	    </div>

      	    <div class="input-group">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">規格別名</div>
      	      </div>
      	      <input type="text" class="form-control py-0" id="onick">
      	    </div>

      	    <div class="form-group purple-border mt-3">
      	      <label for="opts">規格項目</label>
      	      <textarea class="form-control" id="opts" rows="3"></textarea>
      	    </div>

      	    <p class="note note-primary">
      	    	請使用逗號區分項目，例如 S,M,L,XL,XXL
      	    </p>

      	  </div>
      	  <!--Footer-->
      	  <div class="modal-footer py-4">
      	    <div class="btn-group m-auto">
      	      <button type="button" class="btn btn-outline-info" data-dismiss="modal"><i class="fas fa-times fa-lg mr-1"></i>關閉</button>
      	      <button type="button" id="send_opt" class="btn btn-outline-info">送出<i class="fas fa-paper-plane fa-lg ml-1"></i></button>           
      	    </div>
      	  </div>

      </div>

    </div>
  </div>
</div>


<div class="modal fade" id="edit_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">編輯資訊</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-0 mx-3">

      	  <div class="modal-body">

      	    <div class="input-group my-3">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">資訊名稱</div>
      	      </div>
      	      <input type="text" class="form-control py-0" id="iname">
      	    </div>

      	    <div class="form-group purple-border mt-3">
      	      <label for="icontent" class="mb-0">資訊內容</label>
      	      <textarea class="form-control" id="icontent" rows="3"></textarea>
      	    </div>

      	  </div>
      	  <!--Footer-->
      	  <div class="modal-footer py-4">
      	    <div class="btn-group m-auto">
      	      <button type="button" class="btn btn-outline-info" data-dismiss="modal"><i class="fas fa-times fa-lg mr-1"></i>關閉</button>
      	      <button type="button" id="send_info" class="btn btn-outline-info">送出<i class="fas fa-paper-plane fa-lg ml-1"></i></button>           
      	    </div>
      	  </div>

      </div>

    </div>
  </div>
</div>


<div class="modal fade" id="edit_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">編輯加購品</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-0 mx-3">

      	  <div class="modal-body">

      	    <div class="input-group my-3">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">主商品編號</div>
      	      </div>
      	      <input type="text" class="form-control py-0" id="mnum">
      	    </div>

      	    <div class="input-group my-3">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">加購品編號</div>
      	      </div>
      	      <input type="text" class="form-control py-0" id="pnum">
      	    </div>

      	    <div class="input-group my-3">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">加購品價格</div>
      	      </div>
      	      <input type="number" class="form-control py-0" id="pprice">
      	    </div>

      	    <div class="input-group mt-3">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">可加購數量</div>
      	      </div>
      	      <input type="number" class="form-control py-0" id="pcnt">
      	      <small class="w-100 mt-2 text-right">*輸入0代表不限制數量</small>
      	    </div>


      	  </div>
      	  <!--Footer-->
      	  <div class="modal-footer py-4">
      	    <div class="btn-group m-auto">
      	      <button type="button" class="btn btn-outline-info" data-dismiss="modal"><i class="fas fa-times fa-lg mr-1"></i>關閉</button>
      	      <button type="button" id="send_add" class="btn btn-outline-info">送出<i class="fas fa-paper-plane fa-lg ml-1"></i></button>           
      	    </div>
      	  </div>

      </div>

    </div>
  </div>
</div>

<script>

	var m_page = 1;

	 $(document).ready(function() {
	    $('#icontent')
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


	 window.pagObj = $('#m_pagination').twbsPagination({
	             totalPages: <?php echo $m_total_pages ?>,
	             visiblePages: 10,
	             onPageClick: function (event, page) {

	             }
	         }).on('page', function (event, page) {
	         	//console.log(page);
	             m_page = page;
	             get_sub_products();
	 });


	function get_sub_products(){
		var icount = (parseInt(m_page) - 1) * 8;
		$.post('get_sub_products.php',{icount: icount}, function(data){
			
			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

			if (result.sitems === ''){
				//toastr.error('沒有資料');
				return;
			}

			$('#add_table').html(result.sitems);

			$('[data-toggle="tooltip"]').tooltip();
		                                
		});
	}



	$('#new_options').on('click', function(){
		$('#oname, #onick, #opts').val('');
		$('#send_opt').data('oid', '0');
		$('#edit_options .modal-title').text('新增規格');
		$('#edit_options').modal();
	});

	$('#new_info').on('click', function(){
		$('#iname, #ocontent').val('');
		$('#send_info').data('oid', '0');
		$('#edit_info .modal-title').text('新增資訊');
		$('#icontent').trumbowyg('empty');
		$('#edit_info').modal();
	});

	$('#new_add').on('click', function(){
		$('#mnum, #pnum, #pprice').val('');
		$('#pcnt').val('0');
		$('#send_add').data('oid', '0');
		$('#edit_add .modal-title').text('新增加購品');
		$('#edit_add').modal();
	});


	$('#opt_table').on('click', '.edit_opt', function(){
		$('#oname').val($(this).data('oname'));
		$('#onick').val($(this).data('onick'));
		$('#opts').val($(this).data('opts'));
		$('#send_opt').data('oid', $(this).data('oid'));
		$('#edit_options .modal-title').text('編輯規格');
		$('#edit_options').modal();
	});

	$('#info_table').on('click', '.edit_info', function(){
		$('#iname').val($(this).data('iname'));
		$('#send_info').data('oid', $(this).data('oid'));
		$('#edit_info .modal-title').text('編輯資訊');

		var p 	=	$(this).parent().parent().parent();
		$('#icontent').trumbowyg('html', $('.icontent', p).html());
		$('#edit_info').modal();
	});


	$('#add_table').on('click', '.edit_add', function(){
		$('#mnum').val($(this).data('mnum'));
		$('#pnum').val($(this).data('pnum'));
		$('#pprice').val($(this).data('price'));
		$('#pcnt').val($(this).data('cnt'));
		$('#send_add').data('oid', $(this).data('oid'));
		$('#edit_add .modal-title').text('編輯加購品');
		$('#edit_add').modal();
	});


	function get_options(){
		$.post('get_options.php', function(data){
			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

		    $('#opt_table').html(result.opts);                      
		});
	}

	function get_infos(){
		$.post('get_infos.php', function(data){
			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

		    $('#info_table').html(result.infos);                      
		});
	}

	$('#send_opt').on('click', function(){
		var oid = $(this).data('oid');
		var oname = $('#oname').val();
		var onick = $('#onick').val();
		var opts = $('#opts').val();

		if ($.trim(oname) === '' || $.trim(onick) === '' || $.trim(opts) === ''){
			toastr.error('請填入必要欄位~!');
			return;
		}

		$.post('edit_opts.php', {oname: oname, onick: onick, opts: opts, oid: oid}, function(data){
			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

			$('#edit_options').modal('hide');

		    get_options();
		                                
		});
	});


	$('#send_info').on('click', function(){
		var oid = $(this).data('oid');
		var iname = $('#iname').val();
		var icontent = $('#icontent').val();

		if ($.trim(iname) === '' || $.trim(icontent) === ''){
			toastr.error('請填入必要欄位~!');
			return;
		}

		$.post('edit_info.php', {iname: iname, icontent: icontent, oid: oid}, function(data){
			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

			$('#edit_info').modal('hide');

		    get_infos();
		                                
		});
	});


	$('#send_add').on('click', function(){
		var oid = $(this).data('oid');
		var mnum = $('#mnum').val();
		var pnum = $('#pnum').val();
		var price = $('#pprice').val();
		var pcnt = $('#pcnt').val();

		if ($.trim(mnum) === '' || $.trim(pnum) === '' || $.trim(price) === '' || $.trim(pcnt) === ''){
			toastr.error('請填入必要欄位~!');
			return;
		}

		$.post('edit_add.php', {mnum: mnum, pnum: pnum, price: price, oid: oid, pcnt: pcnt}, function(data){
			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

			if (result.err_msg !== 'OK'){
				toastr.error(result.err_msg);
				return;
			}

			$('#edit_add').modal('hide');

			m_page = 1;
			$('#m_pagination').twbsPagination('destroy');
			$('#m_pagination').twbsPagination({
				totalPages: <?php echo $m_total_pages ?>,
				visiblePages: 10,
				startPage: 1
			}).on('page', function (event, page) {
	        	//console.log(page);
	            m_page = page;
	            get_sub_products();
			});

		    get_sub_products();
		                                
		});
	});



	$('#opt_table').on('click', '.del_opt', function(){
		var msg = "確定要刪除這個規格？"; 
		if (confirm(msg)==true){ 
			var oid = $(this).data('oid');
			$.post('del_opts.php', {oid: oid}, function(data){
				var result = JSON.parse(data);

				if (result['err_msg'] === '-1'){
					alert('登入逾時，請重新登入~!');
					window.location = 'login.php';
				}

				if (result['err_msg'] !== 'OK'){
					toastr.error(result.err_msg);
					return;
				}

				get_options();
			})
		}
	});


	$('#info_table').on('click', '.del_info', function(){
		var msg = "確定要刪除這個資訊？"; 
		if (confirm(msg)==true){ 
			var oid = $(this).data('oid');
			$.post('del_info.php', {oid: oid}, function(data){
				var result = JSON.parse(data);

				if (result['err_msg'] === '-1'){
					alert('登入逾時，請重新登入~!');
					window.location = 'login.php';
				}

				if (result['err_msg'] !== 'OK'){
					toastr.error(result.err_msg);
					return;
				}

				get_infos();
			})
		}
	});


	$('#add_table').on('click', '.del_add', function(){
		var msg = "確定要刪除這個加購品？"; 
		if (confirm(msg)==true){ 
			var oid = $(this).data('oid');
			$.post('del_add.php', {oid: oid}, function(data){
				var result = JSON.parse(data);

				if (result['err_msg'] === '-1'){
					alert('登入逾時，請重新登入~!');
					window.location = 'login.php';
				}

				if (result['err_msg'] !== 'OK'){
					toastr.error(result.err_msg);
					return;
				}

				m_page = 1;
				$('#m_pagination').twbsPagination('destroy');
				$('#m_pagination').twbsPagination({
					totalPages: result.total_page,
					visiblePages: 10,
					startPage: 1
				}).on('page', function (event, page) {
		        	//console.log(page);
		            m_page = page;
		            get_sub_products();
				});

			    get_sub_products();

				
			})
		}
	});

	get_options();
	get_infos();
	get_sub_products();



</script>