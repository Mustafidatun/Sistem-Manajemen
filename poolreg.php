<?php
include "database/koneksi.php";
include "database/check.php";

$ng_poolname = mysqli_query($connectdb, "SELECT count(*) FROM ng_pool WHERE name like '%pool%'");
$get_poolname = mysqli_fetch_row($ng_poolname);
$poolname = 'pool'.($get_poolname[0] + 1);
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
                    <label for="inputPool">Pool Name</label>
                    <input type="text" class="form-control" id="inputPool" name="poolname" value=<?php echo $poolname ?> readonly>
                  </div>
                  <div class="form-group">
                    <label for="inputPrefix">Prefix</label>
                    <input type="text" class="form-control" id="inputPrefix" placeholder="Input Prefix" name="prefix">
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
 
        $pool = $_POST['poolname'];
        $prefix = $_POST['prefix']; 
        $netaddress = 24;
    
        
        function cidr2NetmaskAddr($cidr) {
          $ta = substr($cidr, strpos($cidr, '/') + 1) * 1;
          $netmask = str_split(str_pad(str_pad('', $ta, '1'), 32, '0'), 8);
          foreach ($netmask as &$element) $element = bindec($element);
          return join('.', $netmask);
        }
        
        $ip_count = 1 << (32 - $netaddress);
        
        $mask = cidr2NetmaskAddr($prefix.'/'.$netaddress);
        
        $ips = ip2long($prefix);
        $addressmask = ip2long($mask);
        $ipa = ((~$addressmask) & $ips) ;
        $network = long2ip(($ips ^ $ipa)).'/'.$netaddress;

  $ng_poolcheck = mysqli_query($connectdb, "select name, prefix from ng_pool where name=\"$pool\" or prefix =\"$network\"");

  if(mysqli_fetch_row($ng_poolcheck) == NULL ){
  
            $ng_pool = mysqli_query($connectdb, "INSERT INTO ng_pool (name,prefix) VALUES (\"$pool\" ,\"$network\")") ; 

            $ng_poolid = mysqli_query($connectdb, "SELECT id FROM ng_pool WHERE name=\"$pool\" AND prefix =\"$network\"");
            $get_poolid = mysqli_fetch_row($ng_poolid);
            $poolid = $get_poolid[0];

            $no_childpool = 1;
            for ($i = 0; $i < $ip_count; $i++) {
            $ipaddr_start = long2ip(($ips ^ $ipa) + $i);
            $i = $i + 15;
            $ipaddr_end = long2ip(($ips ^ $ipa) + $i);
      $poolname = $pool.'_'.$no_childpool++;
      $available = 16;
          $ng_childpool = mysqli_query($connectdb, "INSERT INTO ng_childpool (poolname,poolid,start_address,end_address,available) VALUES (\"$poolname\" ,\"$poolid\" ,\"$ipaddr_start\" ,\"$ipaddr_end\" ,\"$available\")"); ;
            }

  }else{
       echo '<script language="javascript">alert("Prefix '. $network .' is registered")</script>';
        }
       }
       ?>

