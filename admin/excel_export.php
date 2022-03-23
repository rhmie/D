<?php session_start(); ?>
<?php

	include('../mysql.php');

	$result	=	Array();

	if (!isset($_SESSION['bee_admin'])){
		$result['err_msg']	=	'-1';
	    exit(json_encode($result));
	}

	$filename = "orders";  //your_file_name
	$file_ending = "xls";   //file_extention

	header("Content-Type: application/xls");    
	header("Content-Disposition: attachment; filename=".$_POST['table'].".xls");  
	header("Pragma: no-cache"); 
	header("Expires: 0");

	$sep = "\t";

	$sql 	=	'SELECT * FROM '.$_POST['table'];

	if (!empty($_POST['range1']) && !empty($_POST['range2'])){
		$f1 = new DateTime($_POST['range1']);
		$f2 = new DateTime($_POST['range2']);
		$f1->modify('-1 day');
		$f2->modify('+1 day');

		$sql .=	' WHERE cdate > "'.$f1->format('Y-m-d').'" AND cdate < "'.$f2->format('Y-m-d').'"';
	}

	$result = $mysqli->query($sql);

	while ($property = mysqli_fetch_field($result)) { //fetch table field name
	    echo $property->name."\t";
	}

	print("\n");

	while($row = mysqli_fetch_row($result))  //fetch_table_data
	{
	    $schema_insert = "";
	    for($j=0; $j< mysqli_num_fields($result);$j++)
	    {
	        if(!isset($row[$j]))
	            $schema_insert .= "NULL".$sep;
	        elseif ($row[$j] != "")
	            $schema_insert .= "$row[$j]".$sep;
	        else
	            $schema_insert .= "".$sep;
	    }
	    $schema_insert = str_replace($sep."$", "", $schema_insert);
	    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
	    $schema_insert .= "\t";
	    print(trim($schema_insert));
	    print "\n";
	}  


?>