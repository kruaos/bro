<?php 
ob_start();
include('../config/config.php');
date_default_timezone_set("Asia/Bangkok");
mysqli_set_charset($link,'utf8');

$RefNo=$_GET['RefNo'];
$LoanStatus="C";
$LastUpdate=date('Y-m-d');

$sql= "UPDATE loanbook  set LoanStatus='$LoanStatus', LastUpdate='$LastUpdate' where RefNo='$RefNo';";

// print_r($sql);
// exit();
$result = mysqli_query($link, $sql);
	if ($result)
	{
		// echo "is ok";
		header( "location: loan-late-show1.php" );
		mysqli_close($link);
		exit(0);
	}else{
		echo "i'am not";
		mysqli_close($link);
		exit(0);
	}
?>