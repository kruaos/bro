<?php 
ob_start();
include('../config/config.php');
date_default_timezone_set("Asia/Bangkok");
mysqli_set_charset($link,'utf8');


$IDLoanPay=$_POST['IDLoanPay'];
$RefNo=$_POST['RefNo'];
$Username=$_POST['Username'];
$InstalmentNo= str_replace(',', '', $_POST['InstalmentNo']);
$Interest= str_replace(',', '', $_POST['instal_loan']);
$Payment= str_replace(',', '', $_POST['amount_loan']);
$PayTotal= str_replace(',', '', $_POST['Payment_loan']);
$PayInterest= str_replace(',', '', $_POST['instal_loan']);
$InterestOutst=0;
$CreateDate=date('Y-m-d');
$LastUpdate=date('Y-m-d');	
$ReceiveStatus="I";

$sql= "UPDATE loanpayment  set PayTotal='$PayTotal' , Payment='$Payment' , Interest='$Interest' where IDLoanPay='$IDLoanPay';";

// print_r($sql);
// exit();
$result = mysqli_query($link, $sql);
	if ($result)
	{
		// echo "is ok";
		header( "location: loan-pay-tool.php" );
		mysqli_close($link);
		exit(0);
	}else{
		echo "i'am not";
		mysqli_close($link);
		exit(0);
	}
?>