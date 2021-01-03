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
  $sqlnum = "select * from bankevent where bank_event_status='1' and num ='".$_GET['num']."' order by createdate ";
  $qnum = mysqli_query($link, $sqlnum);
  foreach ($qnum as $rsnum) 
  print_r($rsnum);




  $sql = "select * from bankmember  where bankid ='".$rsnum['bankid']."'";
  $qinfo = mysqli_query($link, $sql);
  // echo $sql;
  foreach ($qinfo as $rsinfo) {
    $fullname= $rsinfo['pname'].$rsinfo['fname']."  ".$rsinfo['lname'];
  }

  ?>
            <div class="card-body">    
              <h6 class="m-0 font-weight-bold text-primary">รายการ ฝากถอน ของ 
                <?php 
                // if($qinfo->num_rows==0){ echo "ย้อนกลับ";}else{
                  echo $fullname;
                // }
                ?> </h6>
              
              <form method="POST">
                <div class="form-row">
                  <div class="form-group col-md-6 alert alert-success" >
                    <label for="">ฝาก</label>
                    <input type="text" class="form-control" placeholder="ฝาก" name='de'>
                  </div>
                </div>

                <div class="form-row">
                  <a href="bank-show.php" class="btn btn-danger col-6  btn-lg">ยกเลิก</a>
                  <button type="submit" class="btn btn-primary col-6  btn-lg" name='send1'>เพิ่ม</button>
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
                      <td >bankid </td>
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
  $sql = "select * from bankevent where bank_event_status='1' and num ='".$_GET['num']."' order by createdate ";
  $query = mysqli_query($link, $sql);
  $num=0; $amount=0; 
  foreach ($query as $rs1) 
        {
?>             
                    <tr >
                      <td><?php echo $num=$num+1; //echo $rs1['num']; ?></td>
                      <td><?php echo show_day(substr($rs1['createdate'],0,10)); ?></td>
                      <td><?php echo $rs1['bankid']; ?></td>
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
                      <td >แก้ไข / ลบ</td>
                     
                   	
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
  mysqli_close($link);
?>                    
                  </tbody>
                </table>
                <a href="bank-event-edit.php?bankid=<?php echo $_GET['bankid'];?>" class="btn btn-danger" >ย้อนกลับ</a>

            </div>
          </div>

<?PHP 
include('../tmp_dsh2/footer.php');
?>