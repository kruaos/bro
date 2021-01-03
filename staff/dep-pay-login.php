<?php 
session_start();
session_id();

$_SESSION['employee_USER']=$_POST['employee_USER'];
$_SESSION['income_array']=$income_dep_array;

header( "location: dep-pay-tool.php" );

?>