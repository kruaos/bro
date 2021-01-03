<?php 
include('config/setstatus.php');
include('../config/config.php');

?>
<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" />
<?php
session_start();

function DateTimeDiff($strDateTime1,$strDateTime2)
{
    return((strtotime($strDateTime2)-strtotime($strDateTime1))/(60*60))/24;
}
	error_reporting( error_reporting() & ~E_NOTICE );
	if (!(($_SESSION['workroleid']=="b")or($_SESSION['workroleid']=="a")or($_SESSION['workroleid']=="i"))){
			echo "<center><span class='h1'>ท่านไม่มีสิทธิ์เข้าถึง <br>"."<a href='../brcb/index.php'>$login</a> ";
		}else{
		if($_GET['bankid']==null){
?>
<title>ระบบคิดดอกเบี้ย</title>
<div id="container">
<?php

}else if(!isset($_POST['addinter'])){
$dep1=substr($_GET['bankid'],0,2);
$dep2=substr($_GET['bankid'],2,4);
$bankidname=$_GET['bankid'];

include('../config/config.php');

	$sqlname = "select * from memberbank where bankid = '$bankidname';";
		$resultname = mysqli_query($link, $sqlname);
		$dbarr = mysqli_fetch_array($resultname);
		$fullname=$dbarr["pname"].$dbarr["mname"]."  ".$dbarr["lname"] ;

	$sql="select * from memberbank  where bankid like '".$dep1."%%".$dep2."'";
	$query= mysqli_query($link,$sql);
	$result=mysqli_fetch_array($query);
	if(($_GET['bankid']==0)){
		echo "รหัสไม่ถูกต้อง กรุณากรอกรหัสใหม่ <br> <a href='../bank/addinterest.php'>$back</a>";
	}else{
?>
<meta charset=utf8>
<link rel="stylesheet" href="../config/css1.css" type="text/css" />


<title>ฝากเงินธนาคารชุมชน</title>
<div id="container">
<div class='row'>

</div>
<div id="tab" >
<?php
/*
	ในส่วนนี้เห็นว่า หากมีการเพิ่มค่าของ 01******* ซึ่งเป็นบัญชีแบบสะสมทรัพย์ ควรมีการปรับตารางใหม่ เพื่อให้เหมาะสม กับงานเดิมที่เกิดขึ้น
	เพราะแบบสะสมทรัพย์จะต้องคิดทั้งยอดบวกและลบ --commnet วันที่ 10 มีนา 59
	1..น่าจะเปลี่ยนเฉพาะสูตร SQL และการตีตารางใหม่ เพื่อไม่ให้กระทบตารางเดิม
*/
?>
<table width='1000' class="header">
<th colspan="10" > ระบบคิดดอกเบี้ย : ข้อมูลการฝากเงินของ <?=$fullname; ?> </th></tr>
<tr><th  colspan="10">รหัสสมาชิก <?php echo $bankidname;?></th></tr>
<tr>
	
	<td class="c1" width="15%"><b>วันที่ทำรายการ</td>
	<td class="c2"  bgcolor='#ffffff' width="18%"><b>รายการฝาก</td>
	<td class="c1"  bgcolor='#ffffff' width="18%"><b>รายการถอน</td>
	<td class="c2" width="18%"><b>คงเหลือ</td>
	<td class="c1" width="20%"><b> สถานะ</td>
	<td class="c2" width="11%"><b>เพิ่ม</td>
</tr>
<?php $c=1;// ตัวนี้เอาไว้นับ จำนวนลำดับช่อง
include('../config/config.php');
if ((substr($_GET['bankid'],0,2))=='01'){
		$sql="select * from eventbank where bankid ='".$_GET['bankid']." '  order by createdate";
}else{
		$sql="select * from eventbank where bankid ='".$_GET['bankid']." ' and (code='de' or code='bl') and (time='1' or time='0') and (code='de' or code='bl') order by createdate";
}
	$query= mysqli_query($link,$sql);
	$numrows= mysqli_num_rows($query);
		for($i=1;$i<=$numrows;$i++){
		$result=mysqli_fetch_array($query);
		$code=$result['code'];
// --------------------- เริ่มต้น การบันทึกข้อมูลเข้า eventbankint -------- นำเอาค่าเข้าไปก่อนเพื่อคิดใหม่ (6 พค)

				$incomeint=$result['income'];
				$createdateint=$result['createdate'];
				$deptimeint=$result['deptime'];
				$timeint=$result['time'];
				$codeint=$result['code'];
					$sql = "Insert into eventbankaddint values(
						'$incomeint','$codeint',
						'$deptimeint',
						'$timeint',
						'$createdateint'
						)";
					$result2 = mysqli_query($link, $sql);
//------------------------------------------------------- สิ้นสุด การบันทึกข้อมูลเข้า eventbankint-------------------
?>
<?php
$inter=$result['income'];
$d=date("d");	$yn=date("y")+43;	$mn=date("m"); 	// set ค่าวันเริ่มต้น
$m=substr($result['deptime'],3,2);		$y=substr($result['deptime'],-2,2);  // ตัดค่าเดือน เพื่อคำนวน
$cck=((($yn-$y)*12)-$m)+$mn;			// ตรวจสอบว่า ต้องเริ่มจุดไหน

// ------------->>แก้ปัญหา cck เช็ค โดยการทำแบบ switch-------------------------------------
if(((substr($_GET['bankid'],0,2))=='01')and ($cck>=1)){			$iin=0.0125;$sw=1;
}else if (((substr($_GET['bankid'],0,2))=='02')and ($cck>=3)){	$iin=0.035;$sw=2;
}else if (((substr($_GET['bankid'],0,2))=='03')and ($cck>=6)){	$iin=0.0375;$sw=3;
}else if (((substr($_GET['bankid'],0,2))=='04')and ($cck>=12)){	$iin=0.04;$sw=4;
}else{	$sw=0;	}
// --------------------------------------------------------------------------------------

/*
	04  ตรวจสอบว่า ต้องเข้าไปทำรายการในเมนูใด  04 - ประจำ 12 เดือน ***********----------------------------------->>>>>>>>>>>
*/
	$em=substr($endtime,3,2);		
	$ey=substr($endtime,-2,2);
	if ($result['time']==1){	$s=((($yn-$y)*1)+floor(($mn-$m)/12));
		} else {				$s=(($ey-$y)*1)+floor(($em-$m)/12);	}
	include ('config/setinter.php');				$x=1;$a=4;$n=1;

	do {
	if ($a<=4){
//---------------------กรณีนี้ครบ 12 เดือน  -----------------------		
		$sinter = ($inter*$iin)	;
		$createdate=((($y=($y+1))+2500)-543)."-".sprintf("%02d",$mt3[$a])."-".date("d");
		$time=$result['deptime']."-".sprintf("%03d",$n);
		$deptime=date("d")."/".sprintf("%02d",$mt3[$a])."/".$y;
	echo "<input name=1 type='hidden' value='".$c."'>" ;
	echo "<input type='hidden' name='income".$c."' value='".$sinter."'>" ;
	echo "<input type='hidden' name='createdate".$c."' value='".$createdate."'>" ;
	echo "<input type='hidden' name='time".$c."' value='".$time."'>" ;
	echo "<input type='hidden' name='deptime".$c."' value='".$deptime."'>" ;
	$dayintshow=substr($result['deptime'],0,2);
	$newdate = $dayintshow."/".sprintf("%02d",$mt3[$a])."/".$y;	
	$amount = number_format($inter=$inter+($inter*$iin),2,'.',',');
	$newstatus = $result['deptime']."-".sprintf("%03d",$n);

		$a++;$n++;$c++;
		}else{
//---------------------กรณีไม่ครบ 12 เดือน  -----------------------	
		$a=1;
		$sinter = (($inter*3*$iin)/12)	;
		$createdate=((($y+1)+2500)-543)."-".sprintf("%02d",$mt3[$a])."-".date("d");
		$time=$result['deptime']."-".sprintf("%03d",$n);
		$deptime=date("d")."/".sprintf("%02d",$mt3[$a])."/".$y=($y+$mty[$a]);
	echo "<input name='2' type='hidden' value='".$c."'>" ;
	echo "<input type='hidden' name='income".$c."' value='".$sinter."'>" ;
	echo "<input type='hidden' name='createdate".$c."' value='".$createdate."'>" ;
	echo "<input type='hidden' name='time".$c."' value='".$time."'>" ;
	echo "<input type='hidden' name='deptime".$c."' value='".$deptime."'>" ;
	$dayintshow=substr($result['deptime'],0,2);
	$newdate = $dayintshow."/".sprintf("%02d",$mt3[$a])."/".$y;	
	$amount = number_format($inter=$inter+($inter*$iin),2,'.',',');
	$newstatus = $result['deptime']."-".sprintf("%03d",$n);

		$a++;$n++;$c++;
				}
	$cd=floor(((strtotime(date('Y-m-d H:m:s'))-strtotime($result['createdate']))/( 60 * 60))/ 24);
//------------------------เริ่มต้น บันทึกข้อมูลลง eventbankint ------------------------------
		$incomeint=$sinter;
		$createdateint=$createdate;
		$deptimeint=$newdate;
		$timeint=$newstatus;
		$codeint="in";
		$sql = "Insert into eventbankaddint values(
				'$incomeint','$codeint',
				'$deptimeint',
				'$timeint($cd)',
				'$createdateint'
				)";
		$result04 = mysqli_query($link, $sql);		
		
//------------------------สิ้นสุด บันทึกข้อมูลลง eventbankint ------------------------------		
		$x++;
			}
		 while ($x<=$s);
	}
}
echo "<input type='hidden' name='count' value='".$c."'>"
?>
<?php
//----------------------------------- เริ่มต้น ตารางผลดอกเบี้ยใหม่ --------------------

	$sqlint="SELECT * , sum(income)as'income2' FROM `eventbankaddint`   where `createdate`<curdate()  group by `createdate` ORDER BY `eventbankaddint`.`createdate` ASC";

	
	$queryint= mysqli_query($link,$sqlint);
	$numrowsint= mysqli_num_rows($queryint);
		for($i=1;$i<=$numrowsint;$i++){
			$resultint=mysqli_fetch_array($queryint);
?>
<tr>
	<td class="c1">
	<?php 
		$mname=array("ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ตุ.ค.","พ.ย.","ธ.ค.");
		echo substr($resultint['deptime'],0,2)." ".$mname[number_format(substr($resultint['deptime'],3,2))-1]." ".substr($resultint['deptime'],6,2);
		?>
		<input type='hidden' value='<?php echo $resultint['deptime'];?>'>
		<input type='hidden' value='<?php echo $resultint['createdate'];?>'>
	</td>
		<?php
		if(($resultint['code'])=='wi'){	
			echo "<td  bgcolor='#ffffff' ><center>--</center></td>";
			echo "<td  bgcolor='#ffffff' align='right'>".number_format($resultint['income2'],2,'.',',').
				"<input type='hidden' value='".$resultint['income2']."'></td>";
		}else{
			echo "<td  bgcolor='#ffffff' align='right'>".number_format($resultint['income2'],2,'.',',').
				"<input type='hidden' value='".$resultint['income2']."'></td>";
			echo "<td  bgcolor='#ffffff' ><center>--</center></td>";
			}
		if ($code=='wi'){$income=-$resultint['income2'];}else{$income=$resultint['income2'];}  
		?>
	<td align='right'><?php  $balance=$balance+$income;
    	echo number_format($balance,2,'.',',');?>
	</td>
  	<td class="c2"><?php 
	  if ($resultint['code']=='wi' or $resultint['code']=='de'or $resultint['code']=='bl')
			  {
				  if ($resultint['code']=='de'){
					$etime='ฝาก';
				  }else if($resultint['code']=='wi'){
					$etime='ถอน';
				  }else if($resultint['code']=='bl'){
					$etime='ยอดยกมา';  
				  }else{
				  $etime=$resultint['code'];
				  }			
			}else{$etime=$resultint['time'];} ;
		echo $etime; ?> 
	</td>
	<td>เพิ่ม</td>
</tr>
<?php
	}
	$sw=substr($_GET['bankid'],1,1);
	$allinttype1="select sum(income) as 'sumincome'from eventbankaddint where time like 'A1'";
	$queryinttype1= mysqli_query($link,$allinttype1);
	$allinttype1row= mysqli_num_rows($queryinttype1);
		for($i=1;$i<=$allinttype1row;$i++){
			$resultinttype1=mysqli_fetch_array($queryinttype1);
		}		
		$saldelint='truncate table eventbankaddint';
	$querydelint= mysqli_query($link,$saldelint);	


