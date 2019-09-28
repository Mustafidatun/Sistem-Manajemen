<?php
include "database/koneksi.php";
include "database/check.php";

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | General Form Elements</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">

  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php include './include/header.php'?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php 
        if($_SESSION['level'] == 0){
          include 'include/sidebar_supermanager.php';
        }else if($_SESSION['level'] == 1){
          include 'include/sidebar_manager.php';
        }else if($_SESSION['level'] == 2){
          include 'include/sidebar_submanager.php';
        }else if($_SESSION['level'] == 5){
          include './include/sidebar_fieldtec.php';
        }else if($_SESSION['level'] == 10){
          include './include/sidebar_finance.php';
        }else if($_SESSION['level'] == 11){
          include './include/sidebar_purchase.php';
        }else if($_SESSION['level'] == ""){
          include 'page_404.html'; 
        }
      ?>
    <!-- /.sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manager Registration</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Manager Registration</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="#" method=post >
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputApName">Ap Name</label>
                    <input type="text" class="form-control" id="inputApName"placeholder="Input Ap Name" name="apname">
                  </div>
                  <div class="form-group">
                    <label for="inputApLat">Ap Lat</label>
                    <input type="text" class="form-control" id="inputApLat" placeholder="Input Ap Lat" name="aplat">
                  </div>
                  <div class="form-group">
                    <label for="inputApLong">Ap Long</label>
                    <input type="text" class="form-control" id="inputApLong" placeholder="Input Ap Long" name="aplong">
                  </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-default float-right">Cancel</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

               </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
    
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://kit.fontawesome.com/bd16c6b546.js"></script>
<script src="./js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="./js/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="./js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="./js/demo.js"></script>
</body>
</html>
<?php

 if($_SERVER["REQUEST_METHOD"] == "POST") {
 
      $apname = $_POST['apname']; 
      $aplat = $_POST['aplat'];
      $aplong = $_POST['aplong'];

      $jmlid = mysqli_query($connectdb, "SELECT count(id) as jmlid FROM ng_pop");
      $dtjmlid  = mysqli_fetch_array($jmlid);
      $id = $dtjmlid['jmlid'] + 1;
      if($id < 10)
        $apid = '0'.$id.''.$apname;
      else 
        $apid = $id.''.$apname;

      $ng_popcheck = mysqli_query($connectdb, "SELECT aplat, aplong FROM ng_pop WHERE aplat =\"$aplat\" AND aplong =\"$aplong\"");

      if(mysqli_fetch_row($ng_popcheck) == NULL ){
        $ng_pop = mysqli_query($connectdb, "INSERT INTO ng_pop (apid, apname, aplat, aplong) VALUES (\"$apid\" , \"$apname\" , \"$aplat\" ,\"$aplong\")");
      }else{ 
        echo '<script language="javascript">alert("Ap Lat and ap long is registered")</script>';
      }
      
      echo("<meta http-equiv='refresh' content='1'>"); //Refresh by HTTP META 
    }

?>