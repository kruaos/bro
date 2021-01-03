<title>กลุ่มออมทรัพย์เพื่อการผลิตบ้านไร่  </title>

<div id="page-top ">
 <nav class="navbar navbar-expand navbar-dark bg-dark static-top d-print-none">
    <div class="navbar-brand mr-1">BaanRai Bank</div>
    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="navbar-brand mr-1" >
      <?php 
      echo "COM_BANK_1";
        // session      
       ?>         
      </div>
    </div>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="#">Activity Log</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>
  </nav>
  <?php 
  date_default_timezone_set("Asia/Bangkok");
  $sec = "10";
  ?>
    <head>
    <!-- <meta http-equiv="refresh" content="<?php echo $sec?>;'"> -->
    </head>