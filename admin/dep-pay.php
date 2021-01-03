<?php 
session_start();
session_id();
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');
?>
<div class="container-fluid">
<h1 class="display-3">จ่ายเงินฝากสัจจะ</h1>
<form  class="control-row" action="dep-pay-login.php" method="POST">
	<select name="employee_USER" class="form-control"> 
<?php 
	$sql="select * from employee ORDER BY Username ASC ";
	$query= mysqli_query($link, $sql);
	while ($rs1 = mysqli_fetch_array($query)) 
        {
          $Username=$rs1['Username'];
          $Firstname=$rs1['Firstname'];
		  $Lastname=$rs1['Lastname'];
?>
		<option value="<?php echo $Username; ?>">
			<?php echo $Username." [".$Firstname." ".$Lastname."]"?>
		</option>
<?php 
		}
?>
	</select>
	<button type="submit" class="btn btn-primary btn-lg btn-block">จ่ายเงินสัจจะ + พชพ</button>
</form>
</div>
<?PHP 
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>