<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
$count_time=0;
?>
<div class="container-fluid">

<?php 
function show_day($showday){
  $m_name = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  echo  number_format(substr($showday, 8,2))."  ".$m_name[number_format(substr($showday, 5,2))]." ".(substr($showday, 0,4)+543);
}

function month_count_num($month_count){
  $m_num = array('','1','2','3','4','5','6','7','8','9','10','11','12');
  return $m_num[$month_count];
}


function type_bank($bankid){
  $type = array("","ออมทรัพย์","ฝากประจำ 3 เดือน","ฝากประจำ 6 เดือน","ฝากประจำ 12 เดือน");
  return  $type[substr($bankid,1,1)];
}


function iin_bank($bankid){
  $iin = array(0.0,0.0125,0.035,0.0375,0.04);
  return  $iin[substr($bankid,1,1)];
}

function CountDate($frist_date_dep,$end_date_dep)
{return floor(((strtotime($end_date_dep)-strtotime($frist_date_dep))/(60*60))/24);}

function DateTimeDiff($strDateTime1,$strDateTime2)
{return floor(((strtotime($strDateTime2)-strtotime($strDateTime1))/(60*60))/24);}

include('../config/config.php');
  $sql = "select * from bankmember  where bankid ='".$_GET['bankid']."'";
  $qinfo = mysqli_query($link, $sql);
  // echo $sql;
  while($rsinfo = mysqli_fetch_array($qinfo))
  {
    $fullname= $rsinfo['pname'].$rsinfo['fname']."  ".$rsinfo['lname'];
    $bankname= $rsinfo['bankname'];
    $bankid=$rsinfo['bankid'];
    $type_bank=type_bank($rsinfo['bankid']);
  }
?>
  <div class="card-body">    
    <div class="alert alert-primary" role="alert">
      <h6 class="m-0 font-weight-bold text-primary">ข้อมูลบัญชีธนาคารของ <?php echo $fullname." ชื่อบัญชี ".$bankname;?><br> บัญชีเลขที่ <?php echo $bankid;?> ประเภทบัญชี <?php echo $type_bank;?> 
      </h6>
    </div>
<!-- nav แสดงหน้า -->
    <nav aria-label="Page navigation example">
      <ul class="pagination">
      </ul>
    </nav> 
    <table class="table table-sm "  width="100%" cellspacing="0">
      <tdead >
      <tr class="table-secondary">
        <th >num</th>
        <th width='150'>deptime </th>
        <th >สถานะ </th>
        <td width='150' align="right">ฝาก </td>
        <td width='150' align="right">ถอน </td>
        <td width='150' align="right">คงเหลือ </td>
        <td width='400' align="center">เวลาที่เงินอยู่ในระบบ [dep_live]</td>
        <td align="center">ดอกเบี้ย [inte]</td>
      </tr>
    </tdead>
    <tbody>
<?php 
    $array_sort=array();
    $sql = "select * from bankevent where  code<>'del' and bankid like '".$_GET['bankid']."%' order by createdate ";
    $query = mysqli_query($link, $sql);
    $num=0; $amount=0; $last_date=0;$last_dep=0;$total_day=0;$iin=0.125;$datebank="";$show_int=0;$midyear="";
    while($rs1 = mysqli_fetch_array($query))
    {
      
?>
      <tr style="display:none">
        <td><?php echo $num=$num+1;  //echo "สถานะ"; ?></td>
        <td><?php echo show_day(substr($rs1['createdate'],0,10)); ?></td>
        <td><?php echo $rs1['code']; ?></td>
        <td align='right'><?php 
        if ($rs1['income']>0){
          echo number_format($rs1['income'],2); 
          $deposit=number_format($rs1['income'],2);
          $withdrawal='';

        }
        ?></td>
        <td  align='right' ><?php 
        if ($rs1['income']<0){
          echo number_format(abs($rs1['income']),2); 
          $deposit='';
          $withdrawal=number_format(abs($rs1['income']),2);
        }?></td>
        <td  align='right'><?php 
          $amount=$amount+$rs1['income'];
          echo number_format($amount,2); 
          $bookbalance=number_format($amount,2);
        ?>  </td>
        <td align='center'>
        <?php 
        $deposit_comment='';
        if($rs1['code']=='de')  // กำหนดว่าจะต้องไม่ใช่ ยอดยกมา 'bl'
        {
// สูตร นับวันจาก ->> https://www.thaicreate.com/php/forum/058080.html
          $now_date_dep=substr($rs1['createdate'],0,10);
          $last_date_dep=$last_date;
          $today_date_dep=date('Y-m-d');

          // echo strtotime($now_date_dep);
          // echo $now_date_dep;
          // echo "<br>";
          // echo strtotime($today_date_dep);
          // echo $today_date_dep;
          // echo "<br>";
        	list($byear, $bmonth, $bday)= explode("-",$now_date_dep);       //จุดต้องเปลี่ยน
	        list($tyear, $tmonth, $tday)= explode("-",$today_date_dep);                //จุดต้องเปลี่ยน
		
          $mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear); 
          $mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear );
          $mage = ($mnow - $mbirthday);

          $u_y=date("Y",$mage)-1970;
          $u_m=date("m",$mage)-1;
          $u_d=date("d",$mage)-1;

          $count_m =($u_y*12)+$u_m;
          $count_time = ((($u_y*12)+$u_m)/6);

          // echo $u_y."ปี".$u_m."เดือน".$u_d."วัน = ";
          // echo $count_m." เดือน -> ";
          // echo number_format($count_time,2)." รอบ";
          $time=number_format($count_time,2);
          $deposit_comment= $u_y."ปี".$u_m."เดือน".$u_d."วัน = ".$count_m." เดือน -> ".$time." รอบ";
          echo $deposit_comment;
          // echo $bmonth;
	        // echo floor(((strtotime($last_date_dep)-strtotime($now_date_dep))/(60*60))/24);
	        // echo "<br>";
          // for($m_i=$bmonth)
          // {
          // }
          // $total_day=CountDate($now_date_dep,$last_date_dep);
          // $last_date=substr($rs1['createdate'],0,10);
          } ?></td>
        <td>8
          <?php
          // $inte=$last_dep*$iin/100*$total_day/365;
          // echo $last_dep."*".$total_day." = ";
          // $last_dep=$amount;
          // if($num!=1)
          // {
          // echo (10000*0.75/100*4/365);
          // echo "[".number_format($show_int,2)."] > ";
          // echo  number_format($inte,2); 
          //   if($num==2){
          //     $show_int=$inte;
          //   }else{
          // $show_int=$show_int+$inte;
          //   }
          // }
          ?></td>
