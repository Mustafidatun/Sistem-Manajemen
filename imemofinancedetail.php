<?php
include "database/koneksi.php";
include "database/check.php";

$userid = $_SESSION['userid'];
if($_GET['memoid'] <> "" || $_GET['vendor'] <> "" || $_GET['date'] <> "" || $_GET['poid'] <> "" || $_GET['approve_date'] <> "" || $_GET['username'] <> ""){
$memoid = $_GET['memoid'];
$vendor = $_GET['vendor'];
$date = $_GET['date'];
$poid = $_GET['poid'];
$approve_date = $_GET['approve_date'];
$approve = $_GET['username'];

$memolist = mysqli_query($connectdb, "SELECT ng_equipmaster.type, ng_equipmaster.merk, 
                                            ng_equipmaster.vol,
                                            ng_vendor.vendor, 
                                            ng_internalmemo.price,
                                            ng_internalmemo.quantity, 
                                            (ng_internalmemo.price*ng_internalmemo.quantity) AS subtotal
                                        FROM ng_internalmemo 
                                        INNER JOIN ng_purchaseorder ON ng_purchaseorder.internalmemoid = ng_internalmemo.id
                                        INNER JOIN ng_equipmaster ON ng_equipmaster.id = ng_internalmemo.equipmasterid
                                        INNER JOIN ng_vendor ON ng_vendor.id = ng_equipmaster.vendorid
                                        WHERE ng_internalmemo.memoid = \"$memoid\" AND 
                                                ng_internalmemo.date = \"$date\" AND 
                                                ng_vendor.vendor = \"$vendor\" AND 
                                                ng_purchaseorder.poid = \"$poid\" AND 
                                                ng_internalmemo.approve_date = \"$approve_date\" AND
                                                ng_internalmemo.status = 1 ");

}else{
  header("location:imemofinance.php");
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
            <h1>Internal Memo Detail</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Internal Memo Detail</li>
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
              <div class="col-12 mt-5 mb-5 ml-0">
                <div class="row">
                  <div class="col-6">
                    <div class="col-md-12 ml-auto">
                      <div class="row">
                        <p class="col-md-3 font-weight-bold">Memo Id </p>
                        <p class="col-md-8 p-0"><?php echo $memoid; ?></p>
                      </div>
                    </div>
                    <div class="col-md-12 ml-auto">
                      <div class="row">
                        <p class="col-md-3 font-weight-bold">Vendor</p>
                        <p class="col-md-8 p-0"><?php echo $vendor; ?></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="col-md-12 ml-auto">
                      <div class="row">
                        <p class="col-md-3 font-weight-bold">Date </p>
                        <p class="col-md-8 p-0"><?php echo date('d F Y', strtotime($date));?></p>
                      </div>
                    </div>
                    <div class="col-md-12 ml-auto">
                      <div class="row">
                        <p class="col-md-3 font-weight-bold">Approve Date </p>
                        <p class="col-md-8 p-0"><?php echo date('d F Y', strtotime($approve_date));?></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="col-md-12 ml-auto">
                      <div class="row">
                        <p class="col-md-3 font-weight-bold">PO Id </p>
                        <p class="col-md-8 p-0"><?php echo $poid;?></p>
                      </div>
                    </div>
                    <div class="col-md-12 ml-auto">
                      <div class="row">
                        <p class="col-md-3 font-weight-bold">Approve By </p>
                        <p class="col-md-8 p-0"><?php echo $approve;?></p>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>
              </div>

            <form action="" method=post>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Type</th>
                    <th>Merk</th>
                    <th>Vendor</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Vol</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                      $total = 0;
                      while ($dtmemo = mysqli_fetch_assoc($memolist)){
                        $total += $dtmemo['subtotal'];
                    ?>

                    <tr >
                      <td><?php echo $dtmemo['type']; ?></td>
                      <td><?php echo $dtmemo['merk']; ?></td>
                      <td><?php echo $dtmemo['vendor']; ?></td>
                      <td align="right"><?php echo number_format($dtmemo['price']); ?></td>
                      <td size="3"><?php echo $dtmemo['quantity']; ?></td>
                      <td><?php echo $dtmemo['vol']; ?></td>
                      <td align="right"><?php echo number_format($dtmemo['subtotal']); ?></td>
                    </tr>

                    <?php } ?>

                  </tbody>
                  <tfoot>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>Total</td>
                      <td align="right"><?php echo $total; ?></td>
                    </tr>
                  </tfoot>
              </table>
            
              <input id="poid" name="poid" type="hidden" value="<?php echo $poid; ?>">
              <div class="col-md-6 mt-1 mb-5">
                <button id='send' type='submit' class="btn btn-primary btn-sm" type="submit">Approve</button>  
              </div>
            </form>

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
          
            $update_internalmemo = mysqli_query($connectdb, "UPDATE ng_internalmemo SET status = \"2\", approve_date = DATE(NOW()), financeid = \"$userid\" WHERE memoid = \"$memoid\" AND date = \"$date\" AND ng_internalmemo.status = 1 ");

              header("location:imemofinance.php");
              echo("<meta http-equiv='refresh' content='0' url='imemofinance.php'>"); //Refresh by HTTP META 
            }
            ?>
        