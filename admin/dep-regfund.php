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
  }?>              
          <div class="card-body">              
              <h6 class="m-0 font-weight-bold text-primary">
              <?php echo $fullname;?> -> ข้อมูลสมาชิกสัจจะ จาก regfund</h6>

            <table class="table table-sm "  width="100%" cellspacing="0">
                <thead>
                    <tr>
            <th >รหัส</th>
            <th >IDRegFund </th>
            <th >IDFund </th>
						<th >Balance </th>
						<th >SumAmount </th>
						<th >จำนวน </th>
						<th >คงเหลือ </th>
                    </tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 
$sql = "select * from regfund where IDMember=".$_GET['IDMember'].' Order by IDFund';
$query2 = mysqli_query($link, $sql);
$num=0; 
while($rs2 = mysqli_fetch_array($query2))
        {
$IDRegFund[$num]=$rs2['IDRegFund'];
$IDRegFund=$rs2['IDRegFund'];
$IDFund=$rs2['IDFund'];
$Balance=$rs2['Balance'];
?>             
  <tr>
    <td><?php echo $num=$num+1; ?></td>                
    <td><?php echo $IDRegFund; ?></td>                
    <td><?php echo $IDFund; ?></td>                
    <td><?php echo number_format($Balance); ?></td>                
    <td>
      <?php 
      $sql3 = "select sum(Amount) as sumdep ,count(Amount) as countdep from deposit where IDRegFund=".$rs2['IDRegFund'];
      $query3 = mysqli_query($link, $sql3);
      while($rs3 = mysqli_fetch_array($query3))
      { 
        $sumdep=$rs3['sumdep'];
        $countdep=$rs3['countdep'];
        echo number_format($sumdep)." บาท ";
      }
      ?>
    </td>
    <td ><?php echo $countdep." ครั้ง";  ?></td>
    <td ><?php echo number_format($Balance+$sumdep)." บาท";?> </td>                
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