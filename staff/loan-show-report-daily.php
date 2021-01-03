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

$now_data=date('Y-m-d');

$sql = "SELECT lp.* , m.Firstname, m.Lastname  FROM  loanpayment as lp , member as m , loanbook as lb 
WHERE lp.RefNo=.lb.RefNo and m.IDMember=lb.IDMember and lp.CreateDate ='$now_data' ORDER BY  lp.Username  DESC ";

$queryloan = mysqli_query($link, $sql);
echo " ประจำวันที่ ";
echo show_day($now_data);
echo " จำนวน ";
echo mysqli_num_rows($queryloan);
echo " ราย  ";
$num=0; $sum1=0; $sum2=0;

?>              
<h6 class="m-0 font-weight-bold text-primary">รายละเอียดจาก loanpayment</h6>
<div class="row">
<table class="table table-sm" cellspacing="0" width="100%">
       <thead>
          <tr>
            <th >IDLoanPay</th>
            <th >ชื่อสมาชิก</th>
            <th >RefNo </th>
            <th >CreateDate </th>
            <th >PayTotal </th>
            <th >Interest </th>
            <th >Payment </th>
            <th >Username </th>
					</tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 

while($rs1 = mysqli_fetch_array($queryloan))
        {
?>             
      <tr>
 						<td><?php echo $rs1['IDLoanPay']/*$num=$num+1*/; ?></td>    
 						<td><?php echo $rs1['Firstname']." ".$rs1['Lastname']; ?></td>                
            <td><?php echo $rs1['RefNo']; ?></td>                            
 						<td><?php echo show_day($rs1['CreateDate']); ?></td>                
            <td><?php echo $rs1['PayTotal']; ?></td>                
            <td><?php echo $rs1['Interest']; ?></td>                
            <td><?php echo number_format($rs1['Payment'],2); ?></td>                
            <td><?php echo $rs1['Username']; ?></td>                

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