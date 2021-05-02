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

    include('../config/config.php');
    ?>

    <?php
    if (isset($_GET['IDmember']) == null) {
    ?>
        <form>
            <div class="form-group">
                <label>กรอกรหัสมาชิก</label>
                <input type="number" name="IDmember" class="form-control" placeholder="กรอกรหัสสมาชิก" placeholder="0-9" required>
            </div>
            <button type="submit" class="btn btn-primary">ค้นหา</button>
        </form>



    <?php
    } else {
        // echo "is null";
        $IDmember = $_GET['IDmember'];

        $sql2 = "SELECT * from member where IDMember=$IDmember";
        $query2 = mysqli_query($link, $sql2);
        // print_r($sql);
        $num = 0;
        while ($rs2 = mysqli_fetch_array($query2)) {
            $fullname = $rs2['Title'] . $rs2['Firstname'] . "  " . $rs2['Lastname'];
        }
    ?>
        <div class="card-header py-3">
            <span class="m-0">ประวัติการกู้เงิน</span>
            <span class="m-0 font-weight-bold text-primary"><?php echo $fullname; ?></span>
            <span class="m-0">รหัส</span>
            <span class="m-0 font-weight-bold text-primary"><?php echo $IDmember; ?></span>
        </div>
        <div class="card-body">
            <table class="table table-bordered  table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ผู้กู้</th>
                        <th>บัญชีเลขที่ </th>
                        <th>วันที่ </th>
                        <th>วงเงิน</th>
                        <th>หลักทรัพย์</th>
                        <th>สถานะบัญชี</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- loop  -->
                    <?php
                     $sql = "SELECT member.*, loanbook.* FROM `loanbook`  INNER JOIN member on member.IDMember=loanbook.IDMember where loanbook.IDMember=$IDmember";
                     $query = mysqli_query($link, $sql);
                     // print_r($sql);
                     $num = 0;
                    while ($rs1 = mysqli_fetch_array($query)) {
                    ?>
                        <tr>
                            <td><?php echo  $num = $num++; ?></td>
                            <td><?php echo  $fullname; ?></td>
                            <td>
                                <a href="loan-pay-show1.php?RefNo=<?php echo $rs1['RefNo']; ?>&memid=<?php echo $IDmember; ?>">
                                    <?php echo  $rs1['RefNo']; ?>
                                </a>
                            </td>
                            <td><label><?php echo  show_day($rs1['CreateDate']); ?></label></td>
                            <td><?php echo  number_format($rs1['Amount']); ?></td>
                            <td><?php
                                if ($rs1['Guaranty'] == null) {
                                    $sqlint1 = 'select * from member where IDMember=' . $rs1['Insurer1'];
                                    $qint1 = mysqli_query($link, $sqlint1);
                                    while ($rsin1 = mysqli_fetch_array($qint1)) {
                                        $fullname1 = $rsin1['Title'] . $rsin1['Firstname'] . " " . $rsin1['Lastname'];
                                    }
                                    echo "ผู้ค้ำประกันคนที่ 1 " . $fullname1;
                                    $sqlint2 = 'select * from member where IDMember=' . $rs1['Insurer2'];
                                    $qint2 = mysqli_query($link, $sqlint2);
                                    while ($rsin2 = mysqli_fetch_array($qint2)) {
                                        $fullname2 = $rsin2['Title'] . $rsin2['Firstname'] . " " . $rsin2['Lastname'];
                                    }
                                    echo "<br>ผู้ค้ำประกันคนที่ 2 " . $fullname2;
                                } else {
                                    echo  $rs1['Guaranty'];
                                }
                                ?></td>
                            <td>
                                <?php
                                if ($rs1['LoanStatus'] == "N") {
                                    // echo $rs1['LoanStatus']; 
                                    echo  "<span class='badge badge-danger'>อยู่ระหว่างการกู้</span>";
                                } else if ($rs1['LoanStatus'] == "C") {
                                    // echo $rs1['LoanStatus']; 
                                    echo  "ปิดบัญชี";
                                }

                                ?>
                            </td>
                        </tr>

                    <?php
                    }
                    mysqli_close($link);
                    ?>
                </tbody>
            </table>
            <a href="loan-agreement.php" class="btn btn-danger">ย้อนกลับ</a>

        </div>

    <?php
    }
    ?>


</div>

<?PHP
include('../tmp_dsh2/footer.php');
?>