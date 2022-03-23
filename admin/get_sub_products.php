<?php session_start(); ?>
<?php

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	$db = new MysqliDb($mysqli);

	$result	=	Array();

	if (!isset($_SESSION['bee_admin'])){
		$result['err_msg']	=	'-1';
	    exit(json_encode($result));
	}

	$sql	=	'SELECT A1.*, A2.pname as aname, A2.pnum as anum, A2.images as aimgs, A3.pname as bname, A3.pnum as bnum, A3.images as bimgs FROM sub_products A1, products A2, products A3 WHERE A2.id = A1.mid AND A3.id = A1.pid ORDER BY A1.id DESC LIMIT '.$_POST['icount'].', 8';

	$sub_products	=	$db->rawQuery($sql);

	$sitems	=	'';

	foreach ($sub_products as $sub){
		$aimgs 	=	explode(',', $sub['aimgs']);
		$bimgs	=	explode(',', $sub['bimgs']);
		$cnt_label	=	$sub['cnt'];
		if ($sub['cnt'] == 0) $cnt_label = '無限制';	
		$sitems .= '<tr>';
		$sitems .= '<td><img height="60"  src="'.$aimgs[0].'" alt="'.$sub['aname'].'"></td>';
		$sitems .= '<td data-toggle="tooltip" data-placement="top" title="'.$sub['aname'].'">'.$sub['anum'].'</td>';
		$sitems .= '<td><img height="60" src="'.$bimgs[0].'" alt="'.$sub['bname'].'"></td>';
		$sitems .= '<td data-toggle="tooltip" data-placement="top" title="'.$sub['bname'].'">'.$sub['bnum'].'</td>';
		$sitems .= '<td>'.$sub['price'].'</td>';
		$sitems .= '<td>'.$cnt_label.'</td>';
		$sitems .= '<td class="text-right">
			<div class="btn-group">
				<button data-oid="'.$sub['id'].'" data-cnt="'.$sub['cnt'].'" data-mnum="'.$sub['anum'].'" data-pnum="'.$sub['bnum'].'" data-price="'.$sub['price'].'" class="btn btn-blue-grey btn-sm edit_add"><i class="fas fa-edit mr-1"></i>編輯</button>

				<button data-oid="'.$sub['id'].'" class="btn btn-blue-grey btn-sm del_add"><i class="fas fa-trash-alt mr-1"></i>刪除</button>
			</div>
		</td>';
	}

	$result['err_msg']	=	'OK';
	$result['sitems']	=	$sitems;

	echo json_encode($result);

?>