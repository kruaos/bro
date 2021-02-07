<?php 
include('../config/config.php');

$sql="SELECT * FROM `deposit` where username='183461' and `CreateDate`='2021-02-07' ";
$query = mysqli_query($link, $sql);
// print_r($query);

while ($rs1 = mysqli_fetch_array($query)) {
    // echo "<pre>";
    $IDDeposit=$rs1['IDDeposit'];
    // echo $IDDeposit=$rs1['Username'];
    echo "UPDATE `finance`.`deposit` SET `Username` = 'oper5' WHERE `deposit`.`IDDeposit` =$IDDeposit LIMIT 1 ; ";
    
    echo "<br>";
    // echo "</pre>";
} 

?>