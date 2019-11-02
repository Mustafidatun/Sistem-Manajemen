<?php
include "database/koneksi.php";
include "database/check.php";

$ng_vendorlist = mysqli_query($connectdb, "SELECT id, vendor FROM ng_vendor");
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
        }else if($_SESSION['level'] == 11){
          include './include/sidebar_purchase.php';
        }else if($_SESSION['level'] == "" || $_SESSION['level'] == 1 || $_SESSION['level'] == 2 || 
          $_SESSION['level'] == 10){
          include 'include/page_404.html'; 
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
            <h1>Create Master Barang</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Master Barang</li>
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
                <h3 class="card-title">Form Master Barang</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="#" method=post >
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputMerk">Merk</label>
                    <input type="text" class="form-control" id="inputMerk" placeholder="Input Merk Equipment" name="merk" required>
                  </div>
                  <div class="form-group">
                    <label for="inputType">Type</label>
                    <input type="text" class="form-control" id="inputType" placeholder="Input Type Equipment" name="type" required>
                  </div>
                  <div class="form-group">
                    <label for="inputPrice">Price</label>
                    <input type="number" class="form-control" id="inputPrice" placeholder="Input Price ex.1000000" name="price" required>
                  </div>
                   <div class="form-group">
                    <label>Vol</label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="pcs" name="vol" checked="checked">
                      <label class="form-check-label">Pcs</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="unit" name="vol">
                      <label class="form-check-label">Unit</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="box" name="vol">
                      <label class="form-check-label">Box</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="ls" name="vol">
                      <label class="form-check-label">Ls</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Vendor</label>
                    <select class="form-control" name="vendor" required>
                      <option value=''>Pilih</option>
                      <?php 
                        while ($dtvendor = mysqli_fetch_array($ng_vendorlist)){
                            
                            echo "<option value=".$dtvendor['id'].">".$dtvendor['vendor']."</option>";
                        }
                      ?>  
                    </select>
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
 
    $merk = $_POST['merk'];
    $type = $_POST['type']; 
    $price = $_POST['price']; 
    $vendor = $_POST['vendor']; 
    $vol = $_POST['vol']; 

    $ng_brgcheck = mysqli_query($connectdb, "SELECT type, vendorid FROM ng_equipmaster WHERE type =\"$type\" AND vendorid =\"$vendor\"");

    if(mysqli_fetch_row($ng_brgcheck) == NULL ){
      
      $ng_equipmaster = mysqli_query($connectdb, "INSERT INTO ng_equipmaster (type, merk, price, vol, vendorid) VALUES (\"$type\" ,\"$merk\" ,\"$price\" ,\"$vol\" ,\"$vendor\")") ; 

    }else{
      echo '<script language="javascript">alert("Product is registered")</script>';
    }

    echo("<meta http-equiv='refresh' content='1'>"); //Refresh by HTTP META 
  }

?>