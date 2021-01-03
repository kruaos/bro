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

    $SQL_input1[$x1]=array('IDMember'=>$IDMember,'Username'=>$Username,'CreateDate'=>$CreateDate,'LastUpdate'=>$LastUpdate, 'Amount'=>$Amount, 
    'DepositStatus'=>$DepositStatus, 'IDDeposit'=>$IDDeposit, 'IDRegFund'=>$IDRegFund,'Receive'=>$Receive);
    $SQL_input2[$x1]=array($IDMember,$Username,$CreateDate,$LastUpdate,$Amount,$DepositStatus,$IDDeposit,$IDRegFund,$Receive);
    $SQL_input_amount[$x1]=array('Amount'=>$Amount,'IDDeposit'=>$IDDeposit, 'IDRegFund'=>$IDRegFund);

  $x1++;
}
$SQLCountDeposit = "select  r.*, d.*  from deposit as d, RegFund as r 
                    where d.IDRegFund=r.IDRegFund and d.CreateDate='$now_data' 
                    group by r.IDMember ORDER BY  d.IDDeposit ASC ";
$QueryInput1 = mysqli_query($link, $SQLCountDeposit);
$num1=1;
    while($rs2 = mysqli_fetch_array($QueryInput1)){
        $IDMember=$rs2['IDMember'];
        // echo " [".$num1."] "; 
        $x2=1;
        for($a1=0;$a1<count($SQL_input1);$a1++){
            if($IDMember==$SQL_input1[$a1]['IDMember']){
                if($x2==3){
                    // echo "<br>";
                    $num1++;
                    // echo " [".$num1."] "; 
                }
                
                // echo " [".$x2."] "; 
                // echo $SQL_input[$a1]['IDMember'];
                // echo $SQL_input[$a1]['Username'];
                // echo $SQL_input[$a1]['CreateDate'];
                // echo $SQL_input[$a1]['LastUpdate'];
                // echo $SQL_input[$a1]['Amount'];
                // echo $SQL_input[$a1]['DepositStatus'];
                // echo $SQL_input[$a1]['IDDeposit'];
                // echo $SQL_input[$a1]['IDRegFund'];
                
                // $array_test[$num1][$a1]= $SQL_input[$a1]['IDMember'];
                // $array_test[$num1][$a1]= $SQL_input[$a1]['Username'];
                // $array_test[$num1][$a1]= $SQL_input[$a1]['CreateDate'];
                // $array_test[$num1][$a1]= $SQL_input[$a1]['LastUpdate'];
                // $array_test[$num1][$a1]= $SQL_input[$a1]['Amount'];
                // $array_test[$num1][$a1]= $SQL_input[$a1]['DepositStatus'];
                // $array_test[$num1][$a1]= $SQL_input[$a1]['IDDeposit'];
                // $array_test[$num1][$a1]= $SQL_input[$a1]['IDRegFund'];
                // while($rs2 = mysqli_fetch_array($SQL_input2[$a1])){
                
                
                // }
                $x2++;
            }
        }
        $num1++;
        // echo "<br>";
    }
    echo "<pre>";
    print_r($SQL_input1);
    echo "</pre>";


exit();

    $sql = "select  r.*, d.*  from deposit as d, RegFund as r where d.IDRegFund=r.IDRegFund and d.CreateDate='$now_data' ORDER BY  d.IDDeposit DESC ";
    // $sql = "select  * from deposit where CreateDate='$now_data' ORDER BY IDDeposit DESC ";
