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
?>  
</tbody>
  </table>
  <form action="dep-show-detail-add.php" method="post">
    <div class="row">
      <a href="dep-show.php" class="col col-6 btn btn-danger" >ย้อนกลับ</a>
      <input class="col col-6 btn btn-success"  type="submit" value="โอน">
    </div>
    <h6 class="m-0 font-weight-bold text-primary">รายละเอียดสมาชิกสัจจะ จาก deposit</h6>
    <div class="row">
    <table class="table table-sm"  cellspacing="0">
      <thead>
        <tr>
        <th >ที่</th>
        <th >วัน เดือน ปี  </th>
        <th >เงินสัจจะ  </th>
        <th >เพื่อนช่วยเพื่อน</th>
        <th >ยอดซ้ำ </th>
        <th >code </th>
        <th >note </th>
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
// --------เริ่มต้นการค้นหา ยอดการฝากทั้งหมด ของสมาชิก 
if(count($IDRegFund)<=1){
  $sql_acc_notgroup = "select IDDeposit, CreateDate , IDRegFund , Amount, Username ,LastUpdate , Receive, DepositStatus from deposit 
  where IDRegFund=".$IDRegFund[0]." 
  order by IDDeposit ";
}else if(count($IDRegFund)<=2){
  $sql_acc_notgroup = "select IDDeposit, CreateDate , IDRegFund , Amount, Username ,LastUpdate , Receive, DepositStatus from deposit 
  where IDRegFund=".$IDRegFund[0]." or IDRegFund=".$IDRegFund[1]." 
  order by IDDeposit ";
}else{
  $sql_acc_notgroup = "select IDDeposit, CreateDate , IDRegFund , Amount, Username ,LastUpdate , Receive, DepositStatus from deposit 
  where IDRegFund=".$IDRegFund[0]." or IDRegFund=".$IDRegFund[1]." or IDRegFund=".$IDRegFund[2]." 
  order by IDDeposit ";
}
// echo $sql_acc_notgroup;
// exit();
$show_sq_acc_notgroup =mysqli_query($link, $sql_acc_notgroup);
$x4=0;
while ($sq_acc_notgroup=mysqli_fetch_array($show_sq_acc_notgroup)) {
  $IDDeposit=$sq_acc_notgroup['IDDeposit'];
  $CreateDate=$sq_acc_notgroup['CreateDate'];
  $IDRegFund=$sq_acc_notgroup['IDRegFund'];
  $Amount=$sq_acc_notgroup['Amount'];   
  $Username=$sq_acc_notgroup['Username'];   
  $LastUpdate=$sq_acc_notgroup['LastUpdate'];   
  $Receive=$sq_acc_notgroup['Receive'];   
  $DepositStatus=$sq_acc_notgroup['DepositStatus'];   
  $IDMember=$_GET['IDMember'];   

  $sq_acc_notgroup_array[$x4]=array($IDDeposit,$CreateDate, $IDRegFund, $Amount, $Username, 
  $LastUpdate, $Receive, $DepositStatus, $IDMember);
  /*
  comment ตำแหน่งตัวแปร ห้ามลบ
  $IDDeposit,     0
  $CreateDate,    1
  $IDRegFund,     2
  $Amount,        3
  $Username,      4 
  $LastUpdate,    5 
  $Receive,       6
  $DepositStatus, 7 
  $IDMember       8
  */
  $x4++;
}
// ----------------การเปรียบเทียบและแสดงผล เนื่องจาก array เป็นตัวเลข จึงจะต้อง จำแนกเป็นตัวเลข 
$show_num=1;       
$m_name = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
echo "<tr>";
// $a1 หมายถึงลำดับที่รวมวันที่  $a2 หมายถึง ทุกยอด
for($a1=0;$a1<count($sq_acc_group_array);$a1++){
  $CreateDate=$sq_acc_group_array[$a1][1];
  $show_day=number_format(substr($CreateDate, 8,2))."  ".
  $m_name[number_format(substr($CreateDate, 5,2))]." ".(substr($CreateDate, 0,4)+543);
  echo "<td>".$show_num."</td>";
  echo "<td>".$show_day."</td>";
  $chk_num=1;       
  $a3=1;
  $c_array=count($sq_acc_notgroup_array);
  for($a2=0;$a2<$c_array;$a2++){
    $time1=$sq_acc_group_array[$a1][1];
    $time2=$sq_acc_notgroup_array[$a2][1];
    if($time1==$time2){
        $show_deposit_all[$a3]=$sq_acc_notgroup_array[$a2];
        $show_deposit_amount[$a3]=$sq_acc_notgroup_array[$a2][3];
        $a3++;
        $x5=$chk_num;
        $chk_num++;
    }
  }
  for($x1=1;$x1<=3;$x1++){
  echo "<td>";
  // เพื่อตรวจสอบว่า "ค่า" เกินกว่าที่ออกแบบไว้หรือไม่ 
  if(empty($show_deposit_amount[$x1])){
      echo " ";
    }else if($x1>=3){ 
      echo "<h5><span class='badge badge-danger'> ยอดซ้ำ </span></h5>";
    }else{
      echo $show_deposit_amount[$x1];
    }
    echo "</td>";
  }
  echo "<td class='small'>";
  $x6=count($show_deposit_all);
  if($x6>2){
    $IDDeposit="";         -
    $IDMember=$show_deposit_all[1][8];          //8
    $Username=$show_deposit_all[1][4];          //4
    $CreateDate=$show_deposit_all[1][1];        //1
    $LastUpdate=$show_deposit_all[1][5];        //5
    $Amount_FixDep=$show_deposit_all[1][3];     //3
    $Amount_Insur=$show_deposit_all[2][3];      //3
    $Receive=$show_deposit_all[1][6];           //6
    $DepositStatus=$show_deposit_all[1][7];     //7
    $IDDeposit_ref=$show_deposit_all[1][0]."/".$show_deposit_all[2][0];     //0
    $IDRegFund_FixDep=$show_deposit_all[1][2];  //2
    $IDRegFund_Insura=$show_deposit_all[2][2];  //2   
    // print_r($show_deposit_all);
    echo "('','".$IDMember."','".$Username."','".
    $CreateDate."','".$LastUpdate."','".$Amount_FixDep."','".
    $Amount_Insur."','".$Receive."','".$DepositStatus."','".
    $IDDeposit_ref."','".$IDRegFund_FixDep."','".$IDRegFund_Insura."')";
    echo "<br>";
    $IDDeposit2="";         -
    $IDMember2=$show_deposit_all[3][8];          //8
    $Username2=$show_deposit_all[3][4];          //4
    $CreateDate2=$show_deposit_all[3][1];        //1
    $LastUpdate2=$show_deposit_all[3][5];        //5
    $Amount_FixDep2=$show_deposit_all[3][3];     //3
    $Amount_Insur2=$show_deposit_all[4][3];      //3
    $Receive2=$show_deposit_all[3][6];           //6
    $DepositStatus2=$show_deposit_all[3][7];     //7
    $IDDeposit_ref2=$show_deposit_all[3][0]."/".$show_deposit_all[4][0];     //0
    $IDRegFund_FixDep2=$show_deposit_all[3][2];  //2
    $IDRegFund_Insura2=$show_deposit_all[4][2];  //2   
    echo "('','".$IDMember."','".$Username."','".
    $CreateDate2."','".$LastUpdate2."','".$Amount_FixDep2."','".
    $Amount_Insur2."','".$Receive2."','".$DepositStatus2."','".
    $IDDeposit_ref2."','".$IDRegFund_FixDep2."','".$IDRegFund_Insura2."')";

  }else{
    // echo "<span class='badge badge-secondary'> x6 : ".$x6." </span><br> ";
    if($x6==1){
      $IDDeposit="";         -
      $IDMember=$show_deposit_all[1][8];          //8
      $Username=$show_deposit_all[1][4];          //4
      $CreateDate=$show_deposit_all[1][1];        //1
      $LastUpdate=$show_deposit_all[1][5];        //5
      $Amount_FixDep=$show_deposit_all[1][3];     //3
      $Amount_Insur="";                           //3
      $Receive=$show_deposit_all[1][6];           //6
      $DepositStatus=$show_deposit_all[1][7];     //7
      $IDDeposit_ref=$show_deposit_all[1][0];     //0
      $IDRegFund_FixDep=$show_deposit_all[1][2];  //2
      $IDRegFund_Insura='';  //2   
      echo "('','".$IDMember."','".$Username."','".
      $CreateDate."','".$LastUpdate."','".$Amount_FixDep."','".
      $Amount_Insur."','".$Receive."','".$DepositStatus."','".
      $IDDeposit_ref."','".$IDRegFund_FixDep."','".$IDRegFund_Insura."')";
      // echo "<br>";
      // print_r($show_deposit_all);
    }else{
      $IDDeposit="";         -
      $IDMember=$show_deposit_all[1][8];          //8
      $Username=$show_deposit_all[1][4];          //4
      $CreateDate=$show_deposit_all[1][1];        //1
      $LastUpdate=$show_deposit_all[1][5];        //5
      $Amount_FixDep=$show_deposit_all[1][3];     //3
      $Amount_Insur=$show_deposit_all[2][3];      //3
      $Receive=$show_deposit_all[1][6];           //6
      $DepositStatus=$show_deposit_all[1][7];     //7
      $IDDeposit_ref=$show_deposit_all[1][0]."/".$show_deposit_all[2][0];     //0
      $IDRegFund_FixDep=$show_deposit_all[1][2];  //2
      $IDRegFund_Insura=$show_deposit_all[2][2];  //2   

      $send_tran="('','".$IDMember."','".$Username."','".
      $CreateDate."','".$LastUpdate."','".$Amount_FixDep."','".
      $Amount_Insur."','".$Receive."','".$DepositStatus."','".
      $IDDeposit_ref."','".$IDRegFund_FixDep."','".$IDRegFund_Insura."')";
      echo $send_tran;
      // echo "<input type='text' name='tran".$show_num."' value='".$send_tran."'>";
      // echo "<br>";
    }
  }
  echo "</td>";
  echo "<td>".$x6."</td>";
  $show_deposit_all=null;   
  $show_deposit_amount=null;   
  $show_num++;
  // $chk_num=1;
  echo "</tr>";
  echo "</form>";
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