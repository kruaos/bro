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
  $sql = "select * from loanbook, member where RefNo=".$_GET['RefNo']." and loanbook.IDMember= member.IDMember";
  $qmem = mysqli_query($link, $sql);
  $sumpay=0;
while($rsmemb = mysqli_fetch_array($qmem)){
  $showmem=$rsmemb['Title'].$rsmemb['Firstname']." ".$rsmemb['Lastname']." วงเงิน ".number_format($rsmemb['Amount'])." บาท";
  $rsamount=$rsmemb['Amount'];
}


?>

            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">รายละเอียดการส่งกู้ ของ <?php echo $showmem?> </h6>
            </div>
            <div class="card-body"> 
                <table class="table table-bordered  table-sm"  width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th >งวดที่</th>
                      <th >เงินต้น</th>
                      <th >ดอกเบี้ย</th>
                      <th >รวมจ่าย</th>
                      <th >เงินต้นคงเหลือ</th>
                      <th >วันที่จ่าย</th>
                    </tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 
  $sql = "select * from loanpayment where RefNo=".$_GET['RefNo'];
  $query = mysqli_query($link, $sql);
  $sumpay=$rsamount;
  while($rs1 = mysqli_fetch_array($query))
        {
                    $sumpay=$sumpay-$rs1['PayTotal'];
?>             
                <tr>
                  <td><div class="text-center"><?php echo  $rs1['InstalmentNo'];?></div></td>
                  <td><div class="text-right"><?php echo  number_format($rs1['PayTotal']); ?></div></td>
                  <td><div class="text-right"><?php echo  number_format($rs1['Interest']);?></div></td>
                  <td><div class="text-right"><?php echo  number_format($rs1['Payment']); ?></div></td>
                  <td><div class="text-right"><?php echo  number_format($sumpay); ?></div></td>
                  <td><div class="text-center"><?php echo  show_day($rs1['CreateDate']); ?></div></td>
                </tr>
<?php 
        } 

  mysqli_close($link);
?>                    
                    <tr>
                      <td><?php   ?></td>
                      <td><div class="text-right"><?php  echo number_format($sumpay); ?></div></td>
                      <td><?php   ?></td>
                      <td><?php   ?></td>
                      <td><?php   ?></td>
                      <td><?php   ?></td>
                    </tr>
                  </tbody>
                </table>
 <a href="loan-cus-show.php?memid=<?php echo $_GET['memid'];?>" class="btn btn-danger" >ย้อนกลับ</a>
            </div>
          </div>
<?PHP 
include('../tmp_dsh2/footer.php');
?>