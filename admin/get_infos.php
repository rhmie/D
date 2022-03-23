<?php session_start(); ?>
<?php

	include("../mysql.php");
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$result	=	Array();

	if (!isset($_SESSION['bee_admin'])){
		$result['err_msg']	=	'-1';
	    exit(json_encode($result));
	} 

	$opts	=	$db->orderBy('id', 'desc')->get('product_info');

	$optable	=	'';

	foreach ($opts as $opt){
		$optable .= '<tr>';
		$optable .= '<td>'.$opt['iname'].'</td>';
		$optable .= '<td class="icontent">'.$opt['info'].'</td>';
		$optable .= '<td class="text-right">
			<div class="btn-group">
				<button data-iname="'.$opt['iname'].'" data-oid="'.$opt['id'].'" class="btn btn-blue-grey btn-sm edit_info"><i class="fas fa-edit mr-1"></i>編輯</button>

				<button data-oid="'.$opt['id'].'" class="btn btn-blue-grey btn-sm del_info"><i class="fas fa-trash-alt mr-1"></i>刪除</button>
			</div>
		</td>';
	}

	$result['infos']	=	$optable;

	echo json_encode($result);


?>