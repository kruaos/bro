<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');
?>
<div class="container-fluid">


<h1 class="display-1">รายงานการส่งเงินกู้</h1>
<li> <a href="loan-show-report-daily.php"> รายงานรรับเงินกู้ประจำวัน </a></li>
<li> <a href="loan-show-report-monthly.php"> รายงานรรับเงินกู้รายเดือน </a></li>

<hr>
<li> <a href="loan-show-now.php"> สมาชิกที่ยังไม่ได้ปิดบัญชี  </a></li>
<hr>
<?php 
    $DateNow=date('Y-m-d');
    $ShowTableLoanPaymentSQL="SELECT * from loanpayment where Createdate='$DateNow' group by Username ";
    // echo $ShowTableLoanPaymentSQL;
    $ShowTLPQuery = mysqli_query($link,$ShowTableLoanPaymentSQL); 
    // print_r($ShowTLPQuery);
?>
<table class="table table-hover">
    
    <thead>
    <tr>
        <th>ที่</th>
        <th>เจ้าหน้าที่</th>
        <th>จำนวนรายการ</th>
        <th>ยอดเงินรวม </th>
        <th>จัดการ</th>
    </tr>
    </thead>
<?php 
    $num=1;
    $TotalSumAmount=0;

    while($TLP = mysqli_fetch_array($ShowTLPQuery)){
        // print_r($TLP);
        $Username= $TLP['Username'];
        $CountLonepaymentSql="SELECT count(Payment) as CountPay from loanpayment where Createdate='$DateNow' and Username='$Username' ";
        $SumLonepaymentSql="SELECT Sum(Payment) as SumPay from loanpayment where Createdate='$DateNow' and Username='$Username' ";
        $FullNameEmpSql="SELECT * from employee where Username='$Username' ";
        $CountLpQuery = mysqli_query($link,$CountLonepaymentSql); 
        $SumLpQuery = mysqli_query($link,$SumLonepaymentSql); 
        $FullNameEmpQuery = mysqli_query($link,$FullNameEmpSql); 
        while($CLp = mysqli_fetch_array($CountLpQuery)){
            $CountPay=$CLp['CountPay'];
        }
        while($SLp = mysqli_fetch_array($SumLpQuery)){
            $SumPay=$SLp['SumPay'];
        }        
        while($FNE = mysqli_fetch_array($FullNameEmpQuery)){
            $FullNameEmp=$FNE['Firstname']." ".$FNE['Lastname'];
        }
?>
    <tr>
        <td><?php echo $num; ?></td>
        <td><?php echo $FullNameEmp; ?></td>
        <td><?php echo $CountPay; ?></td>
        <td><?php echo number_format($SumPay); ?></td>
        <td><a href="loan-report-user.php?username=<?php echo $Username;?>">แสดง</a></td>
    </tr>
<?php 
    $num++;
    $TotalSumAmount=$TotalSumAmount+$SumPay;

    }
?>
    <tr class="table-active">
        <td></td>
        <td>ผลรวม</td>
        <td></td>
        <td><?php echo number_format($TotalSumAmount); ?></td>
        <td></td>

    </tr>
</table>




</div>
<?PHP 
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>