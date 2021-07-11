<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
?>
<div class="container-fluid">




<div class="container mt-5">
<form class="alert alert-warning" action="bank-member-edit.php">
  <div class="form-group ">
    <label class="h1">ปรับปรุงข้อมูลบัญชีธนาคาร</label>
    <input style="height: 50px; font-size:large;" type="text" class="form-control" name="bankid" placeholder="กรอกเลขบัญชีธนาคาร" required>
  </div>
  <button type="submit" class="col-12 btn btn-warning "><h1>ทำรายการ</h1></button>
  <a href="bank-event.php" class="btn col-12 btn-danger"><h1>ย้อนกลับ</h1></a>

</form>
</div>


</div>
<?PHP 
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>