<?php include('./include.php');?>

<?php 
$payment     = $_POST['payment'];
$name        = $_POST['name'];
$tel         = $_POST['tel'];
$email       = $_POST['email'];
$address     = $_POST['address'];
$message     = $_POST['message'];
$couponCode  = $_POST['couponCode'];
$pricetotal  = $_POST['pricetotal'];
$disprice    = $_POST['disprice'];

if(isset($_SESSION['bee_member'])){ 
	$memberid = $_SESSION['bee_member']; 
}else{ 
	$memberid  = ""; 
}
if(isset($_SESSION['bee_name'])){ $membername = $_SESSION['bee_name']; }else{ $membername =""; }
if(isset($_SESSION['bee_phone'])){ $memberphone = $_SESSION['bee_phone']; }else{ $memberphone = ""; }
if($pricetotal == $disprice OR $couponCode == '')
{
	$finshprice = $pricetotal;
}else{
	$finshprice = $disprice;

}

$order = '{"prods":['; 
foreach($_SESSION['product_item'] as $row)
{
	$price = $row['price'];
	$count = $row['count'];
	$itmetotal = intval($price) * intval($count);
	$order .= '{"pid":'.$row['id'].',"pname":"'.$row['pname'].'","opts":["'.$row['opts'].'","'.$row['price'].'"],"cnt":'.$row['count'].',"cnt_price":'.$itmetotal.',"img":"'.$row['images'].'"},';
}
$order = substr($order, 0, -1);
$order .= '],"adds":[],"totalprice":'.$disprice.'}'; 

$post = array(
		"oid"          => "p".date('Y').date('m').date('d').date('H').date('i').date('s'),
		"mid"          => $memberid,
		"mname"        => $membername,
		"mphone"       => $memberphone,
		"oname"        => $name,
		"ophone"       => $tel,
		"addr"         => $address,
		"total"        => $finshprice,
		"content"      => $order,
		"pay_method"   => "", 
		"time_limited" => "", 
		"rtncode"      => "", 
		"green_info"   => "", 
		"memo"         => $message,
		"gift"         => '0',
		"cdate"        => date('Y-m-d H:i:s'),
	);
	$db->insert('orders',$post);
?>