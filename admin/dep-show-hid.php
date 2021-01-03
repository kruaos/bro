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

$perpage = 100;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
  } else {
    $_GET['page'] = 1;
    $page = $_GET['page'];
  }
    $start = ($page - 1) * $perpage;

  $sql = "select * from member";
  $query = mysqli_query($link, $sql);
  $total_record=$query->num_rows;
  $total_page = ceil($total_record / $perpage);

?>
            <div class="card-body">              
              <h6 class="m-0 font-weight-bold text-primary">ข้อมูลสมาชิกสัจจะ </h6>
				<div class="input-group mb-3">
<!-- nav แสดงหน้า -->

      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <?php for($i=1;$i<=$total_page;$i++){ ?>
            <li class="page-item"><a  class="page-link" href="dep-show.php?page=<?php echo $i; ?>" ><?php echo $i; ?></a></li>
          <?php } ?>

<form class="form-inline" action="dep-show.php" method="GET">
  <div class="form-group mx-sm-3 mb-2">
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
                      <th >วันที่เป็นสมาชิก</th>
                      <th >สถานะ</th>
                      <th >regfund</th>
                      <th >depositless</th>
                      <th >loanbook </th>
                      <th >loanpaymentless</th>
                      <th >regbalance</th>
                      <th >lastupdate</th>

                    </tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 
if (isset($_GET['Fristname'])){
  $sql = "select * from member  
  where (Firstname like '%".$_GET['Fristname']."%' or lastname like '%".$_GET['Fristname']."%') or (IDMember like '".$_GET['Fristname']."%')" ;

  // $sql = "select * from member where Firstname like '%".$_GET['Fristname']."%' or Lastname like '%".$_GET['Fristname']."%'";
}else{
  $sql = "select * from member order by IDMember limit {$start},{$perpage}";
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
                      <td><a href="dep-show-detail.php?IDMember=<?php echo $rs1['IDMember'];?>">
                        <?php 
                        echo $rs1['Title'].$rs1['Firstname']." ".$rs1['Lastname'];
                        ?></a>
                      </td>
                      <td><?php echo  show_day($rs1['CreateDate']); ?></td>
                      <td><?php echo  $rs1['MemberStatus']; ?></td>
                      <td>
                        <?php 
                          $sql = "select * from regfund where IDMember=".$rs1['IDMember'];
                          $query1 = mysqli_query($link, $sql);
                          if( $query1->num_rows <> 0 ){
                          echo "<a href='dep-regfund.php?IDMember=$IDMember' class='btn btn-success btn-sm'>  ";
                          echo $query1->num_rows;
                          echo " รายการ </a>      ";
                            } else {
                              echo "ไม่พบข้อมูล";  
                              }                      ?>
                      </td>
                      <td>
                        <?php 
                          $sqldep = "select * from depositless where IDMember=".$rs1['IDMember'];
                          $querydep = mysqli_query($link, $sqldep);
                          if( $querydep->num_rows <> 0 ){
                          echo "<a href='dep-depositless.php?IDMember=$IDMember' class='btn btn-success btn-sm'>  ";
                          echo $querydep->num_rows;
                          echo " รายการ </a>      ";
                            } else {
                              echo "ไม่พบข้อมูล";  
                            }                      
                            ?>
                      </td>
                      <td>
                        <?php 
                          $sql = "select  * from loanbook where IDMember=".$rs1['IDMember'];
                          $query2 = mysqli_query($link, $sql);
                          if( $query2->num_rows <> 0 ){
                          echo "<a href='dep-loanbook.php?IDMember=$IDMember' class='btn btn-danger btn-sm'>  ";
                          echo $query2->num_rows;
                          echo " รายการ </a>      ";
                            } else {
                              echo "ไม่พบข้อมูล";
                            }
                        ?>                        
                      </td>                  
                      <td>
                        <?php 
                          $sql = "select  * from loanpaymentless where IDMember=".$rs1['IDMember'];
                          $query2 = mysqli_query($link, $sql);
                          if( $query2->num_rows <> 0 ){
                          echo "<a href='dep-loanless.php?IDMember=$IDMember' class='btn btn-danger btn-sm'>  ";
                          echo $query2->num_rows;
                          echo " รายการ </a>      ";
                            } else {
                              echo "ไม่พบข้อมูล";
                            }
                            ?>            
                      </td>
                      <td>
                        <?php
                        $regbal= "select * from regfund where IDfund=1 and IDMember=".$rs1['IDMember'];
                        $qreg = mysqli_query($link, $regbal);
                        while($rs = mysqli_fetch_array($qreg)){
                          $lastupdate=$rs['LastUpdate'];
                          echo number_format($rs['Balance'],2);
                        }
                        ?>
                      </td>
                      <td>
                        <?php 
                          echo show_day($lastupdate);
                        ?>
                      </td>
                    </tr>
<?php 

} 

         mysqli_close($link)
?>                    
                  </tbody>
                </table>

            </div>
          </div>

<?PHP 
include('../tmp_dsh2/footer.php');
?>