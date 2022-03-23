<?php session_start(); ?>
<?php

include("../check_ref.php");

if (!isset($_SESSION['bee_admin'])){
    echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
    exit();
}

include("../mysql.php");
require_once ('../MysqliDb.php');
$db = new MysqliDb($mysqli);

	$admins = $db->get('admins');
	$fbox = '';

	foreach ($admins as $admin) {
		if (file_exists('./avt/' . $admin['id'] . '.png')) {
			$img = './avt/' . $admin['id'] . '.png?id='.mt_rand(10000,999999);
		} else {
			$img = '../images/default_avast.png';
		}
		$fbox .= '<tr>
	                <td data-toggle="collapse" data-target="#auth_area'.$admin['id'].'" aria-expanded="false" aria-controls="auth_area'.$admin['id'].'" class="text-left align-middle ident-text"><span class="hidden-xs-down"><img src="'.$img.'" width="60" height="60" class="rounded-circle img-responsive mr-2"></span> '.$admin['admin_name'].'
	                	<div id="auth_area'.$admin['id'].'" class="collapse hidden-sm-down">
	                		<hr>';
	                		if ($admin['auth_1'] == '1') $fbox .= '<div class="chip"><i class="fa fa-user fa-fw"></i>管理員設定</div>';
	                		if ($admin['auth_6'] == '1') $fbox .= '<div class="chip"><i class="fas fa-cog fa-fw"></i>系統管理</div>';
	                		if ($admin['auth_9'] == '1') $fbox .= '<div class="chip"><i class="fas fa-pager fa-fw"></i>首頁管理</div>';
	                		if ($admin['auth_2'] == '1') $fbox .= '<div class="chip"><i class="fa fa-users fa-fw"></i>會員管理</div>';
	                		if ($admin['auth_3'] == '1') $fbox .= '<div class="chip"><i class="far fa-list-alt fa-fw"></i>訂單管理</div>';
	                		if ($admin['auth_10'] == '1') $fbox .= '<div class="chip"><i class="fas fa-cubes fa-fw"></i>類別管理</div>';
	                		if ($admin['auth_4'] == '1') $fbox .= '<div class="chip"><i class="fas fa-gift fa-fw"></i>商品管理</div>';
	                		if ($admin['auth_8'] == '1') $fbox .= '<div class="chip"><i class="fas fa-list fa-fw"></i>規格管理</div>';
	                		if ($admin['auth_12'] == '1') $fbox .= '<div class="chip"><i class="fab fa-wordpress-simple fa-fw"></i>文章管理</div>';
	                		if ($admin['auth_11'] == '1') $fbox .= '<div class="chip"><i class="far fa-file-alt fa-fw"></i>單頁管理</div>';
	                		if ($admin['auth_7'] == '1') $fbox .= '<div class="chip"><i class="fas fa-heartbeat fa-fw"></i>簡訊發送</div>';
	                		if ($admin['auth_5'] == '1') $fbox .= '<div class="chip"><i class="fas fa-th-large fa-fw"></i>區塊管理</div>';
	                		if ($admin['auth_13'] == '1') $fbox .= '<div class="chip"><i class="fas fa-globe fa-fw"></i>語系管理</div>';
	                		$fbox .= '</div>
	                </td>

	                <td class="text-right align-middle" width="25%">
	                    <div class="btn-group" role="group">
	                      <button data-toggle="modal" data-target="#ident_modal" type="button" data-aid='.$admin['id'].' data-username="'.$admin['admin_name'].'" data-auth_1='.$admin['auth_1'].' data-auth_2='.$admin['auth_2'].' data-auth_3='.$admin['auth_3'].' data-auth_4='.$admin['auth_4'].' data-auth_5='.$admin['auth_5'].' data-auth_6='.$admin['auth_6'].' data-auth_7='.$admin['auth_7'].' data-auth_8='.$admin['auth_8'].' data-auth_9='.$admin['auth_9'].' data-auth_10='.$admin['auth_10'].' data-auth_11='.$admin['auth_11'].' data-auth_12='.$admin['auth_12'].' data-auth_13='.$admin['auth_13'].' class="btn btn-blue-grey btn-sm btn-edit-admin"><i class="fas fa-pencil-alt"></i><span class="hidden-md-down"> 編輯</span></button>
	                      <button data-aid='.$admin['id'].' type="button" class="btn btn-blue-grey btn-sm btn-del-admin"><span class="hidden-md-down">刪除 </span><i class="fa fa-trash"></i></button>
	                    </div>
	                </td>
	            </tr>';
	}

?>

