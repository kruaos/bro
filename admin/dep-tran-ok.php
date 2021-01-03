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

$sql = "select * from member_n ";
$query = mysqli_query($link, $sql);
$query_num=$query->num_rows;
// echo $query_num;
// exit();

// for($a4=1;$a4<=500;$a4++){
// for($a4=501;$a4<=1000;$a4++){
// for($a4=1001;$a4<=1500;$a4++){
for($a4=1501;$a4<=2000;$a4++){
                // echo $a4;
  // while ($rs1=mysqli_fetch_array($query) ) {
  //     $runIDMember=$rs1['IDMember'];
  // }
      // $runIDMember=$_GET['IDMember'];
      $runIDMember=$a4;

  ?>              
  <!-- loop  -->       
  <?php 
  $sql1 = "select * from regfund where IDMember=".$runIDMember.' Order by IDFund';
  $query = mysqli_query($link, $sql1);
  $num=0; 

  while ($rs1=mysqli_fetch_array($query) ) {
    $IDRegFund[$num]=$rs1['IDRegFund'];
    $num++;
  }
  // เริ่มต้น คำสั่งค้นหา เลขบัญชี พชพ+สัจจะ
  $show_sql = "select * from regfund where IDMember=".$runIDMember.' Order by IDFund';
  $show_query = mysqli_query($link, $show_sql);
  $num=0;

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
    $IDMember=$runIDMember;   

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
  $count_num=1;       
  $m_name = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  for($a1=0;$a1<count($sq_acc_group_array);$a1++){
    $CreateDate=$sq_acc_group_array[$a1][1];
    $show_day=number_format(substr($CreateDate, 8,2))."  ".
    $m_name[number_format(substr($CreateDate, 5,2))]." ".(substr($CreateDate, 0,4)+543);
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
    $x6=count($show_deposit_all);
    if($x6>2){
      $IDDeposit="";         -
      $IDMember=$show_deposit_all[1][8];          //8
      $Username=$show_deposit_all[1][4];          //4
      $CreateDate=$show_deposit_all[1][1];        //1
      $LastUpdate=$show_deposit_all[1][5];        //5
      $Receive=$show_deposit_all[1][6];           //6
      $DepositStatus=$show_deposit_all[1][7];     //7
      if($show_deposit_all[1][3]>=30){
        $Amount_FixDep=$show_deposit_all[1][3];     //3
        $Amount_Insura=$show_deposit_all[2][3];     //3
        $IDDeposit_FixDep=$show_deposit_all[1][0];
        $IDDeposit_Insura=$show_deposit_all[2][0];  //0
        $IDRegFund_FixDep=$show_deposit_all[1][2];  //2
        $IDRegFund_Insura=$show_deposit_all[2][2];  //2   
      }else{
        $Amount_FixDep=$show_deposit_all[2][3];     //3
        $Amount_Insura=$show_deposit_all[1][3];     //3
        $IDDeposit_FixDep=$show_deposit_all[2][0];
        $IDDeposit_Insura=$show_deposit_all[1][0];  //0
        $IDRegFund_FixDep=$show_deposit_all[2][2];  //2
        $IDRegFund_Insura=$show_deposit_all[1][2];  //2    
      }
      $send_tran[$count_num]="('','".$IDMember."','".$Username."','".
      $CreateDate."','".$LastUpdate."','".$Amount_FixDep."','".
      $Amount_Insura."','".$Receive."','".$DepositStatus."','".
      $IDDeposit_FixDep."','".$IDDeposit_Insura."','".$IDRegFund_FixDep."','".$IDRegFund_Insura."')";
      $count_num++;

      $IDDeposit2="";         -
      $IDMember2=$show_deposit_all[3][8];          //8
      $Username2=$show_deposit_all[3][4];          //4
      $CreateDate2=$show_deposit_all[3][1];        //1
      $LastUpdate2=$show_deposit_all[3][5];        //5
      if($show_deposit_all[3][3]>=30){
        $Amount_FixDep2=$show_deposit_all[3][3];     //3
        $Amount_Insura2=$show_deposit_all[4][3];     //3  #
        $IDDeposit_FixDep2=$show_deposit_all[3][0];
        $IDDeposit_Insura2=$show_deposit_all[4][0];  //0  #
        $IDRegFund_FixDep2=$show_deposit_all[3][2];  //2
        $IDRegFund_Insura2=$show_deposit_all[4][2];  //2  #
      }else{
            // if($show_deposit_all[4][3]==null or $show_deposit_all[3][3]==null){
            if($show_deposit_all[3][3]==null ){
            $Amount_FixDep2=$show_deposit_all[4][3];     //3
            $Amount_Insura2=$show_deposit_all[3][3];     //3  #
            $IDDeposit_FixDep2=$show_deposit_all[4][0];
            $IDDeposit_Insura2=$show_deposit_all[3][0];  //0  #
            $IDRegFund_FixDep2=$show_deposit_all[4][2];  //2
            $IDRegFund_Insura2=$show_deposit_all[3][2];  //2  #
          }else{
            $Amount_FixDep2="";     //3
            $Amount_Insura2=$show_deposit_all[3][3];     //3  
            $IDDeposit_FixDep2="";
            $IDDeposit_Insura2=$show_deposit_all[3][0];  //0  
            $IDRegFund_FixDep2="";  //2
            $IDRegFund_Insura2=$show_deposit_all[3][2];  //2  
          }
      }
      $Receive2=$show_deposit_all[3][6];           //6
      $DepositStatus2=$show_deposit_all[3][7];     //7
    //   $IDDeposit_FixDep2=$show_deposit_all[3][0];
    //   $IDDeposit_Insura2=$show_deposit_all[4][0];  //0  #
    //   $IDRegFund_FixDep2=$show_deposit_all[3][2];  //2
    //   $IDRegFund_Insura2=$show_deposit_all[4][2];  //2  #
      $send_tran[$count_num]="('','".$IDMember."','".$Username."','".
      $CreateDate2."','".$LastUpdate2."','".$Amount_FixDep2."','".
      $Amount_Insura2."','".$Receive2."','".$DepositStatus2."','".
      $IDDeposit_FixDep2."','".$IDDeposit_Insura2."','".$IDRegFund_FixDep2."','".$IDRegFund_Insura2."')";
   }else{
      if($x6==1){
        $IDDeposit="";         -
        $IDMember=$show_deposit_all[1][8];          //8
        $Username=$show_deposit_all[1][4];          //4
        $CreateDate=$show_deposit_all[1][1];        //1
        $LastUpdate=$show_deposit_all[1][5];        //5
        $Amount_FixDep=$show_deposit_all[1][3];     //3
        $Amount_Insura="";                           //3
        $Receive=$show_deposit_all[1][6];           //6
        $DepositStatus=$show_deposit_all[1][7];     //7
        $IDDeposit_FixDep=$show_deposit_all[1][0];     //0
        $IDDeposit_Insura="";     //0
        $IDRegFund_FixDep=$show_deposit_all[1][2];  //2
        $IDRegFund_Insura='';  //2   
        $send_tran[$count_num]="('','".$IDMember."','".$Username."','".
        $CreateDate."','".$LastUpdate."','".$Amount_FixDep."','".
        $Amount_Insura."','".$Receive."','".$DepositStatus."','".
        $IDDeposit_FixDep."','".$IDDeposit_Insura."','".$IDRegFund_FixDep."','".$IDRegFund_Insura."')";
      }else{
        $IDDeposit="";         -
        $IDMember=$show_deposit_all[1][8];          //8
        $Username=$show_deposit_all[1][4];          //4
        $CreateDate=$show_deposit_all[1][1];        //1
        $LastUpdate=$show_deposit_all[1][5];        //5
        if($show_deposit_all[1][3]>=30){
            $Amount_FixDep=$show_deposit_all[1][3];     //3
            $Amount_Insura=$show_deposit_all[2][3];     //3
            $IDDeposit_FixDep=$show_deposit_all[1][0];
            $IDDeposit_Insura=$show_deposit_all[2][0];  //0
            $IDRegFund_FixDep=$show_deposit_all[1][2];  //2
            $IDRegFund_Insura=$show_deposit_all[2][2];  //2   
          }else{
            $Amount_FixDep=$show_deposit_all[2][3];     //3
            $Amount_Insura=$show_deposit_all[1][3];     //3
            $IDDeposit_FixDep=$show_deposit_all[2][0];
            $IDDeposit_Insura=$show_deposit_all[1][0];  //0
            $IDRegFund_FixDep=$show_deposit_all[2][2];  //2
            $IDRegFund_Insura=$show_deposit_all[1][2];  //2    
          }
        $Receive=$show_deposit_all[1][6];           //6
        $DepositStatus=$show_deposit_all[1][7];     //7
        // $Amount_FixDep=$show_deposit_all[1][3];     //3
        // $Amount_Insura=$show_deposit_all[2][3];      //3
        // $IDDeposit_FixDep=$show_deposit_all[1][0];
        // $IDDeposit_Insura=$show_deposit_all[2][0];     //0
        // $IDRegFund_FixDep=$show_deposit_all[1][2];  //2
        // $IDRegFund_Insura=$show_deposit_all[2][2];  //2   

        $send_tran[$count_num]="('','".$IDMember."','".$Username."','".
        $CreateDate."','".$LastUpdate."','".$Amount_FixDep."','".
        $Amount_Insura."','".$Receive."','".$DepositStatus."','".
        $IDDeposit_FixDep."','".$IDDeposit_Insura."','".$IDRegFund_FixDep."','".$IDRegFund_Insura."')";

      }
    }
    $x6;
    $count_num++;
    $show_deposit_all=null;   
    $show_deposit_amount=null;   
    $show_num++;
  }
      for($c1=1;$c1<=count($send_tran);$c1++) {
        $date_insert="insert into `deposit_n`(`IDDeposit`, `IDMember`, `Username`,
        `CreateDate`, `LastUpdate`, `Amount_FixDep`, 
        `Amount_Insura`, `Receive`, `DepositStatus`, `IDDeposit_FixDep`, `IDDeposit_Insura`, 
        `IDRegFund_FixDep`, `IDRegFund_Insura`) VALUES".$send_tran[$c1];
        $result = mysqli_query($link, $date_insert);
      }
      if ($result){
          echo "[".$runIDMember."]";
          // exit(0);
      }else{
          // echo $date_insert;
          echo "<center>ไม่สามารถเพิ่มข้อมูลใหม่ลงในฐานข้อมูลได้ ".$runIDMember." <br></center>";
        }
      // echo $a4;
    //   echo $date_insert;
    //   echo "<hr>";
  $show_deposit_all=null;   
  $show_deposit_amount=null; 
  $send_tran=null;
  $IDRegFund=null;
  $IDRegFund_array=null;
  $sq_acc_group_array=null;
  $sq_acc_notgroup_array=null;
  $date_insert=null;
}
?>             
    </div>
</div>
<?php 
    mysqli_close($link);
    include('../tmp_dsh2/footer.php');
?>