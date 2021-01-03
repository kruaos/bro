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
    $_GET['page'] = 1;
    $page = $_GET['page'];
  }
    $start = ($page - 1) * $perpage;

  $sql = "select * from member_n";
  $query = mysqli_query($link, $sql);
  $total_record=$query->num_rows;
  $total_page = ceil($total_record / $perpage);

?>
<div class="card-body">              
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <?php for($i=1;$i<=$total_page;$i++){ ?>
            <li class="page-item"><a  class="page-link" href="dep-show1.php?page=<?php echo $i; ?>" ><?php echo $i; ?></a></li>
          <?php } ?>

        <form class="form-inline" action="dep-show1.php" method="GET">
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
                      <th >regfund_all</th>
                      <th >regfund 1</th>
                      <th >regfund 2</th>
                      <th >regfund 3</th>
                      <th >สถานะ</th>
                      <th >รายละเอียด</th>
                    </tr>
                  </thead>
                  <tbody>
<!-- loop  --> 
<?php 
if (isset($_GET['Fristname'])){
  $sql = "select * from member_n  
  where (Firstname like '%".$_GET['Fristname']."%' or lastname like '%".$_GET['Fristname']."%') or (IDMember like '".$_GET['Fristname']."%')" ;
}else{
  $sql = "select * from member_n order by IDMember limit {$start},{$perpage}";
}      

$query = mysqli_query($link, $sql);
$num=0; 
while($rs = mysqli_fetch_array($query))

        {
          $IDMember=$rs['IDMember'];
?>             
                    <tr>
                      <td><?php echo sprintf('%04d',$IDMember); ?></td>
                      <td><a href="dep-show-detail.php?IDMember=<?php echo $IDMember; ?>">
                        <?php 
                        echo $rs['Title'].$rs['Firstname']." ".$rs['Lastname'];
                        ?>
                        </a>
                      </td>
                      <td>
                      <?php 
                          $sql1 = "select * from regfund where IDMember=$IDMember";
                          $query1 = mysqli_query($link, $sql1);
                          {
                            Print_r($query1->num_rows);
                          }
                      ?>
                      </td>
                      <td>
                      <?php 
                          $sql2 = "select * from regfund where IDMember=$IDMember and IDFund=1";
                          $query2 = mysqli_query($link, $sql2);
                          while($rs2 = mysqli_fetch_array($query2))
                          {
                            Print_r($rs2['IDRegFund']);
                          }
                      ?>
                      </td>
                      <td>
                      <?php 
                          $sql3 = "select * from regfund where IDMember=$IDMember and IDFund=2";
                          $query3 = mysqli_query($link, $sql3);
                          while($rs3 = mysqli_fetch_array($query3))
                          {
                            Print_r($rs3['IDRegFund']);
                          }
                      ?>
                      </td>
                      <td>
                      <?php 
                          $sql4 = "select * from regfund where IDMember=$IDMember and IDFund=3";
                          $query4 = mysqli_query($link, $sql4);
                          while($rs4 = mysqli_fetch_array($query4)){
                            Print_r($rs4['IDRegFund']);
                          }
                      ?>
                      </td>
                      <td>
                        <a href="dep-show-detail.php?IDMember=<?php echo $IDMember; ?>" class="btn btn-sm btn-success">คลิก</a>
                      </td>                      
                      <td>
                      <a href="dep-show-detail1.php?IDMember=<?php echo $IDMember; ?>" class="btn btn-sm btn-danger">โอน</a>
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