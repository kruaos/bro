<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');

// $employee_use=$_POST['employee_USER'];
$employee_use="emp_test";
?>
<div class="container-fluid">
	<div class="row">
		<div class="p-3 mb-2 col bg-primary">
			<h1 class="display-5">
			ระบบฝากสัจจะ	<?php echo $employee_use;?>
			</h1>
		</div>
	</div>
	<div class="row">
<!-- ส่วนแสดงรายละเอียดฝากสัจจะ -->
	<div class="col-sm-4 col-md-12 col-lg-4 d-print-none">
		<form method="POST" action="dep-pay-tool1.php" >
<?php 
        if(isset($_POST['switch_menu1'])){
            echo '<fieldset disabled>';
        }else{
            $switch_menu2="1";
        }
?>
			  <div class="form-group">
			    <label >รหัสสมาชิก</label>
			    <input type="text" class="form-control "  placeholder="รหัสสมาชิก" name="IDRegFund">
			    <input type="hidden" class="form-control "  name="switch_menu1">
			  </div>
<?php 
	if(isset($_POST['switch_menu1'])){
		echo '</fieldset>';
	}
?>				
		</form>
    	<form method="POST" action="dep-pay-tool1.php" >
<?php 
include('../config/config.php');
//IDDeposit	IDRegFund	Username	CreateDate	LastUpdate	Amount	Receive	DepositStatus // deposit2
// IDRegFund	IDFund	IDMember	Closedate	CreateDate	LastUpdate	Balance // regfund
	if(isset($_POST['switch_menu1'])){
		$IDMember=$_POST['IDMember'];

 		$sql = "select * from member where IDMember='$IDMember'";
 		// echo $sql;exit;
 		$query = mysqli_query($link, $sql);
 		while($rs1 = mysqli_fetch_array($query))
        {
        	 $fullname=$rs1['Title'].$rs1['Firstname']." ".$rs1['Lastname'];
        }

		$sql_regfund = "select * from regfund where IDMember='$IDMember' ";
 		$q_regfund = mysqli_query($link, $sql_regfund);
 		while($rs_regfund = mysqli_fetch_array($q_regfund))
        {
        	$IDFund=$rs_regfund['IDFund'];
        }
		$sql_loanpayment = "select sum(PayTotal) as 'sumPayTotal' from loanpayment where RefNo='$RefNo'";
 		$q_loanpayment = mysqli_query($link, $sql_loanpayment);
 		while($rs_payment = mysqli_fetch_array($q_loanpayment))
        {
        	$sumPayTotal=$rs_payment['sumPayTotal'];
        	$Payment_loan=$Amount/$Instalment;
        	$balance_loan=$Amount-$sumPayTotal;
        	$instal_loan=($balance_loan*($InterestRate/12))/100;
        	$amount_loan=$Payment_loan+$instal_loan;
        }
	}
	if((isset($_POST['switch_menu2'])) or $switch_menu2=='1'){
		echo '<fieldset disabled>';
	}
?>
			  <div class="form-group">
			    <b>รหัสสมาชิก</b>	 <?php echo $member_reg_id;  ?><br>		    
			    <b>ชื่อ-สกุล</b> <?php echo $fullname;  ?>	
			    <br>
			    <div class="form-group row">
			    	<div class="col-sm-4">
			    		<label >ยอดเงินคงค้าง</label>
			    	</div>
			    	<div class="col-sm-8">
			    	<input type="text" class="form-control text-right "  value="<?php echo number_format($balance_loan,2); ?>" placeholder="เงินต้น">
			    	</div>
			    </div>
			    <div class="form-group row">
			    	<div class="col-sm-4">
			    		<label >เงินต้น</label>
			    	</div>
			    	<div class="col-sm-8">
			    	<input type="text" class="form-control text-right "  value="<?php echo number_format($Payment_loan,2); ?>" placeholder="เงินต้น" name='PayTotal'>
			    	</div>
			    </div>
			    <div class="form-group row">
			    	<div class="col-sm-4">
			    		<label >ดอกเบี้ย</label>
			    	</div>
			    	<div class="col-sm-8">
				    	<input type="text" class="form-control text-right "  value="<?php echo number_format($instal_loan,2); ?>" placeholder="ดอกเบี้ย" name='Interest' >
				    </div>
				</div>
			    <div class="form-group row">
			    	<div class="col-sm-4">
			    		<label >รวมจ่าย</label>
			    	</div>
			    	<div class="col-sm-8">
			    		<input type="text" class="form-control text-right "  value="<?php echo number_format($amount_loan,2); ?>" placeholder="รวมจ่าย" name='Payment'>
			    	</div>
			    </div>
			    <br>
			    <input type='hidden' value="<?php echo $RefNo;?>" name='RefNo'>
			    <input type="hidden" class="form-control "  value='a' name="switch_menu2">
			    <input type='submit' class="btn btn-success col">
			    <a href="" class="btn btn-danger col">ยกเลิก</a>
			  </div>
