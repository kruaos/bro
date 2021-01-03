<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
?>
<div class="container-fluid">



<br>
<!-- <h1 class="display-1">bank-event</h1> -->
<form class=" alert alert-primary" action="bank-event-dewi.php">
  <div class="form-group ">
    <label>รายการฝาก ถอน คิดดอกเบี้ย</label>
    <input type="text" class="form-control" name="bankid" placeholder="กรอกเลขบัญชีธนาคาร">
  </div>
  <button type="submit" class=" form-control btn btn-primary">ทำรายการ</button>
</form>
<br>
<form  class=" alert alert-danger">
  <div class="form-group ">
    <label>ปรับปรุงบัญชีธนาคาร</label>
    <input type="text" class="form-control"  name="bankid" placeholder="กรอกเลขบัญชีธนาคาร">
  </div>
  <button type="submit" class=" form-control btn btn-danger">ทำรายการแก้ไขบัญชี</button>
</form>
<br>

<form  class=" alert alert-warning">

  <div class="form-group">
    <label>ถอนเงินฝากสัจจะ</label>
    <input type="text" class="form-control" name="IDFund" placeholder="กรอกเลขบัญชีเงินฝากสัจจะ">
  </div>
  <button type="submit" class=" form-control btn btn-warning">ทำรายการ</button>
</form>

</div>
<?PHP 
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>