<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
?>
<div class="container">


<h1 class="display-5 mt-5">รายการฝ่ายเงินกู้</h1>
<div class="row">
    <a href='loan-late-show1.php' class="btn col-12 btn-danger mt-2"><h1>รายงานผู้ผิดนัดชำระ</h1> </a>
    <a href='loan-late-show-2loan.php' class="btn col-12 btn-primary mt-2" ><h1>มีการกู้เงิน 2 บัญชี  </h1></a>
    <!-- <a href='loan-late-show2.php' class="btn col-12 btn-info mt-2"><h1>สถานะการฝากล่าสุด </h1></a> -->
    <a href='loan-late-show3.php' class="btn col-12 btn-success mt-2"><h1>สถานะการปิดบัญชี </h1></a>
    <a href='loan-late-show4.php' class="btn col-12 btn-warning mt-2" ><h1>ยืนยันการปิดบัญชี </h1> </a>


</div>
<!-- <li>ใบเตือนผิดนัดสัญญา </li> -->

</div>



<?PHP 
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>