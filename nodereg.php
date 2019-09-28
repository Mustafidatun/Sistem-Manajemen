<?php
include "database/koneksi.php";
include "database/check.php";

$pool = mysqli_query($connectdb, "select id,name from ng_pool where name!='suspend' and nodeid='0'");
$city = mysqli_query($connectdb, "select id,kota from ng_kota");

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
              <form role="form" action="#" method=post>
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputNode">Node Name</label>
                    <input type="text" class="form-control" id="inputNode" placeholder="Input Node Name" name="node">
                  </div>
                  <div class="form-group">
                    <label for="inputAddress">Node IP Address</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="Input Node IP Address" name="address">
                  </div>
                  <div class="form-group">
                    <label>Kota</label>
                    <select class="form-control" name="kota">
                      <option value=''>Pilih</option>
                      <?php while ($idkota = mysqli_fetch_row($city)){?>
                          <option value=<?php echo $idkota[0];?>><?php echo $idkota[1]?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="inputSecret">Secret</label>
                    <input type="text" class="form-control" id="inputSecret" placeholder="Input Node Secret" name="secret">
                  </div>
                  <div class="form-group">
                    <label for="inputType">Type</label>
                    <input type="text" class="form-control" id="inputType" placeholder="Mikrotik" name="type">
                  </div>
                  <div class="form-group">
                    <label for="inputPort">Port</label>
                    <input type="text" class="form-control" id="inputPort" placeholder="3799" name="port">
                  </div>
                  <div class="form-group">
                    <label>Pool</label>
                    <select class="form-control" name="pool">
                      <option value=''>Pilih</option>
                      <?php while ($xpool = mysqli_fetch_row($pool)){?>
        
                        <option value=<?php echo $xpool[0];?>><?php echo $xpool[1]; ?></option>
                        
                      <?php } ?>
                    </select>
                  </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-default float-right">Cancel</button>
                </div>

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
 
    $nodename = $_POST['node'];
      $address = $_POST['address']; 
      $kota = $_POST['kota']; 
      $secret = $_POST['secret']; 
      $type = $_POST['type']; 
      $port = $_POST['port']; 
      $pool = $_POST['pool']; 

      $ng_node = "INSERT INTO ng_node (node,address,kota,secret,type,port,pool) values (\"$nodename\" ,\"$address\",\"$kota\",\"$secret\",\"$type\",\"$port\",\"$pool\")" ; 
    mysqli_query ($connectdb, $ng_node );
    
    $nas = "INSERT INTO nas (nasname,shortname,secret,type,ports) values (\"$address\" ,\"$nodename\",\"$secret\",\"$type\",\"$port\")" ;
    mysqli_query ($connectdb, $nas );
        
    sleep(5);
    
    $checknode = mysqli_query($connectdb, "select nodeid from ng_node where node =\"$nodename\" and address =\"$address\"");
    $nodes = mysqli_fetch_row($checknode);
    
    $nodenya = $nodes[0];
    $pol = "UPDATE ng_pool SET nodeid= \"$nodenya\" WHERE id = \"$pool\"";
      echo $pol.'<br>';
    mysqli_query($connectdb, $pol);
   }

?>
