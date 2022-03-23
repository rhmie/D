<?php session_start(); ?>
<?php

	if (!isset($_SESSION['bee_admin'])){
	   echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
	}

?>

<section class="section" id="sections">

	<div class="row">

	 	<div class="col-12 mt-2 px-0">

	 		<!-- Nav tabs -->
	 		<ul class="nav nav-tabs md-tabs nav-justified primary-color" role="tablist">
	 		  <li class="nav-item">
	 		    <a class="nav-link active" data-toggle="tab" href="#section_tab" role="tab">
	 		      首頁區塊</a>
	 		  </li>
	 		  <li class="nav-item">
	 		    <a class="nav-link" data-toggle="tab" href="#nav_tab" role="tab">
	 		      導覽項目</a>
	 		  </li>
	 		  <li class="nav-item">
	 		    <a class="nav-link" data-toggle="tab" href="#page_tab" role="tab">
	 		      頁面管理</a>
	 		  </li>
	 		  <li class="nav-item">
	 		    <a class="nav-link" data-toggle="tab" href="#news_tab" role="tab">
	 		      電子報管理</a>
	 		  </li>
	 		</ul>
	 		<!-- Nav tabs -->

	 		<!-- Tab panels -->
	 		<div class="tab-content">

	 		  <!-- Panel 1 -->
	 		  <div class="tab-pane fade in show active px-3" id="section_tab" role="tabpanel">

	 		  	<div class="col-12">
	 		  		<p class="note note-primary">
	 		  			在此新增首頁區塊內容及排序，首頁將會顯示區塊於精選專欄下方，請使用 bootstrap 4 標籤 container 或 container-fluid 作為區塊開頭
	 		  		</p>
	 		  	</div>

	 		  	<div class="btn-group">
	 		  		<a href="#" onclick="javascript:edit_section(0);" id="new_section" type="button" class="btn btn-outline-info"><i class="fas fa-plus fa-lg mr-1"></i>新增區塊</a>
	 		  		<button class="btn btn-outline-info" type="button" id="section_refresh"><i class="fas fa-redo-alt mr-1"></i>重新整理</button>

	 		  		<a href="https://gods.tw/blocks/login.php" target="_blank" type="button" class="btn btn-outline-info"><i class="fas fa-th-large fa-lg mr-1"></i>區塊編輯器</a>
	 		  	</div>

	 		  	<table class="table table-striped">
	 		  	  <thead>
	 		  	    <tr>
	 		  	      <th scope="col">區塊名稱</th>
	 		  	      <th scope="col" class="text-center">排序</th>
	 		  	      <th scope="col" class="text-center">狀態</th>
	 		  	      <th scope="col" class="text-right">操作</th>
	 		  	    </tr>
	 		  	  </thead>
	 		  	  <tbody id="section_table">

	 		  	    
	 		  	  </tbody>
	 		  	</table>

	 		   

	 		  </div>
	 		  <!-- Panel 1 -->

	 		  <!-- Panel 4 -->
	 		  <div class="tab-pane fade px-3" id="nav_tab" role="tabpanel">

	 		  	<div class="col-12">
	 		  		<p class="note note-primary">
	 		  			項目下若有連結則僅能編輯不能刪除，若要刪除項目，請先刪除項目下之連結頁面
	 		  		</p>
	 		  	</div>

	 		  	<div class="btn-group">
	 		  		<button id="new_navitem" type="button" class="btn btn-outline-info"><i class="fas fa-plus fa-lg mr-1"></i>新增導覽列項目</button>
	 		  	</div>

	 		  	<table class="table table-striped">
	 		  	  <thead>
	 		  	    <tr>
	 		  	      <th scope="col">項目名稱</th>
	 		  	      <th scope="col">排序</th>
	 		  	      <th scope="col" class="text-right">操作</th>
	 		  	    </tr>
	 		  	  </thead>
	 		  	  <tbody id="nav_table">

	 		  	    
	 		  	  </tbody>
	 		  	</table>

	 		  </div>
	 		  <!-- Panel 4 -->


	 		  <!-- Panel 2 -->
	 		  <div class="tab-pane fade px-3" id="page_tab" role="tabpanel">

	 		  	<div class="col-12">
	 		  		<p class="note note-primary">
	 		  			在此增加新的頁面，搭配區塊編輯進行連結，頁面名稱請使用英文或數字(勿使用中文或添加副檔名)，儲存時系統將生成一份獨立的html文件。
	 		  		</p>
	 		  		<p class="note note-danger">
	 		  			請注意產生新頁面時，新頁面會存入最新的首頁元素資訊，例如導覽列項目、元素顏色、分類等等，所以當您修改任何元素後，請對頁面重新進行一次儲存。
	 		  		</p>
	 		  	</div>

	 		  	<div class="btn-group">
	 		  		<a href="#" onclick="javascript:edit_page(0);" id="new_page" type="button" class="btn btn-outline-info"><i class="fas fa-plus fa-lg mr-1"></i>新增頁面</a>
	 		  		<button class="btn btn-outline-info" type="button" id="page_refresh"><i class="fas fa-redo-alt mr-1"></i>重新整理</button>

	 		  		<a href="https://gods.tw/blocks/login.php" target="_blank" type="button" class="btn btn-outline-info"><i class="fas fa-th-large fa-lg mr-1"></i>區塊編輯器</a>
	 		  	</div>

	 		  	<table class="table table-striped">
	 		  	  <thead>
	 		  	    <tr>
	 		  	      <th scope="col">頁面名稱</th>
	 		  	      <th scope="col">連結名稱</th>
	 		  	      <th scope="col">連結排序</th>
	 		  	      <th scope="col">頁面位置</th>
	 		  	      <th scope="col">顯示於</th>
	 		  	      <th scope="col" class="text-right">操作</th>
	 		  	    </tr>
	 		  	  </thead>
	 		  	  <tbody id="page_table">

	 		  	    
	 		  	  </tbody>
	 		  	</table>

	 		    

	 		  </div>
	 		  <!-- Panel 2 -->


	 		  <!-- Panel 3 -->
	 		  <div class="tab-pane fade px-3" id="news_tab" role="tabpanel">

	 		  	<div class="row">

		 		  <div class="col-6">
		 		  	<div class="btn-group">
		 		  		<a href="#" onclick="javascript:edit_news(0);" id="new_letter" type="button" class="btn btn-outline-info"><i class="fas fa-plus fa-lg mr-1"></i>新增電子報</a>
		 		  		<button class="btn btn-outline-info" type="button" id="news_refresh"><i class="fas fa-redo-alt mr-1"></i>重新整理</button>
		 		  	</div>
		 		  </div>

		 		  <div class="col-6 text-right">
		 		  	<p class="mt-4">訂閱數: <span id="mail_count">0</span></p>
		 		  </div>

	 		  </div>

	 		  	<table class="table table-striped">
	 		  	  <thead>
	 		  	    <tr>
	 		  	      <th scope="col">標題</th>
	 		  	      <th scope="col">發送日期</th>
	 		  	      <th scope="col" class="text-right">操作</th>
	 		  	    </tr>
	 		  	  </thead>
	 		  	  <tbody id="news_table">

	 		  	    
	 		  	  </tbody>
	 		  	</table>

	 		  </div>
	 		  <!-- Panel 3 -->

	 		</div>
	 		<!-- Tab panels -->

	 	</div>
	</div>
