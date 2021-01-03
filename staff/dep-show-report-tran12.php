<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

?>
<div class="container-fluid">
<?php 
function show_day($showday){
  $m_name = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  echo  number_format(substr($showday, 8,2))."  ".$m_name[number_format(substr($showday, 5,2))]." ".(substr($showday, 0,4)+543);

}
if(isset($_GET['tran_date'])){
  $date_find=$_GET['tran_date'];
}else{
  $date_find="";
}

?>              
<h4 class="m-0 font-weight-bold text-primary">รายละเอียดสมาชิกสัจจะ เพื่อโอน <?php echo$date_find;?></h4>

<form>
  <input type="date" name="tran_date">
  <input type="submit">
</form>
<div class="row">

<table class="table table-sm"   cellspacing="0">
    <?php 
if($date_find==""){
  $now_data=date('Y-m-d');
}else{
  $now_data=$date_find;
}
$show_sql = "select * from regfund Order by IDFund";
$show_query = mysqli_query($link1, $show_sql);

while ($rsq=mysqli_fetch_array($show_query)) {
  $LoopIDFund[$rsq['IDMember']]=$rsq['IDFund'];
}

$sql1 = "select  r.*, d.*  from deposit as d, RegFund as r 
        where d.IDRegFund=r.IDRegFund and d.CreateDate='$now_data' 
        ORDER BY  d.IDDeposit ASC ";
    // $sql = "select  * from deposit where CreateDate='$now_data' ORDER BY IDDeposit DESC ";
// echo $sql;
$QueryInput = mysqli_query($link1, $sql1);
$num=0; $sum1=0; $sum2=0; $x1=0;
while($rs1 = mysqli_fetch_array($QueryInput))
{
    $IDMember=$rs1['IDMember'];
    $Username=$rs1['Username'];
    $CreateDate=$rs1['CreateDate'];
    $LastUpdate=$rs1['LastUpdate'];
    $Amount=$rs1['Amount'];
    $Receive=$rs1['Receive'];
    $DepositStatus=$rs1['DepositStatus'];
    $IDDeposit=$rs1['IDDeposit'];
    $IDRegFund=$rs1['IDRegFund'];

    $SQL_input1[$x1]=array('IDMember'=>$IDMember,'Username'=>$Username,
    'CreateDate'=>$CreateDate,'LastUpdate'=>$LastUpdate, 'Amount'=>$Amount, 
    'DepositStatus'=>$DepositStatus, 'IDDeposit'=>$IDDeposit, 'IDRegFund'=>$IDRegFund,'Receive'=>$Receive);
    $SQL_input2[$x1]=array($IDMember,$Username,$CreateDate,$LastUpdate,$Amount,$DepositStatus,$IDDeposit,$IDRegFund,$Receive);
    $SQL_input_amount[$x1]=array('Amount'=>$Amount,'IDDeposit'=>$IDDeposit, 'IDRegFund'=>$IDRegFund);

  $x1++;
}
$SQLCountDeposit = "select  r.*, d.*  from deposit as d, RegFund as r 
                    where d.IDRegFund=r.IDRegFund and d.CreateDate='$now_data' 
                    group by r.IDMember ORDER BY  d.IDDeposit ASC ";
$QueryInput1 = mysqli_query($link1, $SQLCountDeposit);
$num=1;

