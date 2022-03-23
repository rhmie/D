<?php session_start(); ?>
<?php

	date_default_timezone_set("Asia/Taipei");

	include('../mysql.php');
	require_once ('../MysqliDb.php');
	include('./SimpleXLSX.php');

	$result	=	Array();

	if (!isset($_SESSION['bee_admin'])){
		$result['err_msg']	=	'-1';
	    exit(json_encode($result));
	}

	if ($_FILES['excel_file']['error'] !== UPLOAD_ERR_OK){
		$result['err_msg']	=	'UPLOAD ERROR';
		   exit(json_encode($result));
	}

	$tmp   = $_FILES['excel_file']['tmp_name'];
	move_uploaded_file($tmp, 'products.xlsx');

	$db = new MysqliDb($mysqli);

	$data_all	=	Array();

	if ($xlsx = SimpleXLSX::parse('products.xlsx')) {

		if (count($xlsx->rows()) < 3){
			$result['err_msg']	=	'資料數量錯誤~!';
			exit(json_encode($result));
		}

		if (count($xlsx->rows()[0]) !== 20){
			$result['err_msg']	=	'欄位數量錯誤~!';
			exit(json_encode($result));
		}

		$i = 0;

		foreach ($xlsx->rows() as $elt) {

			$data 	=	Array();

			if ($i > 1) {

				$prod 	=	$db->where('pnum', $elt[0])->getOne('products');

				if ($db->count > 0){
					if (isset($_POST['rewrite'])){
						$db->where('id', $prod['id'])->delete('products');
					} else {
						continue;
					}
				}

				$data['pnum']	=	$elt[0];
				$data['pname']	=	$elt[1];
				$data['price']	=	$elt[2];
				$data['sprice']	=	$elt[3];
				$data['sdate']	=	NULL;
				if (trim($elt[4]) !== '') $data['sdate']	=	$elt[4];
				$data['cost']	=	0;
				if (trim($elt[5]) !== '') $data['cost']	=	$elt[5];

				$data['info']	=	NULL;
				if (trim($elt[10]) !== '') $data['info']	=	$elt[10];

				$data['images']	=	NULL;
				if (trim($elt[11]) !== '') $data['images']	=	$elt[11];

				$data['info_images']	=	NULL;
				if (trim($elt[12]) !== '') $data['info_images']	=	$elt[12];

				$data['youtube']	=	NULL;
				if (trim($elt[13]) !== '') $data['youtube']	=	$elt[13];

				$data['related_items']	=	NULL;
				if (trim($elt[14]) !== '') $data['related_items']	=	$elt[14];

				
				if (trim($elt[15]) !== ''){
					$db->where('id', $elt[15])->getOne('main_class');
					if ($db->count > 0){
						$data['main_id']	=	$elt[15];
					} else {
						continue;
					}
				} else {
					continue;
				}

				if (trim($elt[16]) !== ''){
					$db->where('id', $elt[16])->getOne('sub_class');
					if ($db->count > 0){
						$data['sub_id']	=	$elt[16];
					} else {
						continue;
					}
				} else {
					continue;
				}

				$data['stock']	=	0;
				if (trim($elt[17]) !== '') $data['stock']	=	$elt[17];

				$data['buy_limited']	=	0;
				if (trim($elt[18]) !== '') $data['buy_limited']	=	$elt[18];

				$data['opt_asign']	=	0;
				if (trim($elt[19]) !== '') $data['opt_asign']	=	$elt[19];

				$now = new DateTime();
				$data['cdate']	=	$now->format('Y-m-d H:i');

				$data['opts']	=	NULL;

				$opt_arr 	=	Array();

				$opt 		=	Array();
				if (trim($elt[6]) !== '' && trim($elt[7]) !== ''){
					$opt['oname']	=	$elt[6];
					$opt['opts']	=	explode(',', $elt[7]);
					array_push($opt_arr, $opt);
				}

				$opt 		=	Array();
				if (trim($elt[8]) !== '' && trim($elt[9]) !== ''){
					$opt['oname']	=	$elt[8];
					$opt['opts']	=	explode(',', $elt[9]);
					array_push($opt_arr, $opt);
				}

				if (count($opt_arr) > 0) $data['opts']	=	json_encode($opt_arr);

				array_push($data_all, $data);   

			} 

			$i++;
		}

		if (count($data_all) === 0){
			$result['err_msg']	=	'沒有導入任何資料~!';
			exit(json_encode($result));
		}

		$ids = $db->insertMulti('products', $data_all);

		if(!$ids) {
			$result['err_msg']	=	'insert failed: ' . $db->getLastError();
		} else {
			$result['cnt']		=	count($ids);
		    $result['err_msg']	=	'OK';
		}


	} else {
		$result['err_msg']	=	'資料格式錯誤!';
	}

	echo json_encode($result);

?>