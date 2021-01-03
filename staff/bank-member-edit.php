<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');

function show_day($showday){
    $m_name = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    echo  number_format(substr($showday, 8,2))."  ".$m_name[number_format(substr($showday, 5,2))]." ".(substr($showday, 0,4)+543);
  }
  include('../config/config.php');
?>
  
<?php
if (!isset($_POST['send'])) {


	if(isset($_GET['bankid'])){
		$bankid_show=$_GET['bankid'];
	}else{
		$bankid_show='';
	}

	$sql = "select * from bankmember  where bankid=$bankid_show";
	$query = mysqli_query($link, $sql);
	while($rs1 = mysqli_fetch_array($query)){
		$bankid=$rs1['bankid'];
		$pname=$rs1['pname'];
		$fname=$rs1['fname'];
		$lname=$rs1['lname'];
		$idcard=$rs1['idcard'];
		$telephone=$rs1['telephone'];
		$bankname=$rs1['bankname'];
		$createdate=$rs1['createdate'];  // ไม่ควรให้เปลี่ยนวันสมัคร 
		$bookbalance=$rs1['bookbalance'];
	}



?>
<div class='container'>
	<form method='post'>
  	<div class="alert alert-warning col-sm-12 " role="alert">  ตารางแก้ไขข้อมูล สมาชิก</div>
	<div class="form-group row" >
    <label class="col-sm-4  ">1. รหัสสมาชิก</label>
    	<div class="col-sm-8">
      		<input  type="name" name="bankid" class="form-control" value="<?php echo $bankid;?>">
    	</div>
  	</div>
	<div class="form-group row">
		<label class="col-sm-4 ">2. คำนำหน้า</label>
		<div class="col-sm-8">
		<input type="text" name="pname"  class="form-control" value="<?php echo $pname;?>">*ด.ช. ด.ญ. นาย นาง นางสาว ฯลฯ
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 ">3. ผู้เปิดบัญชี</label>
		<div class="col-sm-8 ">
			ชื่อ<input type="text" name="mname" class="form-control" value="<?php echo $fname;?>" >	
			สกุล<input type="text" name="lname" class="form-control" value="<?php echo $lname;?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 ">5. เบอร์โทรศัพท์ติดต่อ </label>
		<div class="col-sm-8">
		<input type="text" name="telephone" class="form-control" value="<?php echo $telephone;?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 ">6. ชื่อบัญชี</label>
		<div class="col-sm-8">
		<input type="text" name="bankname" class="form-control" value="<?php echo $bankname;?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 ">7. วันที่สมัคร </label>
		<div class="col-sm-8">
		<input type="text" class="form-control" value="<?php echo $createdate;?>"> 
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 ">8. ยอดยกมา</label>
		<div class="col-sm-8">
		<input type="text" name="bl" class="form-control" value="<?php echo $bookbalance;?>">บาท
		</div>
	</div>
	<div id="tab">
		<button type="submit" name="send" class="btn btn-warning">บันทึก</button>
		<a href="bank-show.php" class="btn btn-danger" >ยกเลิก</a>
	</div>
	</form>
</div>
</div>

<?php 
//ส่วนการเพิ่มข้อมูล 
}else{
	include('../config/config.php');
	$sql="SELECT * FROM bankmember";
	$query= mysqli_query($link,$sql);
	$bankno= mysqli_num_rows($query);
	$bankid= $_POST['bankid'];
	$pname= $_POST['pname'];
	$mname= $_POST['mname'];
	$lname= $_POST['lname'];
	$bankname= $_POST['bankname'];	
	$telephone= $_POST['telephone'];
	$workno='demo';
	$createdate=date("Y-m-d H:i:s");
	$lastupdate=date("Y-m-d H:i:s");
	$bankstatus='op';
	$idcard='';
	$address='';
	$birthday='';
	$bookbalance='';

	include('../config/config.php');
	mysqli_set_charset($link,'utf8');
	$sql = "
	INSERT INTO `bankmember`(
			`bankno`, `bankid`, 
			`pname`, `fname`, `lname`, 
			`idcard`, `address`, `telephone`, `birthday`, 
			`bankstatus`, `workno`, 
			`createdate`, `lastupdate`,
			`bankname`, `bookbalance`)
		values(
			'$bankno','$bankid',
			'$pname','$mname','$lname',
			'$idcard','$address','$telephone','$birthday',
			'$bankstatus','$workno',
			'$createdate','$lastupdate',		
			'$bankname','$bookbalance');";
	$result = mysqli_query($link, $sql);
if($_POST['bl']=0 or $_POST['bl']=null){
	$bookbankbalance='0';
}else{
	$bookbankbalance=$_POST['bl'];
}
	$sql2 = "Insert into bookbankbalance2 
		(`bankid`, `bookbankbalance`,`lastupdate`) 
		values(
		'$bankid','$bookbankbalance','$lastupdate'		
		);";
	$result2 = mysqli_query($link, $sql2);
	if ($result)
	{
		echo "<center><span class='h1'>บันทึกข้อมูลเรียบร้อย<br></span>";
		mysqli_close($link);
		echo "<a href='bank-show.php' class='btn btn-success'>ย้อนกลับ</a>";
		exit(0);
	}else{
		echo $sql;
		echo "<center><span class='h1'>ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้<br></span>";
		echo "<a href=../bank/addmember.php></a><br>";
		echo "<a href='bank-show.php' class='btn btn-danger' >ย้อนกลับ</a>";
	}

	}
		

?>