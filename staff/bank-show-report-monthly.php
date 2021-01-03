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

function show_sub($show_sub){
  if ($show_sub=='wi'){
    echo "ถอน";
  }else if($show_sub=='de'){
    echo "ฝาก";
  }else{
    echo $show_sub;
  }
}

?>              
<h6 class="m-0 font-weight-bold text-primary">รายละเอียดส่งเงินธนาคาร</h6>
<div class="row">

<?php 

if (isset($_GET['select_day'])){
  $d=substr($_GET['select_day'],0,2);
  $m=substr($_GET['select_day'],3,2);
  $Y=2000+(substr($_GET['select_day'],6,2))-43;
  //echo $setdate=$_GET['select_day'];
  $setdate=$Y.'-'.$m.'-'.$d;
}else{
  $setdate=date('Y-m-d');
}

echo " ประจำวันที่ ";
echo show_day($setdate);
// echo " จำนวน ";
// echo mysqli_num_rows($queryloan);
// echo " ราย  ";


?>
<form method="GET" action="bank-show-report-monthly.php">
<?php /*
  <input type="text" name="month_select">
*/
?>
  <select name="select_day">
<?php 
  $sql_select="SELECT * FROM  `bankevent` GROUP BY  `deptime` ORDER BY  `createdate` DESC ";
  $q_select = mysqli_query($link, $sql_select);
  while($rs_se = mysqli_fetch_array($q_select))
        {

?>  
    <option><?php echo $rs_se['deptime'];?></option>
<?php 
        }
?>
  </select>
  <input type="submit">
</form>
<table class="table table-sm"  cellspacing="0">
       <thead>
          <tr>
            <th >ลำดับ ID</th>
            <th >ชื่อบัญชี </th>
            <th >รายการ  </th>
            <th >จำนวน </th>
            <th >คงเหลือ </th>
            <th >เวลา </th>
            <th >ผู้รับ  </th>
            <th >หมายเหตุ </th>
					</tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 
$num=0; $sum1=0; $sum2=0;



$sql_show_book_report_day = "SELECT *  FROM  `bankevent`  Where createdate like '$setdate%' and bank_event_status=1 ORDER BY  `num` asc";
$query_book_report_day = mysqli_query($link, $sql_show_book_report_day);
while($rs1 = mysqli_fetch_array($query_book_report_day))
        {
?>             
      <tr>
 						<td><?php echo $rs1['num']/*$num=$num+1*/; ?></td>    
 						<td><a href="bank-view.php?bankid=<?php echo $rs1['bankid'] ; ?>"><?php echo $rs1['bankid'] ; ?></a></td>                
            <td><?php echo show_sub($rs1['code']); ?></td>                            
            <td align="right"><?php echo number_format($rs1['income'],2); ?></td>                
            <td><?php  ?></td>                
 						<td><?php echo substr($rs1['createdate'],10,10) ; ?></td>                
            <td><?php echo $rs1['workno']; ?></td>                
            <td><?php  ?></td>                
            <?php
              $sum1=$sum1+$rs1['income']

              ?>
 					</tr>
<?php } ?>
 <tr>
 						<td></td>                 
 						<td></td>                 
 						<td></td>                 
 						<td  align="right">
              <?php echo number_format($sum1,2); ?> 
            </td>                  
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