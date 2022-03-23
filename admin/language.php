<?php session_start(); ?>
<?php

	if (!isset($_SESSION['bee_admin'])){
	   echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
	}

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$langs	=	$db->get('language');

	$optable	=	'';

	foreach ($langs as $lang){
		$optable .= '<tr>';
		$optable .= '<td>'.$lang['id'].'</td>';
		$optable .= '<td>'.$lang['gname'].'</td>';

		$optable .= '<td class="text-right">
			<div class="btn-group">
				<button onclick="javascript:edit_lang('.$lang['id'].');" class="btn btn-blue-grey btn-sm edit_lan"><i class="fas fa-edit mr-1"></i>編輯</button>

				<button data-gid="'.$lang['id'].'" class="btn btn-blue-grey btn-sm del_lan"><i class="fas fa-trash-alt mr-1"></i>刪除</button>
			</div>
		</td>';
	}


?>


<section class="section" id="language">

	<div class="row">

	 	<div class="col-12">

	 		<div class="btn-group">
	 			<button href="#" onclick="javascript:edit_lang(0);" id="new_lan_btn" type="button" class="btn btn-outline-info"><i class="fas fa-plus fa-lg mr-1"></i>建立新語系</button>
	 			<button class="btn btn-outline-info" type="button" id="lang_refresh"><i class="fas fa-redo-alt mr-1"></i>重新整理</button>
	 		</div>

	 		<table class="table table-striped">
	 		  <thead>
	 		    <tr>
	 		      <th scope="col">ID</th>
	 		      <th scope="col">語系名稱</th>
	 		      <th scope="col" class="text-right">操作</th>
	 		    </tr>
	 		  </thead>
	 		  <tbody id="lan_table">
	 		  	<?=$optable?>
	 		  </tbody>
	 		</table>

	 	</div>

	 </div>

</section>

	<script>

		function edit_lang(pid){
			window.open('./edit_language_window.php?id='+pid, "connectWindow", "width=850,height=900, scrollbars=yes");
		}

		$('#lang_refresh').on('click', function(){
			 $('#main_page').load('language.php');
		});


		$('#lan_table').on('click', '.del_lan', function(){
			var msg = "確定要移除這個語系？"; 
			if (confirm(msg)==true){ 

				var gid =	$(this).data('gid');

				var tr = $(this).parent().parent().parent();

				$.post('del_lan.php', {gid: gid}, function(data){

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

				});
			}
		})



	</script>