<section class="section text-center" id="ident_settings">
	<div class="row align-items-center stdcolor std-text-size">
	    <button type="button" id="add_admin" class="btn btn-pink darken-3 btn-sm" data-toggle="modal" data-target="#ident_modal"><i class="fa fa-plus"></i><span class="hidden-sm-down"> 新增</span></button>
	</div>

	<div class="row">
	    <!--Table-->
	    <table class="table">

	        <!--Table head-->
	        <thead class="blue darken-3 text-white">
	            <tr>
	                <th class="text-left">名稱</th>
	                <th class="text-right">操作</th>
	            </tr>
	        </thead>
	        <!--Table head-->

	        <!--Table body-->
	        <tbody class="stdcolor">
	        	<?php echo $fbox ?>

	        </tbody>
	        <!--Table body-->
	    </table>
	    <!--Table-->

	</div>

		<div class="modal fade" id="ident_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
		                    <div class="modal-dialog cascading-modal" role="document">
		                        <!--Content-->
		                        <div class="modal-content">

		                            <!--Header-->
		                            <div class="modal-header pink darken-3 text-white white-text white-text">
		                                <h4 class="title"><i class="fa fa-id-card-o"></i> <span id="modal_title">新增管理員</span></h4>
		                                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
		                                                            <span aria-hidden="true">×</span>
		                                                        </button>
		                            </div>
		                            <!--Body-->
		                            <div class="modal-body mb-0">
									<form id="adform" enctype="multipart/form-data">
										<input type="hidden" name="aid" id="aid" value="0">

										<div class="md-form form-sm text-left">
										    <i class="fa fa-user prefix"></i>
										    <input type="text" id="username" name="admin_name" placeholder=" " minlength="2" maxlength="8" class="form-control" required>
										    <label for="admin_name" class="active">名稱</label>
										</div>


		                                <div class="md-form form-sm text-left">
		                                    <i class="fa fa-key prefix"></i>
		                                    <input type="password" id="password" name="password" placeholder=" " minlength="6" maxlength="12" class="form-control">
		                                    <label id="passlabel" for="password" class="active">密碼</label>
		                                </div>

		                                <div class="md-form form-sm text-left">
		                                	<div class="file-field">
		                                	    <div class="btn btn-pink lighten-2 btn-sm">
		                                	        <span class="lan">頭像</span>
		                                	        <input type="file" name="avt" accept="image/*">
		                                	    </div>
		                                	    <div class="file-path-wrapper">
		                                	       <input class="file-path validate lan" type="text">
		                                	    </div>
		                                	</div>
		                                </div>

		                                <div class="form-inline mb-3">

		                                    <div class="form-group ml-4">
		                                        <input type="checkbox" class="form-check-input" id="auth_2" name="auth_2" value="1">
		                                        <label class="pl-4" for="auth_2">會員管理</label>
		                                    </div>

		                                    <div class="form-group ml-4">
		                                        <input type="checkbox" class="form-check-input" id="auth_9" name="auth_9" value="1">
		                                        <label class="pl-4" for="auth_9">首頁管理</label>
		                                    </div>

		                                    <div class="form-group ml-4">
		                                        <input type="checkbox" class="form-check-input" id="auth_10" name="auth_10" value="1">
		                                        <label class="pl-4" for="auth_10">類別管理</label>
		                                    </div>

		                                    <div class="form-group ml-4">
		                                        <input type="checkbox" class="form-check-input" id="auth_4" name="auth_4" value="1">
		                                        <label class="pl-4" for="auth_4">商品管理</label>
		                                    </div>

		                                    <div class="form-group ml-4">
		                                        <input type="checkbox" class="form-check-input" id="auth_8" name="auth_8" value="1">
		                                        <label class="pl-4" for="auth_8">規格管理</label>
		                                    </div>

		                                    <div class="form-group ml-4">
		                                        <input type="checkbox" class="form-check-input" id="auth_12" name="auth_12" value="1">
		                                        <label class="pl-4" for="auth_12">文章管理</label>
		                                    </div>


		                                    <div class="form-group ml-4">
		                                        <input type="checkbox" class="form-check-input" id="auth_11" name="auth_11" value="1">
		                                        <label class="pl-4" for="auth_11">單頁管理</label>
		                                    </div>


		                                    <div class="form-group ml-4">
		                                        <input type="checkbox" class="form-check-input" id="auth_3" name="auth_3" value="1">
		                                        <label class="pl-4" for="auth_3">訂單管理</label>
		                                    </div>

		                                    <div class="form-group ml-4">
		                                        <input type="checkbox" class="form-check-input" id="auth_5" name="auth_5" value="1">
		                                        <label class="pl-4" for="auth_5">區塊管理</label>
		                                    </div>

		                                    <div class="form-group ml-4">
		                                        <input type="checkbox" class="form-check-input" id="auth_1" name="auth_1" value="1">
		                                        <label class="pl-4" for="auth_1">管理員設定</label>
		                                    </div>

		                                    <div class="form-group ml-4">
		                                        <input type="checkbox" class="form-check-input" id="auth_6" name="auth_6" value="1">
		                                        <label class="pl-4" for="auth_6">系統管理</label>
		                                    </div>

		                                    <div class="form-group ml-4">
		                                        <input type="checkbox" class="form-check-input" id="auth_7" name="auth_7" value="1">
		                                        <label class="pl-4" for="auth_7">簡訊發送</label>
		                                    </div>

		                                    <div class="form-group ml-4">
		                                        <input type="checkbox" class="form-check-input" id="auth_13" name="auth_13" value="1">
		                                        <label class="pl-4" for="auth_13">語系管理</label>
		                                    </div>

		                                </div>

										<div class="text-center mb-2">
										     <div id="edit_status" class="btn-group" role="group">
										        <button type="button" class="btn btn-rounded pink darken-3 text-white white-text mt-1 waves-effect waves-light" data-dismiss="modal"><i class="fa fa-times ml-1"></i> 取消</button>
										        <button type="submit" class="btn btn-rounded pink darken-3 text-white white-text mt-1 waves-effect waves-light">確定 <i class="fa fa-sign-in ml-1"></i></button>
										    </div>
										</div>
									</form>
		                            </div>
		                        </div>
		                        <!--/.Content-->
		                    </div>
		                </div>

