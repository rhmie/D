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

	$opts	=	$db->orderBy('id', 'desc')->get('news_letters');

	$optable	=	'';

	foreach ($opts as $opt){
		$optable .= '<tr>';
		$optable .= '<td>'.$opt['title'].'</td>';
		$optable .= '<td>'.$opt['cdate'].'</td>';
		$optable .= '<td class="text-right">
			<div class="btn-group">
				<button onclick="javascript:edit_news('.$opt['id'].');" class="btn btn-blue-grey btn-sm edit_newsletter"><i class="fas fa-edit mr-1"></i>編輯</button>

				<button data-bid="'.$opt['id'].'" class="btn btn-blue-grey btn-sm del_newsletter"><i class="fas fa-trash-alt mr-1"></i>刪除</button>
			</div>
		</td>';
	}

	$result['newsletters']	=	$optable;
	$result['ocount']		=	$db->getValue ('news_mail', 'count(*)');

	echo json_encode($result);

?>