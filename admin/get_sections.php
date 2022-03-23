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

	$opts	=	$db->orderBy('id', 'desc')->get('sections');

	$optable	=	'';

	foreach ($opts as $opt){
		$optable .= '<tr>';
		$optable .= '<td>'.$opt['sname'].'</td>';
		$status  = '隱藏';
		if ($opt['shown'] == 1) $status = '顯示';
		$optable .= '<td class="text-center">'.$opt['sort'].'</td>';
		$optable .= '<td class="text-center">'.$status.'</td>';
		$optable .= '<td class="text-right">
			<div class="btn-group">
				<button onclick="javascript:edit_section('.$opt['id'].');" class="btn btn-blue-grey btn-sm"><i class="fas fa-edit mr-1"></i>編輯</button>

				<button data-sid="'.$opt['id'].'" class="btn btn-blue-grey btn-sm del_section"><i class="fas fa-trash-alt mr-1"></i>刪除</button>
			</div>
		</td>';
	}

	$result['sections']	=	$optable;

	echo json_encode($result);

?>