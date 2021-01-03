<?php 
session_start();
session_id();

$_SESSION['LoanEmplopeeUser']=$_POST['LoanEmplopeeUser'];
// $_SESSION['income_array']=$income_dep_array;

header( "location: loan-pay-tool.php" );

?>