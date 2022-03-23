<?php include('./include.php');?>
<?php 
	$discode = $_POST['discode'];
	$rs = $db->where('promocode' , $discode)->getOne('members');
	if(!empty($rs)){
		echo $rs['discount'];
	}else{
		echo "無此優惠碼";
	}
?>