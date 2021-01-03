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
  $type = array("","ฝากประจำ 3 เดือน","ฝากประจำ 6 เดือน","ฝากประจำ 12 เดือน","ออมทรัพย์");
  return  $type[substr($bankid,1,1)];
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
              <h6 class="m-0 font-weight-bold text-primary">ข้อมูลบัญชีธนาคารของ <?php echo $fullname." ชื่อบัญชี ".$bankname;?><br> บัญชีเลขที่ <?php echo $bankid;?> ประเภทบัญชี <?php echo $type_bank;?> </h6>
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
                      <td width='100' align="right">ฝาก </td>
                      <td width='100' align="right">ถอน </td>
                      <td width='100' align="right">คงเหลือ </td>
                      <td align="center">วันเดือนปีที่บันทึก</td>
                      <th >workno</th>
                    </tr>
                  </tdead>
                  <tbody>
<!-- loop  -->       
<?php 
if (isset($_GET['bankid'])){
  $sql = "select * from bankevent where  bank_event_status='1' and  code<>'del' and bankid =".$_GET['bankid']." order by createdate ";
}else{
  $sql = "select * from bankevent where  bank_event_status='1' and order by createdate ";
}
// echo $sql;
$query = mysqli_query($link, $sql);
$num=0; $amount=0; 
while($rs1 = mysqli_fetch_array($query))
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
?>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                  </tr>

<?php 
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
		mysqli_query($link, $uporadd);
	}
  mysqli_close($link);
?>                    
                  </tbody>
                </table>
                <a href="bank-show.php" class="btn btn-danger col-md-2" >ย้อนกลับ</a>
                <a href="bank-event-edit.php?bankid=<?php echo $_GET['bankid']; ?>" class="btn btn-success col-md-2">แก้ไข</a>
                <a href="bank-inte-<?php echo substr($_GET['bankid'],0,2) ?>.php?bankid=<?php echo $_GET['bankid']; ?>" class="btn btn-warning col-md-2">คิดดอกเบี้ย</a>
            </div>
          </div>

<?PHP 
include('../tmp_dsh2/footer.php');
?>