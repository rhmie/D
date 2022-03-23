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

	if ($_POST['sid'] !== '0'){
		$count	=	$db->where('main_id', $_POST['sid'])->getValue('products', 'count(*)');
		$total	=	ceil($count / 6);
		if ($total == 0) $total = 1;

		$result['totalpages']	=	$total;

		$icount = (int)$_POST['icount'];

		$prods	=	$db->where('main_id', $_POST['sid'])->orderBy($_POST['sort'], 'desc')->get('products', Array($icount, 6));

	}


	if ($_POST['pname'] !== '0'){
		if ($_POST['pname'] == 'stock'){
			$prods 	=	$db->where('stock', 0)->orderBy($_POST['sort'], 'desc')->get('products');
		} else {
			$prods 	=	$db->where('pname', '%'.$_POST['pname'].'%', 'like')->orderBy($_POST['sort'], 'desc')->get('products');
		}
	}

	if ($_POST['pnum'] !== '0'){
		$prods 	=	$db->where('pnum', $_POST['pnum'])->get('products');
	}


	$pitems	=	'';

	foreach ($prods as $prod){
		$img	=	explode(',', $prod['images']);

		$nostock	=	$hidden	=	'';

		if ($prod['stock'] == 0) $nostock = 'nostock';
		if ($prod['status'] == 1) $hidden = 'hidden';

		$pitems .= '<tr class="'.$nostock.' '.$hidden.'">';
		$pitems .= '<td>'.$prod['id'].'</td>';
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

			// //如果已超過優惠到期日

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

		$pitems .= '<td>'.$prod['stock'].'</td>';
		$pitems .= '<td>'.$prod['views'].'</td>';
		$pitems .= '<td>'.$prod['volume'].'</td>';
		$pitems .= '<td class="text-right">
		<div class="btn-group">
				<button onclick="javascript:edit_prod('.$prod['id'].');" class="btn btn-blue-grey btn-sm edit_prod"><i class="fas fa-edit mr-1"></i>編輯</button>
				<button data-pid="'.$prod['id'].'" class="btn btn-blue-grey btn-sm del_prod"><i class="fas fa-trash-alt mr-1"></i>刪除</button>
			</div>
		</td>';

		$pitems .= '</tr>';
	}

	$result['err_msg']	=	'OK';
	$result['products']	=	$pitems;

	echo json_encode($result);

?>