while($rs2 = mysqli_fetch_array($QueryInput1)){
    $c1=1;

    for($a1=0;$a1<count($SQL_input1);$a1++){
        if($SQL_input1[$a1]['IDMember']==$rs2['IDMember']){
            $AmountArray[$c1]=$SQL_input1[$a1]['Amount'];
            $IDDepositArray[$c1]=$SQL_input1[$a1]['IDDeposit'];
            $IDRegFundArray[$c1]=$SQL_input1[$a1]['IDRegFund'];
            $c1++;
        }
    }
    $IDMember= $rs2['IDMember'];
    $Username= $rs2['Username'];
    $CreateDate= $rs2['CreateDate'];
    $LastUpdate= $rs2['LastUpdate'];
    $DepositStatus= $rs2['DepositStatus'];
    $Receive= $rs2['Receive'];
  
    if(count($AmountArray)==1){
        $Amount_FixDep=$AmountArray[1];    
        $Amount_InSur='';     
        $IDDeposit_FixDep=$IDDepositArray[1];
        $IDDeposit_InSur='';        
        $IDRegFund_FixDep=$IDRegFundArray[1];  
        $IDRegFund_InSur='';

        // echo "[".count($AmountArray)."]";
        // echo $num;
        // echo ";";   
        $send_tran[$num]= "('','".$IDMember."','".$Username."','".$CreateDate."','".$LastUpdate
        ."','".$Amount_FixDep."','".$Amount_InSur."','".$Receive."','".$DepositStatus
        ."','".$IDDeposit_FixDep."','".$IDDeposit_InSur."','".$IDRegFund_FixDep."','".$IDRegFund_InSur."');";


    }else if(count($AmountArray)==2){
        $Amount_FixDep=$AmountArray[1];    
        $Amount_InSur=$AmountArray[2];     
        $IDDeposit_FixDep=$IDDepositArray[1];
        $IDDeposit_InSur=$IDDepositArray[2];        
        $IDRegFund_FixDep=$IDRegFundArray[1];  
        $IDRegFund_InSur=$IDRegFundArray[2];

        // echo "[".count($AmountArray)."]";
        // echo $num;
        // echo ";";        
        $send_tran[$num]= "('','".$IDMember."','".$Username."','".$CreateDate."','".$LastUpdate
        ."','".$Amount_FixDep."','".$Amount_InSur."','".$Receive."','".$DepositStatus
        ."','".$IDDeposit_FixDep."','".$IDDeposit_InSur."','".$IDRegFund_FixDep."','".$IDRegFund_InSur."');";

    }else if(count($AmountArray)==4){
        $Amount_FixDep=$AmountArray[1];    
        $Amount_InSur=$AmountArray[2];     
        $IDDeposit_FixDep=$IDDepositArray[1];
        $IDDeposit_InSur=$IDDepositArray[2];        
        $IDRegFund_FixDep=$IDRegFundArray[1];  
        $IDRegFund_InSur=$IDRegFundArray[2];

        // echo "[".count($AmountArray)."]";   
        // echo $num;
        // echo ";";
        $send_tran[$num]= "('','".$IDMember."','".$Username."','".$CreateDate."','".$LastUpdate
        ."','".$Amount_FixDep."','".$Amount_InSur."','".$Receive."','".$DepositStatus
        ."','".$IDDeposit_FixDep."','".$IDDeposit_InSur."','".$IDRegFund_FixDep."','".$IDRegFund_InSur."');";

        
        $Amount_FixDep=$AmountArray[3];    
        $Amount_InSur=$AmountArray[4];     
        $IDDeposit_FixDep=$IDDepositArray[3];
        $IDDeposit_InSura=$IDDepositArray[4];        
        $IDRegFund_FixDep=$IDRegFundArray[3];  
        $IDRegFund_InSur=$IDRegFundArray[4];
       
        $num++;
        // echo "<br>";
        // echo "[".count($AmountArray)."]";   
        // echo $num;
        // echo ";";
        $send_tran[$num]="('','".$IDMember."','".$Username."','".$CreateDate."','".$LastUpdate
        ."','".$Amount_FixDep."','".$Amount_InSur."','".$Receive."','".$DepositStatus
        ."','".$IDDeposit_FixDep."','".$IDDeposit_InSur."','".$IDRegFund_FixDep."','".$IDRegFund_InSur."');";
        }


    $num++;
    // echo "<br>";
    $AmountArray=null;
    $IDRegFundArray=null;
    $IDDepositArray =null;
}
include('../config/config.php');

// echo count($send_tran);
// exit();
for($c1=1;$c1<=count($send_tran);$c1++) {
    $date_insert="insert into `deposit_n`(`IDDeposit`, `IDMember`, `Username`,
    `CreateDate`, `LastUpdate`, `Amount_FixDep`, 
    `Amount_Insura`, `Receive`, `DepositStatus`, `IDDeposit_FixDep`, `IDDeposit_Insura`, 
    `IDRegFund_FixDep`, `IDRegFund_Insura`) VALUES".$send_tran[$c1];
    // echo $date_insert;
    // $result = mysqli_query($link2, $date_insert);
    // exit();
  }
  // echo $date_insert;
  // include('../config/config.php');
  if ($result){
    echo "<center><span class='h1'>บันทึกข้อมูลเรียบร้อย<br></span>";
    mysqli_close($link);
    mysqli_close($link1);
    mysqli_close($link2);
    // echo "<a href='bank-show.php?' class='btn btn-success'>ย้อนกลับ</a>";
    exit(0);
    }else{
    echo $date_insert;
    echo "<center><span class='h1'>ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้<br></span>";
    // echo "<a href=../bank/addmember.php></a>";
    mysqli_close($link);
    mysqli_close($link1);
    mysqli_close($link2);      // echo "<a href='bank-member-add.php?bankid=".$bankid."' class='btn btn-danger' >ย้อนกลับ</a>";
    }




    mysqli_close($link);
    mysqli_close($link1);
    mysqli_close($link2);    ?>             
                  </tbody>
                </table>
            </div>
          </div>

<?PHP 
include('../tmp_dsh2/footer.php');
?>