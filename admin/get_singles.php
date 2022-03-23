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

	$system 	=	$db->getOne('system');

	$icount = (int)$_POST['icount'];

	$sql	=	'SELECT A1.*, A2.id AS pid, A2.images, A2.pname, A2.price, A2.sprice, A2.sdate FROM singles A1, products A2 WHERE A1.pid = A2.id ORDER BY A1.id DESC LIMIT '.$icount.', 6';

	$singles	=	$db->rawQuery($sql);

	$optable	=	'';

	$system	=	$db->getOne('system');

	foreach ($singles as $single){
		$img	=	explode(',', $single['images']);
		$optable .= '<tr>';
		$optable .= '<td><img height="60" src="'.$img[0].'"></td>';
		$optable .= '<td><a target="_blank" class="blue-text" href="'.$system['weburl'].$single['pnum'].'.html">'.$single['pnum'].'</a></td>';

		$pname	=	$single['pname'];

		if (mb_strlen($pname, 'utf-8') > 20){
			$pname	=	mb_substr($pname, 0, 19).'...';
			$optable .= '<td data-toggle="tooltip" data-placement="top" title="'.$single['pname'].'">'.$pname.'</td>';
		} else {
			$optable .= '<td>'.$single['pname'].'</td>';
		}

		$optable .= '<td>'.$single['price'].'</td>';

		if ((int)$single['sprice'] > 0){

			// $today	=	new DateTime();
			// $sdate	=	new DateTime($single['sdate']);

			// //如果已超過優惠到期日

			// if ($sdate < $today){
			// 	$data			=	Array();
			// 	$data['sdate']	=	NULL;
			// 	$data['sprice']	=	0;
			// 	$db->where('id', $single['pid'])->update('products', $data);

			// 	$optable  .= '<td>0</td>';

			// } else {

			// 	$optable  .= '<td data-toggle="tooltip" data-placement="top" title="優惠到期日: '.$single['sdate'].'">'.$single['sprice'].'</td>';

			// }

			$optable  .= '<td data-toggle="tooltip" data-placement="top" title="優惠到期日: '.$single['sdate'].'">'.$single['sprice'].'</td>';

		} else {
			$optable  .= '<td>'.$single['sprice'].'</td>';
		}

		
		$optable .= '<td>'.$single['cdate'].'</td>';
		$optable .= '<td class="text-right">
				<div class="btn-group">
					<button data-url="'.$system['weburl'].$single['pnum'].'.html" class="btn btn-blue-grey btn-sm copy_btn"><i class="far fa-copy mr-1"></i>複製網址</button>
					<button data-num="'.$single['pnum'].'" data-sid="'.$single['id'].'" class="btn btn-blue-grey btn-sm del_single"><i class="fas fa-trash-alt mr-1"></i>刪除</button>
				</div>

		</td>';
	}

	$result['err_msg']	=	'OK';
	$result['singles']	=	$optable;

	echo json_encode($result);


?>