<?php 
        $input1=$num;
        $input2=substr($rs1['createdate'],0,10);
        $input3=$rs1['code'];
        $input4=$deposit;
        $input5=$withdrawal;
        $input6=$bookbalance;
        $input7=$deposit_comment;
        $input8='';
        
        $array_sort[]=array($input1,$input2,$input3,$input4,$input5,$input6,$input7,$input8);
?>
      </tr>
<?php    
$strCreatedate=$rs1['createdate'];                             //ส่วนแสดงรายการดอกเบี้ย -- เริ่ม 
for($i=1; $i<=$count_time; $i++) {
  // echo "<tr><td>".$i."</td><tr>";
    $strStartDate =$strCreatedate;
    $strNewDate = date ("Y-m-d", strtotime("+6 month", strtotime($strStartDate)));
    $strCreatedate=$strNewDate;
?>
  <tr style="display:none">
    <td>-</td>
    <td><?php echo show_day(substr($strCreatedate,0,10)); ?></td>
    <td>in</td>
    <td align='right'><?php 
      $iin=iin_bank($_GET['bankid']);
      $show_iin=number_format(($rs1['income']*$iin),2);
      echo $show_iin; 
      ?></td>
    <td align='right'>-</td>
    <td align='right'>-</td>
    <td align='center'><?php echo 'ยอดที่ '.$num.' - งวดที่ '.$i; ?></td>
    <td>8</td>
  </tr>
<?php 
    $input1='-';
    $input2=substr($strCreatedate,0,10);
    $input3='in';
    $input4=$show_iin;
    $input5='';
    $input6='';
    $input7='ยอดที่ '.$num.' - งวดที่ '.$i;
    $input8='';
    
    $array_sort[]=array($input1,$input2,$input3,$input4,$input5,$input6,$input7,$input8);
}
$count_time=0;
                                        //ส่วนแสดงรายการดอกเบี้ย -- จบ 
?>
<?php 
      }
      // ปิดการ loop แสดงผล 
      // comment 4 แสดงผลตารางสุดท้าย สรุปรวม 
      $mdo = substr($datebank,8,2);
      $mmo = substr($datebank,5,2);
      $myo = substr($datebank,0,4);

      $mdn = date('d');
      $mmn = date('m');
      $myn = date('Y');

      // echo "<br>".$mmo."/".$myo." -> ".$mmn."/".$myn."<br>";
?>
<!-- <tr> -->
  <!-- </tbody>
</table> -->
<hr>
<?php 
// echo "<pre>";
// print_r($array_sort);
// echo "</pre>";
function compareByTimeStamp($time1, $time2) 
{ 
	if (strtotime($time1[1]) > strtotime($time2[1])) 
		return 1; 
	else if (strtotime($time1[1]) < strtotime($time2[1])) 
		return -1; 
	else
		return 0; 
} 
usort($array_sort, "compareByTimeStamp"); 
// echo "<pre>";
// print_r($array_sort);
// echo "</pre>";
$amount_table=count($array_sort)-1;
// echo $amount_table;

// echo '<table border=1>';
for($x=0;$x<=$amount_table;$x++){
  echo '<tr>';
  $amount_tr=count($array_sort[$x])-1;
    for($y=0;$y<=$amount_tr;$y++){
     echo ' <td> '.$array_sort[$x][$y].' </td> ';
    }
  echo '</tr>';
    // echo $x;
}  
// echo '</table>';

// echo '<table>';
// foreach ($array_sort as $el) {
//   echo '<tr>';
//   foreach ($el as $el2) {
//     echo ' <td> '.$el2.' </td> ';
//   }
//   echo '</tr>';
// }
// echo '</tabel>';
// echo "\n";
?>
  </tbody>
</table>
<hr>
<a href="bank-view.php?bankid=<?php echo $_GET['bankid']; ?>" class="btn btn-danger col-md-2 d-print-none" >ย้อนกลับ</a>
<a href="#" class="btn btn-success col-md-2 d-print-none" >บันทึก</a>
<!-- <a href="bank-inte-01.php?bankid=<?php echo $_GET['bankid']; ?>&viewset=show" class="btn btn-primary col-md-2 d-print-none" >แสดงการคำนวน</a> -->
<input type="button" name="Button" value="พิมพ์" onclick="window.print();" class="btn btn-dark col-md-2 d-print-none">
  </div>
</div>

<?PHP 
  mysqli_close($link);
  include('../tmp_dsh2/footer.php');
?>