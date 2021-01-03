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
    <tr>
    <td>IDMember</td>
    <td>Username</td>
    <td>CreateDate </td>
    <td>LastUpdate</td>
    <td>Amount_FixDep</td>
    <td>Amount_Insura</td>
    <td>Receive</td>
    <td>DepositStatus</td>
    <td>IDDeposti_FixDep</td>
    <td>IDDeposti_Insura</td>
    <td>IDRegFund_FixDep</td>
    <td>IDRegFund_Insura</td>
    </tr>
    <?php 
if($date_find==""){
  $now_data=date('Y-m-d');
}else{
  $now_data=$date_find;
}
/*
    
    1. ดึงข้อมูลทุกคนว่ามีบัญชีอะไรบ้าง 
        1.1 ค้นข้อมูลตรงกับวัน 
        1.1 SQLCountDeposit นับรายชื่อผู้ฝาก ไม่ซ้ำจำนวน ณ วันที่เลือก 
    2. นับจำนวน IDMemeber ที่ไม่ซ้ำกัน 
    3. loop รอบการแสดงผล 
        3.1 IDMember แสดงยอด + เวลา + IDregFund
        3.2 input ลงใน array 
        3.3 แสดงผลใหม่หน้าจอ + แสดงแถวโคท 
    4. ทำรายการโอน  



*/    
$show_sql = "select * from regfund Order by IDFund";
$show_query = mysqli_query($link, $show_sql);
// echo $sql2;
// print_r($show_query);
// echo $show_query->num_rows;

while ($rsq=mysqli_fetch_array($show_query)) {
  $LoopIDFund[$rsq['IDMember']]=$rsq['IDFund'];
}
// ได้ loop ของแต่ละยอดแล้ว 
    // echo "<pre>";
    // print_r($IDRegFund_array);
    // echo "</pre>";
    // exit();

$sql1 = "select  r.*, d.*  from deposit as d, RegFund as r 
        where d.IDRegFund=r.IDRegFund and d.CreateDate='$now_data' 
        ORDER BY  d.IDDeposit ASC ";
    // $sql = "select  * from deposit where CreateDate='$now_data' ORDER BY IDDeposit DESC ";
