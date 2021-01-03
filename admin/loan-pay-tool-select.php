<?php 
ob_start();

session_start();
session_id();
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');
$IDMember=$_POST['IDMember'];
$employee_use=$_SESSION['LoanEmplopeeUser'];

?>
<div class="container-fluid">
	<div class="row">
		<div class="p-3 mb-2 col bg-warning"><h1 class="display-5">ชำระเงินกู้</h1> รหัสเจ้าหน้าที่ : <?php echo $employee_use; ?></div>
	</div>
	<div class="row">
<!-- ส่วนแสดงรายละเอียดผู้กู้ -->
		<div class="col-4 d-print-none">
        <table class="table table-bordered"  id='EdataTable' >
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">RefNo</th>
                <th scope="col">InterestRate</th>
                <th scope="col">Instalment</th>
                <th scope="col">Amount</th>
                <th scope="col">LoanStatus</th>
                <th scope="col">PayStatus</th>
                <th scope="col">CreateDate</th>
                <th scope="col">LastUpdate</th>
                <th scope="col">LimitDate</th>
            </tr>
            </thead>
            <tbody>
<?php
    $num=0;
    $SelectLoanbookSQL="SELECT * from loanbook where IDMember = $IDMember and LoanStatus='N'";
    $SelectLonabookQuery=mysqli_query($link,$SelectLoanbookSQL);
    while($SLb=mysqli_fetch_array($SelectLonabookQuery)){
        $RefNo = $SLb['RefNo'];
        $Insurer1 = $SLb['Insurer1'];
        $Insurer2 = $SLb['Insurer2'];
        $InterestRate = $SLb['InterestRate'];
        $Instalment = $SLb['Instalment'];
        $Amount = $SLb['Amount'];
        $LoanStatus = $SLb['LoanStatus'];
        $PayStatus = $SLb['PayStatus'];
        $Guaranty = $SLb['Guaranty'];
        $CreateDate = $SLb['CreateDate'];
        $LastUpdate = $SLb['LastUpdate'];
        $LimitDate = $SLb['LimitDate'];
        $num++;
    ?>
        <tr>
            <td><?php echo $num; ?></td>
            <td><?php echo "<a href='loan-pay-tool-add.php?RefNo=".$RefNo."'>".$RefNo."</a>"; ?></td>
            <td><?php echo $InterestRate; ?></td>
            <td><?php echo $Instalment; ?></td>
            <td><?php echo $Amount; ?></td>
            <td><?php echo $LoanStatus; ?></td>
            <td><?php echo $PayStatus; ?></td>
            <td><?php echo $CreateDate; ?></td>
            <td><?php echo $LastUpdate; ?></td>
            <td><?php echo $LimitDate; ?></td>
        </tr>
<?php 

    } // ปิดการแสดงผลค้นหา
?>

<?php 
    // echo $IDMember; 
    // echo "<br>";
    if($num==0){
        echo "ไม่พบข้อมูล ";
    }else if($num==1){
        $_SESSION['IDMember']=$IDMember;
        $_SESSION['RefNo']=$RefNo;
        header("location: loan-pay-tool-add.php");
        echo "พบข้อมูล ";
    }else{
        $_SESSION['IDMember']=$IDMember;
        echo "มีข้อมูลมากกว่า 1 บัญชี ";
    }
    echo "<a href='loan-pay-tool.php'>ย้อนกลับ</a>";

?> 

		</div>
	</div>
</div>
<?PHP 
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>