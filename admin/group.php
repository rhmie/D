<?php session_start(); ?>
<?php

	if (!isset($_SESSION['bee_admin'])){
	   echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
	}

?>

<style>
.modal-full {
    min-width: 100%;
    margin: 0;
}

.modal-full .modal-content {
    min-height: 100vh;
}
</style>

<section class="section" id="group">

	<div class="row">
	 	<div class="col-12">
	 		<p class="note note-primary">
	 			任何類別底下若有商品存在，類別將只能編輯名稱而無法刪除
	 		</p>
	 	</div>

	 	<div class="col-12 mt-2 px-0">

	 		<!-- Nav tabs -->
	 		<ul class="nav nav-tabs md-tabs nav-justified primary-color" role="tablist">
	 		  <li class="nav-item">
	 		    <a class="nav-link active" data-toggle="tab" href="#main_class" role="tab">
	 		      主類別</a>
	 		  </li>
	 		  <li class="nav-item">
	 		    <a class="nav-link" data-toggle="tab" href="#sub_class" role="tab">
	 		      次類別</a>
	 		  </li>
	 		</ul>
	 		<!-- Nav tabs -->

	 		<!-- Tab panels -->
	 		<div class="tab-content">

	 		  <!-- Panel 1 -->
	 		  <div class="tab-pane fade in show active px-3" id="main_class" role="tabpanel">

	 		  	<button id="new_main" type="button" class="btn btn-outline-info"><i class="fas fa-plus fa-lg mr-1"></i>新增主類別</button>

	 		  	<table class="table table-striped">
	 		  	  <thead>
	 		  	    <tr>
	 		  	    	<th scope="col">ID</th>
	 		  	    	<th scope="col">圖示</th>
	 		  	      <th scope="col">名稱</th>
	 		  	      <th scope="col" class="text-center">商品數量</th>
	 		  	      <th scope="col" class="text-center">次類別</th>
	 		  	      <th scope="col" class="text-center">排序</th>
	 		  	      <th scope="col" class="text-right">操作</th>
	 		  	    </tr>
	 		  	  </thead>
	 		  	  <tbody id="main_table">

	 		  	    
	 		  	  </tbody>
	 		  	</table>

	 		   

	 		  </div>
	 		  <!-- Panel 1 -->

	 		  <!-- Panel 2 -->
	 		  <div class="tab-pane fade px-3" id="sub_class" role="tabpanel">

	 		  	<button id="new_sub" type="button" class="btn btn-outline-warning"><i class="fas fa-plus fa-lg mr-1"></i>新增次類別</button>

	 		  	<table class="table table-striped">
	 		  	  <thead>
	 		  	    <tr>
	 		  	    	<th scope="col">ID</th>
	 		  	    	<th scope="col">圖示</th>
	 		  	      <th scope="col">名稱</th>
	 		  	      <th scope="col">主類別</th>
	 		  	      <th scope="col" class="text-center">商品數量</th>
	 		  	      <th scope="col" class="text-center">排序</th>
	 		  	      <th scope="col" class="text-right">操作</th>
	 		  	    </tr>
	 		  	  </thead>
	 		  	  <tbody id="sub_table">

	 		  	    
	 		  	  </tbody>
	 		  	</table>

	 		    

	 		  </div>
	 		  <!-- Panel 2 -->

	 		</div>
	 		<!-- Tab panels -->

	 	</div>
	</div>


</section>

<div class="modal fade" id="edit_main_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-full" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">編輯主類別</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-0 mx-3">

      	  <div class="modal-body">

      	  	<img alt="" class="mb-2" id="icon1">

      	    <div class="input-group mb-2">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">名稱</div>
      	      </div>
      	      <input type="text" class="form-control py-0" id="mname">
      	    </div>

      	    <div class="input-group mb-2">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">排序</div>
      	      </div>
      	      <input type="number" class="form-control py-0" id="msort" value="1">
      	    </div>

      	    <input name="icon1" type="hidden">

      	    <div class="custom-file">
      	      <input type="file" accept="image/*" class="custom-file-input" name="main_icon" id="main_icon" lang="zh">
      	      <label class="custom-file-label" for="main_icon">選擇圖示</label>
      	    </div>

      	    <textarea id="main_content" row="5" name="content"></textarea>
      	    <small class="font-weight-bold grey-text">＊如無內容則不顯示主類別頁面</small>


      	  </div>
      	  <!--Footer-->
      	  <div class="modal-footer py-4">
      	    <div class="btn-group m-auto">
      	      <button type="button" class="btn btn-outline-info" data-dismiss="modal"><i class="fas fa-times fa-lg mr-1"></i>關閉</button>
      	      <button type="button" id="send_main" class="btn btn-outline-info">送出<i class="fas fa-paper-plane fa-lg ml-1"></i></button>           
      	    </div>
      	  </div>

      </div>

    </div>
  </div>
