<?php include('./include.php');?>
<?php 
$action = $_GET['action'];

if($action == 'add'){
	foreach($_POST['data'] as $key => $row)
	{
		$check = 0 ;
		$product = $db->where('id',$row['id'])->getone('products');
		$post = array(
			'id' => $product['id'],
			'pname' => $product['pname'],
			'price' => $product['price'],
			'images' => $product['images'],
			'opts'  => $product['opts'],
			'count' => 1,

		);
		foreach($_SESSION['product_item'] as $value)
		{

			if(in_array($row['id'],$value) == true)
			{
				$check = 1 ;
				break;
			}

		}
		if($check == 0)
		{
			array_push($_SESSION['product_item'] , $post);
		}
	}
	print_r($_SESSION['product_item']);
}
if($action == 'del')
{
	$product = $db->where('pname',$_POST['name'])->where('price',$_POST['price'])->getone('products');
	foreach($_SESSION['product_item'] as $key => $row)
	{

		if(in_array($_POST['name'],$row) == true AND in_array($_POST['price'],$row) == true)
		{
			unset($_SESSION['product_item'][$key]);
		}

	}
}
if($action == 'delall')
{
	$_SESSION['product_item'] = array();
}
if($action == 'update')
{
	$i = 0 ;
	foreach($_SESSION['product_item'] as $row)
	{
		if($row['id'] == $_POST['id'])
		{
			break;
		}
		$i++;
	}
	if($_SESSION['product_item'][$i]['count'] >= 0  )
	{
		$_SESSION['product_item'][$i]['count'] = $_POST['count'];
	}else{
		$_SESSION['product_item'][$i]['count'] = 0; 
	}
	print_r($_SESSION['product_item']);
}
if($action == 'reload')
{
	$i = 0 ;
	foreach($_SESSION['product_item'] as $row)
	{
		$_SESSION['product_item'][$i]['count'] = 1;
		$i++;
	}
	
}

?>