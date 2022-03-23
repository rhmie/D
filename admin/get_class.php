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

	$mains	=	$db->orderBy('sort', 'asc')->get('main_class');
	$subs	=	$db->orderBy('sort', 'asc')->get('sub_class');

	$main_table	=	$sub_table	=	$main_items	=	'';

	foreach ($mains as $main){
		$main_table	.=	'<tr>';
		$main_table .= '<td>'.$main['id'].'</td>';
		$main_table .= '<td><img width="48" alt="" src="'.$main['icon'].'"></td>';
		$main_table .= '<td>'.$main['cname'].'</td>';

		$sub_count = $db->where('mid', $main['id'])->getValue('sub_class', 'count(*)');

		$count	=	$db->where('main_id', $main['id'])->getValue('products', 'count(*)');

		$main_table .= '<td class="text-center">'.$count.'</td>';

		$main_table .= '<td class="text-center">'.$sub_count.'</td>';

		$main_table .= '<td class="text-center">'.$main['sort'].'</td>';

		$del_btn	=	'';

		if ($sub_count == 0){
			$del_btn	=	'<button data-cid="'.$main['id'].'" class="btn btn-blue-grey btn-sm del_main"><i class="fas fa-trash-alt mr-1"></i>刪除</button>';
		}

		$main_table .= '<td class="text-right">
			<div class="btn-group">
					<button data-sort="'.$main['sort'].'" data-cname="'.$main['cname'].'" data-content="'.htmlspecialchars($main['content']).'" data-cid="'.$main['id'].'" data-icon="'.$main['icon'].'" class="btn btn-blue-grey btn-sm edit_main"><i class="fas fa-edit mr-1"></i>編輯</button>
					'.$del_btn.'
			</div>
		</td>';

		$main_table .= '</tr>';

		$main_items	.=	'<option value="'.$main['id'].'">'.$main['cname'].'</option>';
	}


	foreach ($subs as $sub){
		$sub_table .= '<tr>';
		$sub_table .= '<td>'.$sub['id'].'</td>';
		$sub_table .= '<td><img width="48" alt="" src="'.$sub['icon'].'"></td>';
		$sub_table .= '<td>'.$sub['cname'].'</td>';

		$main 	=	$db->where('id', $sub['mid'])->getOne('main_class');
		$sub_table .= '<td>'.$main['cname'].'</td>';

		$count	=	$db->where('sub_id', $sub['id'])->getValue('products', 'count(*)');

		$sub_table .= '<td class="text-center">'.$count.'</td>';

		$sub_table .= '<td class="text-center">'.$sub['sort'].'</td>';

		$del_btn	=	'';

		if ($count == 0){
			$del_btn	=	'<button data-cid="'.$sub['id'].'" class="btn btn-blue-grey btn-sm del_sub"><i class="fas fa-trash-alt mr-1"></i>刪除</button>';
		}

		$sub_table .= '<td class="text-right">
			<div class="btn-group">
					<button data-sort="'.$sub['sort'].'" data-cname="'.$sub['cname'].'" data-cid="'.$sub['id'].'" data-mid="'.$sub['mid'].'" data-icon="'.$sub['icon'].'" class="btn btn-blue-grey btn-sm edit_sub"><i class="fas fa-edit mr-1"></i>編輯</button>
					'.$del_btn.'
			</div>
		</td>';

		$sub_table 	.=	'</tr>';


	}


	$result['err_msg']		=	'OK';
	$result['main_class']	=	$main_table;
	$result['sub_class']	=	$sub_table;
	$result['main_items']	=	$main_items;

	echo json_encode($result);


?>