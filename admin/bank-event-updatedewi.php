<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
?>
<div class="container-fluid">



<div class="container mt-5">


<form class="alert alert-primary" action="bank-event-edit.php">
  <div class="form-group ">
    <label class="h1">ปรับปรุงรายการฝาก-ถอนเงิน</label>
    <input style="height: 50px; font-size:large;" type="text" class="form-control" name="bankid" placeholder="กรอกเลขบัญชีธนาคาร" required>
  </div>
  <button type="submit" class="col-12 btn btn-primary"><h1>ทำรายการ</h1></button>
  <a href="bank-event.php" class="btn col-12 btn-danger"><h1>ย้อนกลับ</h1></a>

</form>

<div class="container mt-5">

    <?php
    if (!isset($_POST['send1'])) {
      // echo "1";
    ?>

      <form class="alert alert-success" method="POST">
        <div class="form-group ">
          <label class="h3">ค้นหาด้วยชื่อ</label>
          <input style="height: 50px; font-size:large;" type="text" class="form-control" name="nameBookBank" placeholder="ป้อนชื่อบัญชี" required>
        </div>
        <button type="submit" class="col-12 btn btn-success" name="send1">
          <h3>ค้นหา</h3>
        </button>
      </form>
</div>

    <?php

    } else {
      // echo "2";
    ?>
      <table class="table table-striped">
        <tr>
          <th>ลำดับ</th>
          <th>ชื่อ-สกุล</th>
          <th>ชื่อบัญชี</th>
          <th>สถานะสมาชิก</th>
          <th>ทำรายการล่าสุด</th>
        </tr>
        <?php
        include('../config/config.php');
        $nameBB = $_POST['nameBookBank'];
        $sql = "SELECT * from bankmember  where bankname like '%$nameBB%' or fname like '%$nameBB%' or lname like '%$nameBB%' ";
        $qsql = mysqli_query($link, $sql);

        while ($rs1 = mysqli_fetch_array($qsql)) {
          echo "<tr>";
          $bankid=$rs1['bankid'];
          echo "<td>" ."<a href='bank-event-edit.php?bankid=$bankid'>". $rs1['bankid'] ."</a>". "</td>";
          echo "<td>" . $rs1['pname'] . $rs1['fname'] . $rs1['lname'] . "</td>";
          echo "<td>" . $rs1['bankname'] . "</td>";
          echo "<td>" . $rs1['bankstatus'] . "</td>";
          echo "<td>" . $rs1['lastupdate'] . "</td>";
          echo "</tr>";
        }
        
        ?>
      </table>
      <a class="btn btn-danger" href="bank-event-updatedewi.php">ย้อนกลับ</a>
    <?php

    }
    ?>

  </div>

</div>
<?PHP 
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>