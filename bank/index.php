<?php 
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
?>
<div id="content-wrapper">
	<div class="container-fluid" >
	<ol class="breadcrumb">
	          <li class="breadcrumb-item">
	           ระบบ เงินกู้ 
	          </li>
	        </ol>
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-chart-area"></i>
            Area Chart Example</div>
          <div class="card-body">
            <canvas id="myAreaChart" width="100%" height="30"></canvas>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>
  <a href="relation-member.php" class="btn btn-danger" >Relation Member</a>

	</div>
</div>
<?PHP 
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>