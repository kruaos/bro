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
<h4 class="m-0 font-weight-bold text-primary">รายละเอียดสมาชิกสัจจะ Deposit_n <?php echo$date_find;?></h4>

<form>
  <input type="date" name="tran_date">
  <input type="submit" value='ค้นข้อมูล'>
</form>
<div class="row">
<table class="table table-sm"   cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>CreateDate </th>
            <th>รหัสสมาชิก</th>
            <th>Username </th>
            <th>สัจจะ </th>
            <th>พชพ </th>
            <th>Receive </th>
            <th>DepSta </th>
            <th>IDDep_FixDep</th>
            <th>IDDep_Insura</th>
            <th>IDReg_FixDep</th>
            <th>IDReg_Insura</th>
        </tr>
    </thead>
<?php 

if($date_find==""){
  $now_data=date('Y-m-d');
}else{
  $now_data=$date_find;
}

$sql = "select * from deposit_n where CreateDate='$now_data' ORDER BY IDDeposit ASC ";
// echo $sql;
$QueryDep = mysqli_query($link, $sql);
while($rs1 = mysqli_fetch_array($QueryDep))
        {
            echo "<tr>";
            echo "<td>".$rs1['IDDeposit']."</td>";
            echo "<td>".$rs1['IDMember']."</td>";
            echo "<td>".$rs1['Username']."</td>";
            echo "<td>".$rs1['CreateDate']."</td>";
            echo "<td>".$rs1['Amount_FixDep']."</td>";
            echo "<td>".$rs1['Amount_Insura']."</td>";
            echo "<td>".$rs1['Receive']."</td>";
            echo "<td>".$rs1['IDDeposit']."</td>";
            echo "<td>".$rs1['IDDeposit_Insura']."</td>";
            echo "<td>".$rs1['IDDeposit_FixDep']."</td>";
            echo "<td>".$rs1['IDRegFund_FixDep']."</td>";
            echo "<td>".$rs1['IDRegFund_Insura']."</td>";
            echo "</tr>";

        }

    echo "</table>";
  mysqli_close($link);
    ?>             
                  </tbody>
                </table>
            </div>
          </div>

<?PHP 
include('../tmp_dsh2/footer.php');
?>