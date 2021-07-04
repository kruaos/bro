<?php 
session_start();
session_id();
// include('../tmp_dsh2/header.php');
// include('navbar.php');
// include('menu.php');
include('../config/config.php');

// $employee_use=$_SESSION['employee_USER'];
// $IDMember= $_POST['IDMember_Dep'];
// $IDDeposit= $_GET['IDDeposit'];

// $SqlShowTable = "SELECT * from deposit where IDDeposit ='$IDDeposit'";
// $QueryShowTable = mysqli_query($link, $SqlShowTable);
// while ($RS1 = mysqli_fetch_array($QueryShowTable)){
//     // echo "<pre>";
//     // print_r($RS1);
//     // echo "</pre>";
//     $IDLoanPay=$_GET['IDLoanPay'];
//     $IDMember=$_GET['IDMember'];
//     $RefNo=$_GET['RefNo'];
// }
                
$IDLoanPay=$_GET['IDLoanPay'];
$IDMember=$_GET['IDMember'];
$RefNo=$_GET['RefNo'];
// $LogIDDeposit=""                   ;
// $IDRegFund                  ;
// $Username                   ;
// $CreateDate                 ;
// $LastUpdate                 ;
// $Amount                 ;
// $Receive                    ;
// $DepositStatus                  ;

$SqlDelLoan="DELETE  from loanpayment where IDLoanPay=$IDLoanPay";
// $SqlLogDelDeposit="INSERT INTO 'LogDeposit' ('LogIDDeposit','IDDeposit', 'IDRegFund', 'Username', 'CreateDate', 'LastUpdate', 'Amount', 'Receive', 'DepositStatus') VALUES ('$LogIDDeposit','$IDDeposit', '$IDRegFund', '$Username', '$CreateDate', '$LastUpdate', '$Amount', '$Receive', '$DepositStatus');";

// echo $SqlDelLoan;

mysqli_query($link,$SqlDelLoan);

// echo $SqlDelDeposit;
// echo $SqlLogDelDeposit;
header("location: loan-pay-tool.php");
exit(0);



?>