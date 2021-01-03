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
  $sql = "select * from member where IDMember=".$_GET['IDMember'];
  $query = mysqli_query($link, $sql);
  while($rs1 = mysqli_fetch_array($query))
  {
    $fullname=$rs1['Title'].$rs1['Firstname']." ".$rs1['Lastname'];
  }
  
?>              
          <div class="card-body">              
              <h6 class="m-0 font-weight-bold text-primary"><?php echo $fullname;?> -> ข้อมูลสมาชิกสัจจะ จาก loanbook</h6>
           </div>
            <div class="card-body">
                <table class="table table-bordered  table-sm"  width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th >No.</th>
                      <th >ผู้กู้</th>
                      <th >บัญชีเลขที่ </th>
                      <th >วันที่ </th>
                      <th >วงเงิน</th>
                      <th >หลักทรัพย์</th>
                      <th >สถานะบัญชี</th>
                    </tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 
  $sql = "select * from Loanbook where IDMember=".$_GET['IDMember'];
  $query = mysqli_query($link, $sql);
  $num=0;
  while($rs1 = mysqli_fetch_array($query)){
?>             
  <tr>
    <td><?php echo  $num=$num+1; ?></td>
    <td>
    <?php 
      $sql2 = 'select * from member where IDMember='.$rs1['IDMember']; 
      $query2 = mysqli_query($link,$sql2);
      while($rs2 = mysqli_fetch_array($query2)){
      $fullname=$rs2['Title'].$rs2['Firstname']." ".$rs2['Lastname'];
      }
      echo  $fullname; 
    ?>
    </td>
    <td>
      <?php 
        $RefNo=$rs1['RefNo'];
        $memid=$_GET['IDMember'];

      ?>
      <a href="loan-pay-show1.php?RefNo=<?php echo $RefNo;?>&memid=<?php echo $memid;?>">
      <?php echo  $rs1['RefNo']; ?>
      </a>
    </td>
    <td><label><?php echo  show_day($rs1['CreateDate']); ?></label></td>
    <td><?php echo  number_format($rs1['Amount']); ?></td>
    <td><?php 
      if ($rs1['Guaranty']==null){
      $sqlin1 = 'select * from member where IDMember='.$rs1['Insurer1']; 
      $qin1 = mysqli_query($link,$sqlin1);
      while($rsin1 = mysqli_fetch_array($qin1))
      {$fullname=$rsin1['Title'].$rsin1['Firstname']." ".$rsin1['Lastname'];}
      echo "ผู้ค้ำประกันคนที่ 1 ".$fullname;

      $sqlin2 = 'select * from member where IDMember='.$rs1['Insurer2']; 
      $qin2 = mysqli_query($link,$sqlin2);
      while($rsin2 = mysqli_fetch_array($qin2))
      {$fullname=$rsin2['Title'].$rsin2['Firstname']." ".$rsin2['Lastname'];}
      echo "<br>ผู้ค้ำประกันคนที่ 2 ".$fullname;
      }else{
      echo  $rs1['Guaranty'];
      }
    ?>
    </td>
    <td><?php echo  $rs1['LoanStatus']; ?></td>
  </tr>

<?php 
} 
  mysqli_close($link);
?>                    
                  </tbody>
                </table>
                 <a href="admin-show.php" class="btn btn-danger" >ย้อนกลับ</a>

            </div>
          </div>

<?PHP 
include('../tmp_dsh2/footer.php');
?>