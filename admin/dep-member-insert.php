<?php 
echo "<pre>";
print_r($_POST);
echo "</pre>";

include('../config/config.php');


$IDMember=$_POST['IDMember'];
$Title=$_POST['title'];
$Firstname=$_POST['Firstname'];
$Lastname=$_POST['Lastname'];
$AddressNum=$_POST['AddressNum'];
$AddressGroup=$_POST['AddressGroup'];
$Tambol=$_POST['Tambol'];
$Amphur=$_POST['Amphur'];
$Province=$_POST['Province'];
$Birthday=$_POST['Birthday'];
$ExpireDate=$_POST['ExpireDate'];
$MemberStatus=$_POST['MemberStatus'];
$Comment=$_POST['Comment'];
$CreateDate=$_POST['CreateDate'];
$LastUpdate=$_POST['LastUpdate'];
$IDCard=$_POST['IDCard'];
$DateResign=$_POST['DateResign'];

$sqlInsert="INSERT INTO dep_member VALUE (
    '$IDMember', 
    '$Title', '$Firstname', '$Lastname', 
    '$AddressNum', '$AddressGroup', '$Tambol', '$Amphur', '$Province', 
    '$Birthday', '$ExpireDate', '$MemberStatus', 
    '$Comment', '$CreateDate', '$LastUpdate', 
    '$IDCard', '$DateResign'
)";
$result = mysqli_query($link, $sqlInsert);
if($result){
    echo"y";
}else{
    echo $sqlInsert;
    
}

