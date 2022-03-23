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

	$system	=	$db->getOne('system');

	$opts	=	$db->orderBy('sort', 'asc')->get('nav_items');

	$optable	=	'';

	foreach ($opts as $opt){

		$optable .= '<tr>';
		$optable .= '<td>'.$opt['nav_name'].'</td>';
		$optable .= '<td>'.$opt['sort'].'</td>';

		$del_btn 	=	'<button data-sid="'.$opt['id'].'" class="btn btn-blue-grey btn-sm del_nav"><i class="fas fa-trash-alt mr-1"></i>刪除</button>';

		$pages 		=	$db->where('nav_item', $opt['id'])->getValue('pages', 'count(*)');

		if ($pages > 0){
			$del_btn = '';
		}

		$optable .= '<td class="text-right">
			<div class="btn-group">
				<button data-sid="'.$opt['id'].'" data-nav_name="'.$opt['nav_name'].'" data-sort="'.$opt['sort'].'" class="btn btn-blue-grey btn-sm edit_nav"><i class="fas fa-edit mr-1"></i>編輯</button>
				'.$del_btn.'
				
			</div>
		</td>';
	}

	$result['pages']	=	$optable;

	echo json_encode($result);

?>