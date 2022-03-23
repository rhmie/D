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


	$icount = (int)$_POST['icount'];
	$sql	=	'SELECT A1.*, A2.id AS pid, A2.images, A2.pname, A2.price, A2.sprice, A2.sdate FROM hot_products A1, products A2 WHERE A2.id = A1.pid ORDER BY A1.id DESC LIMIT '.$icount.', 6';

	$prods	=	$db->rawQuery($sql);

	$pitems	=	'';

	foreach ($prods as $prod){
		$img	=	explode(',', $prod['images']);
		$pitems .= '<tr>';
		$pitems .= '<td><img height="60" src="'.$img[0].'"></td>';
		$pitems .= '<td>'.$prod['pnum'].'</td>';

		$pname	=	$prod['pname'];

		if (mb_strlen($pname, 'utf-8') > 20){
			$pname	=	mb_substr($pname, 0, 19).'...';
			$pitems .= '<td data-toggle="tooltip" data-placement="top" title="'.$prod['pname'].'">'.$pname.'</td>';
		} else {
			$pitems .= '<td>'.$prod['pname'].'</td>';
		}


		$pitems .= '<td>'.$prod['price'].'</td>';

		if ((int)$prod['sprice'] > 0){

			// $today	=	new DateTime();
			// $sdate	=	new DateTime($prod['sdate']);

			//如果已超過優惠到期日

			// if ($sdate < $today){
			// 	$data			=	Array();
			// 	$data['sdate']	=	NULL;
			// 	$data['sprice']	=	0;
			// 	$db->where('id', $prod['id'])->update('products', $data);

			// 	$pitems  .= '<td>0</td>';

			// } else {

			// 	$pitems  .= '<td data-toggle="tooltip" data-placement="top" title="優惠到期日: '.$prod['sdate'].'">'.$prod['sprice'].'</td>';

			// }

			$pitems  .= '<td data-toggle="tooltip" data-placement="top" title="優惠到期日: '.$prod['sdate'].'">'.$prod['sprice'].'</td>';

		} else {
			$pitems .= '<td>'.$prod['sprice'].'</td>';
		}


		$pitems .= '<td class="text-right">
		<div class="btn-group">
				<button onclick="javascript:edit_prod('.$prod['pid'].');" class="btn btn-blue-grey btn-sm edit_prod"><i class="fas fa-edit mr-1"></i>編輯</button>
				<button data-pid="'.$prod['id'].'" class="btn btn-blue-grey btn-sm del_hot"><i class="fas fa-trash-alt mr-1"></i>刪除</button>
			</div>
		</td>';

		$pitems .= '</tr>';
	}

	$result['err_msg']	=	'OK';
	$result['products']	=	$pitems;

	echo json_encode($result);

?>