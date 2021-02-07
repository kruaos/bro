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
$DateNow = date('Y-m-d');
$TotalSumAmountDep = 0;
$TotalSumAmountIns = 0;
?>
<div class="container-fluid">




    <div class="display-3">รายงานการส่งเงินสัจจะ</div>

    <div class="display-4"> ประจำวันที่ <?php echo show_day($DateNow); ?></div>

    <div class="d-print-none">
        <li><a href="dep-show-report-daily.php">รายละเอียดการฝาก ประจำวัน</a></li>
        <li><a href="dep-show-report-daily-new.php">รายละเอียดการฝาก เลือกวัน Deposit_n</a></li>
        <li><a href="dep-show-report-tran.php">รายละเอียดการฝาก เลือกวัน-สำหรับโอน</a></li>
        <hr>
    </div>
    <?php
    // $DateNow="2020-07-05";
    $ShowTableDepositSQL = "SELECT * from deposit where CreateDate='$DateNow' group by Username ";
    $ShowTDQuery = mysqli_query($link, $ShowTableDepositSQL);
    // print_r($ShowTDQuery);
    // exit();
    ?>
    <table class="table table-hover">

        <thead>
            <tr>
                <th>ที่</th>
                <th>เจ้าหน้าที่</th>
                <th>จำนวนราย </th>
                <th>dep </th>
                <th>ins </th>
                <th>ยอดเงินรวม </th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <?php
        $num = 1;
        $TotalSumAmount = 0;
        while ($TDQ = mysqli_fetch_array($ShowTDQuery)) {
            $Username = $TDQ['Username'];
            $SumDepositSql = "SELECT Sum(Amount) as SumAmount from Deposit where CreateDate='$DateNow' and Username='$Username' ";
            $SumDepQuery = mysqli_query($link, $SumDepositSql);
            while ($SDP = mysqli_fetch_array($SumDepQuery)) {
                $SumAmount = $SDP['SumAmount'];
            }
            $SumDepositDepSql = "SELECT Sum(Amount) as SumAmountDep from Deposit where CreateDate='$DateNow' and Amount='30' and  Username='$Username' ";
            $SumDepDepQuery = mysqli_query($link, $SumDepositDepSql);
            while ($SDdP = mysqli_fetch_array($SumDepDepQuery)) {
                $SumAmountDep = $SDdP['SumAmountDep'];
            }

            $countDepositSql = "SELECT count(Amount) as CountAmount from Deposit where CreateDate='$DateNow' and Amount='30' and  Username='$Username' ";
            $CountDepQuery = mysqli_query($link, $countDepositSql);
            while ($CDq = mysqli_fetch_array($CountDepQuery)) {
                $CountAmount = $CDq['CountAmount'];
            }

            $SumAmountIns = $SumAmount - $SumAmountDep;

            $FullNameEmpSql = "SELECT * from employee where Username='$Username' ";
            $FullNameEmpQuery = mysqli_query($link, $FullNameEmpSql);
            while ($FNE = mysqli_fetch_array($FullNameEmpQuery)) {
                $FullNameEmp = $FNE['Firstname'] . " " . $FNE['Lastname'];
            }

        ?>
            <tr>
                <td><?php echo $num; ?></td>
                <td><?php echo $FullNameEmp; ?></td>
                <td><?php echo $CountAmount; ?></td>
                <td align="right"><?php echo number_format($SumAmountDep, 2); ?></td>
                <td align="right"><?php echo number_format($SumAmountIns, 2); ?></td>
                <td align="right"><?php echo number_format($SumAmount, 2); ?></td>
                <td>
                    <a class="btn btn-warning d-print-none" href="dep-report-user.php?Username=<?php echo $Username; ?>">รายการทั้งหมด</a>
                    <a class="btn btn-success d-print-none" href="dep-report-user-send.php?Username=<?php echo $Username; ?>">ส่งรายงาน</a>
                </td>
            </tr>
        <?php
            $num++;
            $TotalSumAmountDep = $TotalSumAmountDep + $SumAmountDep;
            $TotalSumAmountIns = $TotalSumAmountIns + $SumAmountIns;

            $TotalSumAmount = $TotalSumAmount + $SumAmount;
            $now_data = date('Y-m-d');
            $countSql = "SELECT  Count(Amount) as amountDepCount 
            from deposit 
            where Amount='30' and createdate='$now_data'";
            $queryCount =  mysqli_query($link, $countSql);
            // print_r($queryCount);
            $rs1 = mysqli_fetch_array($queryCount);
            $amountDepCount = $rs1['amountDepCount'];
        }
        ?>
        <tr class="table-active">
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2">จำนวนสมาชิกฝากจำวัน </td>
            <td style='text-align:right'>
                <?php echo Number_format($amountDepCount, 0); ?>
            </td>
            <td>ราย</td>
        </tr>
        <tr class="table-active">
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2">รวมเงินฝากสัจจะ</td>
            <td style='text-align:right'>
                <?php echo number_format($TotalSumAmountDep, 2); ?>
            </td>
            <td>บาท</td>
        </tr>
        <tr class="table-active">
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2">รวมเงินฝากเพื่อนช่วยเพื่อน</td>
            <td style='text-align:right'>
                <div style="font-size:16px"><?php echo number_format($TotalSumAmountIns, 2); ?></div>
            </td>
            <td>บาท</td>
        </tr>
        <tr class="table-active">
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2">ผลรวม</td>
            <td style='text-align:right'>
                <div style="font-size:16px"><?php echo number_format($TotalSumAmount, 2); ?></div>
            </td>
            <td>บาท</td>
        </tr>
    </table>
    <button class="btn btn-danger col d-print-none" onclick="window.print()">พิมพ์รายงาน</button>



</div>
<?PHP
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>