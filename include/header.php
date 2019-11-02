<?php
include "database/koneksi.php";
// include "database/check.php";

$userid = $_SESSION['userid'];
if($_SESSION['level'] <> 0){
  if($_SESSION['level'] == 1 || $_SESSION['level'] == 5 || $_SESSION['level'] == 10 || $_SESSION['level'] == 11){
    //manager, fieldtech, finance, purchasing 
    $dtfoto = mysqli_query($connectdb, "SELECT foto FROM `ng_user` WHERE id = \"$userid\"");
  }else if($_SESSION['level'] == 2){
    //submanager
    $dtfoto = mysqli_query($connectdb, "SELECT foto FROM `ng_submanager` WHERE id = \"$userid\"");  
  }
  $foto = mysqli_fetch_assoc($dtfoto);
  $foto = "./foto/$foto[foto]";
}else{
  $foto = "./images/supermanager.png";
}

?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $login_session; ?></span>
          <img src="<?php echo $foto; ?>" class="img-profile rounded-circle circle-size" alt="User Image">
        </a>

        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <?php if($_SESSION['level'] <> 0){ ?>
          <a href="./profil.php" class="dropdown-item">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> 
            Profile
          </a>
          <div class="dropdown-divider"></div>
          <?php } ?>
          <a href="./login.php" class="dropdown-item">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> 
            Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>