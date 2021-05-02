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
    <div class="card-body">




        <table class="table table-sm " width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>รหัส</th>
                    <th>คำนำ</th>
                    <th>ชื่อ </th>
                    <th>สกุล</th>
                    <th>บ้านเลขที่ </th>
                    <th>หมู่</th>
                    <th>ตำบล</th>
                    <th>อำเภอ</th>
                    <th>จังหวัด</th>
                    <th>พชพ</th>
                    <th>วันที่สมัคร </th>
                    <th>วันที่หมด</th>
                    <th>เสียชีวิต</th>
                </tr>
            </thead>
            <tbody>
                <!-- loop  -->
                <?php
                $nowDate = date('Y-m-d');

                $sql = "SELECT * from member where CreateDate like '2021%' order by IDMember ";
                $query = mysqli_query($link, $sql);
                $num = 0;
                while ($rs = mysqli_fetch_array($query)) {
                    $IDMember = $rs['IDMember'];

                ?>
                    <tr>
                        <td>
                            <?php echo sprintf('%04d', $IDMember); ?>
                        </td>
                        <td>
                            <?php
                            echo $rs['Title'];
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $rs['Firstname'];
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $rs['Lastname'];
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $rs['AddressNum'];
                            ?>
                        </td>

                        <td>
                            <?php
                            echo $rs['AddressGroup'];
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $rs['Tambol'];
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $rs['Amphur'];
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $rs['Province'];
                            ?>
                        </td>
                        <td>
                            <?php
                            // echo $rs['MemberStatus'];
                            ?>
                        <?php
                        $sql2 = "SELECT * from regfund where IDMember=$IDMember";
                        $query2 = mysqli_query($link, $sql2);
                        $insu = $query2->num_rows;
                        if($insu=='1'){
                            echo " ";
                        }else if($insu=='2'){
                            echo "พชพ.";
                        }

                        ?>
                        </td>
                        <td>
                            <?php
                            echo show_day($rs['CreateDate']);
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $rs['ExpireDate'];
                            ?>
                        </td>
                        <td>
                        </td>

                    </tr>
                <?php
                }
                mysqli_close($link);
                ?>
            </tbody>
        </table>
    </div>
</div>

<?PHP
include('../tmp_dsh2/footer.php');
?>