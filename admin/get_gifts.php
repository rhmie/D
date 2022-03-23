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

	$gifts 	=	$db->orderBy('id', 'desc')->get('gifts');

	$pitems	=	'';

	foreach ($gifts as $gift){
		$pitems .=	'<tr>';

		$pitems .=	'<td><img height="60" alt="'.$gift['gname'].'" src="'.$gift['pic'].'"></td>';

		$pitems .=	'<td>'.$gift['gname'].'</td>';

		$pitems 	.=	'<td>'.$gift['price'].'</td>';
		$pitems 	.=	'<td>'.$gift['stock'].'</td>';

		$pitems		.=	'<td class="text-right">
		<div class="btn-group">
				<button data-gid="'.$gift['id'].'" data-gname="'.$gift['gname'].'" data-gstock="'.$gift['stock'].'" data-gprice="'.$gift['price'].'" class="btn btn-blue-grey btn-sm edit_gift"><i class="fas fa-edit mr-1"></i>編輯</button>
				<button data-gid="'.$gift['id'].'" class="btn btn-blue-grey btn-sm del_gift"><i class="fas fa-trash-alt mr-1"></i>刪除</button>
			</div>
		</td></tr>';
	}

	$result['err_msg']	=	'OK';
	$result['gifts']		=	$pitems;

	echo json_encode($result);
?>