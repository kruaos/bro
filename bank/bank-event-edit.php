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
include('../config/config.php');
  $sql = "select * from bankmember  where bankid ='".$_GET['bankid']."'";
  $qinfo = mysqli_query($link, $sql);
  // echo $sql;
  while($rsinfo = mysqli_fetch_array($qinfo))
  {
    $fullname= $rsinfo['pname'].$rsinfo['fname']."  ".$rsinfo['lname'];
  }

  ?>
            <div class="card-body">    
              <h6 class="m-0 font-weight-bold text-primary">รายการ ฝาก-ถอน ของ 
                <?php 
                // if($qinfo->num_rows==0){ echo "ย้อนกลับ";}else{
                  echo $fullname;
                // }
                ?>  </h6>
              <br>
              <form method="POST">
                <div class="form-row">
                  <div class="form-group col-md-12 " >
                  
  <div class="form-row">
    <div class="form-group col-md-2">
      <label >วันที่</label>
      <input type="text" class="form-control" name='d_set' placeholder="วันที่">
    </div>
    <div class="form-group col-md-2">
      <label >เดือน</label>
      <input type="text" class="form-control"  name='m_set' placeholder="เดือน">
      <!-- <select class="form-control"> <option>Default select</option></select>     -->
    </div>
    <div class="form-group col-md-2">
      <label >ปี พ.ศ. </label>
      <input type="text" class="form-control" name='y_set' placeholder="ปี พ.ศ.">
    </div>
  </div>

<!--     <div class="form-group col-md-4">
      <label >วันที่</label>
      <input type="text" class="form-control" id='datepicker' placeholder="วันที่">
    </div> -->
                  </div>
                  <div class="form-group col alert alert-success" >
                    <label for="">ฝาก</label>
                    <input type="text" class="form-control" placeholder="ฝาก" name='de'>
                  </div>
                  <div class="form-group col alert alert-danger">
                    <label for="">ถอน</label>
                    <input type="text" class="form-control"  placeholder="ถอน" name='wi' >
                  </div>
                  <div class="form-group col alert alert-info ">
                    <label for="">ดอกเบี้ย</label>
                    <input type="text" class="form-control"  placeholder="ดอกเบี้ย" name='in' >
                  </div>
                  <div class="form-group col alert alert-dark ">
                    <label for="">ยอดยกมา</label>
                    <input type="text" class="form-control"  placeholder="ยอดยกมา" name='bl' >
                  </div>
                </div>
                <div class="form-row">
                  <a href="bank-show.php" class="btn btn-danger col-6  btn-lg">ยกเลิก</a>
                  <button type="submit" class="btn btn-primary col-6  btn-lg "  name='send1'>เพิ่ม</button>
                </div>
              </form>
<?php 
if(isset($_POST['send1'])){
      if((is_numeric($_POST['de']))and(($_POST['wi'] or $_POST['in'] or $_POST['bl'])==null)){
        $income=$_POST['de'];
        $code="de";
      }else if((is_numeric($_POST['wi']))and(($_POST['de'] or $_POST['in'] or $_POST['bl'])==null)){
        $income=-$_POST['wi'];
        $code="wi";
      }else if((is_numeric($_POST['in']))and(($_POST['wi'] or $_POST['de'] or $_POST['bl'])==null)){
        $income=$_POST['in'];
        $code="in";
      }else if((is_numeric($_POST['bl']))and(($_POST['wi'] or $_POST['in'] or $_POST['de'])==null)){
        $income=$_POST['bl'];
        $code="bl";
      }else{
       ?>
        <div class="alert alert-warning " role="alert">
            ค่าไม่ถูกต้อง 
        </div>
       <?php 
       exit;
      }
      // if ($income<>null){
      $bankid=$_GET['bankid'];
      $workno='b';
      $createdate=($_POST['y_set']-543)."-".sprintf('%02d',$_POST['m_set'])."-".sprintf('%02d',$_POST['d_set'])." ".date("H:i:s");
      $deptime=date("d/m/").((date("Y")+543)-2500);
      $time=1;
      $bank_event_status='1';
      $sqlinsert="insert into bankevent value('','$bankid','$workno','$income','$code','$createdate','$deptime',$time,'$bank_event_status','')";
    // echo $sqlinsert;exit;
    mysqli_query($link,$sqlinsert);

      // }
  // echo $_POST['de']." - ".$_POST['wi'];

    
  }
  ?>

                <table class="table table-sm "  width="100%" cellspacing="0">
                  <thead>
                    <tr class="table-secondary">
                      <td >num</td>
                      <td >deptime </td>
                      <td >รายการ </td>
                      <td align='right'>ฝาก </td>
                      <td align='right'>ถอน </td>
                      <td align='right'>คงเหลือ </td>
                      <td align='center'>createdate</td>
                      <td >แก้ไข</td>
                    </tr>
                  </thead>
                  <tbody>
<!-- loop  -->       

<?php 
  $sql = "select * from bankevent where code<>'del' and bank_event_status='1' and bankid ='".$_GET['bankid']."' order by createdate ";
  $query = mysqli_query($link, $sql);
  $num=0; $amount=0; 
  while($rs1 = mysqli_fetch_array($query))
        {
?>             
                    <tr >
                      <td><?php echo $num=$num+1; //echo $rs1['num']; ?></td>
                      <td><?php echo show_day(substr($rs1['createdate'],0,10)); ?></td>
                      <td><?php echo $rs1['code']; ?></td>
                      <td align='right'><?php 
                      if ($rs1['income']>0){
                      echo number_format($rs1['income'],2); 
                      }
                      ?>
                      </td>
                      <td align='right'><?php 
                      if ($rs1['income']<0){
                      echo number_format(abs($rs1['income']),2); 
                  		}
                      ?>
                      </td >
                      <td align='right'><?php 
                      $amount=$amount+$rs1['income'];
                      echo number_format($amount,2); 
                      ?>
                      	
                      </td>
                      <td align='center'><?php echo $rs1['createdate']; ?></td>
                      <td >
                        <!-- <a href="bank-event-edit-detail.php?num=<?php echo $rs1['num'];?>" class="btn btn-warning btn-sm">แก้ไข </a> -->

                        <a href="bank-event-edit.php?del_num=<?php echo $rs1['num'];?>&bankid=<?php echo $_GET['bankid']?>" class="btn btn-danger btn-sm">ลบ </a>
                      </td>
              </tr>

<?php 
        } 
if (isset($_GET['del_num'])){
  $sql_del="update bankevent set bank_event_status='0' where num=".$_GET['del_num'];
  mysqli_query($link, $sql_del);
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
                      <td></td>
                  </tr>

<?php 
	// if($amount<>0){
		// $count_db="select * from bankbalance where bankid=".$_GET['bankid'];
		// $qr_db = mysqli_query($link, $count_db);
		// if($qr_db->num_rows==0){
		// 	$uporadd="insert into bankbalance values(".$_GET['bankid'].",$amount,'')";
		// }else{
		// 	$uporadd="update bankbalance set bookbalance=$amount where bankid=".$_GET['bankid'];
		// }
		// echo $uporadd;
		// mysqli_query($link, $uporadd);
  	// }
  mysqli_close($link);
?>                    
                  </tbody>
                </table>

                <a href="bank-view.php?bankid=<?php echo $_GET['bankid'];?>" class="btn btn-danger" >ย้อนกลับ</a>

            </div>
          </div>

<?PHP 
include('../tmp_dsh2/footer.php');
?>