<?php
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

$Username = $_GET['Username'];
?>
<div class="container-fluid">
    <?php
    function show_day($showday)
    {
        $m_name = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        echo  number_format(substr($showday, 8, 2)) . "  " . $m_name[number_format(substr($showday, 5, 2))] . " " . (substr($showday, 0, 4) + 543);
    }
    $now_data = date('Y-m-d');
    $sqlSelectName = "SELECT * from employee where Username = '$Username'";
    $qSelectName =  mysqli_query($link, $sqlSelectName);
    $rs4 = mysqli_fetch_array($qSelectName);
    $FullnameUser = $rs4['Firstname']."  ".$rs4['Lastname'];


    ?>
    <h3 class="m-0 font-weight-bold text-primary">รายละเอียดการรับเงินฝากสัจจะ/เพื่อนช่วยเพื่อน</h6>
        <h3 class="m-0 font-weight-bold ">ของ <?php echo  $FullnameUser; ?></h6>
        <h3 class="m-0 font-weight-bold ">ประจำวันที่  <?php echo  show_day($now_data); ?></h6>

            <div class="row pt-5">
                <table class="table table-sm" cellspacing="0" style="font-size: 20px;">

                    <?php
                    $countSql1 = "SELECT  Count(Amount) as amountDepCount , Sum(Amount) as amountDepSum 
          from deposit 
          where Amount='30' and createdate='$now_data' and Username='$Username'";
                    $queryCount =  mysqli_query($link, $countSql1);
                    // print_r($queryCount);
                    $rs1 = mysqli_fetch_array($queryCount);
                    $amountDepCount = $rs1['amountDepCount'];
                    $amountDepSum = $rs1['amountDepSum'];

                    $countSql2 = "SELECT  Count(Amount) as amountInsCount , Sum(Amount) as amountInsSum 
          from deposit 
          where Amount<>'30' and createdate='$now_data' and Username='$Username'";
                    $queryCount2 =  mysqli_query($link, $countSql2);
                    // print_r($queryCount);
                    $rs2 = mysqli_fetch_array($queryCount2);
                    $amountInsCount = $rs2['amountInsCount'];
                    $amountInsSum = $rs2['amountInsSum'];

                    $countSql3 = "SELECT  Count(Amount) as amountSUM 
          from deposit 
          where createdate='$now_data' and Username='$Username'";
                    $queryCount3 =  mysqli_query($link, $countSql3);
                    // print_r($queryCount);
                    $rs3 = mysqli_fetch_array($queryCount3);
                    $amountSUM = $rs3['amountSUM'];
                    ?>

                    <tr class='table-active'>
                        <td colspan="2">จำนวน เงินฝากสัจจะ</td>
                        <td style='text-align:right'><?php echo $amountDepCount; ?></td>
                        <td>ราย</td>
                        <td>เป็นเงิน </td>
                        <td style='text-align:right'>
                            <?php
                            echo number_format($amountDepSum, 2);
                            ?></td>
                        <td>บาท</td>
                        <td></td>
                    </tr>
                    <tr class='table-active'>
                        <td colspan="2"> จำนวน เงินฝากเพื่อนช่วยเพือ่น</td>
                        <td style='text-align:right'><?php echo $amountInsCount; ?></td>
                        <td>ราย</td>
                        <td>เป็นเงิน </td>
                        <td style='text-align:right'>
                            <?php
                            echo number_format($amountInsSum, 2);
                            ?></td>
                        <td>บาท</td>
                        <td></td>
                    </tr>
                    <tr class='table-active'>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>ยอดรวม</td>
                        <td style='text-align:right'>
                            <?php
                            echo number_format($amountSUM, 2);
                            ?></td>
                        <td>บาท</td>
                        <td></td>
                    </tr>

                    <?PHP

                    mysqli_close($link);
                    ?>
                    </tbody>
                </table>
                <button class="col-3 btn btn-danger col d-print-none" onclick="window.print()">พิมพ์รายงาน</button>
                <a class="col-3 btn btn-secondary col d-print-none" href="dep-report.php"> ย้อนกลับ </a>
            </div>
</div>

<?PHP
include('../tmp_dsh2/footer.php');
?>