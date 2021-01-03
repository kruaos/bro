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
  while ($rsnum = mysqli_fetch_array($qnum)){
    // print_r($rsnum);
    $bankid=$rsnum['bankid'];
    $createdate=$rsnum['createdate'];
    $income=$rsnum['income'];
    $num=$rsnum['num'];
    $code=$rsnum['code'];
  }

  $sql = "select * from bankmember  where bankid ='".$bankid."'";
  $qinfo = mysqli_query($link, $sql);
  // echo $sql;
      while ($rsinfo = mysqli_fetch_array($qinfo)){
          $fullname= $rsinfo['pname'].$rsinfo['fname']."  ".$rsinfo['lname'];
      }
  // foreach ($qinfo as $rsinfo) {
  //   $fullname= $rsinfo['pname'].$rsinfo['fname']."  ".$rsinfo['lname'];
  // }

  ?>
            <div class="card-body">    
              <h6 class="m-0 font-weight-bold text-primary">รายการ ฝากถอน ของ 
                <?php 
                // if($qinfo->num_rows==0){ echo "ย้อนกลับ";}else{
                  echo $fullname;
                // }
                ?> </h6>
              
              <form method="POST">

              <div class="form-group">
              <div class="form-row">
                      <div class="form-group col-md-2">
                        <label >วันที่</label>
                        <input type="text" class="form-control" name='d_set' value="<?php echo number_format(substr($createdate,8,2)) ;?>">
                      </div>
                      <div class="form-group col-md-2">
                        <label >เดือน</label>
                        <!-- <input type="text" class="form-control"  name='m_set' placeholder="เดือน"> -->
                        <select class="form-control"  name='m_set'>
                        <?php 
                        
                        // for($x=1;$x<=12;$x++){
                        //   $select_m='select';
                        // }
                        $select_m=substr($createdate, 5,2);
                        if($select_m=='01'){
                          $s1='selected';$s2='';$s3='';$s4='';$s5='';$s6='';$s7='';$s8='';$s9='';$s10='';$s11='';$s12='';
                        }else if($select_m=='02'){
                          $s1='';$s2='selected';$s3='';$s4='';$s5='';$s6='';$s7='';$s8='';$s9='';$s10='';$s11='';$s12='';
                        }else if($select_m=='03'){
                          $s1='';$s2='';$s3='selected';$s4='';$s5='';$s6='';$s7='';$s8='';$s9='';$s10='';$s11='';$s12='';
                        }else if($select_m=='04'){
                          $s1='';$s2='';$s3='';$s4='selected';$s5='';$s6='';$s7='';$s8='';$s9='';$s10='';$s11='';$s12='';
                        }else if($select_m=='05'){
                          $s1='';$s2='';$s3='';$s4='';$s5='selected';$s6='';$s7='';$s8='';$s9='';$s10='';$s11='';$s12='';
                        }else if($select_m=='06'){
                          $s1='';$s2='';$s3='';$s4='';$s5='';$s6='selected';$s7='';$s8='';$s9='';$s10='';$s11='';$s12='';
                        }else if($select_m=='07'){
                          $s1='';$s2='';$s3='';$s4='';$s5='';$s6='';$s7='selected';$s8='';$s9='';$s10='';$s11='';$s12='';
                        }else if($select_m=='08'){
                          $s1='';$s2='';$s3='';$s4='';$s5='';$s6='';$s7='';$s8='selected';$s9='';$s10='';$s11='';$s12='';
                        }else if($select_m=='09'){
                          $s1='';$s2='';$s3='';$s4='';$s5='';$s6='';$s7='';$s8='';$s9='selected';$s10='';$s11='';$s12='';
                        }else if($select_m=='10'){
                          $s1='';$s2='';$s3='';$s4='';$s5='';$s6='';$s7='';$s8='';$s9='';$s10='selected';$s11='';$s12='';
                        }else if($select_m=='11'){
                          $s1='';$s2='';$s3='';$s4='';$s5='';$s6='';$s7='';$s8='';$s9='';$s10='';$s11='selected';$s12='';
                        }else if($select_m=='12'){
                          $s1='';$s2='';$s3='';$s4='';$s5='';$s6='';$s7='';$s8='';$s9='';$s10='';$s11='';$s12='selected';
                        }
                        
                        ?>
                          <option value='01'<?php echo $s1;?>>ม.ค.</option>
                          <option value='02'<?php echo $s2;?>>ก.พ.</option>
                          <option value='03'<?php echo $s3;?>>มี.ค.</option>
                          <option value='04'<?php echo $s4;?>>เม.ย.</option>
                          <option value='05'<?php echo $s5;?>>พ.ค.</option>
                          <option value='06'<?php echo $s6;?>>มิ.ย.</option>
                          <option value='07'<?php echo $s7;?>>ก.ค.</option>
                          <option value='08'<?php echo $s8;?>>ส.ค.</option>
                          <option value='09'<?php echo $s9;?>>ก.ย.</option>
                          <option value='10'<?php echo $s10;?>>ต.ค.</option>
                          <option value='11'<?php echo $s11;?>>พ.ย.</option>
                          <option value='12'<?php echo $s12;?>>ธ.ค.</option>
                        </select>
                        <!-- <select class="form-control"> <option>Default select</option></select>     -->
                      </div>
                      <div class="form-group col-md-2">
                        <label >ปี พ.ศ. </label>
                        <input type="text" class="form-control" name='y_set' value="<?php echo substr($createdate,0,4)+543 ;?>">
                      </div>
                    </div>
                <label >สถานะ </label>
                    <select class="form-control"  name='code'>
                        <?php 
                          if($code=='de'){
                            $de_select="selected";$wi_select=" ";$in_select=" ";$bl_select=" ";
                          }else if($code=='wi'){
                            $de_select=" ";$wi_select="selected";$in_select=" ";$bl_select=" ";
                          }else if($code=='in'){
                            $de_select=" ";$wi_select=" ";$in_select="selected";$bl_select=" ";
                          }else if($code=='bl'){
                            $de_select=" ";$wi_select=" ";$in_select=" ";$bl_select="selected";
                          }                          
                        ?>
                          <option value='de'<?php echo $de_select;?>><p class='text-success'>ฝาก</p></option>
                          <option value='wi'<?php echo $wi_select;?>><p class=''>ถอน</p></option>
                          <option value='in'<?php echo $in_select;?>><p class=''>ดอกเบี้ย</p></option>
                          <option value='bl'<?php echo $bl_select;?>><p class=''>ยกมา</p></option>
                    </select>
              </div>
              <div class="form-group">
                <label>ยอดที่แก้ไข</label>
                
                <input class="form-control" name='income' value="<?php echo $income ;?>">
                <input type='hidden' name='num' value="<?php echo $num ;?>">

              </div>

                <div class="form-row">
                  <a href="bank-show.php" class="btn btn-danger col-6  btn-lg">ยกเลิก</a>
                  <button type="submit" class="btn btn-warning col-6  btn-lg" name='send1'>บันทึก</button>
                </div>
              </form>
