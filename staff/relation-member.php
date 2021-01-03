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

$perpage = 200;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
  } else {
    $page = 1;
  }
    $start = ($page - 1) * $perpage;

  $sql = "select * from member";
  $query = mysqli_query($link, $sql);
  $total_record=$query->num_rows;
  $total_page = ceil($total_record / $perpage);

?>
            <div class="card-body">              
              <h6 class="m-0 font-weight-bold text-primary">Ralation member บัญชีเงินสัจจะ </h6>
<!-- nav แสดงหน้า -->
                  <nav aria-label="Page navigation example">
                   <ul class="pagination">
                  <li class="page-item"> <a href="relation-member.php?page=1" aria-label="Previous" class="page-link">
                   <span aria-hidden="true">&laquo;</span>
                   </a>
                   </li>
                   <?php for($i=1;$i<=$total_page;$i++){ ?>
                  <li class="page-item"><a href="relation-member.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a></li>
                   <?php } ?>
                  <li class="page-item">
                   <a href="relation-member.php?page=<?php echo $total_page;?>" class="page-link" aria-label="Next"> <span aria-hidden="true">&raquo;</span> </a>
                   </li>
                   </ul>
                   </nav> 

                <table class="table table-sm "  width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th >รหัส</th>
                      <th >ชื่อ - สกุล </th>
                      <th >regfund_all</th>
                      <th >regfund 1</th>
                      <th >regfund 2</th>
                      <th >regfund 3</th>
                    </tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 
$sql = "select * from member ORDER BY IDMember ASC limit {$start},{$perpage}";
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
                          $sql = "select * from regfund where IDMember=".$rs1['IDMember'];
                          $query1 = mysqli_query($link, $sql);
                          {
                            Print_r($query1->num_rows);
                          }
                      ?>
                      </td>
                      <td>
                      <?php 
                          $sql = "select * from regfund where IDMember=".$rs1['IDMember']." and IDFund=1";
                          $query1 = mysqli_query($link, $sql);
                          while($rs1 = mysqli_fetch_array($query1))
                          {
                            Print_r($rs1['IDRegFund']);
                          }
                      ?>
                      </td>
                      <td>
                      <?php 
                          $sql = "select * from regfund where IDMember=".$rs1['IDMember']." and IDFund=2";
                          $query2 = mysqli_query($link, $sql);
                          while($rs2 = mysqli_fetch_array($query2))
                          {
                            Print_r($rs2['IDRegFund']);
                          }
                      ?>
                      </td>
                      <td>
                      <?php 
                          $sql = "select * from regfund where IDMember=".$rs1['IDMember']." and IDFund=3";
                          $query3 = mysqli_query($link, $sql);
                          while($rs3 = mysqli_fetch_array($query3)){
                            Print_r($rs3['IDRegFund']);
                          }
                      ?>
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