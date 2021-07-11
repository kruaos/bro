<?php
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
?>
<div class="container-fluid">
    <?php
    function show_day($showday)
    {
        $m_name = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        echo  number_format(substr($showday, 8, 2)) . "  " . $m_name[number_format(substr($showday, 5, 2))] . " " . (substr($showday, 0, 4) + 543);
    }
    ?>

    <?php
    if (isset($_GET['memid']) == null) {
        // echo "not see memid";
    ?>
    <div class="container mt-5">
        <form>
            <div class="form-group">
            <label class="h1">กรอกรหัสมาชิกสมาชิกสัจจะ (ตรวจสอบการค้าประกัน) </label>
                <input style="font-size:large; height:50px;"  type="number" name="memid" class="form-control" placeholder="กรอกรหัสสมาชิก" placeholder="0-9" required>
            </div>
            <button type="submit" class="btn btn-primary col-12" ><h1>ค้นหา
            </h1></button>
        </form>
    </div>


    <?php
    } else {
        // echo "see member id  ";
    ?>


        <?php
        include('../config/config.php');
        $idmember = $_GET['memid'];
        $sql2 = "SELECT * from member where IDMember = $idmember";
        $query2 = mysqli_query($link, $sql2);
        while ($rs = mysqli_fetch_array($query2)) {
            $fullname = $rs['Title'] . $rs['Firstname'] . " " . $rs['Lastname'];
        }
        ?>
        <div class="card-header py-3">
            <p>
                <span>
                    ข้อมูลการค้ำประกันของ
                </span>
                <span class="m-0 font-weight-bold text-primary">
                    <?php echo  $fullname; ?>
                </span>
                <span>
                    รหัสสมาชิก
                </span>
                <span class="m-0 font-weight-bold text-primary">
                    <?php echo $_GET['memid']; ?>
                </span>
            </p>

        </div>
        <div class="card-body">
            <h3 class="text-danger">รายการค้ำ ที่ยังไม่ได้ปิดบัญชี </h3>
            <table class="table table-bordered  table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ผู้กู้</th>
                        <th>บัญชีเลขที่ </th>
                        <th>วันที่ </th>
                        <th>วงเงิน</th>
                        <th>ผู้ค้ำประกัน</th>
                        <th>สถานะบัญชี</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- loop  -->
                    <?php
                    $sql = "SELECT * from Loanbook where LoanStatus ='n'  and (Insurer1=$idmember or Insurer2= $idmember ) ";

                    // $sql = "SELECT * from Loanbook where Insurer1=" . $_GET['memid'] . " or Insurer2=" . $_GET['memid'];
                    $query = mysqli_query($link, $sql);
                    $num = 0;
                    while ($rs1 = mysqli_fetch_array($query)) {
                    ?>
                        <tr>
                            <td><?php echo  $num = $num + 1; ?></td>
                            <td><?php
                                $sql2 = 'select * from member where IDMember=' . $rs1['IDMember'];
                                $query2 = mysqli_query($link, $sql2);
                                while ($rs = mysqli_fetch_array($query2)) {
                                    $fullname = $rs['Title'] . $rs['Firstname'] . " " . $rs['Lastname'];
                                }
                                echo  $fullname;
                                ?>
                            </td>
                            <td>
                                <a href="loan-chk-show.php?RefNo=<?php echo $rs1['RefNo']; ?>&memid=<?php echo $_GET['memid']; ?>">
                                    <?php echo  $rs1['RefNo']; ?>
                                </a>
                            </td>
                            <td><?php echo  show_day($rs1['CreateDate']); ?></td>
                            <td><?php echo  number_format($rs1['Amount']); ?></td>
                            <td><?php
                                if ($rs1['Guaranty'] == null) {
                                    $sqli1 = 'select * from member where IDMember=' . $rs1['Insurer1'];
                                    $queryi1 = mysqli_query($link, $sqli1);
                                    while ($rsi1 = mysqli_fetch_array($queryi1)) {
                                        $fullname = $rsi1['Title'] . $rsi1['Firstname'] . " " . $rsi1['Lastname'];
                                    }
                                    if ($rs1['Insurer1'] == $_GET['memid']) {
                                        echo "<div class='text-danger'>";
                                    }
                                    echo "ผู้ค้ำประกันคนที่ 1 " . $fullname . "<br>";
                                    if ($rs1['Insurer1'] == $_GET['memid']) {
                                        echo "</div>";
                                    }
                                    $Insurer2 = $rs1['Insurer2'];
                                    $sqli2 = "SELECT * from member where IDMember=$Insurer2";
                                    // echo $sqli2;

                                    $queryi2 = mysqli_query($link, $sqli2);
                                    while ($rsi2 = mysqli_fetch_array($queryi2)) {
                                        $fullname = $rsi2['Title'] . $rsi2['Firstname'] . " " . $rsi2['Lastname'];
                                        if ($Insurer2  == $_GET['memid']) {
                                            // echo $rsi2['Insurer2'] ;
                                            echo "<div class='text-danger'>";
                                        }
                                        echo "ผู้ค้ำประกันคนที่ 2 " . $fullname . "<br>";
                                        if ($Insurer2 == $_GET['memid']) {
                                            echo "</div>";
                                        }
                                    }
                                }
                                ?></td>
                            <td><?php
                                $LoanStatus = $rs1['LoanStatus'];
                                if ($LoanStatus == 'C') {
                                    echo "ปิดบัญชี";
                                } else if ($LoanStatus == 'n' or 'N') {
                                    echo "<div class='text-danger'>ยังไม่ปิด</div>";
                                }
                                // echo  $rs1['LoanStatus']; 
                                ?></td>
                        </tr>

                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="card-body">
            <h3 class="text-primary">รายการค้ำที่ปิดบัญชีแล้ว </h3>
            <table class="table table-bordered  table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ผู้กู้</th>
                        <th>บัญชีเลขที่ </th>
                        <th>วันที่กู้ </th>
                        <th>วงเงิน</th>
                        <th>ผู้ค้ำประกัน</th>
                        <!-- <th>สถานะบัญชี</th> -->
                        <th>วันที่ปิดบัญชี</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- loop  -->
                    <?php

                    $sql = "SELECT * from Loanbook where LoanStatus = 'C' and (Insurer1=$idmember or Insurer2= $idmember ) ";
                    $query = mysqli_query($link, $sql);
                    $num = 0;
                    while ($rs1 = mysqli_fetch_array($query)) {
;
                    ?>
                        <tr>
                            <td><?php echo  $num = $num + 1; ?></td>
                            <td><?php
                                $sql2 = 'select * from member where IDMember=' . $rs1['IDMember'];
                                $query2 = mysqli_query($link, $sql2);
                                while ($rs = mysqli_fetch_array($query2)) {
                                    $fullname = $rs['Title'] . $rs['Firstname'] . " " . $rs['Lastname'];
                                }
                                echo  $fullname;
                                ?>
                            </td>
                            <td>
                                <a href="loan-chk-show.php?RefNo=<?php echo $rs1['RefNo']; ?>&memid=<?php echo $_GET['memid']; ?>">
                                    <?php echo  $rs1['RefNo']; ?>
                                </a>
                            </td>
                            <td><?php echo  show_day($rs1['CreateDate']); ?></td>
                            <td><?php echo  number_format($rs1['Amount']); ?></td>
                            <td><?php
                                if ($rs1['Guaranty'] == null) {
                                    $sqli1 = 'select * from member where IDMember=' . $rs1['Insurer1'];
                                    $queryi1 = mysqli_query($link, $sqli1);
                                    while ($rsi1 = mysqli_fetch_array($queryi1)) {
                                        $fullname = $rsi1['Title'] . $rsi1['Firstname'] . " " . $rsi1['Lastname'];
                                    }
                                    if ($rs1['Insurer1'] == $_GET['memid']) {
                                        echo "<div class='text-danger'>";
                                    }
                                    echo "ผู้ค้ำประกันคนที่ 1 " . $fullname . "<br>";
                                    if ($rs1['Insurer1'] == $_GET['memid']) {
                                        echo "</div>";
                                    }
                                    $Insurer2 = $rs1['Insurer2'];
                                    $sqli2 = "SELECT * from member where IDMember=$Insurer2";
                                    // echo $sqli2;

                                    $queryi2 = mysqli_query($link, $sqli2);
                                    while ($rsi2 = mysqli_fetch_array($queryi2)) {
                                        $fullname = $rsi2['Title'] . $rsi2['Firstname'] . " " . $rsi2['Lastname'];
                                        if ($Insurer2  == $_GET['memid']) {
                                            // echo $rsi2['Insurer2'] ;
                                            echo "<div class='text-danger'>";
                                        }
                                        echo "ผู้ค้ำประกันคนที่ 2 " . $fullname . "<br>";
                                        if ($Insurer2 == $_GET['memid']) {
                                            echo "</div>";
                                        }
                                    }
                                }
                                ?></td>
<!-- 
                            <td>
                                <?php
                                $LoanStatus = $rs1['LoanStatus'];
                                if ($LoanStatus == 'C' or 'c') {
                                    echo "ปิดบัญชี";
                                } else if ($LoanStatus == 'n' or 'N') {
                                    echo "<div class='text-danger'>ยังไม่ปิด</div>";
                                }
                                // echo  $rs1['LoanStatus']; 
                                ?>
                            </td>
                             -->
                            <td>
                                <?php
                                echo show_day($rs1['LastUpdate']);
                                ?>
                            </td>

                        </tr>

                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <a href="loan-chk.php" class="btn btn-danger">ย้อนกลับ</a>
    <?php
        mysqli_close($link);
    }

    ?>


</div>

<?PHP

include('../tmp_dsh2/footer.php');
?>