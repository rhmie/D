<?php

	if (!isset($_POST['RtnCode'])){
		exit('<h1>繳費失敗，請重新操作</h1>');
	}

	if ((int)$_POST['RtnCode'] !== 1){
		exit('<h1>繳費失敗，請重新操作 錯誤代碼 '.$_POST['RtnCode'].'</h1>');
	}

	echo '<h1>繳費完成</h1>';

?>