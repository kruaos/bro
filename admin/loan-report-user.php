<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

$Username=$_GET['username'];
?>
<div class="container-fluid">
<?php 
function show_day($showday){
  $m_name = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  echo  number_format(substr($showday, 8,2))."  ".$m_name[number_format(substr($showday, 5,2))]." ".(substr($showday, 0,4)+543);

}

$now_data=date('Y-m-d');

$sql = "SELECT lp.* ,m.IDMember, m.Firstname, m.Lastname  FROM  loanpayment as lp , member as m , loanbook as lb 
WHERE lp.RefNo=.lb.RefNo and lp.Username='$Username' and m.IDMember=lb.IDMember and lp.CreateDate ='$now_data' ORDER BY  lp.Username  DESC ";

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
          <th >IDMember</th>
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
$sum1=0;
$sum2=0;
$sum3=0;
while($rs1 = mysqli_fetch_array($queryloan))
        {
          $IDLoanPay=$rs1['IDLoanPay'];
          $IDMember=$rs1['IDMember'];
          $FullName=$rs1['Firstname']." ".$rs1['Lastname'];
          $RefNo=$rs1['RefNo'];
          $CreateDate=$rs1['CreateDate'];
          $PayTotal=$rs1['PayTotal'];
          $Interest=$rs1['Interest'];
          $Payment=$rs1['Payment'];
          $Username=$rs1['Username'];
?>             
      <tr>
      <td><?php echo $IDLoanPay; ?></td>    
      <td><?php echo $IDMember; ?></td>    
 						<td><?php echo $FullName; ?></td>                
            <td><?php echo $RefNo; ?></td>                            
 						<td><?php echo show_day($CreateDate); ?></td>                
            <td style='text-align:right;'><?php echo number_format($PayTotal); ?></td>                
            <td style='text-align:right;'><?php echo number_format($Interest); ?></td>                
            <td style='text-align:right;'><?php echo number_format($Payment); ?></td>                
            <td style='text-align:center;'><?php echo $Username; ?></td>                
 					</tr>
<?php 
  $sum1=$sum1+$PayTotal;
  $sum2=$sum2+$Interest;
  $sum3=$sum3+$Payment;
  } 
?>
 <tr class='table-active'>
 <td></td>                 
 <td></td>                 
 						<td><b>ยอดรวม</b></td>                 
 						<td></td>                 
 						<td></td>                 
 						<td  style='text-align:right;'>
              <?php  
 						    echo number_format($sum1);
              ?>
             </td>                  
 						<td  style='text-align:right;'>
              <?php  
 						    echo number_format($sum2);
              ?>
             </td>   
 						<td  style='text-align:right;'  >
              <?php  
 						    echo number_format($sum3);
              ?>
            </td>                 
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