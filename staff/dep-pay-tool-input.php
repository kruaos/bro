<?php 
session_start();
session_id();
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');

$employee_use=$_SESSION['employee_USER'];

?>


<div class="container-fluid ">
    <div class="row">
        <div class="p-3 mb-2 col bg-primary">
			<h1 class="display-6">ระบบฝากสัจจะ </h1>
        </div>    
    </div>
    <div class="row">
        <div class="col col-sm-12 col-md-4 col-lg-4 ">
            <form method="POST" action="dep-pay-tool.php" >
            <div class="form-group">
                <label >รหัสสมาชิก</label>
                <input type="text" class="form-control " placeholder="รหัสสมาชิก" name="income_dep" 
                onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}"
                onfocus="this.value = this.value;" autofocus >
                <input type="hidden" class="form-control "  value='a' name="switch_menu1">
                <!-- <input type="submit" class="form-control btn-warning"  name="switch_menu1"> -->
            </div>
    </form>
    <form method="POST" action="dep-pay-tool.php" >
			
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
            <tr>
                <th scope="row"></th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
            </table>
        </div>
    </div>
</div>
<?PHP 
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>