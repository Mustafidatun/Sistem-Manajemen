<?php
include "database/koneksi.php";
include "database/check.php";

$ng_user = mysqli_query($connectdb, "SELECT ng_user.username, 
                                                ng_user.password, 
                                                ng_user.email, 
                                                ng_userlogin.level 
                                        FROM ng_user 
                                        INNER JOIN ng_userlogin ON ng_userlogin.userid = ng_user.id
                                        ORDER BY ng_userlogin.level ASC");

if(!$ng_user){
    die ("Query Error: ".mysqli_errno($connectdb).
                      " - ".mysqli_error($connectdb));
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
  <script src="https://kit.fontawesome.com/bd16c6b546.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">

  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
  
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
        }else if($_SESSION['level'] == "" || $_SESSION['level'] == 1 || $_SESSION['level'] == 2 ||
                $_SESSION['level'] == 10|| $_SESSION['level'] == 11){
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
            <h1>User List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">User List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- tAbel FidA -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Username</th>
                  <th>Password</th>
                  <th>Email</th>
                  <th>Level</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                    while ($dtmanager = mysqli_fetch_assoc($ng_user)){
                    if($dtmanager['level'] == 1){
                      $lvl = 'Manager';
                    }else if($dtmanager['level'] == 10){
                      $lvl = 'Finance';
                    }else if($dtmanager['level'] == 11){
                      $lvl = 'Purchase';
                    }
                    
                    //password
                    $countpass = strlen(substr($dtmanager['password'],0,-3));
                    $replacepass = '';
                    for($i = 0; $i < $countpass; $i++){
                      $replacepass .= 'x';
                    }
                    $password = str_replace(substr($dtmanager['password'],0,-3), $replacepass ,$dtmanager['password']);
                    //end password
                ?>
                <tr>
                  <td><?php echo $dtmanager['username']; ?></td>
                  <td><?php echo $password; ?></td>
                  <td><?php echo $dtmanager['email']; ?></td>
                  <td><?php echo $lvl; ?></td>
                </tr>
              </tbody>
              <?php } ?>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; Mustafidatun Nashihah.</strong>
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="./js/jquery.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<!-- Bootstrap -->
<script src="./js/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="./js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="./js/demo.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
</body>
</html>
