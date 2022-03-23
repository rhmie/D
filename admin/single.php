<?php session_start(); ?>
<?php

	if (!isset($_SESSION['bee_admin'])){
	   echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
	}

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$count = $db->getValue('singles', 'count(*)');
	$s_total_pages = ceil($count / 8);
	if ($s_total_pages == 0) $s_total_pages = 1;

?>

<section class="section" id="single">

	<div class="row">
	 	<div class="col-12">
	 		<p class="note note-primary">
	 			在此為商品增加一個<strong>一頁式購買頁面</strong>，此頁面將成為一個獨立的 HTML 文件，適用於獨立的廣告與行銷，會員無需登入即可直接購買。
	 		</p>

	 		<p class="note note-danger">
	 			請注意~!, 當您在商品管理內修改任何商品屬性，例如價格、圖片等等，程式將自動重新生成 HTML 頁面。
	 		</p>
	 	</div>


	 	<div class="col-12">

	 		<button id="new_single_btn" type="button" class="btn btn-outline-warning"><i class="fas fa-plus fa-lg mr-1"></i>建立新獨立頁面</button>

	 		<table class="table table-striped">
	 		  <thead>
	 		    <tr>
	 		      <th scope="col">縮圖</th>
	 		      <th scope="col">商品編號</th>
	 		      <th scope="col">商品名稱</th>
	 		      <th scope="col">價格</th>
	 		      <th scope="col">優惠價</th>
	 		      <th scope="col">建立日期</th>
	 		      <th scope="col" class="text-right">操作</th>
	 		    </tr>
	 		  </thead>
	 		  <tbody id="single_table">

	 		    
	 		  </tbody>
	 		</table>

	 	</div>

	 </div>


	 <div class="row justify-content-center">
	 	<nav class="text-center my-4" aria-label="Page navigation">
	 	    <ul class="pagination" id="s_pagination"></ul>
	 	</nav>
	 </div>

</section>


<div class="modal fade" id="new_single" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">建立頁面</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="single_form">
      	<div class="modal-body pt-0 mx-3">
      	
      	    <div class="input-group my-3">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">商品編號</div>
      	      </div>
      	      <input type="text" class="form-control py-0" name="pnum" id="pnum" required>
      	    </div>


      	    <div class="input-group my-3">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">運費</div>
      	      </div>
      	      <input type="text" class="form-control py-0" id="ship" name="ship" placeholder="0=免運費" value="0" required>
      	    </div>

      	    <div class="custom-control custom-checkbox mb-2">
      	      <input type="checkbox" class="custom-control-input" value="1" id="comment" name="comment">
      	      <label class="custom-control-label" for="comment">顯示facebook留言版</label>
      	    </div>

      	    <div class="custom-control custom-checkbox mb-2">
      	      <input type="checkbox" class="custom-control-input" value="1" id="msger" name="msger">
      	      <label class="custom-control-label" for="msger">顯示facebook messenger客服</label>
      	    </div>

      	    <div class="custom-control custom-checkbox">
      	      <input type="checkbox" class="custom-control-input" value="1" id="scontact" name="scontact" checked>
      	      <label class="custom-control-label" for="scontact">使用與官網相同的聯絡資訊</label>
      	    </div>

      	    <div class="d-none" id="contact_field">

      	    	<div class="input-group my-3">
      	    	  <div class="input-group-prepend">
      	    	    <div class="input-group-text">聯絡電話</div>
      	    	  </div>
      	    	  <input type="text" class="form-control py-0" maxlength="10" name="cphone" id="cphone">
      	    	</div>

      	    	<div class="input-group my-3">
      	    	  <div class="input-group-prepend">
      	    	    <div class="input-group-text">Email</div>
      	    	  </div>
      	    	  <input type="text" class="form-control py-0" maxlength="100" name="cmail" id="cmail">
      	    	</div>

      	    	<div class="input-group my-3">
      	    	  <div class="input-group-prepend">
      	    	    <div class="input-group-text">Line</div>
      	    	  </div>
      	    	  <input type="text" class="form-control py-0" maxlength="100" name="cline" id="cline">
      	    	</div>

      	    	<div class="input-group my-3">
      	    	  <div class="input-group-prepend">
      	    	    <div class="input-group-text">粉絲專頁</div>
      	    	  </div>
      	    	  <input type="text" class="form-control py-0" name="cfbpage" id="cfbpage">
      	    	</div>

      	    	<div class="input-group my-3">
      	    	  <div class="input-group-prepend">
      	    	    <div class="input-group-text">地址</div>
      	    	  </div>
      	    	  <input type="text" class="form-control py-0" name="caddr" id="caddr">
      	    	</div>

      	    </div>

      	  </div>
      	  <!--Footer-->
      	  <div class="modal-footer py-4">
      	    <div class="btn-group m-auto">
      	      <button type="button" class="btn btn-outline-info" data-dismiss="modal"><i class="fas fa-times fa-lg mr-1"></i>關閉</button>
      	      <button type="submit" id="send_single" class="btn btn-outline-info">送出<i class="fas fa-paper-plane fa-lg ml-1"></i></button>           
      	    </div>
      	  </div>

      	</form>

      </div>
  </div>
