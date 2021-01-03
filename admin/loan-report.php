<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

function show_day($showday){
    $m_name = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    echo  number_format(substr($showday, 8,2))."  ".$m_name[number_format(substr($showday, 5,2))]." ".(substr($showday, 0,4)+543);
  }
?>
<div class="container-fluid">


<div class="display-3">รายงานการส่งเงินกู้</div>
<div class="display-4">ประจำวันที่ <?php echo show_day(date('Y-m-d'));?> </div>
<p>
<div class="d-print-none">

<li> <a href="loan-show-report-daily.php" > รายงานรรับเงินกู้ประจำวัน </a></li>
<li> <a href="loan-show-report-monthly.php"> รายงานรรับเงินกู้รายเดือน </a></li>

<hr>
<li> <a href="loan-show-now.php"> สมาชิกที่ยังไม่ได้ปิดบัญชี  </a></li>
</p>
<hr>
</div>
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
        <td ><?php echo $CountPay; ?></td>
        <td style="text-align:center;"><?php echo number_format($SumPay); ?></td>
        <td><a href="loan-report-user.php?username=<?php echo $Username;?>">แสดง</a></td>
    </tr>
<?php 
    $num++;
        $TotalSumAmount=$TotalSumAmount+$SumPay;
    }
?>
    <tr class="table-active">
        <td></td>
        <td><div style="font-size:20px">ผลรวม</div></td>
        <td></td>

        <td style="text-align:center;" ><div style="font-size:20px"><?php echo number_format($TotalSumAmount); ?></div></td>
        <td></td>

    </tr>
</table>
<button class="btn btn-danger col d-print-none" onclick="window.print()">พิมพ์รายงาน</button>



</div>
<?PHP 
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>