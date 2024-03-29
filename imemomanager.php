<?php
include "database/koneksi.php";
include "database/check.php";

$memolist = mysqli_query($connectdb, "SELECT DISTINCT ng_internalmemo.memoid, 
                                                      ng_internalmemo.date, 
                                                      SUM(ng_internalmemo.price*ng_internalmemo.quantity)AS total, 
                                                      ng_vendor.vendor,
                                                      ng_user.username AS username_purchase 
                                      FROM ng_internalmemo 
                                      INNER JOIN ng_equipmaster ON ng_equipmaster.id = ng_internalmemo.equipmasterid
                                      INNER JOIN ng_vendor ON ng_vendor.id = ng_equipmaster.vendorid
                                      INNER JOIN ng_user ON ng_user.id = ng_internalmemo.purchasingid
                                      WHERE ng_internalmemo.status = 0
                                      GROUP BY memoid ORDER BY date ASC");
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
            <h1>Internal Memo List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Internal Memo List</li>
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
                    <th>Memo Id</th>
                    <th>Created By</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Detail Memo</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($dtmemo = mysqli_fetch_assoc($memolist)){?>

                    <tr>
                      <td><?php echo $dtmemo['memoid']; ?></td>
                      <td><?php echo $dtmemo['username_purchase']; ?></td>
                      <td><?php echo date('d F Y', strtotime($dtmemo['date'])); ?></td>
                      <td align="left"><?php echo number_format($dtmemo['total']); ?></td>
                      <td><button id="send" type="submit" class="btn btn-primary btn-sm" onclick="location.href = 'imemomanagerdetail.php?memoid=<?php echo $dtmemo['memoid']; ?>&vendor=<?php echo $dtmemo['vendor']; ?>&date=<?php echo $dtmemo['date']; ?>&purchase=<?php echo $dtmemo['username_purchase']; ?>'">Detail</button>
                      </td>
                    </tr>
                      
                  <?php } ?>

                </tbody>
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
