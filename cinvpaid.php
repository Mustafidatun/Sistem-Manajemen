<?php
include "database/koneksi.php";
include "database/check.php";

if(!empty($_GET['ADJLAsjljsKDSLSJd'])){
$invoice = $_GET['ADJLAsjljsKDSLSJd'];

  $cinv = mysqli_query ($connectdb, "select ng_invoice.*, ng_customer.firstname, ng_customer.lastname 
                                    from ng_invoice
                                    inner join ng_customer on ng_customer.id = ng_invoice.customerid
                                    where invoiceid=\"$invoice\"");
  $datacq = mysqli_fetch_assoc($cinv);
}else{
    header("location:customer_invoice.php");
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
        }else if($_SESSION['level'] == 10){
          include './include/sidebar_finance.php';
        }else if($_SESSION['level'] == "" || $_SESSION['level'] == 1 || $_SESSION['level'] == 2 || $_SESSION['level'] == 11){
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
            <h1>Customer Invoice Paid</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Customer Invoice Paid</li>
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
                <h3 class="card-title">Form Customer Invoice Paid</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="#" method=post enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputInvoiceId">Invoice Number</label> 
                    <input type="hidden" id="inputId" name="idiv" vaLue="<?php echo $data['id']; ?>">
                    <input type="text" class="form-control" id="inputInvoiceId" name="invid" vaLue="<?php echo $datacq['invoiceid']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="inputCustomerName">Customer Name</label>
                    <input type="text" class="form-control" id="inputCustomerName" name="fname" vaLue="<?php echo $datacq['firstname'].' '.$datacq['lastname']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="inputDate">Invoice Date</label>
                    <input type="text" class="form-control" id="inputDate" name="dateinv" vaLue="<?php echo $datacq['date']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="inputDueDate">Invoice Due Date</label>
                    <input type="text" class="form-control" id="inputDueDate" name="duedate" vaLue="<?php echo $datacq['due_date']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="inputTotal">Total Invoice</label>
                    <input type="text" class="form-control" id="inputTotal" name="total" vaLue="<?php echo number_format($datacq['ammount']); ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="inputAddress">Pay Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control" id="inputPayDate" name="paiddate" placeholder="Input Pay Date" type="date" required>
                    </div>
                  </div>
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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://kit.fontawesome.com/bd16c6b546.js"></script>
<script src="./js/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<!-- Bootstrap -->
<script src="./js/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="./js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="./js/demo.js"></script>
<script>
  $(document).ready(function () {
    bsCustomFileInput.init()
  })
</script>
</body>
</html>
<?php
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $paiddate = date('Y-m-d',strtotime($_POST['paiddate']));
      $invc = $_POST['idiv']; 
      $ng_cq = "update ng_invoice set paydate=\"$paiddate\" , status=1 where id=\"$invc\"" ; 
    mysqli_query ($connectdb, $ng_cq );
    header ("location:customer_invoice.php");
  }
?>