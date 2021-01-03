<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
?>
<div class="container-fluid">
<?php 

function show_day($showday){
  $m_name = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  echo  number_format(substr($showday, 8,2))."  ".$m_name[number_format(substr($showday, 5,2))]." ".(substr($showday, 0,4)+543);
}
include('../config/config.php');
  $sql = "SELECT loanbook.*, member.Firstname,  member.Title,  member.Lastname   from loanbook, member where RefNo=".$_GET['RefNo']." and loanbook.IDMember= member.IDMember";
  $qmem = mysqli_query($link, $sql);
  $sumpay=0;
while($rsmemb = mysqli_fetch_array($qmem)){
  $showmem=$rsmemb['Title'].$rsmemb['Firstname']." ".$rsmemb['Lastname']." วงเงิน ".number_format($rsmemb['Amount'])." บาท";
  $rsamount=$rsmemb['Amount'];
  $CreateDateLoanBook=substr($rsmemb['CreateDate'],0,7)."-01";
  $CreateDateLoanBookShow=$rsmemb['CreateDate'];
  $IDMember=$rsmemb['IDMember'];
}


?>

            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">รายละเอียดการส่งกู้ ของ <?php echo $showmem?> 
              <br>
              เริ่มต้นสัญญา : <?php echo show_day($CreateDateLoanBookShow); ?> 
              รหัสสมาชิก : <?php echo $IDMember; ?> 
            </h6>
            </div>
            <div class="card-body"> 
                <table class="table table-bordered  table-sm"  width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th >งวดที่</th>
                      <th >เงินต้น</th>
                      <th >ดอกเบี้ย</th>
                      <th >รวมจ่าย</th>
                      <th >เงินต้นคงเหลือ</th>
                      <th >วันที่จ่าย</th>
                      <th >สถานะ</th>
                      <th >Username</th>
                    </tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 
  $CreateDateOld=$CreateDateLoanBook;
  $sql = "select * from loanpayment where RefNo=".$_GET['RefNo'];
  $query = mysqli_query($link, $sql);
  $sumpay=$rsamount;
  while($rs1 = mysqli_fetch_array($query)){

        $CreateDateNow=substr($rs1['CreateDate'],0,7)."-01";
        $CreateDateNowShow=$rs1['CreateDate'];

            list($byear, $bmonth, $bday)= explode("-",$CreateDateOld);       //จุดต้องเปลี่ยน
            list($tyear, $tmonth, $tday)= explode("-",$CreateDateNow);                //จุดต้องเปลี่ยน
      
            $mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear); 
            $mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear );
            $mage = ($mnow - $mbirthday);
  
            $u_y=date("Y",$mage)-1970;
            $u_m=date("m",$mage)-1;
            $u_d=date("d",$mage)-1;

            $count_time = ((($u_y*12)+$u_m)/12);

            $time=number_format($count_time,2);

            $CountMonthLoanpayment =(($u_y*12)+$u_m)-1;
            $count_m =($u_y*12)+$u_m;
            $deposit_comment= $u_y."ปี".$u_m."เดือน".$u_d."วัน = ".$count_m." เดือน -> ".$time." รอบ";

            $sumpay=$sumpay-$rs1['PayTotal'];

        ?>             
          <tr>
            <td><div class="text-center"><?php echo $rs1['InstalmentNo'];?></div></td>
            <td><div class="text-right"><?php echo  number_format($rs1['PayTotal']); ?></div></td>
            <td><div class="text-right"><?php echo  number_format($rs1['Interest']);?></div></td>
            <td><div class="text-right"><?php echo  number_format($rs1['Payment']); ?></div></td>
            <td><div class="text-right"><?php echo  number_format($sumpay); ?></div></td>
            <td><div class="text-center"><?php echo show_day($CreateDateNowShow)." | เดือนที่ ".substr($CreateDateNowShow,5,2); ?></div></td>
            <td><div class="text-center"><?php 
            // echo $CreateDateOld." > ".$CreateDateNow;
// echo $deposit_comment;

                        if($count_m>=2){
                          echo "ขาดส่ง ".$CountMonthLoanpayment." เดือน";
                        }
                        // echo  $deposit_comment; 
                        ?></div></td>
            <td><div class="text-center"><?php echo  $rs1['Username']; ?></div></td>
          </tr>
          <?php 
          $CreateDateOld=$CreateDateNow;
          $LastDate=$CreateDateNow;
          
      }
      mysqli_close($link);
      
      if(mysqli_num_rows($query)==0){
        // echo "1 | ";
        // echo $LastDate= $CreateDateLoanBook;
        $LastDate= substr($CreateDateLoanBook,0,7)."-01";
      }
      $TodayDate=date('Y-m')."-01";
      list($byear, $bmonth, $bday)= explode("-",$LastDate);       //จุดต้องเปลี่ยน
      list($tyear, $tmonth, $tday)= explode("-",$TodayDate);                //จุดต้องเปลี่ยน

      $mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear); 
      $mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear );
      $mage = ($mnow - $mbirthday);

      $u_y=date("Y",$mage)-1970;
      $u_m=date("m",$mage)-1;
      $u_d=date("d",$mage)-1;

      $count_time = ((($u_y*12)+$u_m)/12);

      $time=number_format($count_time,2);

      $CountMonthLoanpayment=($u_y*12)+$u_m;
      $count_m =($u_y*12)+$u_m;
      $deposit_comment= $u_y." ปี ".$u_m." เดือน ".$u_d." วัน = ".$count_m." เดือน -> ".$time." รอบ";

?>                    
                    <tr>
                      <td><?php   ?></td>
                      <td><div class="text-right"><?php  echo number_format($sumpay); ?></div></td>
                      <td><?php   ?></td>
                      <td><?php   ?></td>
                      <td><?php   ?></td>
                      <td><?php   ?></td>
                      <td class="text-center"><?php 
                        if($CountMonthLoanpayment<>0){
                          echo "เริ่ม ".$LastDate." ";  
                          echo "หยุด ".$TodayDate." ";  
                          echo " ".$deposit_comment." ";  
                          echo "ขาดส่ง ".$CountMonthLoanpayment." เดือน";  
                        }
                        ?>
                      </td>
                      <td><?php   ?></td>
                    </tr>
                  </tbody>
                </table>
                <div class="btn-group btn-block"> 
                  <a href="loan-late-show1.php?" class="btn btn-danger " >ย้อนกลับ</a>
                  <a href="loan-close-loanbook.php?RefNo=<?php echo $_GET['RefNo']; ?>" class="btn btn-secondary " >ปิดบัญชี</a>
                </div>
            </div>
          </div>
<?PHP 
include('../tmp_dsh2/footer.php');
?>