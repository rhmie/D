<?php session_start(); ?>
<?php

	if (!isset($_SESSION['bee_admin'])){
	    echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
	    exit();
	}

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	include('./ssl_encrypt.php');
	$db = new MysqliDb($mysqli);

	$count = $db->getValue ('members', 'count(*)');
	$m_total_pages = ceil($count / 8);
	if ($m_total_pages == 0) $m_total_pages = 1;

	$f1     =   encrypt_decrypt('encrypt', 'members').'_members.sql';


?>

<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">會員資訊</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-0 mx-3">
      	  <form id="infoform">
      	  	<input type="hidden" name="mid" id="m_id">
      	  <div class="modal-body">

      	    <div class="md-form form-sm mb-2">
      	      <i class="fas fa-user prefix fa-fw purple-text"></i>
      	      <input type="text" id="name" name="mname" class="form-control form-control-sm" required>
      	      <label class="active" for="name">姓名</label>
      	    </div>

      	    <div class="md-form form-sm mb-2 mt-5 fbbox">
      	      <i class="fas fa-phone-volume prefix fa-fw purple-text"></i>
      	      <input type="text" id="mobile" name="phone" class="form-control form-control-sm" required>
      	      <label class="active" for="mobile">電話</label>
      	    </div>

      	    <div class="md-form form-sm mb-2 mt-5 fbbox">
      	      <i class="fas fa-lock prefix fa-fw purple-text"></i>
      	      <input type="password" id="password" name="password" class="form-control form-control-sm">
      	      <label class="active" for="password">密碼</label>
      	    </div>

      	    <p class="note note-primary text-left mt-2">
      	    	會員若使用facebook登入，設定密碼將無作用
      	    </p>
 

      	  </div>
      	  <!--Footer-->
      	  <div class="modal-footer py-4">
      	    <div class="btn-group m-auto">
      	      <button type="button" class="btn btn-outline-info" data-dismiss="modal"><i class="fas fa-times fa-lg mr-1"></i>關閉</button>
      	      <button type="submit" id="infobtn" class="btn btn-outline-info">送出<i class="fas fa-paper-plane fa-lg ml-1"></i></button>           
      	    </div>
      	  </div>

      	</form>

      </div>

    </div>
  </div>
</div>


<section class="section" id="members">
	<div class="row align-items-center mb-3">

	<div class="col-md-3">
		<form id="searchform">   
		        <input id="searchbox" name="searchbox" class="form-control form-control-sm mr-sm-2" type="text" placeholder="搜尋名稱" aria-label="搜尋">
		 </form>
	 </div>

	 <div class="col-md-3">
	 	<form id="search_memberid">   
	 	        <input id="search_idbox" name="search_idbox" class="form-control form-control-sm mr-sm-2" type="number" placeholder="搜尋ID" aria-label="搜尋">
	 	 </form>
	  </div>

	  <div class="col-6">
	  	<form id="excform" method="POST" action="excel_export.php">
	  		<input name="table" type="hidden" value="members">
	  	</form>
	  	<div class="btn-group btn-group-sm">
	  		<a type="button" id="new_member" class="btn btn-blue-grey btn-sm mt-0"><i class="fas fa-plus mr-1"></i> 新增會員</a>
	  		<a type="button" href="./<?=$f1?>" class="btn btn-blue-grey btn-sm mt-0" download><i class="fas fa-download mt-1"></i> 下載SQL檔</a>
	  		<button type="button" id="btn_export" class="btn btn-blue-grey btn-sm mt-0"><i class="far fa-file-excel mt-1"></i> 下載excel檔</button>
	  	</div>
	  </div>

	</div>

	<div class="row">
	    <!--Table-->
	    <table class="table" id="mtable">

	        <!--Table head-->
	        <thead class="blue darken-3 text-white">
	            <tr>
	                <th>ID</th>
	                <th class="text-left">姓名</th>
	                <th class="text-left">電話</th>
	                <th class="text-left">登入方式</th>
	                <th class="text-left">訂單數</th>
	                <th class="text-left">縣市</th>
	                <th class="text-right">操作</th>
	            </tr>
	        </thead>
	        <!--Table head-->

	        <!--Table body-->
	        <tbody id="member_area" class="stdcolor">

	        </tbody>
	        <!--Table body-->
	    </table>
	    <!--Table-->

	</div>

	<div class="row justify-content-center">
		<nav class="text-center my-4" aria-label="Page navigation">
		    <ul class="pagination" id="m_pagination"></ul>
		</nav>
	</div>

