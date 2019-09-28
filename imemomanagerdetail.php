<?php
include "database/koneksi.php";
include "database/check.php";

$userid = $_SESSION['userid'];
if($_GET['memoid'] <> "" || $_GET['vendor'] <> "" || $_GET['date'] <> ""){
$memoid = $_GET['memoid'];
$vendor = $_GET['vendor'];
$date = $_GET['date'];

$memolist = mysqli_query($connectdb, "SELECT ng_internalmemo.id AS im_id, 
                                            ng_equipmaster.id AS equipmasterid, 
                                            ng_equipmaster.type, ng_equipmaster.merk, 
                                            ng_equipmaster.vol, ng_vendor.vendor, 
                                            ng_internalmemo.price, 
                                            ng_internalmemo.quantity, 
                                            (ng_internalmemo.price*ng_internalmemo.quantity) AS subtotal
                                        FROM ng_internalmemo 
                                        INNER JOIN ng_equipmaster ON ng_equipmaster.id = ng_internalmemo.equipmasterid
                                        INNER JOIN ng_vendor ON ng_vendor.id = ng_equipmaster.vendorid
                                        WHERE ng_internalmemo.memoid = \"$memoid\" AND 
                                                ng_internalmemo.date = \"$date\" AND 
                                                ng_vendor.vendor = \"$vendor\" AND 
                                                ng_internalmemo.status = 0");

}else{
  header("location:imemomanager.php");
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
                <td>Memo Id</td>
                <td> : </td>
                <td><?php echo $memoid; ?></td>
            </tr>
            <tr>
                <td>Vendor</td>
                <td> : </td>
                <td><?php echo $vendor;?></td>
            </tr>
            <tr>
                <td>Date</td>
                <td> : </td>
                <td><?php echo date('d F Y', strtotime($date));?></td>
            </table>

            <form action="#" method="post">   
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
                        <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                        $total = 0;
                        $index = 0;
                        while ($dtmemo = mysqli_fetch_assoc($memolist)){
                            $total += $dtmemo['subtotal'];
                        ?>
                    
                    <tr >
                        <td><?php echo $dtmemo['type']; ?></td>
                        <td><?php echo $dtmemo['merk']; ?></td>
                        <td><?php echo $dtmemo['vendor']; ?></td>
                        <td><?php echo $dtmemo['price']; ?></td>
                        <td><?php echo $dtmemo['quantity']; ?></td>
                        <td><?php echo $dtmemo['vol']; ?></td>
                        <td><?php echo $dtmemo['subtotal']; ?></td>
                        <td>
                            <input type="checkbox" name="inputs[<?php echo $index; ?>][im_id]" value="<?php echo $dtmemo['im_id']; ?>" checked>
                        </td>
                    </tr>
                    
                    <?php 
                        $index++;
                        } 
                    ?>
                        
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total</td>
                        <td><?php echo $total; ?></td>
                    </tr>
                </tfoot>
            </table>
            <div class="form-group">  
                <button id="send" class="btn btn-primary btn-sm" type="submit">Submit</button>  
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

          $jmlpo = mysqli_query($connectdb, "SELECT SUM(DISTINCT poid) AS jmlpo FROM ng_purchaseorder GROUP BY poid ORDER BY poid DESC LIMIT 1");
          $dtjmlpo = mysqli_fetch_array($jmlpo);

          $dtchecklist_barang = $_POST['inputs'];
          
          // $date = date("Y-m-d");
          $poid = ($dtjmlpo['jmlpo']+1).'/PO/'.date('m').'/'.date('Y');

            foreach ($dtchecklist_barang as $dt){

                    $im_id = $dt['im_id'];
                    
                    $ng_internalmemo = mysqli_query($connectdb, "SELECT equipmasterid, price FROM ng_internalmemo WHERE id = \"$im_id\"");
                    $dtim = mysqli_fetch_array($ng_internalmemo);
                    $equipmasterid = $dtim['equipmasterid'];
                    $price = $dtim['price'];

                    $update_internalmemo = mysqli_query($connectdb, "UPDATE ng_internalmemo SET status = \"1\", approve_date = DATE(NOW()), userid = \"$userid\" WHERE id = \"$im_id\"");

                    $checkprice = mysqli_query($connectdb, "SELECT price FROM ng_equipmaster 
                                                            WHERE ng_equipmaster.id = \"$equipmasterid\" AND price NOT IN ( 
                                                                SELECT price FROM ng_internalmemo WHERE ng_internalmemo.id = \"$im_id\")");

                    if(mysqli_fetch_row($checkprice) != NULL ){
                      $update_equipmaster = mysqli_query($connectdb, "UPDATE ng_equipmaster SET price = \"$price\" WHERE id = \"$equipmasterid\"");
                    }

                    $ng_po = mysqli_query($connectdb, "INSERT INTO ng_purchaseorder(internalmemoid, poid) VALUES (\"$im_id\", \"$poid\")") ; 

                    // $approval_internalmemo = mysqli_query($connectdb, "CALL spApprovalInternalMemo(\"$userid\",\"$im_id\")");
                }

                echo("<meta http-equiv='refresh' content='0' url='imemomanager.php'>"); //Refresh by HTTP META 
            }
            ?>
        