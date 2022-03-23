<?php session_start(); ?>
<?php

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	include('../simple_html_dom.php');
	$db = new MysqliDb($mysqli);

	$result	=	Array();

	if (!isset($_SESSION['bee_admin'])){
		$result['err_msg']	=	'-1';
	    exit(json_encode($result));
	}

	if (empty($_POST['pagename']) || empty($_POST['content'])){
		$result['err_msg'] = '欄位錯誤';
		exit(json_encode($result));
	}

	$system	=	$db->getOne('system');

	$data					=	Array();
	$data['pagename']		=	$_POST['pagename'];
	$data['content']		=	$_POST['content'];
	$data['linkname']		=	NULL;
	$data['sort']			=	0;
	$data['show_mode']		=	(int)$_POST['show_mode'];
	$data['nav_item']		=	0;
	$data['only_body']		=	0;

	if ($data['show_mode'] == 2){
		$data['nav_item']	=	$_POST['nav_item'];
	}

	if (!empty($_POST['linkname'])) $data['linkname']	=	$_POST['linkname'];
	if (!empty($_POST['sort'])) $data['sort']	=	$_POST['sort'];

	$html 	=	$_POST['content'];

	if (isset($_POST['block'])){

		$data['only_body']		=	1;

		$param					=	Array();

		$lan    =   $db->where('id', $system['language'])->getOne('language');
		$param['lan']   =   json_decode($lan['content'], true);
		
		$param['content']		=	$html;	
		$param['show_banner']	=	$system['banners_all'];
		$param['blank']			=	1;
		include('../param.php');

		require_once '../vendor/autoload.php';
		$loader = new \Twig\Loader\FilesystemLoader('../templates');

		$twig = new \Twig\Environment($loader);
		$filter = new \Twig\TwigFilter('html_entity_decode', 'html_entity_decode');
		$twig->addFilter($filter);

		$html = $twig->render($system['template'].'_blank.html.twig', ['system' => $system, 'param'=> $param]);

	}

	

	file_put_contents('../'.$data['pagename'].'.html', $html);

	$sid			=	(int)$_POST['sid'];

	if ($sid > 0){

		if ($db->where('id', $sid)->update('pages', $data)){
			$result['err_msg']	=	'OK';
		} else {
			$result['err_msg']	=	'DB UPDATE ERROR '.$db->getLastError();
		}

	} else {

		if ($db->insert('pages', $data)){
				$result['err_msg']	=	'OK';
			} else {
				$result['err_msg']	=	'DB INSERT ERROR '.$db->getLastError();
			}
	}

	echo json_encode($result);

?>