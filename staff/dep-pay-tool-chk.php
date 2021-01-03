<?php 
session_start();
session_id();
include('../config/config.php');

$IDMember= $_POST['IDMember_Dep'];
$employee_use=$_SESSION['employee_USER'];

$SRFArray=array();
// Check IDMember is 1) type member  dep 2) type member  dep+ins 3) type member  dep + ins + lat  

$ShowMember="select m.Title, m.Firstname, m.Lastname, m.MemberStatus 
from Member as m where  m.IDMember=$IDMember";
$SMQuery= mysqli_query($link, $ShowMember);
while ($SM= mysqli_fetch_array($SMQuery)){
    $FullNameMember=$SM['Title'].$SM['Firstname']." ".$SM['Lastname'];
    echo $SM['MemberStatus'];
    echo "<br>";
}
$n=1;
$ShowRegfund="select * from regfund where  IDMember=$IDMember order by IDFund ASC";
$SRfQuery= mysqli_query($link, $ShowRegfund);
while ($SRf= mysqli_fetch_array($SRfQuery)){
    $SRFArray[$n]['IDRegFund']= $SRf['IDRegFund'];
    $SRFArray[$n]['IDFund']= $SRf['IDFund'];
    $SRFArray[$n]['LastUpdate']= $SRf['LastUpdate'];
    $SRFArray[$n]['Closedate']= $SRf['Closedate'];
    $SRFArray[$n]['Balance']= $SRf['Balance'];

    echo $SRf['IDRegFund']." | ";
    echo $SRf['IDFund']." | ";
    echo $SRf['LastUpdate']." | ";
    echo $SRf['Balance'];
    echo "<br>";
    $n++;
}
echo count($SRFArray);
echo"<pre>";
print_r($SRFArray);
echo"</pre>";

$IDDeposit1="";
$IDRegFund1=$SRFArray[1]['IDRegFund'];
$Username1=$employee_use;
$CreateDate1 = date('Y-m-d');
$LastUpdate1 = date('Y-m-d'); 
$Amount1="30";
$Receive1="I";
$DepositStatus1="P";

$IDDeposit2="";
$IDRegFund2=$SRFArray[2]['IDRegFund'];
$Username2=$employee_use;
$CreateDate2= date('Y-m-d');
$LastUpdate2= date('Y-m-d'); 
$Amount2="5";
$Receive2="I";
$DepositStatus2="P";

// $SQLInsertDataDeopsit1="INSERT INTO `deposit`(`IDDeposit`, `IDRegFund`, `Username`, `CreateDate`, `LastUpdate`, `Amount`, `Receive`, `DepositStatus`) 
// VALUES ('$IDDeposit1','$IDRegFund1','$Username1','$CreateDate1','$LastUpdate1','$Amount1','$Receive1','$DepositStatus1')";
// echo $SQLInsertDataDeopsit1;
// echo "<br>";
// $SQLInsertDataDeopsit2="INSERT INTO `deposit`(`IDDeposit`, `IDRegFund`, `Username`, `CreateDate`, `LastUpdate`, `Amount`, `Receive`, `DepositStatus`) 
// VALUES ('$IDDeposit2','$IDRegFund2','$Username2','$CreateDate2','$LastUpdate2','$Amount2','$Receive2','$DepositStatus2')";
// echo $SQLInsertDataDeopsit2;
// echo "<br>";

$SQLInsertDataDeopsit3="INSERT INTO `deposit`(`IDDeposit`, `IDRegFund`, `Username`, `CreateDate`, `LastUpdate`, `Amount`, `Receive`, `DepositStatus`) 
VALUES 
('$IDDeposit1','$IDRegFund1','$Username1','$CreateDate1','$LastUpdate1','$Amount1','$Receive1','$DepositStatus1'),
('$IDDeposit2','$IDRegFund2','$Username2','$CreateDate2','$LastUpdate2','$Amount2','$Receive2','$DepositStatus2')";
echo $SQLInsertDataDeopsit3;

// การค้นหา ต้องดูว่า IDFund == 1 จะเป็นตัวหลัก


// echo "INSERT INTO `deposit`(`IDDeposit`, `IDRegFund`, `Username`, `CreateDate`, `LastUpdate`, `Amount`, `Receive`, `DepositStatus`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8])";

/*
    ติดปัญหา สำหรับการดึงข้อมูลจาก regfund ไม่สามารถเลือกได้ว่า อันไหน คือส่วนของ 
    ฐานข้อมูลที่ต้องใช้ จะต้องแก้ปัยหา โดยการ นำข้อมูล ใส่ array 
*/


// $StatusIDMember='1';

// if ($StatusIDMember==1){
//     echo "1";
// }else if ($StatusIDMember==2){
//     echo "2";
// }else if ($StatusIDMember==3){
//     echo "3";
// }else{
//     echo "eof";
// }



?>