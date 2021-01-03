<?php 
session_start();
session_id();
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');

// $employee_use=$_POST['employee_USER'];
$employee_use=$_SESSION['EMP_Loan_Username'];
// $employee_use="ทดสอบ";
$income_dep_array = array();

?>


<div class="container-fluid ">
    <div class="row">
        <div class="p-3 mb-2 col bg-warning">
			<h1 class="display-6">รายการค้นเงินกู้ <?php echo $employee_use;?></h1>
        </div>    
    </div>
    <div class="row">
        <div class="col col-sm-12 col-md-4 col-lg-4 ">
            <form method="POST" action="loan-pay-tool.php" >
            <div class="form-group">
                <label >รหัสสมาชิก</label>
                <input type="text" class="form-control " placeholder="รหัสสมาชิก" name="income_dep" 
                onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}"
                onfocus="this.value = this.value;" autofocus >
                <input type="hidden" class="form-control "  value='a' name="switch_menu1">
                <!-- <input type="submit" class="form-control btn-warning"  name="switch_menu1"> -->
            </div>
            <?php 
            if(isset($_POST['switch_menu1'])){
                $income_dep_array=$_SESSION['income_array'];
                $c_inc=count($_SESSION['income_array']);
                $input_data=$_POST['income_dep'];
                for($x2=0;$x2<=$c_inc;$x2++){
                    if($x2>=$c_inc){
                        $income_dep_array[$x2]=$input_data;
                    }else{
                        $income_dep_array[$x2]=$income_dep_array[$x2];
                    }
                }
                // echo $x2;
                // print_r($income_dep_array);
                $_SESSION['income_array']=$income_dep_array;
            }
            ?>				
    </form>
    <form method="POST" action="loan-pay-tool.php" >
    <div class="form-group">
        <div class="form-group row">
            <div class="col-sm-4">
                <label >รวมจ่าย</label>
            </div>
            <div class="col-sm-8">
                <input type="text" class="form-control text-right "  value="<?php 
                   $amount_dep=array_sum($income_dep_array);
                    echo number_format($amount_dep,2); 
                ?>" placeholder="รวมจ่าย" name='Payment'>
            </div>
        </div>
            <input type='hidden' value="<?php echo $RefNo;?>" name='RefNo'>
            <input type="hidden" class="form-control "  value='a' name="switch_menu2">
            <input type='submit' class="btn btn-success col" value='จ่าย'>
        <form>
            <input type="hidden" class="form-control " name="cancel_btn">
            <input type="submit" class="btn btn-danger col "  value='ล้าง'>
        </form>
<?php 
        if(isset($_POST['cancel_btn'])){
            // session_destroy();
            $_SESSION['income_array']=$income_dep_array;
        }
?>
    </div>
    <?php 
        if(isset($_POST['switch_menu2'])){
            // include('../config/config.php');
            // $IDLoanPay='';
            // $RefNo=$_POST['RefNo'];
            // $Username=$_POST['member_reg_id'];
            // $InstalmentNo=$_POST['member_reg_id'];
            // $Interest=(int)$_POST['Interest'];
            // $Payment=(int)$_POST['Payment'];
            // $PayTotal=(int)$_POST['PayTotal'];
            // $PayInterest=(int)$_POST['Interest'];
            // $InterestOutst='0.00';
            // $CreateDate=date('Y-m-d');
            // $LastUpdate=date('Y-m-d');
            // $ReceiveStatus='I';

            // $sql_insert_long_pay="INSERT INTO loanpayment2  VALUES (
            //     '$IDLoanPay', '$RefNo', '$Username', '$InstalmentNo', 
            //     '$Interest', '$Payment', '$PayTotal', '$PayInterest', 
            //     '$InterestOutst', '$CreateDate', '$LastUpdate', 
            //     '$ReceiveStatus');";
            // mysqli_query($link, $sql_insert_long_pay);
            // echo '</fieldset>';
        }
    ?>				
    </form>
</div>
<div class="col col-sm-12 col-md-8 col-lg-8 ">
    <div class="alert alert-primary" role="alert">
    <?php 
        echo "เจ้าหน้าที่____".$employee_use."____จำนวนรับ_____ราย  ";
        echo "<a href='#'>แสดงการ</a>";
    ?>
    </div>
    <table class="table table-bordered" >
    <!-- <table class="table table-bordered"  id='EdataTable' > -->
        <thead>
            <tr>
                <th scope="col">ที่</th>
                <th scope="col">รหัสสมาชิก</th>
                <th scope="col">ชื่อ - สกุล</th>
                <th scope="col">เงินสัจจะ</th>
                <th scope="col">พชพ.</th>
                <th scope="col">รวม</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $num=1;
            // include('../config/config.php');
            // $username=$employee_use;
            // $date_now=date('Y-m-d');
            // $sql_show_loanpayment = "select * from deposit where CreateDate='$date_now' and username='$username' ORDER BY IDDeposit DESC ";
            // $q_show_loanpayment = mysqli_query($link, $sql_show_loanpayment);
            // while($rs_show_lpm = mysqli_fetch_array($q_show_loanpayment)){
                // $IDRegFund=$rs_show_lpm['IDRegFund'];
                // $sql_idmember = "select IDMember from regfund where IDRegFund=$IDRegFund";
                // $q_idmember = mysqli_query($link, $sql_idmember);
                // while($rs_idmember = mysqli_fetch_array($q_idmember)){
                //     $IDMember=$rs_idmember['IDMember'];
                // }
            
                // $total_count=array('1','2','3');

                $total_count_array=count($income_dep_array);
                for($x1=1;$x1<=$total_count_array;$x1++){
        ?>			  	
            <tr>
                <th scope="row"></th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
       
        <?php 
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