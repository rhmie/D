<?php session_start(); ?>
<?php
   include('../check_ref.php');
   
    if (!isset($_SESSION['bee_admin'])){
        exit('<h1>登入逾期，請重新登入</h1>');
    }

    $_SESSION['bee_member'] = $_GET['mid'];
    header("Location: ../index.php");

 ?>