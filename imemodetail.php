<?php
include "database/koneksi.php";
include "database/check.php";

if($_GET['memoid'] <> "" || $_GET['vendor'] <> "" || $_GET['date'] <> ""){
  $memoid = $_GET['memoid'];
  $vendor = $_GET['vendor'];
  $date = $_GET['date'];

  $memolist = mysqli_query($connectdb, "SELECT ng_equipmaster.type, 
                                              ng_equipmaster.merk, 
                                              ng_internalmemo.price, 
                                              ng_internalmemo.quantity, 
                                              ng_equipmaster.vol,
                                              (ng_internalmemo.price*ng_internalmemo.quantity) AS subtotal, 
                                              ng_internalmemo.status,
                                              IFNULL(ng_userlogin.username, '-') AS username_im, 
                                              IFNULL(ng_internalmemo.approve_date, '-') AS approve_date, 
                                              IFNULL(ng_manager.username, '-') AS username_po, 
                                              ng_vendor.id
                                          FROM ng_internalmemo 
                                          INNER JOIN ng_equipmaster ON ng_equipmaster.id = ng_internalmemo.equipmasterid
                                          INNER JOIN ng_vendor ON ng_vendor.id = ng_equipmaster.vendorid
                                          LEFT JOIN ng_userlogin ON  ng_userlogin.id = ng_internalmemo.userid 
                                          LEFT JOIN ng_manager ON ng_manager.id = ng_internalmemo.financeid
                                          WHERE ng_internalmemo.memoid = \"$memoid\" AND 
                                                ng_internalmemo.date = \"$date\" AND 
                                                ng_vendor.vendor = \"$vendor\"");

  $cekstatus = mysqli_query($connectdb, "SELECT ng_internalmemo.status
                                        FROM ng_internalmemo 
                                        INNER JOIN ng_purchaseorder ON ng_purchaseorder.internalmemoid = ng_internalmemo.id
                                        WHERE ng_internalmemo.memoid = \"$memoid\"
                                        ORDER BY ng_internalmemo.status DESC LIMIT 1");
  $status = mysqli_fetch_assoc($cekstatus);   

  if($status['status'] == 0){
    $persen = '0%';
  }else if($status['status'] == 1){
    $persen = '35%';
  }else if($status['status'] == 2){
    $persen = '70%';
  }else if($status['status'] == 3){
    $persen = '100%';
  }
}else{
  header("location:imemolist.php");
}

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
              <table>
                <tr>
                  <td><label class="control-label" >Memo Id</label></td>
                  <td> : </td>
                  <td><?php echo $memoid; ?></td>
                </tr>
                <tr>
                  <td><label class="control-label" >Vendor</label></td>
                  <td> : </td>
                  <td><?php echo $vendor;?></td>
                </tr>
                <tr>
                  <td><label class="control-label" >Date</label></td>
                  <td> : </td>
                  <td><?php echo date('d F Y', strtotime($date));?></td>
                </tr>
                <tr>
                  <td><label class="control-label" >Proses</label></td>
                  <td> : </td>
                  <td>
                    <div class="progress progress-xs progress-striped active">
                      <div class="progress-bar bg-primary" style="width: <?php echo $persen ?>"></div>
                    </div>
                    <span class="badge bg-primary"><?php echo $persen ?></span>
                  </td>
                </tr>
              </table>

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th></th>
                    <th>Type</th>
                    <th>Merk</th>
                    <th>Approve Date</th>
                    <th>Manager</th>
                    <th>Finance</th>
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
                      $vendorid = $dtmemo['id'];

                      if($dtmemo['status'] != 2){
                        echo "<tr>
                                <td></td>";
                      }else{
                        echo "<tr>
                                <td><a href='#/check-square'><i class='fa fa-check-square'></i></a></td>";
                      }

                  ?>

                    <td><?php echo $dtmemo['type']; ?></td>
                    <td><?php echo $dtmemo['merk']; ?></td>
                    <td><?php echo $dtmemo['approve_date']; ?></td>
                    <td><?php echo $dtmemo['username_im']; ?></td>
                    <td><?php echo $dtmemo['username_po']; ?></td>
                    <td align="right"><?php echo $dtmemo['price']; ?></td>
                    <td size="3"><?php echo $dtmemo['quantity']; ?></td>
                    <td><?php echo $dtmemo['vol']; ?></td>
                    <td align="right"><?php echo $dtmemo['subtotal']; ?></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total</td>
                    <td align="right"><?php echo $total; ?></td>
                  </tr>
                </tfoot>
              </table>

              <?php if($status['status'] == 2) { ?>
    
                <button id='send' type='submit' class="btn btn-primary btn-sm" onclick="location.href = 'purchaseorderreg.php?memoid=<?php echo $memoid; ?>'">Purchase Order</button>
                                
              <?php } ?>

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