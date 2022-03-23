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

	$icount = (int)$_POST['icount'];

	$blogs 	=	$db->orderBy('id', 'desc')->get('blog', Array($icount, 8));

	$pitems	=	'';

	foreach ($blogs as $blog){
		$pitems .=	'<tr>';
		
		$cancel_pub = '';

		if ($blog['status'] == 1){
			$cancel_bub = '<button data-bid="'.$blog['id'].'" class="btn btn-blue-grey btn-sm cancel_blog"><i class="fas fa-power-off mr-1"></i>取消發布</button>';
		}

		$res 	=	Array();
		$rel 	=	Array();
		if (!is_null($blog['related'])){
			$rel 	=	explode(',', $blog['related']);
		}

		$pitems .=	'<td><img height="60" alt="'.$blog['title'].'" src="'.$blog['main_img'].'"></td>';

		$pname	=	$blog['title'];

		if (mb_strlen($pname, 'utf-8') > 20){
			$pname	=	mb_substr($pname, 0, 19).'...';
			$pitems .= '<td data-toggle="tooltip" data-placement="top" title="'.$blog['title'].'"><a target="_blank" class="blue-text" href="../blog_view.php?id='.$blog['id'].'">'.$pname.'</a></td>';
		} else {
			$pitems .= '<td><a class="blue-text" target="_blank" href="../blog_view.php?id='.$blog['id'].'">'.$blog['title'].'</a></td>';
		}

		$pitems .=	'<td class="text-center">'.count($rel).'</td>';

		if ($blog['status'] == 0){
			$pitems .= '<td>尚未發布</td>';
		} else {
			$pitems .= '<td>已發佈</td>';
		}

		$pitems 	.=	'<td>'.$blog['cdate'].'</td>';

		$pitems		.=	'<td class="text-right">
		<div class="btn-group">
				'.$cancel_pub.'
				<button onclick="javascript:edit_blog('.$blog['id'].');" class="btn btn-blue-grey btn-sm edit_blog"><i class="fas fa-edit mr-1"></i>編輯</button>
				<button data-bid="'.$blog['id'].'" class="btn btn-blue-grey btn-sm del_blog"><i class="fas fa-trash-alt mr-1"></i>刪除</button>
			</div>
		</td></tr>';
	}

	$result['err_msg']	=	'OK';
	$result['blog']		=	$pitems;

	echo json_encode($result);
?>