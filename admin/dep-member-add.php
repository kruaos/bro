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
        <form method="POST" action="dep-member-insert.php">
            <div class=" form-group row">
                <div class="col">
                    <label class="col col-form-label">IDMember</label>
                    <input name="IDMember" type="number" class="form-control" required>
                </div>

            </div>

            <div class=" form-group row">
                <div class="col">
                    <label class="col col-form-label">title ชื่อนำ</label>
                    <select name="title" class="custom-select" >
                        <option value="นาย">นาย</option>
                        <option value="นาง">นาง</option>
                        <option value="นางสาว">นางสาว</option>
                    </select>
                </div>
                <div class="col">
                    <label class="col col-form-label">Firstname ชื่อ</label>
                    <input name="Firstname" type="text" class="form-control" required>
                </div>
                <div class="col">
                    <label class="col col-form-label">Lastname นามสกุล</label>
                    <input name="Lastname" type="text" class="form-control" required>
                </div>
            </div>

            <div class=" form-group row">
                <div class="col">
                    <label class="col col-form-label">AddressNum บ้านเลขที่</label>
                    <input name="AddressNum" type="text" class="form-control" required>
                </div>
                <div class="col">
                    <label class="col col-form-label">AddressGroup หมู่</label>
                    <input name="AddressGroup" type="text" class="form-control" required>
                </div>
                <div class="col">
                    <label class="col col-form-label">Tambol ตำบล</label>
                    <input name="Tambol" type="text" class="form-control" required>
                </div>
            </div>

            <div class=" form-group row">
                <div class="col">
                    <label class="colcol-form-label">Amphur อำเภอ </label>
                    <input name="Amphur" type="text" class="form-control" required>
                </div>
                <div class="col">
                    <label class="col col-form-label">Province จังหวัด</label>
                    <input name="Province" type="text" class="form-control" required>
                </div>
                <div class="col">
                    <label class="col col-form-label">IDCard บัตรประชาชน</label>
                    <input name="IDCard" type="text" class="form-control" maxlength="13" required>
                </div>
            </div>
            <div class=" form-group row">
                <div class="col">
                    <label class="colcol-form-label">CreateDate วันที่สมัคร</label> 
                    <input name="CreateDate" type="date" class="form-control" value="<?php echo date('Y-d-m');?>" required>
                </div>
                <div class="col">
                    <label class="col col-form-label">LastUpdate วันที่ปรับปรุง</label>
                    <input name="LastUpdate" type="date" class="form-control" value="<?php echo date('Y-d-m');?>" required>
                </div>
                <div class="col d-none">
                    <label class="col col-form-label">ExpireDate วันลาออก</label>
                    <input name="ExpireDate" type="date" class="form-control" value="0000-00-00" >
                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Birthday วันเกิด</label>
                <div class="col-sm-10">
                    <input name="Birthday" type="date" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">MemberStatus ประเภทสมาชิก</label>
                <div class="col-sm-10">
                    <select name="MemberStatus" class="custom-select" >
                        <option value="1">สมาชิกทั่วไป</option>
                        <option value="2">กิตติมศักดิ์</option>
                        <option value="3">คณะกรรมการ</option>
                    </select>
                </div>
            </div>

            <div class="form-group row d-none">
                <label class="col-sm-2 col-form-label">Comment บันทึก</label>
                <div class="col-sm-10">
                    <input name="Comment" type="text" class="form-control ">
                </div>
            </div>

            <div class="form-group row d-none">
                <label class="col-sm-2 col-form-label">DateResign ???</label>
                <div class="col-sm-10">
                    <input name="DateResign" type="text" class="form-control ">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                    <button type="reset" class="btn btn-warning">ล้าง</button>
                    <a class="btn btn-danger">ยกเลิก</a>
                </div>
            </div>
        </form>
    </div>

    <div class="card-body">
        <table class="table table-sm " width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>รหัส</th>
                    <th>ชื่อ - สกุล </th>
                    <th>ที่อยู่</th>
                    <th>เบอร์โทรศัพท์</th>
                    <th>LastUpdate</th>
                    <th>IDCard</th>
                    <th>MemberStatus</th>
                    <th>Birthday</th>
                </tr>
            </thead>
            <tbody>
                <!-- loop  -->
                <?php
                $nowDate = date('Y-m-d');
                $sql = "SELECT * from member where CreateDate='$nowDate' order by IDMember ";
                // $sql = "SELECT * from member order by IDMember ";
                $query = mysqli_query($link, $sql);
                $num = 0;
                while ($rs = mysqli_fetch_array($query)) {
                    // print_r($rs);
                    $IDMember = $rs['IDMember'];


                    // [0] => 1 [IDMember] => 1 
                    // [1] => น.ส. [Title] => น.ส. 
                    // [2] => สีลา [Firstname] => สีลา 
                    // [3] => ศรีวิชัย [Lastname] => ศรีวิชัย 
                    // [4] => 99 [AddressNum] => 99 
                    // [5] => 8 [AddressGroup] => 8 
                    // [6] => อุโมงค์ [Tambol] => อุโมงค์ 
                    // [7] => เมือง [Amphur] => เมือง 
                    // [8] => ลำพูน [Province] => ลำพูน 
                    // [9] => 1979-03-11 [Birthday] => 1979-03-11 
                    // [10] => [ExpireDate] => 
                    // [11] => 3 [MemberStatus] => 3 
                    // [12] => [Comment] => 
                    // [13] => 2001-03-29 [CreateDate] => 2001-03-29 
                    // [14] => 2016-12-04 [LastUpdate] => 2016-12-04 
                    // [15] => [IDCard] => 
                    // [16] => [DateResign] =>


                ?>
                    <tr>
                        <td><?php echo sprintf('%04d', $IDMember); ?></td>
                        <td><a href="dep-show-detail.php?IDMember=<?php echo $IDMember; ?>">
                                <?php
                                echo $rs['Title'] . $rs['Firstname'] . " " . $rs['Lastname'];
                                ?>
                            </a>
                        </td>
                        <td>
                            <?php
                            // $sql1 = "select * from regfund where IDMember=$IDMember";
                            // $query1 = mysqli_query($link, $sql1); {
                            //     Print_r($query1->num_rows);
                            // }
                            ?>
                        </td>
                        <td>
                            <?php
                            // $sql2 = "select * from regfund where IDMember=$IDMember and IDFund=1";
                            // $query2 = mysqli_query($link, $sql2);
                            // while ($rs2 = mysqli_fetch_array($query2)) {
                            //     Print_r($rs2['IDRegFund']);
                            // }
                            ?>
                        </td>
                        <td>
                            <?php
                            // $sql3 = "select * from regfund where IDMember=$IDMember and IDFund=2";
                            // $query3 = mysqli_query($link, $sql3);
                            // while ($rs3 = mysqli_fetch_array($query3)) {
                            //     Print_r($rs3['IDRegFund']);
                            // }
                            ?>
                        </td>
                        <td>
                            <?php
                            // $sql4 = "select * from regfund where IDMember=$IDMember and IDFund=3";
                            // $query4 = mysqli_query($link, $sql4);
                            // while ($rs4 = mysqli_fetch_array($query4)) {
                            //     Print_r($rs4['IDRegFund']);
                            // }
                            ?>
                        </td>
                        <td>
                            <a href="dep-show-detail.php?IDMember=<?php echo $IDMember; ?>" class="btn btn-sm btn-success">คลิก</a>
                        </td>
                        <td>
                            <a href="dep-show-detail1.php?IDMember=<?php echo $IDMember; ?>" class="btn btn-sm btn-danger">โอน</a>
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