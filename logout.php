<?php session_start(); ?>
<?php
$_SESSION['bee_member'] = NULL; 
$_SESSION['bee_name']  = NULL;
$result['err_msg'] = 'OK';

echo json_encode($result);
?>