</section>

<script>
	$('#add_admin').click(function(){
		$('#auth_1, #auth_2, #auth_3, #auth_4, #auth_5, #auth_6, #auth_7, #auth_8, #auth_9, #auth_10, #auth_11, #auth_12, #auth_13').prop('checked', false);
		$('#modal_title').text('新增管理員');
		$('#passlabel').text('密碼');
		$('#adform input').val('');
		$('#aid').val('0');
	})

	$('#adform').on('submit', (function (e) {
		e.preventDefault();

		$.ajax({
			url: 'new_admin.php',
			type: "POST",
			data:  new FormData(this),
			enctype: 'multipart/form-data',
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){
				var result = JSON.parse(data);

				if (result['err_msg'] === '-1'){
					alert('登入逾時，請重新登入~!');
					window.location = 'login.php';
				}

				if (result['err_msg'] !== 'OK'){
				    toastr.error(result['err_msg']);
				    return false;
				}

				$('#ident_modal, .modal-backdrop').remove();
				$('#main_page').load('ident_settings.php');

				
				
			}
		});

	}));

	$('#ident_modal').on('hidden.bs.modal', function (e) {
	  //$('#main_page').load('ident_settings.php');
	});

	$('body').on('click', '.btn-edit-admin', function(){
		$('#username').val($(this).data('username'));
		$('#password').val('');
		$('#aid').val($(this).data('aid'));
		$('#passlabel').text('密碼/不修改請留白');
		$('#modal_title').text('編輯管理員');
		$('#auth_1').prop('checked', $(this).data('auth_1') > 0);
		$('#auth_2').prop('checked', $(this).data('auth_2') > 0);
		$('#auth_3').prop('checked', $(this).data('auth_3') > 0);
		$('#auth_4').prop('checked', $(this).data('auth_4') > 0);
		$('#auth_5').prop('checked', $(this).data('auth_5') > 0);
		$('#auth_6').prop('checked', $(this).data('auth_6') > 0);
		$('#auth_7').prop('checked', $(this).data('auth_7') > 0);
		$('#auth_8').prop('checked', $(this).data('auth_8') > 0);
		$('#auth_9').prop('checked', $(this).data('auth_9') > 0);
		$('#auth_10').prop('checked', $(this).data('auth_10') > 0);
		$('#auth_11').prop('checked', $(this).data('auth_11') > 0);
		$('#auth_12').prop('checked', $(this).data('auth_12') > 0);
		$('#auth_13').prop('checked', $(this).data('auth_13') > 0);

	});

	$('.btn-del-admin').click(function(){

		var msg = "確定要刪除這個管理員？"; 
		if (confirm(msg)==true){ 
			var aid = $(this).data('aid');
			var box = $(this).parent().parent().parent();

			$.post('del_admin.php', {aid: aid}, function(data){
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

			})
		}
	})


</script>

