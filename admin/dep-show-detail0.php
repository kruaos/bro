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
	$query1 = mysqli_query($link, $sql);
	while ($rs1=mysqli_fetch_array($query1) ) {


  }
?>              
          <div class="card-body">              
              <h6 class="m-0 font-weight-bold text-primary"><?php echo $rs1['Title'].$rs1['Firstname']." ".$rs1['Lastname'];?> -> ข้อมูลสมาชิกสัจจะ จาก regfund</h6>

            <table class="table table-sm "  width="100%" cellspacing="0">
                <thead>
                    <tr>
            <th >รหัส</th>
            <th >IDRegFund </th>
            <th >IDFund </th>
						<th >Balance </th>
						<th >SumAmount </th>
						<th >จำนวน </th>
                    </tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 
$sql = "select * from regfund where IDMember=".$_GET['IDMember'].' Order by IDFund';
$query2 = mysqli_query($link, $sql);
$num=0; 
while ($rs2= mysqli_fetch_array($query2)) 
        {
$IDRegFund[$num]=$rs2['IDRegFund'];
?>             
                    <tr>
 						<td><?php echo $num=$num+1; ?></td>                
 						<td><?php echo $rs2['IDRegFund']; ?></td>                
 						<td><?php echo $rs2['IDFund']; ?></td>                
 						<td><?php echo number_format($rs2['Balance']); ?></td>                
 						<td>
 						<?php 
						  $sql3= "select sum(Amount) as sumdep ,count(Amount) as countdep from deposit where IDRegFund=".$rs2['IDRegFund'];
						$query3= mysqli_query($link, $sql3);
						while ($rs3= mysqli_fetch_array($query3)) 
              { 
                  echo number_format($rs3['sumdep'])." บาท ";
                  $countdep=$rs3['countdep'];
              }
 						?></td>
 						<td ><?php echo  $countdep." ครั้ง";  ?></td>
                    </tr>
<?php 
        } 
?>       			</tbody>
				</table>

<a href="dep-show.php" class="btn btn-danger" >ย้อนกลับ</a>
<h6 class="m-0 font-weight-bold text-primary">รายละเอียดสมาชิกสัจจะ จาก deposit</h6>
<div class="row">


<table class="table table-sm"  cellspacing="0">
                 <thead>
                    <tr>
                      <th >No</th>
                      <th >IDRegFund </th>
                      <th >CreateDate </th>
                      <th >Amount </th>
                      <th >สัจจะ </th>
                      <th >Receive </th>
                      <th >DepositStatus </th>
					           </tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 
if(count($IDRegFund)<=1){
  $sql4 = "select * from deposit where IDRegFund=".$IDRegFund[0]." order by CreateDate";
}else if(count($IDRegFund)<=2){
  $sql4 = "select * from deposit where IDRegFund=".$IDRegFund[0]." or IDRegFund=".$IDRegFund[1]." order by CreateDate";
}else{
  $sql4 = "select * from deposit where IDRegFund=".$IDRegFund[0]." or IDRegFund=".$IDRegFund[1]." or IDRegFund=".$IDRegFund[2]." order by CreateDate";
}


$query4= mysqli_query($link, $sql4);
$num=0; $sum1=0; $sum2=0;
while ($rs1 = mysqli_fetch_array($query4)) 
        {
          $IDRegFund=$rs1['IDRegFund'];
?>             
                    <tr>
 						<td><?php echo $num=$num+1; ?></td>                
 						<td><?php echo $IDRegFund; ?></td>                
            <td><?php echo show_day($rs1['CreateDate']); ?></td>                
 						<td><?php echo $rs1['Amount'];$sum1=$sum1+$rs1['Amount']; ?></td>                
 						<td><?php ?></td>   
 						<td><?php echo $rs1['Receive']; ?></td>                
 						<td><?php echo $rs1['DepositStatus']; ?></td>   
 					</tr>
<?php 
        }
 ?>
 <tr>
 						<td></td>                 
 						<td></td>                 
 						<td></td>                 
 						<td><?php  
 						echo $sum1;
 						?></td>                  
 						<td><?php  
 						echo $sum2;
 						?></td>   
 						<td></td>                 
 						<td></td>                 
 					</tr>


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