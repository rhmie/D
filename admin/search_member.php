<?php session_start(); ?>
<?php
    if (!isset($_SESSION['bee_admin'])){
        exit('-1');
    } 

    include('../check_ref.php');
    include('../mysql.php');
    require_once ('../MysqliDb.php');
    $db = new MysqliDb($mysqli);

    if (isset($_POST['searchbox'])){
        $mname = $_POST['searchbox'];
        $db->where ("mname", '%'.$mname.'%', 'like');
        $db->orderBy('id', 'desc');
        $members = $db->get('members');
    }

    if (isset($_POST['search_idbox'])){
        $sid = (int)$_POST['search_idbox'];
        $members = $db->where('id', $sid)->get('members');
        
    }
    
    $fbox = '';

    include('./put_members.php');

    echo $fbox;

  ?>