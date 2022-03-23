<?php session_start(); ?>
<?php
    if (!isset($_SESSION['bee_admin'])){
        exit('-1');
    } 
    include('../check_ref.php');
    include('../mysql.php');
    require_once ('../MysqliDb.php');
    $db = new MysqliDb($mysqli);

    $icount = (int)$_POST['icount'];
    $db->orderBy('id', 'desc');
    $members = $db->get('members', Array($icount, 8));
    $fbox = '';

	include("./put_members.php");

	echo $fbox;

?>