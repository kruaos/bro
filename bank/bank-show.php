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

$perpage = 50;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
  } else {
    $page = 1;
  }
    $start = ($page - 1) * $perpage;

  $sql = "select * from bankmember";
  $query = mysqli_query($link, $sql);
  $total_record=$query->num_rows;
  $total_page = ceil($total_record / $perpage);

?>
            <div class="card-body">    

              <h6 class="m-0 font-weight-bold text-primary">ข้อมูลสมาชิกธนาคารชุมชน</h6>
<!-- nav แสดงหน้า -->
                  <nav aria-label="Page navigation example">
                   <ul class="pagination">
                   <?php for($i=1;$i<=$total_page;$i++){ ?>
                  <li class="page-item"><a href="bank-show.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a></li>
                   <?php } ?>
                 
                   
<form class="form-inline" action="bank-show.php" method="GET">
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
                    <tr class="table-secondary">
                      <th >รหัส</th>
                      <th >ชื่อบัญชี</th>
                      <th >สถานะ</th>
                      <td align='right'>sumbankevent</th>
                      <td align="center">LastUpdate</th>
                      <th >ฝาก-ถอน</th>
                      <th >แก้ไข</th>
                    </tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 
if (isset($_GET['Fristname'])){
  $sql = "select * from bankmember  
  where (pname like '%".$_GET['Fristname']."%' or fname like '%".$_GET['Fristname']."%' or lname like '%".$_GET['Fristname']."%' or bankname like '%".$_GET['Fristname']."%') or (bankid like '".$_GET['Fristname']."%')" ;
}else{
  $sql = "select * from bankmember  ORDER BY bankno ASC limit {$start},{$perpage}";
}
// echo $sql;
$query = mysqli_query($link, $sql);
$num=0; 

while($rs1 = mysqli_fetch_array($query))

        {
?>             
                    <tr>
                      <td><a href="bank-view.php?bankid=<?php echo $rs1['bankid'];?>"><?php echo $rs1['bankid'];?></a></td>
                      <td><?php echo  $rs1['bankname']; ?></td>
                      <td><?php echo  $rs1['bankstatus']; ?></td>
                      <td align='right'>
                        <?php 
                        $sql1 = "select sum(income) as 'sumbankevent' from bankevent where bank_event_status='1' and bankid=".$rs1['bankid'];
                        $query1 = mysqli_query($link, $sql1);
                        while($rs2 = mysqli_fetch_array($query1))
                        {
                          echo number_format($rs2['sumbankevent'],2); 
                        }
                        ?>
                      </td>
                      <td align="center">
                        <?php 
                        while($rs = mysqli_fetch_array($query1))
                        {
                          echo show_day($rs['lastupdate'])."  ".substr($rs['lastupdate'],11,9); 
                        }
                      ?>
                    </td>
                    <td>
                      <a href="bank-event-dewi.php?bankid=<?php echo $rs1['bankid']; ?>" class="btn btn-primary btn-sm">ฝาก/ถอน</a>

                    </td>
                    <td>
                      <a href="bank-event-edit.php?bankid=<?php echo $rs1['bankid']; ?>" class="btn btn-warning btn-sm">แก้ไข</a>

                    </td>
                  </tr>
<?php 
        } 
  mysqli_close($link);
?>                    
                  </tbody>
                </table>
                <nav aria-label="Page navigation example">
                   <ul class="pagination">
                   <?php for($i=1;$i<=$total_page;$i++){ ?>
                  <li class="page-item"><a href="bank-show.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a></li>
                   <?php } ?>
                   </ul>
                   </nav> 
            </div>
          </div>

<?PHP 
include('../tmp_dsh2/footer.php');
?>