</div>



<div class="modal fade" id="edit_sub_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">編輯次類別</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-0 mx-3">

      	  <div class="modal-body">

      	  	<img alt="" class="mb-2" id="icon2">

      	  	<div class="input-group">
      	  	  <div class="input-group-prepend">
      	  	    <label class="input-group-text" for="main_items">主類別</label>
      	  	  </div>
      	  	  <select class="browser-default custom-select" id="main_items">
      	  	    
      	  	  </select>
      	  	</div>

      	    <div class="input-group my-3">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">名稱</div>
      	      </div>
      	      <input type="text" class="form-control py-0" id="sname">
      	    </div>

      	    <div class="input-group mb-3">
      	      <div class="input-group-prepend">
      	        <div class="input-group-text">排序</div>
      	      </div>
      	      <input type="number" class="form-control py-0" id="ssort" value="1">
      	    </div>

      	    <input name="icon2" type="hidden">

      	    <div class="custom-file">
      	      <input type="file" accept="image/*" class="custom-file-input" name="sub_icon" id="sub_icon" lang="zh">
      	      <label class="custom-file-label" for="sub_icon">選擇圖示</label>
      	    </div>

      	  </div>
      	  <!--Footer-->
      	  <div class="modal-footer py-4">
      	    <div class="btn-group m-auto">
      	      <button type="button" class="btn btn-outline-info" data-dismiss="modal"><i class="fas fa-times fa-lg mr-1"></i>關閉</button>
      	      <button type="button" id="send_sub" class="btn btn-outline-info">送出<i class="fas fa-paper-plane fa-lg ml-1"></i></button>           
      	    </div>
      	  </div>

      </div>

    </div>
  </div>
</div>

