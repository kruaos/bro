<?php 
session_start();
session_id();
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

// $employee_use=$_SESSION['employee_USER'];
// $IDMember= $_POST['IDMember_Dep'];
$IDDeposit= $_GET['IDDeposit'];

$SqlShowTable = "SELECT * from deposit where IDDeposit ='$IDDeposit'";
$QueryShowTable = mysqli_query($link, $SqlShowTable);
while ($RS1 = mysqli_fetch_array($QueryShowTable)){
    // echo "<pre>";
    // print_r($RS1);
    // echo "</pre>";

$IDRegFund=$RS1['IDRegFund'];
$Username=$RS1['Username'];
$CreateDate=$RS1['CreateDate'];
$LastUpdate=$RS1['LastUpdate'];
$Amount=$RS1['Amount'];
$Receive=$RS1['Receive'];
$DepositStatus=$RS1['DepositStatus'];

}
                

$LogIDDeposit=""                   ;
// $IDRegFund                  ;
// $Username                   ;
// $CreateDate                 ;
// $LastUpdate                 ;
// $Amount                 ;
// $Receive                    ;
// $DepositStatus                  ;

$SqlDelDeposit="DELETE  from deposit where IDDeposit=$IDDeposit";
$SqlLogDelDeposit="INSERT INTO 'LogDeposit' ('LogIDDeposit','IDDeposit', 'IDRegFund', 'Username', 'CreateDate', 'LastUpdate', 'Amount', 'Receive', 'DepositStatus') 
VALUES ('$LogIDDeposit','$IDDeposit', '$IDRegFund', '$Username', '$CreateDate', '$LastUpdate', '$Amount', '$Receive', '$DepositStatus');
";

// $queryDelDeposit=mysqli_query($link,$SqlDelDeposit);
// echo $SqlDelDeposit;
echo $SqlLogDelDeposit;


?>