</section>

<div class="modal fade" id="edit_nav" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">新增導覽項目</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-0 mx-3">

      	  <div class="modal-body">

      	    <div class="input-group my-3">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">項目名稱</div>
      	      </div>
      	      <input type="text" class="form-control py-0" id="nav_name">
      	    </div>

      	    <div class="input-group my-3">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">項目排序</div>
      	      </div>
      	      <input type="number" min="1" class="form-control py-0" id="nav_sort">
      	    </div>

      	  </div>
      	  <!--Footer-->
      	  <div class="modal-footer py-4">
      	    <div class="btn-group m-auto">
      	      <button type="button" class="btn btn-outline-info" data-dismiss="modal"><i class="fas fa-times fa-lg mr-1"></i>關閉</button>
      	      <button type="button" id="send_nav" class="btn btn-outline-info">送出<i class="fas fa-paper-plane fa-lg ml-1"></i></button>           
      	    </div>
      	  </div>

      </div>

    </div>
  </div>
</div>


<script>

	function edit_news(pid){
		window.open('./edit_news.php?id='+pid, "connectWindow", "width=850,height=900, scrollbars=yes");
	}

	function edit_section(pid){
		window.open('./edit_section_window.php?id='+pid, "connectWindow", "width=850,height=900, scrollbars=yes");
	}

	function edit_page(pid){
		window.open('./edit_page_window.php?id='+pid, "connectWindow", "width=850,height=900, scrollbars=yes");
	}

	
	 $('#news_table').on('click', '.del_newsletter', function(){
	 		var msg = "確定要刪除這個電子報？"; 

	 		if (confirm(msg)==true){ 

	 			var bid =	$(this).data('bid');

	 			$.post('del_newsletter.php', {bid: bid}, function(data){

	 				var result = JSON.parse(data);

	 				if (result['err_msg'] === '-1'){
	 					alert('登入逾時，請重新登入~!');
	 					window.location = 'login.php';
	 				}

	 				if (result['err_msg'] !== 'OK'){
	 				    toastr.error(result.err_msg);
	 				    return false;
	 				}

	 				get_newsletter();

	 			});
	 		}

	 });


	 $('#section_table').on('click', '.del_section', function(){
	 	var msg = "確定要刪除這個區塊？"; 
	 	if (confirm(msg)==true){ 

	 		var sid =	$(this).data('sid');

	 		$.post('del_section.php', {sid: sid}, function(data){

	 			var result = JSON.parse(data);

	 			if (result['err_msg'] === '-1'){
	 				alert('登入逾時，請重新登入~!');
	 				window.location = 'login.php';
	 			}

	 			if (result['err_msg'] !== 'OK'){
	 			    toastr.error(result.err_msg);
	 			    return false;
	 			}

	 			get_sections();

	 		});
	 	}
	 });

	 $('#page_table').on('click', '.del_page', function(){
	 	var msg = "確定要刪除這個頁面？"; 
	 	if (confirm(msg)==true){ 

	 		var sid =	$(this).data('sid');

	 		$.post('del_page.php', {sid: sid}, function(data){

	 			var result = JSON.parse(data);

	 			if (result['err_msg'] === '-1'){
	 				alert('登入逾時，請重新登入~!');
	 				window.location = 'login.php';
	 			}

	 			if (result['err_msg'] !== 'OK'){
	 			    toastr.error(result.err_msg);
	 			    return false;
	 			}

	 			get_pages();

	 		});
	 	}
	 });



	 function get_sections(){
	 	$.post('get_sections.php', function(data){
	 		var result = JSON.parse(data);

	 		if (result['err_msg'] === '-1'){
	 			alert('登入逾時，請重新登入~!');
	 			window.location = 'login.php';
	 		}

	 	    $('#section_table').html(result.sections);
	 	                                
	 	});
	 }


	 function get_newsletter(){
	 	$.post('get_newsletter.php', function(data){
	 		var result = JSON.parse(data);

	 		if (result['err_msg'] === '-1'){
	 			alert('登入逾時，請重新登入~!');
	 			window.location = 'login.php';
	 		}

	 	    $('#news_table').html(result.newsletters);
	 	    $('#mail_count').text(result.ocount);
	 	                                
	 	});
	 }

	 $('#news_refresh').on('click', function(){
	 	 get_newsletter();
	 });

	 $('#section_refresh').on('click', function(){
	 	 get_sections();
	 });

	 $('#page_refresh').on('click', function(){
	 	 get_pages();
	 });



	 function get_pages(){
	 	$.post('get_pages.php', function(data){
	 		var result = JSON.parse(data);

	 		if (result['err_msg'] === '-1'){
	 			alert('登入逾時，請重新登入~!');
	 			window.location = 'login.php';
	 		}

	 	    $('#page_table').html(result.pages);
	 	                                
	 	});
	 }

	 function get_nav_items(){
	 	$.post('get_nav_items.php', function(data){
	 		var result = JSON.parse(data);

	 		if (result['err_msg'] === '-1'){
	 			alert('登入逾時，請重新登入~!');
	 			window.location = 'login.php';
	 		}

	 	    $('#nav_table').html(result.pages);
	 	                                
	 	});
	 }



	 $('#send_nav').on('click', function(){

	 	var nav_name = $('#nav_name').val();
	 	var nav_sort = $('#nav_sort').val();
	 	var sid = $('#send_nav').data('sid');

	 	if ($.trim(nav_name) === '' || $.trim(nav_sort) === ''){
	 		alert('請輸入必要欄位~!');
	 		return;
	 	}

	 	$.post('edit_nav.php', {sid: sid, nav_name: nav_name, sort: nav_sort}, function(data){

	 		var result = JSON.parse(data);

	 		if (result['err_msg'] === '-1'){
	 			alert('登入逾時，請重新登入~!');
	 			window.location = 'login.php';
	 		}

	 		$('#edit_nav').modal('hide');

	 		get_nav_items();
	 	});
	 });


	 $('#nav_table').on('click', '.del_nav', function(){
	 	var msg = "確定要刪除這個項目？"; 
	 	if (confirm(msg)==true){ 

	 		var sid =	$(this).data('sid');

	 		$.post('del_nav.php', {sid: sid}, function(data){

	 			var result = JSON.parse(data);

	 			if (result['err_msg'] === '-1'){
	 				alert('登入逾時，請重新登入~!');
	 				window.location = 'login.php';
	 			}

	 			if (result['err_msg'] !== 'OK'){
	 			    toastr.error(result.err_msg);
	 			    return false;
	 			}

	 			$('#edit_nav').modal('hide');

	 			get_nav_items();

	 		});
	 	}
	 });

	 $('#new_navitem').on('click', function(){
	 	$('#edit_nav h4').text('新增導覽項目');
	 	$('#nav_name').val('');
	 	$('#nav_sort').val('1');
	 	$('#send_nav').data('sid', 0);
	 	$('#edit_nav').modal();
	 });

	 $('#nav_table').on('click', '.edit_nav', function(){
	 	$('#edit_nav h4').text('編輯導覽項目');
	 	$('#nav_name').val($(this).data('nav_name'));
	 	$('#nav_sort').val($(this).data('sort'));
	 	$('#send_nav').data('sid', $(this).data('sid'));
	 	$('#edit_nav').modal();
	 });


	 get_sections();
	 get_pages();
	 get_newsletter();
	 get_nav_items();


</script>