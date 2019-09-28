<?php
include "database/koneksi.php";
include "database/check.php";

$chpole = mysqli_query($connectdb, "SELECT ng_childpool.*, 
                                          ng_paket.paket 
                                    FROM ng_childpool 
                                    LEFT JOIN ng_paket ON ng_paket.kd_prod = ng_childpool.kd_prod
                                    ORDER BY id, poolid ASC");

$paketlist = mysqli_query($connectdb, "SELECT kd_prod, paket FROM ng_paket");

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | DataTables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

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
            <h1>DataTables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
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
            <div class="card-header">
              <h3 class="card-title">DataTable with default features</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Pool Name</th>
                    <th>Start Address</th>
                    <th>End Address</th>
                    <th>Availability</th>
                    <th>Paket</th> 
                  </tr>
                </thead>
                <tbody>
                  <?php while ($chpooldet = mysqli_fetch_assoc($chpole)){?>

                    <tr>
                      <td><?php echo $chpooldet['poolname']; ?></td>
                      <td><?php echo $chpooldet['start_address']; ?></td>
                      <td><?php echo $chpooldet['end_address']; ?></td>
                      <td><?php echo $chpooldet['available']; ?></td>
                      <td><?php if($chpooldet['paket'] != NULL){
                                  echo $chpooldet['paket'];
                                }else{
                            ?>
                              
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                        Add Paket
                      </button>

                      <!-- Modal -->
                      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel">Paket</h4>
                              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>      
                            </div>
                            <form action="" method=post>
                              <div class="modal-body">
                                  <input id="chpoolid" name="chpoolid" type="text" value="<?php echo $chpooldet['id']; ?>">
                                  <div class="form-group">
                                    <label>Paket</label>
                                    <select class="form-control" name="kd_prod">

                                      <option value=''>Pilih</option>
                                      <?php 
                                      while ($dtpaket = mysqli_fetch_assoc($paketlist)){
                                          echo "<option value=".$dtpaket['kd_prod'].">".$dtpaket['paket']."</option>";
                                      }
                                  ?> 
                                    </select>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                               <button id="send" type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <!-- End Modal -->
                    
                            <?php  } ?>
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

<?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
          $kd_prod = $_POST['kd_prod'];

          $updatepaket = mysqli_query($connectdb, "UPDATE ng_childpool SET kd_prod = \"$kd_prod\" WHERE id = \"$chpoolid\"");

          echo("<meta http-equiv='refresh' content='1'>"); //Refresh by HTTP META 
         }
      ?>