// echo $sql;
$querydep = mysqli_query($link, $sql);
$num=0; $sum1=0; $sum2=0;
while($rs1 = mysqli_fetch_array($querydep))
{
    echo "<pre>";
    print_r($rs1);
    echo "</pre>";
    exit();
    // $IDMember=$rs1['IDMember'];
    // $Username=$rs1['Username'];
    // $CreateDate=$rs1['CreateDate'];
    // $LastUpdate=$rs1['LastUpdate'];
    // $Amount=$rs1['Amount'];
    // $Receive=$rs1['Receive'];
    // $DepositStatus=$rs1['DepositStatus'];
    // $IDDeposit=$rs1['IDDeposit'];
    // $IDRegFund=$rs1['IDRegFund'];

    // $IDMember="";
    // $Username="";
    // $CreateDate="";
    // $LastUpdate="";
    // $Amount_FixDep="";
    // $Amount_Insura="";
    // $Receive="";
    // $DepositStatus="";
    // $IDDeposit_FixDep="";
    // $IDDeposit_Insura="";
    // $IDRegFund_FixDep="";
    // $IDRegFund_Insura="";

?>             
<tr>
<td><?php echo $rs1['IDMember']/*$num=$num+1*/; ?></td>    
<td><?php echo $rs1['Username']; ?></td>                            
<td><?php echo $rs1['CreateDate']; ?></td>                
<td><?php echo $rs1['LastUpdate']; ?></td>                
<td><?php echo $rs1['Amount']; ?></td>                
<td><?php echo $rs1['Amount']; ?></td>                
<td><?php echo $rs1['Receive']; ?></td>                
<td><?php echo $rs1['DepositStatus']; ?></td>                
<td><?php echo $rs1['IDDeposit']; ?></td>                
<td><?php echo $rs1['IDDeposit']; ?></td>                
<td><?php echo $rs1['IDRegFund']; ?></td>                
<td><?php echo $rs1['IDRegFund']; ?></td>                
</tr>
<?php 
// exit();
    } 
?>


</table>

<?php 
// แบบเดิม 
?>
<table class="table table-sm"   cellspacing="0">
       <thead>
          <tr>
            <th >No</th>
            <th >รหัสสมาชิก</th>
            <th >IDRegFund </th>
            <th >CreateDate </th>
            <th >ยอดฝาก </th>
            <th >Receive </th>
            <th >DepositStatus </th>
            <th >Username </th>
					</tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 
if($date_find==""){
  $now_data=date('Y-m-d');
}else{
  $now_data=$date_find;
}

$sql = "select  d.*, r.IDRegFund , m.Firstname, m.Lastname ,m.IDMember
from deposit as d, regfund as r, member as m where d.IDRegFund=r.IDRegFund and m.IDMember=r.IDMember and d.createdate='$now_data' ORDER BY  d.IDDeposit DESC ";
// echo $sql;
$querydep = mysqli_query($link, $sql);
$num=0; $sum1=0; $sum2=0;
while($rs1 = mysqli_fetch_array($querydep))
        {
?>             
      <tr>
 			<td><?php echo $rs1['IDDeposit']/*$num=$num+1*/; ?></td>    
            <td><?php echo $rs1['IDMember']; ?></td>                            
 			<td><?php echo $rs1['Firstname']." ".$rs1['Lastname']; ?></td>                
            <td><?php echo $rs1['IDRegFund']; ?></td>                
 			<td><?php echo show_day($rs1['CreateDate']); ?></td>                
 			<td><?php 
            // if (in_array($IDRegFund[0],$rs1))
            //     {
            //       $sum1=$sum1+$rs1['Amount'];
                  echo $rs1['Amount'];
                // }
            ?>
              
            </td>                
 						<!-- <td> -->
              <?php  
            // if(count($IDRegFund)<=2){
            //     if (in_array($IDRegFund[1],$rs1))
            //     {
            //       $sum2=$sum2+$rs1['Amount'];
                  // echo $rs1['Amount'];
              //   }                
              // }else{
              //   if ((in_array($IDRegFund[1],$rs1))or(in_array($IDRegFund[2],$rs1)))
              //   {
              //     $sum2=$sum2+$rs1['Amount'];
              //     echo $rs1['Amount'];
              //   }
              //   }
                            
 						?>
              
            <!-- </td>    -->
            <td><?php echo $rs1['Receive']; ?></td>                
            <td><?php echo $rs1['Username']; ?></td>                
 						<!-- <td> -->
              <?php 
                // echo $rs1['DepositStatus']; 
              ?>
              
            <!-- </td>    -->
 					</tr>
<?php } ?>
 <tr>
 						<td></td>                 
 						<td></td>                 
 						<td></td>                 
 						<td><?php  
 						echo $sum1;
 						?></td>                  
 						<td><?php  
 						echo $sum2;
 						?></td>   
 						<td></td>                 
 						<td></td>                 
 					</tr>


<?PHP 

  mysqli_close($link);
    ?>             
                  </tbody>
                </table>
            </div>
          </div>

<?PHP 
include('../tmp_dsh2/footer.php');
?>