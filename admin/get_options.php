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

	$opts	=	$db->orderBy('id', 'desc')->get('options');

	$optable	=	'';

	foreach ($opts as $opt){
		$optable .= '<tr>';
		$optable .= '<td>'.$opt['oname'].'</td>';
		$optable .= '<td>'.$opt['onick'].'</td>';
		$optable .= '<td>'.$opt['opts'].'</td>';
		$optable .= '<td class="text-right">
			<div class="btn-group">
				<button data-oname="'.$opt['oname'].'" data-onick="'.$opt['onick'].'" data-oid="'.$opt['id'].'" data-opts="'.$opt['opts'].'" class="btn btn-blue-grey btn-sm edit_opt"><i class="fas fa-edit mr-1"></i>編輯</button>

				<button data-oid="'.$opt['id'].'" class="btn btn-blue-grey btn-sm del_opt"><i class="fas fa-trash-alt mr-1"></i>刪除</button>
			</div>
		</td>';
	}

	$result['opts']	=	$optable;

	echo json_encode($result);


?>