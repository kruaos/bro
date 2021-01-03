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
  echo  $type[substr($bankid,1,1)];
}

function DateTimeDiff($strDateTime1,$strDateTime2)
{
    return floor(((strtotime($strDateTime2)-strtotime($strDateTime1))/(60*60))/24);
}

include('../config/config.php');

  $sql = "select * from bankmember  where bankid ='".$_GET['bankid']."'";
  $qinfo = mysqli_query($link, $sql);
  // echo $sql;
  foreach ($qinfo as $rsinfo) {
    $fullname= $rsinfo['pname'].$rsinfo['fname']."  ".$rsinfo['lname'];
    $bankname= $rsinfo['bankname'];
  }


?>
            <div class="card-body">    
                <div class="alert alert-primary" role="alert">
              <h6 class="m-0 font-weight-bold text-primary">ข้อมูลบัญชีธนาคารของ <?php echo $fullname." ชื่อบัญชี ".$bankname;?><br> บัญชีเลขที่ <?php echo $bankid=$rsinfo['bankid'];?> ประเภทบัญชี <?php type_bank($rsinfo['bankid']);?> 
                
              </h6>
                </div>

<!-- nav แสดงหน้า -->
                  <nav aria-label="Page navigation example">
                   <ul class="pagination">

                   </ul>
                   </nav> 
                <table class="table table-sm "  widtd="100%" cellspacing="0">
                  <tdead >
                    <tr class="table-secondary">
                      <th >num</th>
                      <th >deptime </th>
                      <th >สถานะ </th>
                      <td align="right">ฝาก </td>
                      <td align="right">ถอน </td>
                      <td align="right">คงเหลือ </td>
                      <td align="center">วันเดือนปีที่บันทึก</td>
                      <th >workno</th>
                    </tr>
                  </tdead>
                  <tbody>
<!-- loop  -->       
<?php 
if (isset($_GET['bankid'])){
  $sql = "select * from bankevent where  code<>'del' and bankid like '%".$_GET['bankid']."%' order by createdate ";
}else{
  $sql = "select * from bankevent order by createdate ";
}
$query = mysqli_query($link, $sql);
$num=0; $amount=0; 
foreach ($query as $rs1) 
        {
?>             
                    <tr>
                      <td><?php echo $num=$num+1; ?></td>
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
                      <td align='center'><?php echo $rs1['createdate']; ?></td>
                      <td><?php echo $rs1['workno']; ?></td>
                     
                   	
                    </tr>

<?php 
        } 

// comment 1 ตารางส่วนนนี้ ไม่ได้ ถูกนำมาใช้งานเลย   
/*      
// include('bank-config-setinter.php'); //ดึงค่าเดือน 

$bank_type=substr($rsinfo['bankid'],1,1);  // ชนิดของบัญชี 
$deptime='13/01/2562';
// echo $deptime=$rsinfo['deptime'];   //  จะได้ต่อเมื่อ อยู่ใน array 

$dn=date("d"); $mn=date("m"); $yn=(date("y")+43);   // set ค่าวันเริ่มต้นปัจจุบัน 
$db=substr($deptime,0,2); $mb=substr($deptime,3,2); $yb=substr($deptime,-2,2);  // ตัดค่าเดือน เพื่อคำนวน
// ----------------------------------------------------------------------------------ยังคำนวนไม่ได้
if($db<$dn){$countday=1;}else{$countday=0;}
$cck=(((($yn-$yb)*12)-$mb)+$mn)-$countday; // ตรวจสอบจำนวนเดือนที่มี 
// ----------------------------------------------------------------------------------ยังคำนวนไม่ได้
if(($bank_type=='1')        and ($cck>=1)){   $iin=0.0125;  $sw=1;  //คิดเป็นรายเดือน เมื่อครบเดือน คิดทุกเดือน 
}else if (($bank_type=='2') and ($cck>=3)){   $iin=0.035;   $sw=2;  //คิดเป็นรอบ 3 เดือน 
}else if (($bank_type=='3') and ($cck>=6)){   $iin=0.0375;  $sw=3;  //คิดเป็นรอบ 6 เดือน 
}else if (($bank_type=='4') and ($cck>=12)){  $iin=0.04;    $sw=4;  //คิดเป็นรอบ 12 เดือน  
}else{  $sw=0;  }
*/
// echo "(((".$yn."-".$yb.")*12)-".$mb.")+".$mn." = ".$cck." เดือน -> ".$iin." -> ".$sw;
/*
for ($i=1; $i<=$cck; $i++){
?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                  </tr>
<?php 
}
*/
// ------------------inserty หรือ updta ตาราง bankbalance
	if($amount<>0){
		$count_db="select * from bankbalance where bankid=".$_GET['bankid'];
		$qr_db = mysqli_query($link, $count_db);
    $createdate=date("Y-m-d H:m:s");
		if($qr_db->num_rows==0){
			$uporadd="insert into bankbalance values(".$_GET['bankid'].",$amount,'$createdate')";
		}else{
			$uporadd="update bankbalance set bookbalance=$amount  where bankid=".$_GET['bankid'];
		}
		// echo $uporadd;
		// mysqli_query($link, $uporadd);
	 }
