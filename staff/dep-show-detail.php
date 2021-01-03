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
	$sql = "select * from member where IDMember=".$_GET['IDMember'];
  $query = mysqli_query($link, $sql);
 while ($rs1=mysqli_fetch_array($query) ) {
  $fullname=$rs1['Title'].$rs1['Firstname']." ".$rs1['Lastname'];
 }
?>              
  <div class="card-body">              
    <h6 class="m-0 font-weight-bold text-primary"><?php echo $fullname;?> -> ข้อมูลสมาชิกสัจจะ จาก regfund</h6>
      <table class="table table-sm "  width="100%" cellspacing="0">
        <thead>
          <tr>
            <th >รหัส</th>
            <th >IDRegFund </th>
            <th >IDFund </th>
            <th >Balance </th>
            <th >SumAmount </th>
            <th >จำนวน </th>
            <th >คงเหลือ </th>
          </tr>
        </thead>
      <tbody>
<!-- loop  -->       
<?php 
$sql1 = "select * from regfund where IDMember=".$_GET['IDMember'].' Order by IDFund';
$query = mysqli_query($link, $sql1);
$num=0; 
while ($rs1=mysqli_fetch_array($query) ) {
// foreach ($query as $rs1){
  $IDRegFund[$num]=$rs1['IDRegFund'];
?>             
      <tr>
        <td><?php echo $num=$num+1; ?></td>                
        <td><?php echo $rs1['IDRegFund']; ?></td>                
        <td><?php echo $rs1['IDFund']; ?></td>                
        <td><?php echo number_format($rs1['Balance']); ?></td>                
        <td>
        <?php 
        $sql2 = "select sum(Amount) as sumdep ,count(Amount) as countdep from deposit where IDRegFund=".$rs1['IDRegFund'];
        $query2 = mysqli_query($link, $sql2);
        while ($rs2=mysqli_fetch_array($query2) ) {
        // foreach ($query as $rs2) { 
        echo number_format($rs2['sumdep'])." บาท ";
        }
        ?></td>
        <td ><?php echo $rs2['countdep']." ครั้ง";  ?></td>
        <td ><?php echo number_format($rs1['Balance']+$rs2['sumdep'])." บาท";?> </td>                
      </tr>
<?php 
        } 
?>  </tbody>
  </table>
            <a href="admin-show.php" class="btn btn-danger" >ย้อนกลับ</a>
            <h6 class="m-0 font-weight-bold text-primary">รายละเอียดสมาชิกสัจจะ จาก deposit</h6>
            <div class="row">
            <table class="table table-sm"  cellspacing="0">
              <thead>
              <tr>
                      <th >ที่</th>
                      <th >วัน เดือน ปี  </th>
                      <th >เงินสัจจะ  </th>
                      <th >เพื่อนช่วยเพื่อน</th>
                      <th >สัจจะ (เกิน) </th>
                      <th >พชพ (เกิน) </th>
                      <th >DepositStatus </th>
					           </tr>
                  </thead>
                  <tbody>
<!-- loop  -->  
     
<?php 
// เริ่มต้น คำสั่งค้นหา เลขบัญชี พชพ+สัจจะ
$show_sql = "select * from regfund where IDMember=".$_GET['IDMember'].' Order by IDFund';
$show_query = mysqli_query($link, $show_sql);
$num=0;
// echo $sql2;
// print_r($show_query);
// echo $show_query->num_rows;

while ($rsq=mysqli_fetch_array($show_query)) {

  $IDRegFund_array[$num]=$rsq['IDRegFund'];
  $num++;
}
// ----------output1 ได้เลขบัญชี 3 แบบ เพื่อหาเงินฝักสัจจะ และ พชพ 
// สิ้นสุด การค้นหาเลขบัญชี 

// ----------------เริ่มต้น คำสั่งดึงข้อมูลฝาก ตามเลขบัญชี group วันเดือนปี 
if(count($IDRegFund_array)<=1){
  $sql_acc_group = "select IDDeposit, CreateDate from deposit 
  where IDRegFund=".$IDRegFund_array[0]." 
  group by CreateDate order by IDDeposit ";
}else if(count($IDRegFund_array)<=2){
  $sql_acc_group = "select IDDeposit, CreateDate from deposit 
  where IDRegFund=".$IDRegFund_array[0]." or IDRegFund=".$IDRegFund_array[1]." 
  group by CreateDate order by IDDeposit ";
}else{
  $sql_acc_group = "select IDDeposit, CreateDate from deposit 
  where IDRegFund=".$IDRegFund_array[0]." or IDRegFund=".$IDRegFund_array[1]." or IDRegFund=".$IDRegFund_array[2]." 
  group by CreateDate order by IDDeposit ";
}