</section>

<script>

	var m_page = 1;

	function get_members(){
		var icount = (parseInt(m_page) - 1) * 8;
		$.post('get_members.php',{icount: icount}, function(data){
			data = $.trim(data);
			//console.log(data);
			if (data === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

		    $('#member_area').html(data);

		    $(function () {
		    	$('[data-toggle="tooltip"]').tooltip()
		    })
		                                
		});
	}

	window.pagObj = $('#m_pagination').twbsPagination({
	            totalPages: <?php echo $m_total_pages ?>,
	            visiblePages: 10,
	            onPageClick: function (event, page) {

	            }
	        }).on('page', function (event, page) {
	        	//console.log(page);
	            m_page = page;
	            get_members();
	        });

	$('#members').on('click', '.btn-del-member', function(){
		var msg = "確定要刪除這個會員？ 刪除會員將連帶刪除此會員之所有訂單"; 
		if (confirm(msg)==true){ 
			var mid = $(this).data('mid');
			var box = $(this).parent().parent().parent();

			$.post('del_member.php', {mid: mid}, function(data){

				var result = JSON.parse(data);

				if (result['err_msg'] === '-1'){
					alert('登入逾時，請重新登入~!');
					window.location = 'login.php';
				}

				if (result['err_msg'] !== 'OK'){
				    toastr.error(result['err_msg']);
				    return false;
				}

				box.remove();

				if ($('#member_area').html() === ''){
					if (m_page > 1) m_page = m_page - 1;
					$('#m_pagination').twbsPagination('destroy');

					$('#m_pagination').twbsPagination({
						totalPages: m_page,
						startPage: m_page,
						visiblePages: 8
					});

					
					get_members();
				}

			})
		}
	});

	$('body').on('click', '.btn-edit-member', function(){
		$('#balance').val($(this).data('balance'));
		$('#name').val($(this).data('name'));
		
		$('#mobile').val($(this).data('mobile'));
		$('#m_id').val($(this).data('mid'));

		$('#edit_modal').modal();

	});

	$('#infoform').on('submit', (function (e) {
	      e.preventDefault();

	      $.ajax({
	          url: 'member_info.php',
	          type: "POST",
	          data:  new FormData(this),
	          contentType: false,
	          cache: false,
	          processData:false,
	          error: function (xhr, status, error) {
	              console.log(xhr);
	              console.log(status);
	              console.log(error);
	          },
	          success: function(data){
	              var result = JSON.parse(data);
	              //console.log(result);
	               $('#edit_modal').modal('hide');

	              if (result.err_msg === '-1'){
	              	alert('登入逾時，請重新登入~!');
	              	window.location = 'login.php';
	              }

	              if (result.err_msg !== 'OK') {
	                  toastr.error(result.err_msg);
	                  return;
	              }

	              get_members();

	          }
	      });
	  }));

	$('#searchform, #search_memberid').on('submit', (function (e) {
		e.preventDefault();
		if ($.trim($('input', this).val()) === ''){
		 	$('#m_pagination').show();
		 	get_members();
		} else {
				$.ajax({
					url: 'search_member.php',
					type: "POST",
					data:  new FormData(this),
					contentType: false,
					cache: false,
					processData:false,
					success: function(data){
						data = $.trim(data);

						if (data === '-1'){
							alert('登入逾時，請重新登入~!');
							window.location = 'login.php';
						}

						if (data === '') {
							toastr.warning('沒有搜尋結果~!');
							return;
						}

						$('#m_pagination').hide();

						$('#member_area').html(data);
			            

					}
				});
		}
	}));

	$('#new_member').on('click', function(){
		 $('#infoform')[0].reset();
		 $('#m_id').val('0');
		 $('#edit_modal').modal();
	});

	get_members();

	$('#btn_export').on('click', function(){
		$('#excform').submit();
	});


</script>