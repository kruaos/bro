<?php 
session_start();
session_id();
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

$employee_use=$_SESSION['employee_USER'];
// $IDMember= $_POST['IDMember_Dep'];
$IDDeposit= $_GET['IDDeposit'];

$SqlShowDeposit="Select * from deposit where IDDeposit=$IDDeposit";
$ShowDepositQuery=mysqli_query($link,$SqlShowDeposit);
while ($RSDQ=mysqli_fetch_array($ShowDepositQuery)){
    $IDRegFund=$RSDQ['IDRegFund'];
    $Amount1=$RSDQ['Amount'];
}

$ShowRegfund="select * from regfund where  IDRegFund=$IDRegFund ";
$SRfQuery= mysqli_query($link, $ShowRegfund);
while ($SRf= mysqli_fetch_array($SRfQuery)){
    $IDMember=$SRf['IDMember'];
    $IDFund=$SRf['IDFund'];
    $IDRegFund=$SRf['IDRegFund'];
    $Balance=$SRf['Balance'];
}

$ShowMember="select m.Title, m.Firstname, m.Lastname, m.MemberStatus 
from Member as m where  m.IDMember=$IDMember";
$SMQuery= mysqli_query($link, $ShowMember);
while ($SM= mysqli_fetch_array($SMQuery)){
    $FullNameMember=$SM['Title'].$SM['Firstname']." ".$SM['Lastname'];
}
if($IDFund==1){
    $ShowLabel="เงินฝากสัจจะ";
}else{
    $ShowLabel="พชพ.";
}

?>

<div class="container-fluid ">
    <div class="row">
        <div class="p-3 mb-2 col bg-primary">
			<h1 class="display-6">ระบบฝากสัจจะ </h1>
    </div>    
  </div>
  <div class="row">
    <div class="col col-sm-12 col-md-4 col-lg-4 ">
      <form action="#" >
        <div class="form-group">
          <label >รหัสสมาชิก</label>
          <input type="text" class="form-control " value="<?php echo $IDMember ;?>" disabled >
        </div>
      </form>
     <form method="POST" action="dep-pay-update.php" >
         <div class="form-group">
             <label >ข้อมูลสมาชิก</label>
             <input class="form-control " type="text" value="<?php echo $FullNameMember;?>" disabled>
             <label ><?php echo $ShowLabel; ?></label>
             <input class="form-control " type="text" name="Amount1" value="<?php echo $Amount1;?>" style="text-align:right" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}"
             onfocus="this.value = this.value;">
             <input type="hidden" name="IDDeposit" value="<?php echo $IDDeposit;?>">
             <input type="hidden" name="LastAmount" value="<?php echo $Amount1;?>">
             <input type="hidden" name="Balance" value="<?php echo $Balance;?>">
             <input type="hidden" name="IDRegFund" value="<?php echo $IDRegFund;?>">
     
             <input type="submit" class="form-control btn-warning  value="แก้ไข"> 
            </div>
        </form>
            <a href="dep-pay-tool.php" class="form-control btn-danger">ยกเลิก</a>
</div>
<div class="col col-sm-12 col-md-8 col-lg-8 ">
    <div class="alert alert-primary" role="alert">
      <?php 
        echo "เจ้าหน้าที่____".$employee_use."____จำนวนรับ_____ราย  ";
        echo "<a href='#'>แสดงการ</a>";
    ?>
    </div>
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

$sql1 = "select * from regfund where IDMember=$IDMember Order by IDFund";
$query = mysqli_query($link, $sql1);
$num1=0; 
while ($rs1=mysqli_fetch_array($query) ) {
  $IDRegFund[$num1]=$rs1['IDRegFund'];
  $num1++;
}

// เริ่มต้น คำสั่งค้นหา เลขบัญชี พชพ+สัจจะ
$show_sql = "SELECT * from regfund where IDMember=$IDMember Order by IDFund";
$show_query = mysqli_query($link, $show_sql);
$num2=0;
while ($rsq=mysqli_fetch_array($show_query)) {
  $IDRegFund_array[$num2]=$rsq['IDRegFund'];
  $num2++;
}
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

    if(count($IDRegFund)<=1){
    $sql_acc_notgroup = "SELECT IDDeposit, CreateDate , IDRegFund , Amount from deposit 
    where IDRegFund=$IDRegFund[0] 
    order by IDDeposit";
  }else if(count($IDRegFund)<=2){
    $sql_acc_notgroup = "SELECT IDDeposit, CreateDate , IDRegFund , Amount from deposit 
    where IDRegFund=$IDRegFund[0] or IDRegFund=$IDRegFund[1] 
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
            echo "<td>";
            echo $sq_acc_notgroup_array[$a2][3];
            $show_num++;
            $chk_num++;
          // }
        }
      }
      $chk_num=1;
    echo "</tr>";
}
   ?>             
                  </tbody>
                </table>
        </div>
    </div>
</div>
<?PHP 
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>