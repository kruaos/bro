<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
?>
<div class="container">


<h1 class="display-1">loan-late</h1>
<div class="row">
    <a href='loan-late-show1.php' class="btn col-12 btn-danger">รายงานผู้ผิดนัดชำระ </a>
    <a href='loan-late-show-2loan.php' class="btn col-12 btn-primary" >มีการกู้เงิน 2 บัญชี  </a>
    <a href='loan-late-show2.php' class="btn col-12 btn-info">สถานะการฝากล่าสุด </a>
    <a href='loan-late-show3.php' class="btn col-12 btn-success">สถานะการปิดบัญชี </a>
    <a href='loan-late-show4.php' class="btn col-12 btn-warning" >ยืนยันการปิดบัญชี  </a>


</div>
<li>ใบเตือนผิดนัดสัญญา </li>

</div>



<?PHP 
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>