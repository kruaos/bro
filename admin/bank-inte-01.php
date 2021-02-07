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
  function type_bank($bankid)
  {
    $type = array("", "ออมทรัพย์", "ฝากประจำ 3 เดือน", "ฝากประจำ 6 เดือน", "ฝากประจำ 12 เดือน");
    return  $type[substr($bankid, 1, 1)];
  }

  function CountDate($frist_date_dep, $end_date_dep)
  {
    return floor(((strtotime($end_date_dep) - strtotime($frist_date_dep)) / (60 * 60)) / 24);
  }

  function DateTimeDiff($strDateTime1, $strDateTime2)
  {
    return floor(((strtotime($strDateTime2) - strtotime($strDateTime1)) / (60 * 60)) / 24);
  }

  include('../config/config.php');

  $sql = "select * from bankmember  where bankid ='" . $_GET['bankid'] . "'";
  $qinfo = mysqli_query($link, $sql);
  // echo $sql;
  while ($rsinfo = mysqli_fetch_array($qinfo)) {
    $fullname = $rsinfo['pname'] . $rsinfo['fname'] . "  " . $rsinfo['lname'];
    $bankname = $rsinfo['bankname'];
    $bankid = $rsinfo['bankid'];
    $type_bank = type_bank($rsinfo['bankid']);
  }
  ?>
  <div class="card-body">
    <div class="alert alert-primary" role="alert">
      <h6 class="m-0 font-weight-bold text-primary">ข้อมูลบัญชีธนาคารของ <?php echo $fullname . " ชื่อบัญชี " . $bankname; ?><br> บัญชีเลขที่ <?php echo $bankid; ?> ประเภทบัญชี <?php echo $type_bank; ?> [ กรณีคิดดอกเบี้ย กลางปี มิ.ย /ปลายปี ธ.ค.]
      </h6>
    </div>

    <!-- nav แสดงหน้า -->
    <nav aria-label="Page navigation example">
      <ul class="pagination">

      </ul>
    </nav>


    <table class="table table-sm " width="100%" cellspacing="0">
      <tdead>
        <tr class="table-secondary">
          <th>num</th>
          <th>deptime </th>
          <th>สถานะ </th>
          <td width='100' align="right">ฝาก </td>
          <td width='100' align="right">ถอน </td>
          <td width='100' align="right">คงเหลือ </td>
          <td align="center">เวลาที่เงินอยู่ในระบบ [dep_live]</td>
          <td align="center">ดอกเบี้ย [inte]</td>
          <td align="center">เงินฝาก+ดอกเบี้ย</td>
        </tr>
      </tdead>
      <tbody>
        <?php
        $sql = "select * from bankevent where  code<>'del' and bankid like '" . $_GET['bankid'] . "%' order by createdate ";
        $query = mysqli_query($link, $sql);
        $num = 0;
        $amount = 0;
        $last_date = 0;
        $last_dep = 0;
        $total_day = 0;
        $iin = 0.125;
        $datebank = "";
        $show_int = 0;
        $midyear = "";
        $interest_for_memo=0;

        while ($rs1 = mysqli_fetch_array($query)) {

          /*
old คือ งวดที่แล้ว 
now คือ วันที่ปัจจุบัน 
dep คือ ยอดตามบันทึกการฝาก
*/
          // comment 1 ตารางพิเศษ กาารคิดดอกเบี้ย ปี 
        ?>

          <?php
          // comment 2 ตารางพิเศษ กาารคิดดอกเบี้ย กลางปี comment 2 อาจจะไม่ใช้ เพราะ ให้ แสดง ด้านหน้าอย่างเดียว 
          $fyo = substr($datebank, 0, 4);                     // $last_year_old
          $fdd = substr($rs1['createdate'], 8, 2);            // $last_day_dep
          $fmd = substr($rs1['createdate'], 5, 2);            // $last_month_dep
          $fyd = substr($rs1['createdate'], 0, 4);            // $last_year_dep

          $mdo = substr($datebank, 8, 2);                             // $middle_day_old
          $mmo = substr($datebank, 5, 2);                             // $middle_month_old
          $myo = substr($datebank, 0, 4);                             // $middle_month_old

          $mdd = substr($rs1['createdate'], 8, 2);                    // $middle_day_now
          $mmd = substr($rs1['createdate'], 5, 2);                    // $middle_month_now
          $myd = substr($rs1['createdate'], 0, 4);                    // $middle_year_now
          $midyear = $myd . "-06-30";
          // echo $datebank;exit;
          // echo $mdo." >".$mdd." || ";
          // echo $md;exit;

          // if(($mmo<$mmd)and($mmo<=6)and($mmd>=7)and($num<>0)){    /*  just do ti    */

          // echo "(".$mmo."<".$mmd.")(".$mmo."<=6)(".$mmd.">=7)or(".$fyd.">".$fyo.")(".$num.">0)<br>";
          // if($fyd>=$fyo){
          if ((($mmo < $mmd) or ($fyd > $fyo)) and ($mmo <= 6) and (($mmd >= 7) or ($fyd > $fyo)) and ($num > 0)) {    /*  just do ti    */
          ?>
            <!-- <tr>  -->
            <tr class="bg-success">
              <td><?php echo $num = $num + 1;
                  // echo "-e1";
                  ?></td>
              <td><?php echo show_day($midyear); ?></td>
              <td><?php echo 'ดอกเบี้ย'; ?></td>
              <td align='right'>-</td>
              <td align='right'>-</td>
              <td align='right'><?php echo number_format($last_dep, 2); ?></td>
              <td align='center'>
                <?php
                $datenow = $last_date;                                // $frist_date_dep(วันที่ยอดก่อนหน้า) $end_date_dep(วันที่ยอดปัจจุบัน) ตัวแปรน่าจะชื่อนี้ 
                $datebank = substr($midyear, 0, 10);                    // $now_data_dep (ยอด ณ วันที่ทคิดบัญชี)
                $total_day = DateTimeDiff($datenow, $datebank);
                // echo $datenow." -> ".$datebank." = ";
                echo $total_day . " วัน";
                $last_date = $datebank;

                ?>
              </td>
              <td><?php
                  $inte = $last_dep * $iin / 100 * $total_day / 365;
                  // echo $last_dep."*".$total_day." = ";
                  $last_dep = $amount;                                      // ยอดสุดท้าย $set_last_dep(ตั้งค่ายอดยกไป)=$amount_dep(ยอด ณ วันที่คิดดอกเบี้ย)

                  // echo "[".number_format($show_int,2)."] >";
                  echo  number_format($inte, 2) . " = ";
                  if ($num == 2) {
                    // echo "choice1 -> ";
                    echo number_format($inte, 2);            // เนื่องจาก มีการฝากในวันเดี่ยวกัน 
                  } else {
                    $interest_for_memo = ($show_int + $inte);
                    // echo "choice2 -> ";
                    echo number_format(($interest_for_memo), 2);        // เนื่องจากวันก่อนหน้า มีระยะเวลาคิดดอกเบี้ย เข้าเงื่อนไข 
                  }
                  $show_int = 0;                                            // ตั้งค่า $show_int_dep เป็น 0 เพื่อเริ่มเก็บสะสมใหม่ 
                  ?></td>
              <td>
              <!-- ดอกกลางปี -->
              <?php 
                  $showamout=$interest_for_memo+$last_dep;
                  echo number_format($showamout,2);
                  $amount=$amount+$interest_for_memo;
                ?>
              </td>
            </tr>
          <?php
            // } 
          } // ปิดเช็คตารางแรก 
          ?>

          <?php
          if ($num <> 0) { // 1.1 เช็ค ว่าเป็นตรารางแรกหรือไม่ หากใช่ให้ข้ามไป 
            /*
$fyo = substr($datebank,0,4);                     // $last_year_old
$fdd = substr($rs1['createdate'],8,2);            // $last_day_dep
$fmd = substr($rs1['createdate'],5,2);            // $last_month_dep
$fyd = substr($rs1['createdate'],0,4);            // $last_year_dep
*/
            $lastyear = $fyo . "-12-31";                          // $lastyear=$last_date_old
            if ($fyd > $fyo) {   // ดูท้ายปี ว่ามีหรือไม่              // $last_year_dep>$last_year_old
              // echo $yo." -> ".$yd;          exit;
              // echo $md;
              // echo show_day($datebank);exit;
          ?>
              <!-- <tr> -->
              <tr class="bg-warning">
                <td><?php echo $num = $num + 1;
                    // echo "-e2";
                    ?></td>
                <td><?php echo show_day($lastyear); ?></td>
                <td><?php echo 'ดอกเบี้ย'; ?></td>
                <td align='right'>-</td>
                <td align='right'>-</td>
                <td align='right'><?php echo number_format($last_dep,2); ?></td>
                <td align='center'>
                  <?php
                  // echo $frist_date_dep=$rs1['createdate'];
                  // echo "<br>";
                  // echo $end_date_dep=$datebank;
                  // echo "<br>";
                  // echo countdate($frist_date_dep,$end_date_dep);
                  // echo "<br>";                        
                  // echo $fdd."/".$fmd."/".$fyd."/".$fyo;
                  // echo "<br>";                        
                  $datenow = $lastyear;
                  $datebank = substr($last_date, 0, 10);
                  $total_day = DateTimeDiff($datebank, $datenow);
                  // echo $datebank." -> ".$datenow." = ";
                  echo $total_day . " วัน";
                  $last_date = $datenow;
                  ?>
                </td>
                <td><?php
                    $inte = $last_dep * $iin / 10 * $total_day / 365;
                    // echo $last_dep."*".$total_day." = ";

                    $last_dep = $amount;

                    // echo (10000*0.75/100*4/365);
                    // echo "[".number_format($show_int,2)."] >";
                    echo number_format($inte, 2) . " = รวม ";
                    $interest_for_memo = ($show_int + $inte);
                    echo number_format($interest_for_memo, 2);
                    $show_int = 0;
                    ?></td>
                <td>
                <!-- ดอกปลายปี -->
                <?php 
                  $showamout=$interest_for_memo+$last_dep;
                  echo number_format($showamout,2);
                  $amount=$amount+$interest_for_memo;
                ?>
                
                </td>

              </tr>
            <?php
            }
            ?>
          <?php
          }
          // comment 3 คิดดอกเบี้ยแบบปกติ          
          ?>
          <tr>
            <td><?php echo $num = $num + 1;
                // echo "-e3";
                ?></td>
            <td><?php echo show_day(substr($rs1['createdate'], 0, 10)); ?></td>
            <td><?php echo $rs1['code']; ?></td>
            <td align='right'>
              <?php
              if ($rs1['income'] > 0) {
                echo number_format($rs1['income'], 2);
              }
              ?>
            </td>
            <td align='right'>
              <?php
              if ($rs1['income'] < 0) {
                echo number_format(abs($rs1['income']), 2);
              }
              ?>
            </td>
            <td align='right'>
              <?php
              $amount = $amount + $rs1['income'];
              echo number_format($amount, 2);
              ?>
            </td>
            <td align='center'>
              <?php
              $datenow = $last_date;
              $datebank = substr($rs1['createdate'], 0, 10);
              $total_day = DateTimeDiff($datenow, $datebank);
              if ($num != 1) {
                // echo $datenow." -> ".$datebank." = ";
                echo $total_day . " วัน";
              }
              $last_date = substr($rs1['createdate'], 0, 10);

              ?></td>
            <td><?php
                $inte = $last_dep * $iin / 10 * $total_day / 365;
                // echo $last_dep."*".$total_day." = ";
                $last_dep = $amount;
                if ($num != 1) {
                  // echo (10000*0.75/100*4/365);
                  // echo "[".number_format($show_int,2)."] > ";
                  echo  number_format($inte, 2);
                  if ($num == 2) {
                    $show_int = $inte;
                  } else {
                    $show_int = $show_int + $inte;
                  }
                }
                ?></td>
              <td>
              <!-- 0 - คงเหลือแสดง -->
              <?php
              echo number_format($amount,2);
              ?>
            </td>
          </tr>
          <?php
        } // ปิดการ loop แสดงผล 
        // comment 4 แสดงผลตารางสุดท้าย สรุปรวม 

        $mdo = substr($datebank, 8, 2);
        $mmo = substr($datebank, 5, 2);
        $myo = substr($datebank, 0, 4);

        $mdn = date('d');
        $mmn = date('m');
        $myn = date('Y');

        // echo "<br>".$mmo."/".$myo." -> ".$mmn."/".$myn."<br>";
        $x = 0;
        for ($i = $myo; $i <= $myn; $i++) {
          if (($i == $myo) and ($mmo <= 6) and ($i <> $myn)) {  // กรณีครึ่งปีแกรง ของบัญชี ถ้ามี 
            // $x=$x+1;
            $midyear = $myo . "-06-30";
          ?>
            <tr>
              <!-- <tr class="bg-success">  -->
              <td><?php echo $num = $num + 1;
                  // echo "-e4";
                  ?></td>
              <td><?php echo show_day($midyear); ?></td>
              <td><?php echo 'ดอกเบี้ย'; ?></td>
              <td align='right'>-</td>
              <td align='right'>-</td>
              <td align='right'><?php echo number_format($last_dep, 2); ?></td>
              <td align='center'>
                <?php
                $datenow = $last_date;
                $datebank = $midyear;
                $total_day = DateTimeDiff($datenow, $datebank);
                // echo $datenow." -> ".$datebank." = ";
                echo $total_day . " วัน";
                $last_date = $midyear;
                ?>
              </td>
              <td><?php
                  $inte = $last_dep * $iin / 10 * $total_day / 365;
                  // echo $last_dep."*".$total_day." = ";
                  $last_dep = $amount;

                  // echo (10000*0.75/100*4/365);
                  // echo "[".number_format($show_int,2)."] > ";
                  echo  number_format($inte, 2);
                  ?></td>
              <td>a</td>

            </tr>
          <?php
          }
          if (($i > $myo) and ($i < $myn)) { // กรณี คิดครึ่งปี คิดแบบปกติ 
            // $x=$x+1;
            $midyear = $i . "-06-30";
          ?>
            <!-- <tr> -->
            <tr class="bg-success">
              <td><?php echo $num = $num + 1;
                  // echo "-e5";
                  ?></td>
              <td><?php echo show_day($midyear); ?></td>
              <td><?php echo 'ดอกเบี้ย'; ?></td>
              <td align='right'>-</td>
              <td align='right'>-</td>
              <td align='right'><?php echo number_format($last_dep, 2); ?></td>
              <td align='center'>
                <?php
                $datenow = $midyear;
                $datebank = $last_date;
                $total_day = DateTimeDiff($datebank, $datenow);
                // echo $datenow." -> ".$datebank." = ";
                echo $total_day . " วัน";
                $last_date = $midyear
                ?>
              </td>
              <td>
                <?php
                $inte = $last_dep * $iin / 10 * $total_day / 365;
                // echo $last_dep."*".$total_day." = ";
                $last_dep = $amount;

                // echo (10000*0.75/100*4/365);
                // echo "[".number_format($show_int,2)."] > ";
                echo  number_format($inte, 2);
                ?>
              </td>
              <td>
              <!-- b - กลางปี ส่วนท้าย -->
              <?php 
                  $showamout=$interest_for_memo+$last_dep;
                  echo number_format($showamout,2);
                  $amount=$amount+$interest_for_memo;
                ?>
              </td>

            </tr>
          <?php
          }
          if (($i == $myn) and ($mmn >= 6)) {  // กรณี ครึ่งปี ในปีบัญชีก่อนยอดสุดท้าย 
            // $x=$x+1;
            $midyear = $i . "-06-30";
          ?>
            <tr>
              <!-- <tr class="bg-success">  -->
              <td><?php echo $num = $num + 1;
                  // echo "-e6";
                  ?></td>
              <td><?php echo show_day($midyear); ?></td>
              <td><?php echo 'ดอกเบี้ย'; ?></td>
              <td align='right'>-</td>
              <td align='right'>-</td>
              <td align='right'><?php echo number_format($last_dep, 2); ?></td>
              <td align='center'>
                <?php
                $datenow = $midyear;
                $datebank = $last_date;
                $total_day = DateTimeDiff($datebank, $datenow);
                // echo $datenow." -> ".$datebank." = ";
                echo $total_day . " วัน";
                $last_date = $midyear;
                ?>
              </td>
              <td>
                <?php
                $inte = $last_dep * $iin / 10 * $total_day / 365;
                // echo $last_dep."*".$total_day." = ";
                $last_dep = $amount;

                // echo (10000*0.75/100*4/365);
                // echo "[".number_format($show_int,2)."] > ";
                echo  number_format($inte, 2);
                ?>
              </td>
              <td>c 
              
              </td>

            </tr>
          <?php
          }
          if (($i < $myn) and ($i <> $myn)) {
            // $x=$x+1;
            $endyear = $i . "-12-31";
          ?>
            <!-- <tr> -->
            <tr class="bg-warning">
              <td><?php echo $num = $num + 1;
                  // echo "-e7";
                  ?></td>
              <td><?php echo show_day($endyear); ?></td>
              <td><?php echo 'ดอกเบี้ย'; ?></td>
              <td align='right'>-</td>
              <td align='right'>-</td>
              <td align='right'><?php echo number_format($last_dep, 2); ?></td>
              <td align='center'>
                <?php
                $datenow = $last_date;
                $datebank = $endyear;
                $total_day = DateTimeDiff($datenow, $datebank);
                // echo $datenow." -> ".$datebank." = ";
                echo $total_day . " วัน";
                $last_date = $datebank;
                ?>
              </td>
              <td>
                <?php
                $inte = $last_dep * $iin / 10 * $total_day / 365;
                // echo $last_dep."*".$total_day." = ";
                $last_dep = $amount;

                // echo (10000*0.75/100*4/365);
                // echo "[".number_format($show_int,2)."] > ";
                echo  number_format($inte, 2);
                ?>
              </td>
              <td>
              <!-- d - ปลายปี ส่วนท้าย -->
              
              <?php 
                  $showamout=$interest_for_memo+$last_dep;
                  echo number_format($showamout,2);
                  $amount=$amount+$interest_for_memo;
                ?>
              </td>

            </tr>
        <?php
          }
          $showLastDep = $last_dep;
        }
        ?>
        <!-- <tr> -->
        <tr class="bg-info">
          <td><?php echo $num = $num + 1;
              // echo "-e8";
              ?></td>
          <td><?php echo show_day(date('Y-m-d h:m:s')); ?></td>
          <td><?php echo 'ดอกเบี้ย'; ?></td>
          <td align='right'>-</td>
          <td align='right'>-</td>
          <td align='right'><?php echo number_format($last_dep, 2); ?></td>
          <td align='center'>
            <?php
            $datenow = date('Y-m-d');
            $datebank = $last_date;
            $total_day = DateTimeDiff($datebank, $datenow);
            // echo $datebank." -> ".$datenow." = ";
            echo $total_day . " วัน";
            ?>
          </td>
          <td><?php
              $inte = $last_dep * $iin / 10 * $total_day / 365;
              // echo $last_dep."*".$total_day." = ";
              $last_dep = $amount;

              // echo (10000*0.75/100*4/365);
              // echo "[".number_format($show_int,2)."] > ";
              echo  number_format($inte, 2);
              ?>
          </td>
          <td>
<!--           
          e- ยอดสรุป
           -->
          <?php 
                  $showamout=$interest_for_memo+$last_dep;
                  echo number_format($showamout,2);
                  $amount=$amount+$interest_for_memo;
                ?>
          </td>

        </tr>


      </tbody>
    </table>
    <a href="bank-view.php?bankid=<?php echo $_GET['bankid']; ?>" class="btn btn-danger col-md-2 d-print-none">ย้อนกลับ</a>
    <a href="#" class="btn btn-success col-md-2 d-print-none">บันทึก</a>
    <!-- <a href="bank-inte-01.php?bankid=<?php echo $_GET['bankid']; ?>&viewset=show" class="btn btn-primary col-md-2 d-print-none" >แสดงการคำนวน</a> -->
    <input type="button" name="Button" value="พิมพ์" onclick="window.print();" class="btn btn-dark col-md-2 d-print-none">


  </div>
</div>

<?PHP
mysqli_close($link);
include('../tmp_dsh2/footer.php');
?>