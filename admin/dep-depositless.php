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
              <h6 class="m-0 font-weight-bold text-primary"><?php echo $fullname;?> -> ข้อมูลสมาชิกสัจจะ จาก depositless</h6>

            <table class="table table-sm "  width="100%" cellspacing="0">
                <thead>
                    <tr>
            <th >ลำดับ</th>
            <th >IDRegFund </th>
            <th >Username </th>
						<th >FundType </th>
						<th >LessDate </th>
                    </tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 
$sql = "select * from depositless  where IDMember=".$_GET['IDMember'].' order by LessDate';
// echo $sql;exit;
$query = mysqli_query($link, $sql);
$num=0; 
while($rs1 = mysqli_fetch_array($query))
        {
$IDRegFund[$num]=$rs1['IDRegFund'];
?>             
            <tr>
 						<td><?php echo $num=$num+1; ?></td>                
 						<td><?php echo $rs1['IDRegFund']; ?></td>                
 						<td><?php echo $rs1['Username']; ?></td>                
            <td><?php echo $rs1['FundType']; ?></td>                
            <td><?php echo show_day($rs1['LessDate']); ?></td>                
            </tr>
<?php 
        } 
?>       			</tbody>
				</table>
         <a href="admin-show.php" class="btn btn-danger" >ย้อนกลับ</a>


<?PHP 

  mysqli_close($link);
    ?>             
                  </tbody>
                </table>
            </div>
          </div>

<?PHP 
include('../tmp_dsh2/footer.php');
?>