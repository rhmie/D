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

	$opts	=	$db->orderBy('id', 'desc')->get('pages');

	$optable	=	'';

	foreach ($opts as $opt){

		$surl 	 =	$system['weburl'].$opt['pagename'].'.html';

		$show_mode 	=	'不顯示';
		if ($opt['show_mode'] == 1) $show_mode = '導覽列';

		if ($opt['show_mode'] == 2){
			$nav 	=	$db->where('id', $opt['nav_item'])->getOne('nav_items', 'nav_name');
			 $show_mode = $nav['nav_name'];
		}

		$optable .= '<tr>';
		$optable .= '<td>'.$opt['pagename'].'</td>';
		$optable .= '<td>'.$opt['linkname'].'</td>';
		$optable .= '<td class="text-center">'.$opt['sort'].'</td>';
		$optable .= '<td><a target="_blank" href="'.$surl.'">'.$surl.'</a></td>';
		$optable .= '<td>'.$show_mode.'</td>';
		$optable .= '<td class="text-right">
			<div class="btn-group">
				<button onclick="javascript:edit_page('.$opt['id'].');" class="btn btn-blue-grey btn-sm"><i class="fas fa-edit mr-1"></i>編輯</button>

				<button data-sid="'.$opt['id'].'" class="btn btn-blue-grey btn-sm del_page"><i class="fas fa-trash-alt mr-1"></i>刪除</button>
			</div>
		</td>';
	}

	$result['pages']	=	$optable;

	echo json_encode($result);

?>