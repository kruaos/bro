<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

?>
<div class="container-fluid">




<h1 class="display-1">รายงานการส่งเงินสัจจะ</h1>
<li><a href="dep-show-report-daily.php">รายละเอียดการฝาก ประจำวัน</a></li>
<li><a href="dep-show-report-daily-new.php">รายละเอียดการฝาก เลือกวัน Deposit_n</a></li>
<li><a href="dep-show-report-tran.php">รายละเอียดการฝาก เลือกวัน-สำหรับโอน</a></li>

<hr>
<?php 
    $DateNow=date('Y-m-d');
    // $DateNow="2020-07-05";
    $ShowTableDepositSQL="SELECT * from deposit where CreateDate='$DateNow' group by Username ";
    $ShowTDQuery = mysqli_query($link,$ShowTableDepositSQL); 
    // print_r($ShowTDQuery);
    // exit();
?>
<table class="table table-hover">
    
    <thead>
    <tr>
        <th>ที่</th>
        <th>เจ้าหน้าที่</th>
        <th>ยอดเงินรวม </th>
        <th>จัดการ</th>
    </tr>
    </thead>
<?php 
    $num=1;
    $TotalSumAmount=0;
    while($TDQ = mysqli_fetch_array($ShowTDQuery)){
        $Username= $TDQ['Username'];
        $SumDepositSql="SELECT Sum(Amount) as SumAmount from Deposit where CreateDate='$DateNow' and Username='$Username' ";
        $SumDepQuery = mysqli_query($link,$SumDepositSql); 
while($SDP = mysqli_fetch_array($SumDepQuery)){
            $SumAmount=$SDP['SumAmount'];
        }
?>
    <tr>
        <td><?php echo $num; ?></td>
        <td><?php echo $Username; ?></td>
        <td><?php echo number_format($SumAmount); ?></td>
        <td><a href="dep-report-user.php?Username=<?php echo $Username;?>">แสดง</a></td>
    </tr>
<?php 
    $num++;
    $TotalSumAmount=$TotalSumAmount+$SumAmount;
    }
?>
    <tr class="table-active">
        <td></td>
        <td>ผลรวม</td>
        <td><?php echo number_format($TotalSumAmount); ?></td>
        <td></td>
    </tr>
</table>



</div>
<?PHP 
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>