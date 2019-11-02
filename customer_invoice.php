<?php
include "database/koneksi.php";
include "database/check.php";

$customerinvoicelist = mysqli_query($connectdb, "SELECT ng_customer.id AS customerid, 
                                                      CONCAT_WS(' ',ng_customer.firstname, 
                                                      ng_customer.lastname) AS name,
                                                      ng_customer.username, 
                                                      ng_customer.register_date,
                                                      ng_invoice.invoiceid, 
                                                      ng_invoice.date,ng_invoice.paydate, 
                                                      ng_invoice.due_date,ng_invoice.status,
                                                      ng_invoice.ammount FROM ng_customer
                                            LEFT JOIN ng_invoice ON ng_invoice.customerid = ng_customer.id where ng_invoice.paydate is NULL");
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

  <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/> -->

  <style type="text/css">
    .center {
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>
  
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
            <h1>Invoice List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Invoice List</li>
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
            
            <form class="form-horizontal form-label-left mb-3" action="" method="post" enctype="multipart/form-data">
                  <div class="row">
                    <div class="item form-group col-md-6">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="file_csv">CSV File </label> 
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="input-group">
                          <input id="uploadfilecsv" type="text" class="form-control" placeholder="Choose File...">
                          <span class="input-group-btn">
                            <div class="imageupload">
                              <label class="btn btn-default btn-file">
                                <span>Upload</span>
                                <input id="uploadbtncsv" type="file" name="file_csv" accept=".csv" class="form-control col-md-7 col-xs-12">
                              </label>
                            </div>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="item form-group col-md-6">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="file_excel">Excel File </label> 
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="input-group">
                          <input id="uploadfileexcel" type="text" class="form-control" readonly="readonly" placeholder="Choose File...">
                          <span class="input-group-btn">
                            <div class="imageupload">
                              <label class="btn btn-default btn-file">
                                <span>Upload</span>
                                <input id="uploadbtnexcel" type="file" name="file_excel" accept=".xls" class="form-control col-md-7 col-xs-12">
                              </label>
                            </div>
                          </span>
                        </div>
                    </div>
                  </div>
                  <div class="form-group ml-auto">
                    <div class="col-md-12">
                      <button type="reset" class="btn btn-primary">Cancel</button>
                      <button id="send" type="submit" class="btn btn-success">Submit</button>
                    </div>
                  </div> 
                </form>
                <div class="col-md-12 pt-3 pb-3 mr-auto">
                    <button id="send" type="submit" onclick="location.href = 'customer_invoiceproses.php'" class="btn btn-success">Create Ammount</button>
                </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Due Date</th>
                    <th>Nama Pelanggan</th>
                    <th>Invoice Number</th>
                    <th>Date Ammount</th>
                    <th>Pay Date</th>
                    <th>Ammount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    while ($dtcustomerinvoice = mysqli_fetch_assoc($customerinvoicelist)){ 
                      

                      if($dtcustomerinvoice['invoiceid'] != NULL && 
                          $dtcustomerinvoice['ammount'] != NULL && 
                          $dtcustomerinvoice['date'] != NULL && 
                          $dtcustomerinvoice['due_date'] != NULL){
                                          
                            $invoice = $dtcustomerinvoice['invoiceid'];
                            $date = date('d F Y', strtotime($dtcustomerinvoice['date']));
                            $due_date = date('d F Y', strtotime($dtcustomerinvoice['due_date']));
                            $ammount = $dtcustomerinvoice['ammount'];

                            if($dtcustomerinvoice['paydate'] != NULL){
                              $paydate = date('d F Y', strtotime($dtcustomerinvoice['paydate']));
                            }else{
                              $paydate = '-';
                            }

                      }else{
                        $invoice = '-';
                        $date = '-';
                        $due_date = '-';
                        $ammount = '-';
                      }

                    ?>

                    <tr>
                      <td><?php echo $dtcustomerinvoice['name']; ?></td>
                      <td><?php echo $invoice; ?></td>
                      <td><?php echo $date; ?></td>
                      <td><?php echo $due_date; ?></td>
                      <td><?php echo $paydate; ?></td>
                      <td><?php echo number_format($ammount); ?></td>
                      <td><a href="invoice.php?ADJLAsjljsKDSLSJd=<?php echo $invoice;?>&ZFhObGNtNWhiV1U9=<?php echo $dtcustomerinvoice['username'];?>&SLSJdKASdaE67daSE21=<?php echo substr($ammount, -3);?>" class="btn btn-info btn-xs" target="_blank">show</a>
                      <a href="cinvpaid.php?ADJLAsjljsKDSLSJd=<?php echo $invoice;?>" class="btn btn-success btn-xs" >paid</a>
            </td>
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
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
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

  $(document).ready(function () {
    bsCustomFileInput.init()
  })
</script>
</body>
</html>

<?php
          if(!empty($_FILES["file_csv"]['tmp_name']) && !empty($_FILES["file_excel"]['tmp_name'])){
              
              echo '<script language="javascript">alert("Pilih Salah satu")</script>';

          }else if(!empty($_FILES["file_csv"]['tmp_name'])) {
              $filename = $_FILES["file_csv"]["tmp_name"];
              $file_array = file($filename);

                  foreach ($file_array as $line_number =>&$line)
                  {
                      $row=explode(',"',$line);
                      $csv_tgl = preg_replace('/[^0-9\/]/','',$row[0]);
                      $tgl = date("Y").'-'.substr($csv_tgl,-2).'-'.substr($csv_tgl, 0, 2);
                      $bulan = substr($csv_tgl,-2);
                      $csv_ammount = explode(".", $row[3]);
                      $ammount = preg_replace('/([^0-9])/i', '', $csv_ammount[0]);

                      $check_ammountinvoice = mysqli_query($connectdb, "SELECT ammount 
                                                                        FROM ng_invoice
                                                                        WHERE DATE_FORMAT(date, '%m') = \"$bulan\" AND 
                                                                        paydate IS NULL AND status != 1");

                      while($dtammount = mysqli_fetch_array($check_ammountinvoice)){
                          $invoice_ammount = $dtammount['ammount'];
                          
                          if($invoice_ammount == $ammount){

                              $update_invoice = mysqli_query($connectdb, "UPDATE ng_invoice 
                                                                          SET paydate = \"$tgl\", status = 1 
                                                                          WHERE ammount = \"$ammount\"");
                            
                          }
                      }
                  }

                  echo '<script language="javascript">alert("Update Sukses")</script>';
                  echo("<meta http-equiv='refresh' content='1'>"); //Refresh by HTTP META 

          }else if(!empty($_FILES["file_excel"]['tmp_name'])) {

              require_once 'PHPExcel/PHPExcel.php';
              $excelreader = new PHPExcel_Reader_Excel5();

              $filename = $_FILES["file_excel"]['name'];
              
              $tmp_file = $_FILES['file_excel']['tmp_name'];
              
              $path = "$filename";
              
              move_uploaded_file($tmp_file, $path);

              sleep(5);
              
              $loadexcel = $excelreader->load($filename);
              
            $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
              
              
            foreach($sheet as $row){
                  
                  $csv_tgl = explode("/", $row['C']);
                  $tgl = $csv_tgl[0];
                  $bulan = $csv_tgl[1];
                  $year = $csv_tgl[2];
                  $format_tgl = $year.'-'.$bulan.'-'.$tgl;
                  $csv_ammount = explode(".", $row['I']);
                  $ammount = preg_replace('/([^0-9])/i', '', $csv_ammount[0]);

                  $check_ammountinvoice = mysqli_query($connectdb, "SELECT ammount 
                                                                    FROM ng_invoice
                                                                    WHERE DATE_FORMAT(date, '%m') = \"$bulan\" AND 
                                                                          paydate IS NULL AND status != 1");

                  while($dtammount = mysqli_fetch_array($check_ammountinvoice)){
                    
                    $invoice_ammount = $dtammount['ammount'];
                          
                    if($invoice_ammount == $ammount){

                        $update_invoice = mysqli_query($connectdb, "UPDATE ng_invoice 
                                                                          SET paydate = \"$format_tgl\", status = 1 
                                                                          WHERE ammount = \"$ammount\"");
                            
                    }
                  }
                  // echo $format_tgl.' '.$ammount.'<br/>';
              
            }

              unlink($path);

              echo '<script language="javascript">alert("Update Sukses")</script>';
              echo("<meta http-equiv='refresh' content='1'>"); //Refresh by HTTP META 
          }
          ?>

       