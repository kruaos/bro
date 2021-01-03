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

?>              
<h6 class="m-0 font-weight-bold text-primary">รายละเอียดสมาชิกสัจจะ จาก deposit</h6>
<div class="row">


<table class="table table-sm"   cellspacing="0">
       <thead>
          <tr>
            <th >No</th>
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
$now_data=date('Y-m-d');

$sql = "select  d.*, r.IDRegFund , m.Firstname, m.Lastname ,m.IDMember
from deposit as d, regfund as r, member as m where d.IDRegFund=r.IDRegFund and m.IDMember=r.IDMember and d.createdate='$now_data' ORDER BY  d.IDDeposit DESC ";

$querydep = mysqli_query($link, $sql);
$num=0; $sum1=0; $sum2=0;
while($rs1 = mysqli_fetch_array($querydep))
        {
?>             
      <tr>
 						<td><?php echo $rs1['IDDeposit']/*$num=$num+1*/; ?></td>    
            <td><?php echo $rs1['IDMember']; ?></td>                            
 						<td><?php echo $rs1['Firstname']." ".$rs1['Lastname']; ?></td>                
            <td><?php echo $rs1['IDRegFund']; ?></td>                
 						<td><?php echo show_day($rs1['CreateDate']); ?></td>                
 						<td><?php 
            // if (in_array($IDRegFund[0],$rs1))
            //     {
            //       $sum1=$sum1+$rs1['Amount'];
                  echo $rs1['Amount'];
                // }
            ?>
              
            </td>                
 						<!-- <td> -->
              <?php  
            // if(count($IDRegFund)<=2){
            //     if (in_array($IDRegFund[1],$rs1))
            //     {
            //       $sum2=$sum2+$rs1['Amount'];
                  // echo $rs1['Amount'];
              //   }                
              // }else{
              //   if ((in_array($IDRegFund[1],$rs1))or(in_array($IDRegFund[2],$rs1)))
              //   {
              //     $sum2=$sum2+$rs1['Amount'];
              //     echo $rs1['Amount'];
              //   }
              //   }
                            
 						?>
              
            <!-- </td>    -->
            <td><?php echo $rs1['Receive']; ?></td>                
            <td><?php echo $rs1['Username']; ?></td>                
 						<!-- <td> -->
              <?php 
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