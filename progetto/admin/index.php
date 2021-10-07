<?php
require_once '../core/init.php';
if(!is_logged_id()){
  header('Location: login.php');
}
include 'includes/head.php';
include 'includes/navigation.php';

 ?>
<br><h2 style="color: #ffff;   background: #DB2222;  margin : auto; font-family: Helvetica, Arial, sans-serif;   font-weight: bold;   font-style : italic; font-size:20px;"><center>Home Amministratore</center></h2>
<hr><?php include 'includes/footer.php'; ?>
