<?php 
ob_start();

session_start();
session_id();
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');
$employee_use=$_SESSION['LoanEmplopeeUser'];

$IDMember=$_SESSION['IDMember'];
$InstalmentNo="xx";

if (isset($_GET['RefNo'])){	
	$RefNo=$_GET['RefNo'];
}else{
	$RefNo=$_SESSION['RefNo'];
}

function show_day($showday){
	$m_name = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	echo  number_format(substr($showday, 8,2))."  ".$m_name[number_format(substr($showday, 5,2))]." ".(substr($showday, 0,4)+543);
  }

?>

  <script language="JavaScript">
   function fncSum()
   {
		// var num = '';     
		var sum = 0;
		for(var i=0;i<document.frmprice['price[]'].length;i++){
		 num = document.frmprice['price[]'][i].value;
		 if(num!=""){
		  sum += parseFloat(num);
		 }
		}
		document.frmprice.amount_loan.value = sum;         
	}
  </script>
<div class="container-fluid">
	<div class="row">
	<div class="p-3 mb-2 col bg-warning"><h1 class="display-5">ชำระเงินกู้</h1> รหัสเจ้าหน้าที่ : <?php echo $employee_use; ?></div>
	</div>
	<div class="row">



<!-- ส่วนแสดงรายละเอียดผู้กู้ -->
		<div class="col-4 d-print-none">
			<form name="frmprice" method="POST" action="loan-pay-tool-insert.php" >
			  <div class="form-group">
			    <label >รหัสสมาชิก</label>
                <input type="text" class="form-control "  placeholder="รหัสสมาชิก" value="<?php echo $IDMember ;?>"
                disabled>
			  </div>
<?php 
 		$sql = "select * from member where IDMember='$IDMember'";
 		$query = mysqli_query($link, $sql);
 		while($rs1 = mysqli_fetch_array($query))
        {
        	 $FullName=$rs1['Title'].$rs1['Firstname']." ".$rs1['Lastname'];
		}
		
		$sql_loanbook = "select * from loanbook where RefNo=$RefNo";
 		$q_loanbook = mysqli_query($link, $sql_loanbook);
 		while($rs_lb = mysqli_fetch_array($q_loanbook))
        {
        	$Amount=$rs_lb['Amount'];
        	$InterestRate=$rs_lb['InterestRate'];
        	$RefNo=$rs_lb['RefNo'];
        	$Instalment=$rs_lb['Instalment'];
        }
		$sql_loanpayment = "select sum(PayTotal) as 'sumPayTotal' from loanpayment where RefNo='$RefNo'";
		$max_LoanPayment = "select max(InstalmentNo) as 'MaxLoanPayment' from loanpayment where RefNo='$RefNo'";
        $q_loanpayment = mysqli_query($link, $sql_loanpayment);
        $q_MaxLoanPayment = mysqli_query($link, $max_LoanPayment);
        while($rs_MaxPayment = mysqli_fetch_array($q_MaxLoanPayment)){
            $MaxLoanPayment=$rs_MaxPayment['MaxLoanPayment'];
            $InstalmentNo=$MaxLoanPayment+1;
        }        
        while($rs_payment = mysqli_fetch_array($q_loanpayment))
        {
        	$sumPayTotal=$rs_payment['sumPayTotal'];
        	$Payment_loan=$Amount/$Instalment;
        	$balance_loan=$Amount-$sumPayTotal;
        	$instal_loan=($balance_loan*($InterestRate/12))/100;
        	$amount_loan=$Payment_loan+$instal_loan;
        }
?>

			  <div class="form-group">
			    <b>
			    	<label >ชื่อ-สกุล</label> <?php echo $FullName;  ?>	
				</b>
			    <br>
			    <label >ยอดเงินคงค้าง</label>
                    <input type="text" style="font-size:30px; text-align:right"  class="form-control"  
					value="<?php echo number_format($balance_loan,0); ?>" name="balance_loan" disabled>
			    <label >เงินต้น</label>
                    <input type="text" style="font-size:30px; text-align:right" class="form-control"  
					value="<?php echo round($Payment_loan); ?>" name="Payment_loan"  id="price[]" onkeyup="fncSum();"/>
			    <label >ดอกเบี้ย</label>
                    <input type="text" style="font-size:30px; text-align:right" class="form-control"  
					value="<?php echo round($instal_loan); ?>" name="instal_loan"  id="price[]" onkeyup="fncSum();">
			    <label >รวมจ่าย</label>
                    <input type="text" style="font-size:30px;  text-align:right" class="form-control"  
					value="<?php echo number_format($amount_loan,0); ?>" name="amount_loan" autofocus >
				<br>


