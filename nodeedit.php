<?php
include "database/koneksi.php";
include "database/check.php";

if (isset($_GET['id'])) {
    
    $nodeid = $_GET['id'];
    $nodelist = mysqli_query($connectdb, "SELECT ng_node.*, 
                                                ng_kota.kota, 
                                                ng_pool.name AS poolname 
                                            FROM ng_node
                                            INNER JOIN ng_kota ON ng_kota.id = ng_node.kota
                                            INNER JOIN ng_pool ON ng_pool.id = ng_node.pool
                                            WHERE ng_node.nodeid = \"$nodeid\"");
    $dtnodelist = mysqli_fetch_assoc($nodelist);
    
} else {
    
    header("location:nodelist.php");
  }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin CMS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="images/logo_cms.jpg" type="image/ico" />

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
            <h1>Node Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Node Edit</li>
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
                <h3 class="card-title">Form Node Edit</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="#" method=post>
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputNode">Node Name</label>
                    <input type="hidden" id="oldnodename" name="oldnodename" value="<?php echo $dtnodelist['node']; ?>">
                    <input type="text" class="form-control" id="inputNodeName" placeholder="Input Node Name" name="nodename" value="<?php echo $dtnodelist['node']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="inputAddress">Node IP Address</label>
                    <input type="hidden" id="oldaddress" name="oldaddress" value="<?php echo $dtnodelist['address']; ?>">
                    <input type="text" class="form-control" id="inputAddress" placeholder="Input Node IP Address" name="address" value="<?php echo $dtnodelist['address']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="inputKota">Kota</label>
                    <input type="text" class="form-control" id="inputKota" name="kota" value="<?php echo $dtnodelist['kota']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="inputSecret">Secret</label>
                    <input type="text" class="form-control" id="inputSecret" placeholder="Input Node Secret" name="secret" value="<?php echo $dtnodelist['secret']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="inputType">Type</label>
                    <input type="text" class="form-control" id="inputType" placeholder="Mikrotik" name="type" value="<?php echo $dtnodelist['type']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="inputPort">Port</label>
                    <input type="text" class="form-control" id="inputPort" placeholder="3799" name="port"  value="<?php echo $dtnodelist['port']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="inputPool">Pool</label>
                    <input type="text" class="form-control" id="inputPool" placeholder="3799" name="poolname"   value="<?php echo $dtnodelist['poolname']; ?>" readonly>
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
 
      $nodename = $_POST['nodename'];
      $oldnodename = $_POST['oldnodename'];
      $address = $_POST['address'];
      $oldaddress = $_POST['oldaddress']; 
      $secret = $_POST['secret']; 
      $type = $_POST['type']; 
      $port = $_POST['port']; 

      $ng_node = mysqli_query ($connectdb, "UPDATE ng_node 
                                            SET node = \"$nodename\" ,
                                                address = \"$address\",
                                                secret = \"$secret\",
                                                type = \"$type\", 
                                                port = \"$port\"
                                            WHERE nodeid = \"$nodeid\""); 

      $getnasid = mysqli_query($connectdb, "SELECT id FROM nas WHERE nasname =\"$oldaddress\" AND shortname =\"$oldnodename\"");
      $nasid = mysqli_fetch_assoc($getnasid);
     
    $nas = mysqli_query ($connectdb, "UPDATE nas 
                                        SET nasname = \"$address\",
                                            shortname = \"$nodename\",
                                            secret = \"$secret\",
                                            type =\"$type\",
                                            ports = \"$port\"
                                        WHERE id = ".$nasid['id'].""); 

        echo("<meta http-equiv='refresh' content='1'>"); //Refresh by HTTP META   
        // header("location:nodelist.php");                                 
   }

?>
