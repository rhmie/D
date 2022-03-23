<?php session_start(); ?>
<?php

	if (!isset($_SESSION['bee_admin'])){
	   echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
	}

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$count = $db->getValue('blog', 'count(*)');
	$s_total_pages = ceil($count / 6);
	if ($s_total_pages == 0) $s_total_pages = 1;

?>

<section class="section" id="blog">

	<div class="row">


	 	<div class="col-12">

	 		<div class="btn-group">
	 			<a href="#" onclick="javascript:edit_blog(0);" id="new_blog_btn" type="button" class="btn btn-outline-info"><i class="fas fa-plus fa-lg mr-1"></i>建立新文章</a>
	 			<button class="btn btn-outline-info" type="button" id="blog_refresh"><i class="fas fa-redo-alt mr-1"></i>重新整理</button>
	 		</div>

	 		<table class="table table-striped">
	 		  <thead>
	 		    <tr>
	 		      <th scope="col">縮圖</th>
	 		      <th scope="col">標題</th>
	 		      <th scope="col" class="text-center">關聯商品</th>
	 		      <th scope="col">狀態</th>
	 		      <th scope="col">更新日期</th>
	 		      <th scope="col" class="text-right">操作</th>
	 		    </tr>
	 		  </thead>
	 		  <tbody id="blog_table">

	 		    
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

<script>

	var s_page = 1;

	function edit_blog(pid){
		window.open('./edit_blog.php?id='+pid, "connectWindow", "width=850,height=900, scrollbars=yes");
	}

	window.h_pagObj = $('#s_pagination').twbsPagination({
	            totalPages: <?php echo $s_total_pages ?>,
	            visiblePages: 10,
	            onPageClick: function (event, page) {

	            }
	        }).on('page', function (event, page) {
	            s_page = page;
	            get_blog();
	        });



	function get_blog(){
		var icount = (parseInt(s_page) - 1) * 6;

		$.post('get_blog.php',{icount: icount}, function(data){

			//console.log(data);
			var result = JSON.parse(data);

			if (result['err_msg'] === '-1'){
				alert('登入逾時，請重新登入~!');
				window.location = 'login.php';
			}

		    $('#blog_table').html(result.blog);

		    var clipboard = new Clipboard('.copy_btn', {
		        text: function(e) {
		        	return $(e).data('url');
		        }
		    });


		    clipboard.on('success', function(e) {
		        toastr.success('複製成功~!');
		    });

		    clipboard.on('error', function(e) {
		        toastr.error('複製失敗，請手動複製~!');
		    });
		                                
		});
	}


	get_blog();

	$('#blog_refresh').on('click', function(){
		 get_blog();
	});



	$('#blog_table').on('click', '.del_blog', function(){
		var msg = "確定要移除這篇文章？"; 
		if (confirm(msg)==true){ 

			var bid =	$(this).data('bid');

			var tr = $(this).parent().parent().parent();

			$.post('del_blog.php', {bid: bid}, function(data){

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

				if ($('#blog_table').html() === ''){
					if (s_page > 1) s_page = s_page - 1;
					$('#s_pagination').twbsPagination('destroy');

					$('#s_pagination').twbsPagination({
						totalPages: s_page,
						startPage: s_page,
						visiblePages: 8
					});

					
					get_blog();
				}

			});
		}
	})

</script>