<?php 
	if(isset($_POST['switch_menu2'])){
		include('../config/config.php');
		$IDLoanPay='';
		$RefNo=$_POST['RefNo'];
		$Username=$_POST['member_reg_id'];
		$InstalmentNo=$_POST['member_reg_id'];
		$Interest=(int)$_POST['Interest'];
		$Payment=(int)$_POST['Payment'];
		$PayTotal=(int)$_POST['PayTotal'];
		$PayInterest=(int)$_POST['Interest'];
		$InterestOutst='0.00';
		$CreateDate=date('Y-m-d');
		$LastUpdate=date('Y-m-d');
		$ReceiveStatus='I';

		$sql_insert_long_pay="INSERT INTO loanpayment2  VALUES ('$IDLoanPay', '$RefNo', '$Username', '$InstalmentNo', '$Interest', '$Payment', '$PayTotal', '$PayInterest', '$InterestOutst', '$CreateDate', '$LastUpdate', '$ReceiveStatus');";
		mysqli_query($link, $sql_insert_long_pay);
		// exit();
		echo '</fieldset>';
	}
?>				
			</form>
		</div>
<!-- ส่วนแสดงรายการ ที่ชำระ -->


<div class="col">
<div class="alert alert-primary" role="alert">
    <?php echo $employee_use; ?>
</div>

<table class="table table-bordered"  id='EdataTable' >
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">เลขบัญชี</th>
			      <th scope="col">IDRegFund</th>
			      <th scope="col">Amount</th>
			      <th scope="col">CreateDate</th>
			      <th scope="col">username</th>
			    </tr>
			  </thead>
			  <tbody>
<?php 
	$num=1;
	include('../config/config.php');
	$username=$employee_use;
	$date_now=date('Y-m-d');
	// $date_now='2019-05-05';
	//IDDeposit	IDRegFund	Username	CreateDate	LastUpdate	Amount	Receive	DepositStatus // deposit2

	$sql_show_loanpayment = "select * from deposit where CreateDate='$date_now' and username='$username' ORDER BY IDDeposit DESC ";
	// $sql_show_loanpayment = "select * from deposit where CreateDate='2019-04-07' and username='$username' ORDER BY IDDeposit DESC  ";

	$q_show_loanpayment = mysqli_query($link, $sql_show_loanpayment);
	while($rs_show_lpm = mysqli_fetch_array($q_show_loanpayment))
	{
		$IDRegFund=$rs_show_lpm['IDRegFund'];
// IDRegFund	IDFund	IDMember	Closedate	CreateDate	LastUpdate	Balance // regfund

		$sql_idmember = "select IDMember from regfund where IDRegFund=$IDRegFund";
		$q_idmember = mysqli_query($link, $sql_idmember);
		while($rs_idmember = mysqli_fetch_array($q_idmember))
			{
 				$IDMember=$rs_idmember['IDMember'];
			}
?>			  	
	    <tr>
	      <th scope="row"><?php echo $num; $num=$num+1 ?></th>
	      <td><?php echo $IDMember; ?></td>
	      <td><?php echo $rs_show_lpm['IDRegFund']; ?></td>
	      <td><?php echo $rs_show_lpm['Amount']; ?></td>
	      <td><?php echo $rs_show_lpm['CreateDate']; ?></td>
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