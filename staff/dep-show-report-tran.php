<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

?>
<div class="container-fluid">
<?php 
function show_day($showday){
  $m_name = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  echo  number_format(substr($showday, 8,2))."  ".$m_name[number_format(substr($showday, 5,2))]." ".(substr($showday, 0,4)+543);

}
if(isset($_GET['tran_date'])){
  $date_find=$_GET['tran_date'];
}else{
  $date_find="";
}

?>              
<h4 class="m-0 font-weight-bold text-primary">รายละเอียดสมาชิกสัจจะ เพื่อโอน <?php echo$date_find;?></h4>

<form>
  <input type="date" name="tran_date">
  <input type="submit">
</form>
<div class="row">

<table class="table table-sm"   cellspacing="0">
       <thead>
          <tr>
            <th >No</th>
            <th >IDDeposit</th>
            <th >รหัสสมาชิก</th>
            <th >IDRegFund </th>
            <th >CreateDate </th>
            <th >ยอดฝาก </th>
            <th >Receive </th>
            <th >DepositStatus </th>
            <th >Username </th>
					</tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 
if($date_find==""){
  $now_data=date('Y-m-d');
}else{
  $now_data=$date_find;
}
$sql = "select  d.*, r.IDRegFund , m.Firstname, m.Lastname ,m.IDMember
from deposit as d, regfund as r, member as m where d.IDRegFund=r.IDRegFund and m.IDMember=r.IDMember and d.createdate='$now_data' ORDER BY  d.IDDeposit ASC ";
// echo $sql;
$querydep = mysqli_query($link, $sql);
$num=1; $sum1=0; $sum2=0;
while($rs1 = mysqli_fetch_array($querydep))
        {
?>             
      <tr>
            <td><?php echo $num; ?></td>    
 						<td><?php echo $rs1['IDDeposit']/*$num=$num+1*/; ?></td>    
            <td><?php echo $rs1['IDMember']; ?></td>                            
 						<td><?php echo $rs1['Firstname']." ".$rs1['Lastname']; ?></td>                
            <td><?php echo $rs1['IDRegFund']; ?></td>                
 						<td><?php echo show_day($rs1['CreateDate']); ?></td>                
 						<td><?php echo $rs1['Amount']; ?></td>                
            <td><?php echo $rs1['Receive']; ?></td>                
            <td><?php echo $rs1['Username']; ?></td>                
 						<!-- <td> -->
              <?php 
              $num++;
                // echo $rs1['DepositStatus']; 
              ?>
              
            <!-- </td>    -->
 					</tr>
<?php } ?>
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