// echo $sql;
$QueryInput = mysqli_query($link, $sql1);
$num=0; $sum1=0; $sum2=0; $x1=0;
while($rs1 = mysqli_fetch_array($QueryInput))
{
    // echo "<pre>";
    // print_r($rs1);
    // echo "</pre>";
    // exit();
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
$QueryInput1 = mysqli_query($link, $SQLCountDeposit);
// echo mysqli_num_rows($QueryInput1);
$num=1;

while($rs2 = mysqli_fetch_array($QueryInput1)){
    $c1=1;
    // echo $num;
    // echo ";";
    for($a1=0;$a1<count($SQL_input1);$a1++){
        if($SQL_input1[$a1]['IDMember']==$rs2['IDMember']){
            if($c1==1){
                // echo "[".$c1."]";
                $AmountArray[$c1]=$SQL_input1[$a1]['IDMember'];
                $UsernameArr[$c1]= $SQL_input1[$a1]['Username'];
                $CreateDateArr[$c1]= $SQL_input1[$a1]['CreateDate'];
                $LastUpdateArr[$c1]= $SQL_input1[$a1]['LastUpdate'];
                $DepositStatusArr[$c1]= $SQL_input1[$a1]['DepositStatus'];
                $ReceiveArr[$c1]= $SQL_input1[$a1]['Receive'];
                
            }else if($c1==3){
                // echo "<br>";
                // echo $num; $num++;
                // echo ";";
                // echo "[".$c1."]";
                $AmountArray[$c1]=$SQL_input1[$a1]['IDMember'];
                $UsernameArr[$c1]= $SQL_input1[$a1]['Username'];
                $CreateDateArr[$c1]= $SQL_input1[$a1]['CreateDate'];
                $LastUpdateArr[$c1]= $SQL_input1[$a1]['LastUpdate'];
                $DepositStatusArr[$c1]= $SQL_input1[$a1]['DepositStatus'];
                $ReceiveArr[$c1]=$SQL_input1[$a1]['Receive'];
            }
            // echo ";";
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
    // echo "/";
    // echo count($AmountArray);
    // echo "/";
    // print_r($AmountArray);
    // print_r($IDRegFundArray);
    // print_r($IDDepositArray);




    if(count($AmountArray)==1){
        $Amount_FixDep=$AmountArray[1];    
        $Amount_InSur='';     
        $IDDeposit_FixDep=$IDDepositArray[1];
        $IDDeposit_InSur='';        
        $IDRegFund_FixDep=$IDRegFundArray[1];  
        $IDRegFund_InSur='';

        echo "[".count($AmountArray)."]";
        // echo $num;
        // echo ";";   
        echo "('','".$IDMember."','".$Username."','".$CreateDate."','".$LastUpdate
        ."','".$Amount_FixDep."','".$Amount_InSur."','".$Receive."','".$DepositStatus
        ."','".$IDDeposit_FixDep."','".$IDDeposit_InSur."','".$IDRegFund_FixDep."','".$IDRegFund_InSur."');";


    }else if(count($AmountArray)==2){
        $Amount_FixDep=$AmountArray[1];    
        $Amount_InSur=$AmountArray[2];     
        $IDDeposit_FixDep=$IDDepositArray[1];
        $IDDeposit_InSur=$IDDepositArray[2];        
        $IDRegFund_FixDep=$IDRegFundArray[1];  
        $IDRegFund_InSur=$IDRegFundArray[2];

        echo "[".count($AmountArray)."]";
        // echo $num;
        // echo ";";        
        echo "('','".$IDMember."','".$Username."','".$CreateDate."','".$LastUpdate
        ."','".$Amount_FixDep."','".$Amount_InSur."','".$Receive."','".$DepositStatus
        ."','".$IDDeposit_FixDep."','".$IDDeposit_InSur."','".$IDRegFund_FixDep."','".$IDRegFund_InSur."');";

    }else if(count($AmountArray)==4){
        $Amount_FixDep=$AmountArray[1];    
        $Amount_InSur=$AmountArray[2];     
        $IDDeposit_FixDep=$IDDepositArray[1];
        $IDDeposit_InSur=$IDDepositArray[2];        
        $IDRegFund_FixDep=$IDRegFundArray[1];  
        $IDRegFund_InSur=$IDRegFundArray[2];

        echo "[".count($AmountArray)."]";   
        // echo $num;
        // echo ";";
        echo "('','".$IDMember."','".$Username."','".$CreateDate."','".$LastUpdate
        ."','".$Amount_FixDep."','".$Amount_InSur."','".$Receive."','".$DepositStatus
        ."','".$IDDeposit_FixDep."','".$IDDeposit_InSur."','".$IDRegFund_FixDep."','".$IDRegFund_InSur."');";

        
        $Amount_FixDep=$AmountArray[3];    
        $Amount_InSur=$AmountArray[4];     
        $IDDeposit_FixDep=$IDDepositArray[3];
        $IDDeposit_InSura=$IDDepositArray[4];        
        $IDRegFund_FixDep=$IDRegFundArray[3];  
        $IDRegFund_InSur=$IDRegFundArray[4];
       
        $num++;
        echo "<br>";
        echo "[".count($AmountArray)."]";   
        // echo $num;
        // echo ";";
        echo "('','".$IDMember."','".$Username."','".$CreateDate."','".$LastUpdate
        ."','".$Amount_FixDep."','".$Amount_InSur."','".$Receive."','".$DepositStatus
        ."','".$IDDeposit_FixDep."','".$IDDeposit_InSur."','".$IDRegFund_FixDep."','".$IDRegFund_InSur."');";
        }
    $num++;
    echo "<br>";
    $AmountArray=null;
    $IDRegFundArray=null;
    $IDDepositArray =null;
}
exit();

mysqli_close($link);
?>             
                  </tbody>
                </table>
            </div>
          </div>

<?PHP 
include('../tmp_dsh2/footer.php');
?>