//----------------------------------- สิ้นสุด ตารางผลดอกเบี้ยใหม่ --------------------
?>
</form>
</table>
</div>
	<div class="row" align='center'>
	<a href='../bank/reportbone.php? bankid=<?php echo $_GET['bankid'];?>'>
	<H3>ย้อนกลับ</h3>
	</a>
	</div>

</div>

<?php
//*********************************** แถวนี้น่าจะต้องเขียนใหม่ ******************************************

}else{
	$code="in";
	$bankid=$_POST['bankid'];
for($x=1;$x<$_POST['count'];$x++){
	$income=$_POST['income'.$x];
	$createdate=$_POST['createdate'.$x];
	$time=$_POST['time'.$x];
	$deptime=$_POST['deptime'.$x];
		include('../config/config.php');// เพื่อเพิ่ม รหัสสมาชิก
		$sql="SELECT * FROM eventbank1test";
		$query= mysqli_query($link,$sql);
		$numrows= mysqli_num_rows($query);
		mysqli_close($link);
	$num=$numrows+1;
	$workno=$_SESSION['workno'];
	include('../config/config.php');
		mysqli_set_charset($link,'utf8');
		$result = mysqli_query($link, $sql);
		$sql = "Insert into eventbank1test values(
			'$num',
			'$bankid','$workno',
			'$income','$code',
			'$createdate',
			'$deptime',
			'$time'
			)";
		$result = mysqli_query($link, $sql);
}
	if($x=$_POST['count'])	{
		echo "<center><span class='h1'>รวมรับเงินทั้งสิ้น ".number_format(($payment+$income),2,'.',',')." บาท  <br>บันทึกข้อมูลสำเร็จ<br>";
		mysqli_close($link);
	}	else	{
		echo "<center><span class='h1'>ไม่สามารถบันทึกข้อมูลใหม่ลงในฐานข้อมูลได้<br>";
	}
	echo "<a href=../bank/addinterest.php>$back</a><br>";
		  }
		}

//*********************************** แถวนนี้น่าจะต้องเขียนใหม่
		?>
