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
<h6 class="m-0 font-weight-bold text-primary">รายงานรับเงินกู้รายเดือน</h6>
<div class="row">

<?php 
if(isset($_POST['month_select']) and $_POST['month_select']<>0){
    $show_type='0';
  echo $month_select=sprintf('%02d',$_POST['month_select']);
  $now_data=date('Y-').$month_select.'%';
  $sql = "SELECT lp.* , m.Firstname, m.Lastname  FROM  loanpayment as lp , member as m , loanbook as lb WHERE lp.RefNo=.lb.RefNo and m.IDMember=lb.IDMember and lp.CreateDate like '$now_data' ORDER BY  lp.IDLoanPay DESC ";
}else{
  if(isset($_POST['date_select']) and isset($_POST['user_select'])){
    $now_data=$_POST['date_select'];
    $user_select=$_POST['user_select'];
    if ($user_select=='0'){
    $show_type='1.1';
    $sql = "SELECT lp.* , m.Firstname, m.Lastname  FROM  loanpayment as lp , member as m , loanbook as lb WHERE lp.RefNo=.lb.RefNo and m.IDMember=lb.IDMember and lp.CreateDate ='$now_data' ORDER BY  lp.IDLoanPay DESC ";
    }else{
      $show_type='1.2';
    $sql = "SELECT lp.* , m.Firstname, m.Lastname  FROM  loanpayment as lp , member as m , loanbook as lb WHERE lp.RefNo=.lb.RefNo and m.IDMember=lb.IDMember and lp.CreateDate ='$now_data' and   lp.username='$user_select' ORDER BY  lp.IDLoanPay DESC ";
    }
  
  }else if   (isset($_POST['date_select']))
  {
    $show_type='2';
    $date_select=$_POST['date_select'];
    $now_data=$date_select;
    $user_select=$_POST['user_select'];
    $sql = "SELECT lp.* , m.Firstname, m.Lastname  FROM  loanpayment as lp , member as m , loanbook as lb WHERE lp.RefNo=.lb.RefNo and m.IDMember=lb.IDMember and lp.CreateDate ='$date_select' ORDER BY  lp.username and  lp.IDLoanPay DESC ";
  }else{
    $show_type='3';
      $now_data=date('Y-m-d');
      $sql = "SELECT lp.* , m.Firstname, m.Lastname  FROM  loanpayment as lp , member as m , loanbook as lb WHERE lp.RefNo=.lb.RefNo and m.IDMember=lb.IDMember and lp.CreateDate ='$now_data' ORDER BY  lp.IDLoanPay DESC ";

  }


}
// echo $sql;
$queryloan = mysqli_query($link, $sql);
echo " ประจำวันที่ ";
echo show_day($now_data);
echo " จำนวน ";
echo mysqli_num_rows($queryloan);
echo " ราย  ";


?>
<form method="POST" action="loan-show-report-monthly.php">
<?php /*
  <input type="text" name="month_select">
*/
?>
  <select name="date_select">
<?php 
  $sql_select="SELECT * FROM  `loanpayment` GROUP BY  `CreateDate` ORDER BY  `loanpayment`.`CreateDate` DESC ";
  $q_select = mysqli_query($link, $sql_select);
  while($rs_se = mysqli_fetch_array($q_select))
        {

?>  
    <option><?php echo $rs_se['CreateDate'];?></option>
<?php 
        }
?>
  </select>
<select name="user_select">
  <option value='0'>ทุกคน</option>
<?php 
  $sql_select="SELECT * FROM  `loanpayment` GROUP BY  `Username` ORDER BY  `loanpayment`.`Username` DESC ";
  $q_select = mysqli_query($link, $sql_select);
  while($rs_se = mysqli_fetch_array($q_select))
        {

?>  
    <option><?php echo $rs_se['Username'];?></option>
<?php 
        }
?>
  </select>


  <input type="submit">
<?php 
    if(isset($_POST['user_select']))
    {
      $user_select=$_POST['user_select'];
    }else{
      $user_select=0;
    }
    echo $user_select." / ";
    echo $show_type." / ";
    echo $now_data." / ";
?>

</form>
<table class="table table-sm" cellspacing="0">
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
$num=0; $sum1=0; $sum2=0; $sum3=0;
while($rs1 = mysqli_fetch_array($queryloan))
        {
?>             
      <tr>
 						<td><?php echo $rs1['IDLoanPay']/*$num=$num+1*/; ?></td>    
 						<td><?php echo $rs1['Firstname']." ".$rs1['Lastname']; ?></td>                
            <td><?php echo $rs1['RefNo']; ?></td>                            
 						<td><?php echo show_day($rs1['CreateDate']); ?></td>                
            <td align='right'><?php echo number_format($rs1['PayTotal']); ?></td>                
            <td align='right'><?php echo number_format($rs1['Interest']); ?></td>                
            <td align='right'><?php echo number_format($rs1['Payment'],2); ?></td>                
            <td><?php echo $rs1['Username']; ?></td>                

 					</tr>
<?php 
          $sum1=$sum1+$rs1['PayTotal'];
          $sum2=$sum3+$rs1['Interest'];
          $sum3=$sum3+$rs1['Payment'];
        } ?>
 <tr>
 						<td></td>                 
 						<td></td>                 
 						<td></td>                 
 						<td></td>                 
 						<td align='right'><?php echo number_format($sum1);	?></td>   
 						<td align='right'><?php echo number_format($sum2);	?></td>  
            <td align='right'><?php echo number_format($sum3); ?></td>                  
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