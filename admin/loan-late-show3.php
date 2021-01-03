<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');
?>
<div class="container-fluid">
<?php 
function show_day($showday){
  $m_name = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  echo  number_format(substr($showday, 8,2))."  ".$m_name[number_format(substr($showday, 5,2))]." ".(substr($showday, 0,4)+543);
}

    $IDMemberSql = "select * from member ORDER BY IDMember ASC";
    $LoanBookSql="SELECT * from loanbook where LoanStatus ='C' Order by LastUpdate desc limit 0,100" ;
    $query = mysqli_query($link, $LoanBookSql);
    $total_record=$query->num_rows;
?>
    <div class="card-body">    
    <h4 class="m-0 font-weight-bold text-primary">ข้อมูลสมาชิกเงินกู้ปิดบัญชี  จำนวน <?php echo $total_record; ?> รายล่าสุด 
    <a href="loan-late-show-all.php" class="btn btn-primary">ดูทั้งหมด</a>  
  </h4>
    <table class="table table-sm "  width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th >รหัส</th>
                      <th >ชื่อ - สกุล </th>
                      <th >สถานะการกู้ปัจจุบัน</th>
                      <th >วันที่ยื่นกู้</th>
                      <th >วันที่ปิดบัญชี </th>
                      <!-- <th >จำนวนเดือนผิดนัด</th> -->
                      <th class="d-print-none">แสดงรายการ</th>
                      <th class="d-print-none" >ประวัติการกู้</th>
                      <th class="d-print-none">ประวัติการค้ำ</th>
                    </tr>
                  </thead>
                  <tbody>
<!-- loop  -->       
<?php 

$query = mysqli_query($link, $LoanBookSql);
$num=0; 
while($rs1 = mysqli_fetch_array($query))
{
    $IDMember=$rs1['IDMember'];
    $RefNo=$rs1['RefNo'];
    $LastUpdate=$rs1['LastUpdate'];

    $FullNameSql = "SELECT * from member where IDMember='$IDMember' ";
    $FullNameQuery = mysqli_query($link, $FullNameSql);
    while($FNQ = mysqli_fetch_array($FullNameQuery)){
        $FullName=$FNQ['Title'].$FNQ['Firstname']." ".$FNQ['Lastname'] ;
    } 
    $LastLoanPaymentSql="SELECT * from loanpaymentlastdate where RefNo='$RefNo' ";
    $LastLoanPaymentQuery = mysqli_query($link, $LastLoanPaymentSql);
    ?>             
        <tr>
            <td><?php echo sprintf('%04d',$rs1['IDMember']); ?></td>
            <td><?php echo $FullName; ?>
            </td>
            <td>
            <?php 
            $sqlin3 = "select * from Loanbook where IDMember='$IDMember' and LoanStatus='N'";
            $queryin3 = mysqli_query($link, $sqlin3);
            if ($queryin3->num_rows==0){
              // print_r($queryin3);
              ?>
            ไม่มีการกู้ขณะนี้ 
            <?php }else if ($queryin3->num_rows==1){?>
            <div class='bg-success'> มีการกู้ <?php echo $queryin3->num_rows; ?></div>
            <?php }else{ ?>         
            <div class='bg-warning'> มีการกู้ <?php echo $queryin3->num_rows; ?></div>
            <?php } ?>         
            </td>  
            <td><?php 

            echo $rs1['CreateDate']; 
            ?></td>
            <td><?php 
            echo     $LastUpdate;

                //   while($LLPQ = mysqli_fetch_array($LastLoanPaymentQuery)){
                //   $EndCreateDate=$LLPQ['LastDate'] ;
                //    echo $LLPQ['LastDate'];
                //   } 
                ?>
        </td>
            
            <td class="d-print-none"  ><a href="loan-close-show.php?RefNo=<?php echo $RefNo;?>">แสดง</a></td>             
            <td class="d-print-none">
            <?php 
            $sqlloan = "select * from Loanbook where IDMember='$IDMember'";
            $queryloan = mysqli_query($link, $sqlloan);
            if ($queryloan->num_rows<>0){
            ?>
            <a href="loan-cus-show.php?memid=<?php echo $rs1['IDMember'];?>" class="btn btn-danger btn-sm">ประวัติการกู้ <?php echo $queryloan->num_rows;?> ครั้ง</a>
            <?php }else{?>
            ไม่มีประวัติการกู้
            <?php } ?>
            </td>
            <td class="d-print-none">
            <?php 
            $sqlin1 = "select * from Loanbook where Insurer1=".$rs1['IDMember']." or Insurer2=".$rs1['IDMember'];
            $queryin1 = mysqli_query($link, $sqlin1);
            if ($queryin1->num_rows<>0){
            ?>
            <a href="loan-in-show.php?memid=<?php echo $rs1['IDMember'];?>" class="btn btn-success btn-sm">ตรวจผู้ค้ำ <?php echo $queryin1->num_rows;?> ราย </a>
            <?php }else{?>
            ไม่มีประวัติการค้ำประกัน
            <?php } ?>                        
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