</div>

<script>

	var s_page = 1;

	window.h_pagObj = $('#s_pagination').twbsPagination({
	            totalPages: <?php echo $s_total_pages ?>,
	            visiblePages: 10,
	            onPageClick: function (event, page) {

	            }
	        }).on('page', function (event, page) {
	            s_page = page;
	            get_singles();
	        });


	$('#new_single_btn').on('click', function(){
		$('#pnum, #single_header').val('');
		$('#new_single').modal();
	});



	function get_singles(){
		var icount = (parseInt(s_page) - 1) * 6;

		$.post('get_singles.php',{icount: icount}, function(data){
			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

		    $('#single_table').html(result.singles);

		    $('[data-toggle="tooltip"]').tooltip();

		    var clipboard = new Clipboard('.copy_btn', {
		        text: function(e) {
		        	return $(e).data('url');
		        }
		    });

		    clipboard.on('success', function(e) {
		    	console.log(e);
		        toastr.success('複製成功~!');
		    });

		    clipboard.on('error', function(e) {
		        toastr.error('複製失敗，請手動複製~!');
		    });
		                                
		});
	}


	$('#single_form').on('submit', (function (e) {
		e.preventDefault();
		console.log('submit');
		$('#send_single').html('建立中..<i class="fas fa-circle-notch fa-spin fa-lg ml-1"></i>').parent().addClass('disabled');

		$.ajax({
			url: 'new_single.php',
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){
				var result = JSON.parse(data);

				console.log(result);

				$('#send_single').html('送出<i class="fas fa-paper-plane fa-lg ml-1"></i>').parent().removeClass('disabled');

				if (result.err_msg === '-1'){
					alert('登入逾時，請重新登入~!');
					window.location = 'login.php';
				}

				if (result.err_msg !== 'OK'){
				    toastr.error(result.err_msg);
				    return false;
				}

				$('#new_single').modal('hide');
				get_singles();
			}
		});

	}));

	get_singles();



	$('#single_table').on('click', '.del_single', function(){
		var msg = "確定要移除這個商品頁面？"; 
		if (confirm(msg)==true){ 

			var pid =	$(this).data('sid');
			var pnum =	$(this).data('num');

			var tr = $(this).parent().parent().parent();

			$.post('del_single.php', {pid: pid, pnum: pnum}, function(data){

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

				if ($('#single_table').html() === ''){
					if (s_page > 1) s_page = s_page - 1;
					$('#s_pagination').twbsPagination('destroy');

					$('#s_pagination').twbsPagination({
						totalPages: s_page,
						startPage: s_page,
						visiblePages: 8
					});

					
					get_singles();
				}

			});
		}
	});


	$('#scontact').on('change', function(){
		if ($(this).is(':checked')){
			$('#contact_field').addClass('d-none');
		} else {
			$('#contact_field').removeClass('d-none');
		}
	});

</script>