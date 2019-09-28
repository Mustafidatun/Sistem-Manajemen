<?php
include "database/koneksi.php";
include "database/check.php";

$start_billing = mysqli_query($connectdb, "SELECT ng_customer.id, 
                                                  CONCAT_WS(' ',ng_customer.firstname, ng_customer.lastname) AS name, 
                                                  ng_kota.kota, 
                                                  ng_node.node, 
                                                  ng_customer.register_date, 
                                                  ng_customer.start_billing 
                                          FROM ng_customer
                                          INNER JOIN ng_kota ON ng_kota.id = ng_customer.kota
                                          INNER JOIN ng_node ON ng_node.nodeid = ng_customer.node
                                          WHERE ng_customer.active = 1");
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
      include 'include/sidebar_supermanager.php';
      // include 'include/sidebar_manager.php';
      // include 'include/sidebar_submanager.php';
      // include './include/sidebar_purchase.php';
      // include './include/sidebar_finance.php';
      // include './include/sidebar_fieldtec.php';
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
                      <th>Nama Pelanggan</th>
                      <th>Kota</th>
                      <th>Node</th>
                      <th>Register Date</th>
                      <th>Online Billing</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while ($dtbilling = mysqli_fetch_assoc($start_billing)){?>

                      <tr>
                        <td><?php echo $dtbilling['name']; ?></td>
                        <td><?php echo $dtbilling['kota']; ?></td>
                        <td><?php echo $dtbilling['node']; ?></td>
                        <td><?php echo date('d F Y', strtotime($dtbilling['register_date'])); ?></td>
                        <td><?php if($dtbilling['start_billing'] != '0000-00-00'){
                                      echo date('d F Y', strtotime($dtbilling['start_billing']));
                                  }else{
                            ?>
                                      <form action="" method=post novalidate>
                                        <input id="customerid" name="customerid" type="hidden" value="<?php echo $dtbilling['id']; ?>">
                                        <input id="register_date" name="register_date" type="hidden" value="<?php echo $dtbilling['register_date']; ?>">
                                        <input id="start_billing" name="start_billing" placeholder="Input your start billing" required="required" type="date" value="<?php echo date('Y-m-d'); ?>">           
                                        <button id="send" type="submit">Submit</button>                                    
                                      </form>

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
          $customerid = $_POST['customerid'];
          $register_date = $_POST['register_date'];
          $start_billing = date('Y-m-d', strtotime($_POST['start_billing']));

          if($start_billing >= $register_date){
              $update_billing = mysqli_query($connectdb, "UPDATE ng_customer SET start_billing = \"$start_billing\" WHERE id = \"$customerid\"");
          }else{ 
               echo '<script language="javascript">alert("Tanggal harus diatas tanggal registrasi")</script>';
          }


          echo("<meta http-equiv='refresh' content='1'>"); //Refresh by HTTP META 
       }
  ?>