<?php 
if(isset($_POST['send1'])){
      // if ($income<>null){
      $income=$_POST['income'];
      $workno='root';
      $createdate=($_POST['y_set']-543)."-".sprintf('%02d',$_POST['m_set'])."-".sprintf('%02d',$_POST['d_set'])." ".date("H:i:s");
      $deptime=date("d/m/").((date("Y")+543)-2500);
      $time=1;
      $bank_event_status='1';
      $sqlupdate="UPDATE bankevent SET income = '$income', createdate = '$createdate', deptime = '$deptime', code = '$code'  WHERE  num = $num";
    // echo $sqlupdate;exit;
    mysqli_query($link,$sqlupdate);
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
                      <td >หมายเหตุ</td>
                    </tr>
                  </thead>
                  <tbody>
<!-- loop  -->       

<?php 
  $sql = "select * from bankevent where bank_event_status='1' and num ='".$_GET['num']."' order by createdate ";
  $query = mysqli_query($link, $sql);
  $num=0; $amount=0; 
  while ($rs1 = mysqli_fetch_array($query)){
  // foreach ($query as $rs1) 
        // {
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
                      <td></td>
                  </tr>

<?php 
  mysqli_close($link);
?>                    
                  </tbody>
                </table>
                <a href="bank-event-edit.php?bankid=<?php echo $bankid;?>" class="btn btn-danger" >ย้อนกลับ</a>

            </div>
          </div>

<?PHP 
include('../tmp_dsh2/footer.php');
?>