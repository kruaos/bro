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

$SqlDelDeposit="DELETE  from deposit where IDDeposit=$IDDeposit";
// $queryDelDeposit=mysqli_query($link,$SqlDelDeposit);
echo $SqlDelDeposit;


?>