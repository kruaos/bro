<?php
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
?>
<div class="container-fluid">



  <br>
  <!-- <h1 class="display-1">bank-event</h1> -->
  <div class="container">
    <div>
      <a class="btn btn-success col-12 mt-3" href="bank-event-add.php">
        <h1>รายการฝาก-ถอนเงิน</h1>
      </a>
      <a class="btn btn-warning col-12 mt-3" href="bank-event-updatebook.php">
        <h1>ปรับปรุงข้อมูลบัญชีธนาคาร</h1>
      </a>
      <a class="btn btn-primary col-12 mt-3" href="bank-event-updatedewi.php">
        <h1>ปรับปรุงรายการฝาก-ถอนเงิน</h1>
      </a>
      <a class="btn btn-danger col-12 mt-3" href="bank-event-witdep.php">
        <h1>รายการถอนเงินสัจจะ</h1>
      </a>
    </div>
    <div>
    <h1 class="mt-5" style="text-align:center;">รายการอื่นๆ</h1>
      <a class="btn btn-secondary col-12 mt-3" href="loan-agreement.php">
        <h1>ตรวจสอบการกู้เงิน</h1>
      </a>
      
    </div>
  </div>

</div>
<?PHP
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>