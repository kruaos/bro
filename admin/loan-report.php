<?php
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

function show_day($showday)
{
    $m_name = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    echo  number_format(substr($showday, 8, 2)) . "  " . $m_name[number_format(substr($showday, 5, 2))] . " " . (substr($showday, 0, 4) + 543);
}
?>
<div class="container-fluid">


    <div class="display-3">รายงานการส่งเงินกู้</div>
    <div class="display-4">ประจำวันที่ <?php echo show_day(date('Y-m-d')); ?> </div>
    <p>
    <div class="d-print-none">

        <li> <a href="loan-show-report-daily.php"> รายงานรรับเงินกู้ประจำวัน </a></li>
        <li> <a href="loan-show-report-monthly.php"> รายงานรรับเงินกู้รายเดือน </a></li>

        <hr>
        <li> <a href="loan-show-now.php"> สมาชิกที่ยังไม่ได้ปิดบัญชี </a></li>
        </p>
        <hr>
    </div>
    <?php
    $DateNow = date('Y-m-d');
    $ShowTableLoanPaymentSQL = "SELECT * from loanpayment where Createdate='$DateNow' group by Username ";
    // echo $ShowTableLoanPaymentSQL;
    $ShowTLPQuery = mysqli_query($link, $ShowTableLoanPaymentSQL);
    // print_r($ShowTLPQuery);
    ?>
    <table class="table table-hover">

        <thead>
            <tr>
                <th>ที่</th>
                <th>เจ้าหน้าที่</th>
                <th>จำนวนรายการ</th>
                <th>เงินต้น</th>
                <th>ดอกเบี้ย</th>
                <th>ยอดเงินรวม </th>
                <th class="d-print-none">จัดการ</th>
            </tr>
        </thead>
        <?php
        $num = 1;
        $TotalSumAmount = 0;

        while ($TLP = mysqli_fetch_array($ShowTLPQuery)) {
            // print_r($TLP);
            $Username = $TLP['Username'];
            $CountLonepaymentSql = "SELECT count(Payment) as CountPay from loanpayment where Createdate='$DateNow' and Username='$Username' ";
            $CountLpQuery = mysqli_query($link, $CountLonepaymentSql);
            while ($CLp = mysqli_fetch_array($CountLpQuery)) {
                $CountPay = $CLp['CountPay'];
            }
            $SumPayTotalSql = "SELECT Sum(PayTotal) as PayTotal from loanpayment where Createdate='$DateNow' and Username='$Username' ";
            $SumPayTotalQ = mysqli_query($link, $SumPayTotalSql);
            while ($spt = mysqli_fetch_array($SumPayTotalQ)) {
                $PayTotal = $spt['PayTotal'];
            }
            $SumInterestSql = "SELECT Sum(Interest) as Interest from loanpayment where Createdate='$DateNow' and Username='$Username' ";
            $SumInterestQ = mysqli_query($link, $SumInterestSql);
            while ($sit = mysqli_fetch_array($SumInterestQ)) {
                $Interest = $sit['Interest'];
            }
            $SumLonepaymentSql = "SELECT Sum(Payment) as SumPay from loanpayment where Createdate='$DateNow' and Username='$Username' ";
            $SumLpQuery = mysqli_query($link, $SumLonepaymentSql);
            while ($SLp = mysqli_fetch_array($SumLpQuery)) {
                $SumPay = $SLp['SumPay'];
            }
            $FullNameEmpSql = "SELECT * from employee where Username='$Username' ";
            $FullNameEmpQuery = mysqli_query($link, $FullNameEmpSql);
            while ($FNE = mysqli_fetch_array($FullNameEmpQuery)) {
                $FullNameEmp = $FNE['Firstname'] . " " . $FNE['Lastname'];
            }
        ?>
            <tr>
                <td><?php echo $num; ?></td>
                <td><?php echo $FullNameEmp; ?></td>
                <td><?php echo $CountPay; ?></td>
                <td style="text-align:right;"><?php echo number_format($PayTotal, 2); ?></td>
                <td style="text-align:right;"><?php echo number_format($Interest, 2); ?></td>
                <td style="text-align:right;"><?php echo number_format($SumPay, 2); ?></td>
                <td class="d-print-none"><a href="loan-report-user.php?username=<?php echo $Username; ?>">แสดง</a></td>
            </tr>
        <?php
            $num++;
            $allCountPay = $allCountPay + $CountPay;
            $allPaytotal = $allPaytotal + $PayTotal;
            $allInterest = $allInterest + $Interest;
            $TotalSumAmount = $TotalSumAmount + $SumPay;
        }
        ?>
        <tr class="table-active">
            <td></td>
            <td>
                <div style="font-size:20px">ผลรวม</div>
            </td>
            <td style="font-size:20px">
                <?php echo number_format($allCountPay); ?>

            </td>
            <td style="text-align:right ;font-size:20px">
                <?php echo number_format($allPaytotal, 2); ?>
            </td>
            <td style="text-align:right ;font-size:20px">
                <?php echo number_format($allInterest, 2); ?>
            </td>
            <td style="text-align:right ;font-size:20px">
                <?php echo number_format($TotalSumAmount, 2); ?>

            </td>
            <td class="d-print-none"></td>

        </tr>
    </table>
    <button class="btn btn-danger col d-print-none" onclick="window.print()">พิมพ์รายงาน</button>



</div>
<?PHP
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>