<script>

	function get_class(){
		$.post('get_class.php', function(data){
			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

		    $('#main_table').html(result.main_class);
		    $('#sub_table').html(result.sub_class);
		    $('#main_items').html(result.main_items);
		                                
		});
	}


	get_class();


	$('#main_table').on('click', '.edit_main', function(){
		$('#mname').val($(this).data('cname'));
		$('#msort').val($(this).data('sort'));
		$('#send_main').data('cid', $(this).data('cid'));
		$('input[name=icon1], #main_icon').val('');
		$('#icon1').prop('src', $(this).data('icon'));

		$('#main_content').trumbowyg('html', $(this).data('content'));

		$('#edit_main_modal .modal-title').text('編輯主類別');
		$('#edit_main_modal').modal();
	});


	$('#sub_table').on('click', '.edit_sub', function(){
		$('#sname').val($(this).data('cname'));
		$('#ssort').val($(this).data('sort'));
		$('#send_sub').data('cid', $(this).data('cid'));
		$('input[name=icon2], #sub_icon').val('');
		$('#icon2').prop('src', $(this).data('icon'));

		$('#main_items').val($(this).data('mid'));

		$('#edit_sub_modal .modal-title').text('編輯次類別');
		$('#edit_sub_modal').modal();
	});


	$('#sub_table').on('click', '.del_sub', function(){
		
		var msg = "確定要刪除這個次類別？"; 
		if (confirm(msg)==true){ 

			var cid =	$(this).data('cid');

			$.post('del_sub_class.php', {cid: cid}, function(data){

				var result = JSON.parse(data);

				if (result['err_msg'] === '-1'){
					alert('登入逾時，請重新登入~!');
					window.location = 'login.php';
				}

				if (result['err_msg'] !== 'OK'){
				    toastr.error(result.err_msg);
				    return false;
				}

				get_class();

			});
		}

	});


	$('#main_table').on('click', '.del_main', function(){
		
		var msg = "確定要刪除這個主類別？"; 
		if (confirm(msg)==true){ 

			var cid =	$(this).data('cid');

			$.post('del_main_class.php', {cid: cid}, function(data){

				var result = JSON.parse(data);

				if (result['err_msg'] === '-1'){
					alert('登入逾時，請重新登入~!');
					window.location = 'login.php';
				}

				if (result['err_msg'] !== 'OK'){
				    toastr.error(result.err_msg);
				    return false;
				}

				get_class();

			});
		}

	});


	$('#send_main').on('click', function(){
		var cname = $('#mname').val();
		var sort = $('#msort').val();
		var icon =$('input[name=icon1]').val();

		if ($.trim(cname) === ''){
			toastr.error('請輸入名稱~!');
			return;
		}

		if ($.trim(sort) === ''){
			toastr.error('請輸入排序~!');
			return;
		}

		var cid = $(this).data('cid');
		var content = $('#main_content').trumbowyg('html');
		$(this).data('content', content);

		$.post('edit_main_class.php', {cid: cid, cname: cname, sort: sort, icon: icon, content: content}, function(data){

			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

			if (result['err_msg'] !== 'OK'){
			    toastr.error(result.err_msg);
			    return false;
			}

			$('#edit_main_modal').modal('hide');

			get_class();

		});
	});


	$('#send_sub').on('click', function(){
		var cname = $('#sname').val();
		var sort = $('#ssort').val();
		var icon =$('input[name=icon2]').val();

		if ($.trim(cname) === ''){
			toastr.error('請輸入名稱~!');
			return;
		}

		if ($.trim(sort) === ''){
			toastr.error('請輸入排序~!');
			return;
		}

		var cid = $(this).data('cid');
		var mid = $('#main_items').val();

		$.post('edit_sub_class.php', {cid: cid, cname: cname, mid: mid, sort: sort, icon: icon}, function(data){

			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

			if (result['err_msg'] !== 'OK'){
			    toastr.error(result['err_msg']);
			    return false;
			}

			$('#edit_sub_modal').modal('hide');

			get_class();

		});
	});


	$('#new_main').on('click', function(){
		$('#mname').val('');
		$('#send_main').data('cid', '0');
		$('#icon1').prop('src', '');
		$('input[name=icon1], #main_icon').val('');
		$('#edit_main_modal .modal-title').text('新增主類別');
		$('#main_content').trumbowyg('empty');
		$('#edit_main_modal').modal();
	});


	$('#new_sub').on('click', function(){
		$('#sname').val('');
		$('#send_sub').data('cid', '0');
		$('#icon1').prop('src', '');
		$('input[name=icon2], #sub_icon').val('');
		$('#edit_sub_modal .modal-title').text('新增次類別');
		$('#edit_sub_modal').modal();
	});


	function convertImgToBase64(url, callback, outputFormat){
	    var canvas = document.createElement('CANVAS');
	    var ctx = canvas.getContext('2d');
	    var img = new Image;
	    img.crossOrigin = 'Anonymous';
	    
	    img.onload = function(){

	        if (img.width > 128){
	            var scale = 128 / img.width;
	            img.width = 128;
	            img.height = Math.round(img.height * scale);
	        }

	        if (img.height > 128){
	            var scale = 128 / img.height;
	            img.height = 128;
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

	document.getElementById("main_icon").addEventListener("change", readFile);
	document.getElementById("sub_icon").addEventListener("change", readFile);

	function readFile() {
	  
	  if (this.files && this.files[0]) {
	    
	    var FR= new FileReader();
	    var pid = $(this).prop('id');
	    
	    FR.addEventListener("load", function(e) {

	      convertImgToBase64(e.target.result, function(base64Img){

	          if (pid === 'main_icon'){
	                $('#icon1').prop('src', base64Img);
	                $('input[name=icon1]').val(base64Img);
	            }

	          if (pid === 'sub_icon'){
	          	console.log('got');
	            $('#icon2').prop('src', base64Img);
	            $('input[name=icon2]').val(base64Img);
	          }

	      }, 'image/png');
	    }); 
	    
	    FR.readAsDataURL( this.files[0] );
	  }
	  
	}

	jQuery(document).ready(function($) {
		 $(document).ready(function() {
		    $('#main_content')
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
	});

</script>