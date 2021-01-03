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

$perpage = 500;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
  } else {
    $page = 1;
  }
    $start = ($page - 1) * $perpage;

  $sql = "select * from member ORDER BY IDMember ASC";
  $query = mysqli_query($link, $sql);
  $total_record=$query->num_rows;
  $total_page = ceil($total_record / $perpage);

?>
            <div class="card-body">    

              <h6 class="m-0 font-weight-bold text-primary">ข้อมูลสมาชิกเงินกู้ </h6>
<!-- nav แสดงหน้า -->
                  <nav aria-label="Page navigation example">
                   <ul class="pagination">
                  
                   <?php for($i=1;$i<=$total_page;$i++){ ?>
                  <li class="page-item"><a href="loan-show-now.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a></li>
                   <?php } ?>

<form class="form-inline" action="loan-show-now.php" method="GET">
  <div class="form-group mx-sm-2 mb-2">
    <label class="sr-only">ค้นหาชื่อสมาชิก</label>
    <input type="text" class="form-control" placeholder="ชื่อสมาชิก" name='Fristname'>
  </div>
  <button type="submit" class="btn btn-primary mb-2">ค้นหา</button>
</form>

                   </ul>
                   </nav> 
                <table class="table table-sm "  width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th >รหัส</th>
                      <th >ชื่อ - สกุล </th>
                      <th >สถานะการกู้ปัจจุบัน</th>
                      <th >วันที่เป็นสมาชิก</th>
                      <th >สถานะ</th>
                      <th >ประวัติการกู้</th>
                      <th >ประวัติการค้ำ</th>
                    </tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 
if (isset($_GET['Fristname'])){
  $sql = "select * from member where (Firstname like '%".$_GET['Fristname']."%' or Lastname like '%".$_GET['Fristname']."%') or (IDMember like '".$_GET['Fristname']."%') ORDER BY IDMember ASC";
}else{
  $sql = "select * from member ORDER BY IDMember ASC limit {$start},{$perpage}";
}
// echo $sql;exit;
$query = mysqli_query($link, $sql);
$num=0; 
while($rs1 = mysqli_fetch_array($query))
{
  $IDMember=$rs1['IDMember'];
  
  
  
  ?>             
                    <tr>
                      <td><?php echo sprintf('%04d',$rs1['IDMember']); ?></td>
                      <td>
                        <?php 
                        echo $rs1['Title'].$rs1['Firstname']." ".$rs1['Lastname'];
                        ?>
                      </td>
                        <td>
                          <?php 
                          $sqlin3 = "select * from Loanbook where IDMember=$IDMember and LoanStatus='N'";
                          $queryin3 = mysqli_query($link, $sqlin3);
                          if ($queryin3->num_rows==0){
                              // print_r($queryin3);
                          ?>
                          ไม่มีการกู้ขณะนี้ 
                        <?php }else if ($queryin3->num_rows==1){?>
                              <div class='bg-success'> มีการกู้ <?php echo $queryin3->num_rows; ?></div>
                        <?php }else{ ?>         
                        <div class='bg-warning'> มีการกู้ <?php echo $queryin3->num_rows; ?></div>
                        <?php } ?>         
                        </td>               
                      <td><?php echo  show_day($rs1['CreateDate']); ?></td>
                      <td><?php echo  $rs1['MemberStatus']; ?></td>
                      <td>
                        <?php 
                          $sqlloan = "select * from Loanbook where IDMember=".$rs1['IDMember'];
                          $queryloan = mysqli_query($link, $sqlloan);
                          if ($queryloan->num_rows<>0){
                        ?>
                        <a href="loan-cus-show.php?memid=<?php echo $rs1['IDMember'];?>" class="btn btn-danger btn-sm">ประวัติการกู้ <?php echo $queryloan->num_rows;?> ครั้ง</a>
                      <?php }else{?>
                        ไม่มีประวัติการกู้
                      <?php } ?>
                      </td>
                      <td>
                        <?php 
                          $sqlin1 = "select * from Loanbook where Insurer1=".$rs1['IDMember']." or Insurer2=".$rs1['IDMember'];
                          $queryin1 = mysqli_query($link, $sqlin1);
                          if ($queryin1->num_rows<>0){
                        ?>
                        <a href="loan-in-show.php?memid=<?php echo $rs1['IDMember'];?>" class="btn btn-success btn-sm">ตรวจผู้ค้ำ <?php echo $queryin1->num_rows;?> ราย </a>
                      <?php }else{?>
                        ไม่มีประวัติการค้ำประกัน
                      <?php } ?>                        
                      </td>
                    </tr>

<?php 
        } 
  mysqli_close($link);
?>                    
                  </tbody>
                </table>
            </div>
          </div>

<?PHP 
include('../tmp_dsh2/footer.php');
?>