?>


<?php 
  mysqli_close($link);
?>                    
                  </tbody>
                </table>
แนวคิดที่ 1 ยอดทุกยอดมีการคำนวนดอกเบี้ยจนกระทั่งวันที่ถูกถอนไป 
<table class="table table-sm "  widtd="100%" cellspacing="0">
                  <tdead >
                    <tr class="table-secondary">
                      <th >num</th>
                      <th >deptime </th>
                      <th >สถานะ </th>
                      <td align="right">ฝาก </td>
                      <td align="right">ถอน </td>
                      <td align="right">คงเหลือ </td>
                      <td align="center">เวลาที่เงินอยู่ในระบบ [dep_live]</td>
                      <td align="center">ดอกเบี้ย [inte]</td>
                    </tr>
                  </tdead>
                  <tbody>
<?php 
$num=0; $amount=0; $last_date=0;$last_dep=0;$total_day=0;
foreach ($query as $rs1) 
        {
        ?>                    
 <tr>
                      <td><?php echo $num=$num+1; ?></td>
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
                        if($last_date==!null){
                        $datenow=$last_date;
                        $datebank=$rs1['createdate'];
                        $total_day=DateTimeDiff($datenow,$datebank);
                        echo /*$datenow." -> ".$datebank." = ".*/$total_day." วัน";
                        }
                        $last_date=$rs1['createdate'];

                      ?></td>
                      <td><?php
                      $iin=0.0125;
                      $inte=$last_dep*$iin/100*$total_day/365;
                      $last_dep=$amount;
                      // echo (10000*0.75/100*4/365);
                      echo  number_format($inte,2); 

                      ?></td>
                     
                    
                    </tr>
<?php 
        }
  // แสดงผลตารางสุดท้าย สรุปรวม 
?>
  <tr> 
                      <td><?php echo $num+1;?></td>
                      <td><?php echo show_day(date('Y-m-d h:m:s'));?></td>
                      <td><?php echo 'in';?></td>
                      <td align='right' >-</td>
                      <td align='right' >-</td>
                      <td align='right' >-</td>
                      <td align='center'>
                        <?php 
                        $datenow=date('Y-m-d h:m:s');
                        $datebank=$rs1['createdate'];
                        $total_day=DateTimeDiff($datebank,$datenow);
                        echo /*show_day($datenow)." -> ".show_day($datebank)." = ".*/$total_day." วัน";
                      ?>
                      </td>
                      <td><?php 
                      $iin=0.0125;
                      $inte=$last_dep*$iin/100*$total_day/365;
                      $last_dep=$amount;

                      // echo (10000*0.75/100*4/365);
                      echo  number_format($inte,2); 
                      ?></td>
                  </tr>
                  </tbody>
                </table>

                <a href="bank-view.php?bankid=<?php echo $_GET['bankid']; ?>" class="btn btn-danger col-md-3" >ย้อนกลับ</a>
            </div>
          </div>

<?PHP 
include('../tmp_dsh2/footer.php');
?>