<?php 
$LoanPaymentLastDateSql = "select * from loanpaymentlastdate where RefNo='$RefNo'";
$LoanPaymentLastDateQuery = mysqli_query($link, $LoanPaymentLastDateSql);
while($LPL = mysqli_fetch_array($LoanPaymentLastDateQuery))
{
	$CreateDateOld=substr($LPL['LastDate'],0,7)."-01";
}
// $CreateDateOld=date('Y-m-d');
$CreateDateNow=date('Y-m')."-01";

list($byear, $bmonth, $bday)= explode("-",$CreateDateOld);       //จุดต้องเปลี่ยน
 list($tyear, $tmonth, $tday)= explode("-",$CreateDateNow);                //จุดต้องเปลี่ยน

 $mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear); 
 $mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear );
 $mage = ($mnow - $mbirthday);

 $u_y=date("Y",$mage)-1970;
 $u_m=date("m",$mage)-1;
 $u_d=date("d",$mage)-1;

 $count_time = ((($u_y*12)+$u_m)/12);

 $time=number_format($count_time,2);

 $CountMonthLoanpayment =(($u_y*12)+$u_m)-1;
 $count_m =($u_y*12)+$u_m;
 $deposit_comment= $u_y." ปี ".$u_m." เดือน ".$u_d." วัน = ".$count_m." เดือน -> ".$time." รอบ";

		echo "<div class='alert alert-danger'>";
		echo "เริ่ม ".$CreateDateOld." ";  
		echo "หยุด ".$CreateDateNow." ";  
		echo " ".$deposit_comment." ";  
		echo "ขาดส่ง ".$CountMonthLoanpayment." เดือน";  
		echo "</div>";
?>



<input type="hidden" value="<?php echo $RefNo; ?>" name="RefNo">
                <input type="hidden" value="<?php echo $employee_use; ?>" name="Username">
                <input type="hidden" value="<?php echo $InstalmentNo; ?>" name="InstalmentNo">
                
				<input type='submit' class="btn btn-success col">
			  </div>
			</form>
				<a href="loan-pay-tool.php" class="btn btn-danger col">ยกเลิก</a>

		</div>
<!-- ส่วนแสดงรายการ ที่ชำระ -->
<?php 
include('../config/config.php');
$date_now=date('Y-m-d');
// $date_now='2019-05-05';
$sql_show_loanpayment = "SELECT * from loanpayment where RefNo='$RefNo' ";
$q_show_loanpayment = mysqli_query($link, $sql_show_loanpayment);
// print_r($sql_show_loanpayment);
?>
	<div class="col">
			<table class="table table-bordered table-sm "  id='EdataTable' >
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">วัน เดือน ปี </th>
			      <th scope="col">เลขบัญชี</th>
			      <th scope="col">เงินต้น</th>
			      <th scope="col">ดอกเบี้ย</th>
			      <th scope="col">รวมจ่าย</th>
			      <th scope="col">user</th>
			    </tr>
			  </thead>
			  <tbody>
<?php 
			$num=1;
			while($rs_show_lpm = mysqli_fetch_array($q_show_loanpayment))
			{
?>			  	
			    <tr>
			      <th scope="row"><?php echo $num; $num=$num+1 ?></th>
			      <td><?php echo show_day($rs_show_lpm['CreateDate']); ?></td>
			      <td><?php echo $rs_show_lpm['RefNo']; ?></td>
			      <td><?php echo number_format($rs_show_lpm['PayTotal']); ?></td>
			      <td><?php echo number_format($rs_show_lpm['Interest']); ?></td>
			      <td><?php echo number_format($rs_show_lpm['Payment']); ?></td>
			      <td><?php echo $rs_show_lpm['Username']; ?></td>
			    </tr>
<?php 
			}
?>			    
			  </tbody>
			</table>
		</div>
	</div>
</div>
<?PHP 
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>