<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
?>
<div class="container-fluid">

<?php 
function show_day($showday){
  $m_name = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  echo  number_format(substr($showday, 8,2))."  ".$m_name[number_format(substr($showday, 5,2))]." ".(substr($showday, 0,4)+543);
}
function type_bank($bankid){
  $type = array("","ออมทรัพย์","ฝากประจำ 3 เดือน","ฝากประจำ 6 เดือน","ฝากประจำ 12 เดือน");
  return  $type[substr($bankid,1,1)];
}

function CountDate($frist_date_dep,$end_date_dep)
{
    return floor(((strtotime($end_date_dep)-strtotime($frist_date_dep))/(60*60))/24);
}

function DateTimeDiff($strDateTime1,$strDateTime2)
{
    return floor(((strtotime($strDateTime2)-strtotime($strDateTime1))/(60*60))/24);
}

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
                      <th >deptime </th>
                      <th >สถานะ </th>
                      <td width='100' align="right">ฝาก </td>
                      <td width='100' align="right">ถอน </td>
                      <td width='100' align="right">คงเหลือ </td>
                      <td align="center">เวลาที่เงินอยู่ในระบบ [dep_live]</td>
                      <td align="center">ดอกเบี้ย [inte]</td>
                    </tr>
                  </tdead>
                  <tbody>
<?php 
$sql = "select * from bankevent where  code<>'del' and bankid like '".$_GET['bankid']."%' order by createdate ";
$query = mysqli_query($link, $sql);
$num=0; $amount=0; $last_date=0;$last_dep=0;$total_day=0;$iin=0.125;$datebank="";$show_int=0;$midyear="";

while($rs1 = mysqli_fetch_array($query))
{
?>
 <tr>
    <td><?php echo $num=$num+1;
      // echo "-e3";
     ?></td>
    <td><?php echo show_day(substr($rs1['createdate'],0,10)); ?></td>
    <td><?php echo $rs1['code']; ?></td>
    <td align='right'><?php 
    if ($rs1['income']>0){
      echo number_format($rs1['income'],2); 
    }
    ?>
    </td>
    <td  align='right' ><?php 
    if ($rs1['income']<0){
      echo number_format(abs($rs1['income']),2); 
    }
    ?>
    </td>
    <td  align='right'><?php 
      $amount=$amount+$rs1['income'];
      echo number_format($amount,2); 
    ?>
    </td>
    <td align='center'>
      <?php 
      if($rs1['code']<>'bl')  // กำหนดว่าจะต้องไม่ใช่ ยอดยกมา 'bl'
      {

// สูตร นับวันจาก ->> https://www.thaicreate.com/php/forum/058080.html






	      $now_date_dep=substr($rs1['createdate'],0,10);
	      $last_date_dep=$last_date;
	      $today_date_dep=date('Y-m-d');

	      // echo strtotime($now_date_dep);
	      echo $now_date_dep;
	      echo "<br>";
	      // echo strtotime($today_date_dep);
	      echo $today_date_dep;
	      echo "<br>";

	list($byear, $bmonth, $bday)= explode("-",$now_date_dep);       //จุดต้องเปลี่ยน
	list($tyear, $tmonth, $tday)= explode("-",$today_date_dep);                //จุดต้องเปลี่ยน
		
	$mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear); 
	$mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear );
	$mage = ($mnow - $mbirthday);

	$u_y=date("Y", $mage)-1970;
	$u_m=date("m",$mage)-1;
	$u_d=date("d",$mage)-1;

echo"<br><br>$u_y   ปี    $u_m เดือน      $u_d  วัน<br><br>";

	      // echo floor(((strtotime($last_date_dep)-strtotime($now_date_dep))/(60*60))/24);
	      echo "<br>";
	      $total_day=CountDate($now_date_dep,$last_date_dep);

	      $last_date=substr($rs1['createdate'],0,10);

      }

    ?></td>
    <td>
    	<?php
	      $inte=$last_dep*$iin/100*$total_day/365;
	      // echo $last_dep."*".$total_day." = ";
	      $last_dep=$amount;
	      if($num!=1)
	      {
	      // echo (10000*0.75/100*4/365);
	      // echo "[".number_format($show_int,2)."] > ";
	      echo  number_format($inte,2); 
	        if($num==2){
	          $show_int=$inte;
	        }else{
	      $show_int=$show_int+$inte;
	        }
	      }
    	?>
    </td>
  </tr>
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
  <tr class="bg-info"> 
      <td><?php echo $num=$num+1;
      echo "-e";
    ?></td>
    <td><?php echo show_day(date('Y-m-d h:m:s'));?></td>
    <td><?php echo 'in';?></td>
    <td align='right' >-</td>
    <td align='right' >-</td>
    <td align='right' ><?php echo number_format($last_dep,2);?></td>
    <td align='center'>
      <?php 
        $now_date_dep=date('Y-m-d');
        $last_date_dep=$last_date;
        $total_day=CountDate($now_date_dep,$last_date_dep);
        // echo $datebank." -> ".$datenow." = ";
        echo $total_day." วัน";
      ?>
    </td>
    <td><?php 
        // $inte=$last_dep*$iin/100*$total_day/365;
        // echo $last_dep."*".$total_day." = ";
        $last_dep=$amount;

        // echo (10000*0.75/100*4/365);
        // echo "[".number_format($show_int,2)."] > ";
        echo  number_format($inte,2); 
      ?>
    </td>
  </tr>


  </tbody>
</table>
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