$show_sq_acc_group = mysqli_query($link, $sql_acc_group);
$l1_group=$show_sq_acc_group->num_rows;
$x3=0;
while ($sq_acc_group=mysqli_fetch_array($show_sq_acc_group)) {
    $sq_acc_group_IDDeposit=$sq_acc_group['IDDeposit'];
    $sq_acc_group_CreateDate=$sq_acc_group['CreateDate'];        
    $sq_acc_group_array[$x3]=array($sq_acc_group_IDDeposit,$sq_acc_group_CreateDate);
    $x3++;
} 
// echo count($sq_acc_group_array);
// -------output2 ได้ข้อมูลวันที่ฝากเงิน 


// --------เริ่มต้นการค้นหา ยอดการฝาทั้งหมด ของสมาชิก 
    if(count($IDRegFund)<=1){
    $sql_acc_notgroup = "select IDDeposit, CreateDate , IDRegFund , Amount from deposit 
    where IDRegFund=".$IDRegFund[0]." 
    order by IDDeposit ";
  }else if(count($IDRegFund)<=2){
    $sql_acc_notgroup = "select IDDeposit, CreateDate , IDRegFund , Amount from deposit 
    where IDRegFund=".$IDRegFund[0]." or IDRegFund=".$IDRegFund[1]." 
    order by IDDeposit ";
  }else{
    $sql_acc_notgroup = "select IDDeposit, CreateDate , IDRegFund , Amount from deposit 
    where IDRegFund=".$IDRegFund[0]." or IDRegFund=".$IDRegFund[1]." or IDRegFund=".$IDRegFund[2]." 
    order by IDDeposit ";
  }
    $show_sq_acc_notgroup =mysqli_query($link, $sql_acc_notgroup);
    $x4=0;
    while ($sq_acc_notgroup=mysqli_fetch_array($show_sq_acc_notgroup)) {
        $IDDeposit=$sq_acc_notgroup['IDDeposit'];
        $CreateDate=$sq_acc_notgroup['CreateDate'];
        $IDRegFund=$sq_acc_notgroup['IDRegFund'];
        $Amount=$sq_acc_notgroup['Amount'];   
        
        $sq_acc_notgroup_array[$x4]=array($IDDeposit,$CreateDate, $IDRegFund, $Amount);
        $x4++;
  }

// ----------------การเปรียบเทียบและแสดงผล เนื่องจาก array เป็นตัวเลข จึงจะต้อง จำแนกเป็นตัวเลข 
$show_num=1;       

$m_name = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");

echo "<tr>";
for($a1=0;$a1<count($sq_acc_group_array);$a1++){
  $CreateDate=$sq_acc_group_array[$a1][1];
  $show_day=number_format(substr($CreateDate, 8,2))."  ".$m_name[number_format(substr($CreateDate, 5,2))]." ".(substr($CreateDate, 0,4)+543);
  ;
  echo "<td>".$show_num."</td>";
  echo "<td>".$show_day."</td>";
  // echo "<td></td>";
  $chk_num=1;       
  for($a2=0;$a2<count($sq_acc_notgroup_array);$a2++){
        $time1=$sq_acc_group_array[$a1][1];
        $time2=$sq_acc_notgroup_array[$a2][1];
        if($time1==$time2){
          // if($chk_num>=3){
          //   echo "*";
          // }else{
            // echo "<td>[".$a1.":".$a2."] </td>";
            echo "<td>";
            // echo count($sq_acc_group_array[$a1][1]);
            // echo "/";
            // echo $sq_acc_notgroup_array[$a2][0]." / ";             
            // echo $sq_acc_notgroup_array[$a2][2]."/ ";
            echo $sq_acc_notgroup_array[$a2][3];
            // echo "/".$chk_num;
            // echo "</td>";  
            // echo "<td>*";
            // echo "</td>";  
            $show_num++;
            $chk_num++;
          // }
        }
      }
      $chk_num=1;
    echo "</tr>";
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