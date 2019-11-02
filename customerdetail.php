<?php
include "database/koneksi.php";
include "database/check.php";

if (!empty($_GET['id'])) {
$customerid = $_GET['id'];

$customerlist = mysqli_query($connectdb, "SELECT ng_customer.firstname, 
                                                ng_customer.lastname, 
                                                ng_customer.username, 
                                                ng_customer.alamat, 
                                                ng_customer.email,
                                                ng_customer.no_telp, 
                                                ng_customer.identitas, 
                                                ng_customer.foto, 
                                                ng_kota.kota, 
                                                ng_node.node, 
                                                ng_paket.paket
                                            FROM ng_customer
                                            INNER JOIN ng_kota ON ng_kota.id = ng_customer.kota
                                            INNER JOIN ng_node ON ng_node.nodeid = ng_customer.node
                                            INNER JOIN ng_paket ON ng_paket.id = ng_customer.paket
                                            WHERE ng_customer.id = \"$customerid\"");
$dtcustomerlist = mysqli_fetch_assoc($customerlist);

$customerinvoicelist = mysqli_query($connectdb, "SELECT ng_invoice.invoiceid, 
                                                        ng_invoice.date, 
                                                        ng_invoice.due_date, 
                                                        ng_invoice.paydate,
                                                        ng_invoice.ammount 
                                                  FROM ng_invoice
                                                  INNER JOIN ng_customer ON  ng_customer.id = ng_invoice.customerid
                                                  WHERE ng_customer.id = \"$customerid\"");
  } else {
    header("location:customerlist.php");
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
        }else if($_SESSION['level'] == 1){
          include 'include/sidebar_manager.php';
        }else if($_SESSION['level'] == 2){
          include 'include/sidebar_submanager.php';
        }else if($_SESSION['level'] == "" || $_SESSION['level'] == 10 || $_SESSION['level'] == 11){
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
            <h1>Customer Detail</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Customer Detail</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row m-3">
                <div class="col-md-6">
                  <h3><?php echo $dtcustomerlist['firstname'].' '.$dtcustomerlist['lastname']; ?></h3>
                  <ul>
                      <li><?php echo $dtcustomerlist['alamat'].', '.$dtcustomerlist['kota']; ?></li>
                      <li><?php echo $dtcustomerlist['email']; ?> </li>
                      <li><?php echo $dtcustomerlist['no_telp']; ?> </li>
                      <li><?php echo $dtcustomerlist['paket']; ?> </li>
                  </ul>
                  <?php if($_SESSION['level'] != 5){?>
                  <a class="btn btn-primary btn-sm" href="customeredit.php?id=<?php echo $customerid; ?>">Edit</a>
                  <?php } ?>
                </div>
                <div class="col-md-6">
                  <h4>KTP/SIM/Pasport</h4>
                  <img class="img-responsive avatar-view" src="foto/<?php echo $dtcustomerlist['foto']; ?>" alt="Avatar" title="Change the avatar">
                </div>
              </div>

            <h4>Invoice</h4>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Invoice Number</th>
                  <th>Date Ammount</th>
                  <th>Due Date</th>
                  <th>Pay Date</th>
                  <th>Ammount</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $i = 1;
                  while ($dtcustomerinvoice = mysqli_fetch_assoc($customerinvoicelist)){ 
                ?>

                <tr>
                  <th scope="row"><?php echo $i++; ?></th>
                  <td><a href="invoice.php?ADJLAsjljsKDSLSJd=<?php echo $dtcustomerinvoice['invoiceid']; ?>&ZFhObGNtNWhiV1U9=<?php echo $dtcustomerlist['username']; ?>&SLSJdKASdaE67daSE21=<?php echo substr($dtcustomerinvoice['ammount'], -3); ?>" target="_blank"><?php echo $dtcustomerinvoice['invoiceid']; ?></td>
                  <td><?php echo $dtcustomerinvoice['date']; ?></td>
                  <td><?php echo $dtcustomerinvoice['due_date']; ?></td>
                  <td><?php echo $dtcustomerinvoice['paydate']; ?></td>
                  <td><?php echo $dtcustomerinvoice['ammount']; ?></td>
                </tr>

                <?php
                  }
                ?>
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
