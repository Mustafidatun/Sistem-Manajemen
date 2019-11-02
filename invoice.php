<!DOCTYPE html>
<?php
include ("database/koneksi.php");

$username = $_GET['ZFhObGNtNWhiV1U9'];
$noinv = $_GET['ADJLAsjljsKDSLSJd'];
$code = $_GET['SLSJdKASdaE67daSE21'];
$data = mysqli_fetch_assoc(mysqli_query($connectdb, "select * from ng_customer where username=\"$username\""));
$idpak = $data['paket'];
$idkot = $data['kota'];
$paket = mysqli_fetch_assoc(mysqli_query($connectdb, "select * from ng_paket where id=\"$idpak\""));
$kota = mysqli_fetch_assoc(mysqli_query($connectdb, "select kota from ng_kota where id=\"$idkot\""));
$inv = mysqli_fetch_assoc(mysqli_query($connectdb, "select * from ng_invoice where invoiceid=\"$noinv\""));
    
?>
<html lang="en">
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

  <!-- <body class="nav-md" onLoad="document.getElementById('printme').click();"> -->
  <body class="nav-md" style="color: #000000; background: #FFFFFF;">
    <page size="A4" ><div class="container body">
      <div class="main_container">
                  <div class="x_content">
                    <section class="content invoice">
                      <!-- title row -->
                      <div class="row">
                        <div class="col-xs-12 invoice-header">
                          <h1>
                                          <i class="fa fa-info-circle"></i> Invoice
                                          <small class="pull-right">Date: <?php echo $inv['date']; ?></small>
                                      </h1>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- info row -->
                      <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                          From
                          <address>
                                          <strong> iMax5 </strong>
                                          <br><b>PT. Bentang Selaras Teknologi</b>
                                          <br>Ruko Soekarno Hatta Indah E8-E10
                                          <br>Mojolangu, Lowokwaru, Malang
                                          <br>Email: billing@imax5.id
                                      </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                          To
                          <address>
                                          <strong><?php echo $data['firstname'].' '.$data['lastname'];?></strong>
                                          <br><?php echo $data['alamat'];?>
                                          <br><?php echo $kota['kota']; ?>
                                          <br>Phone: <?php echo $data['no_telp'];?>
                                          <br>Email: <?php echo $data['email'];?>
                                      </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                          <br>
                          
                          <b>Invoice #<?php echo $noinv;?></b> 
                          <br>
                          <b>Payment Due:</b> <?php echo "<b style='color: blue;'>".$inv['due_date']."</b>";?>
                          <br>
						  <?php if($inv['paydate']==NULL){
							  $datex = strtotime($inv['due_date']);
							  $nowx = time(); 
							  echo "<b>Day Left: </b><b style='color: red;'>".round(($datex - $nowx)/86400)."</b>";
						  }else{
							  echo "<b>Date Paid: </b><b style='color: green;'>".$inv['paydate']."</b>";
						  }?>
                          <br>
                          <b>Customer ID:</b> <?php echo $data['username'];?>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <!-- Table row -->
                      <div class="row">
                        <div class="col-xs-12 table">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th>Qty</th>
                                <th>Product</th>
                                <th>Product ID</th>
                                <th style="width: 59%">Description</th>
                                <th>Subtotal</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td><?php echo $paket['paket'];?></td>
                                <td><?php echo $paket['kd_prod'];?></td>
                                <td><?php echo $paket['description'];?></td>
                                <td><?php echo 'IDR '. number_format($inv['ammount']-$code);?></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-xs-6">
                          <p class="lead">Payment Methods:</p>
                          <img src="images/bca.png" alt="BCA">
                          <img src="images/mandiri.png" alt="MANDIRI">
                          <img src="images/mastercard.png" alt="Mastercard">
                          <!-- <img src="images/american-express.png" alt="American Express">
                          <img src="images/paypal.png" alt="Paypal"> -->
                          
                          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
							Pembayaran bisa di transfer ke nomor rekening dibawah<br><br><b>BCA 8161222615 <br>a/n PT Bentang Selaras Teknologi</b><br>
						  <br>
						  <b>MANDIRI 1440003722722 <br>a/n PT Bentang Selaras Teknologi </b><br><br>Mohon transfer sesuai dengan total yang ada pada invoice untuk memudahkan pengecekan dari sisi kami.
						  </p>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-6">
                          <p class="lead">Amount Total</p>
                          <div class="table-responsive">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <th style="width:50%">Subtotal:</th>
                                  <td style="text-align: right;"><?php echo 'IDR '. number_format($inv['ammount']-$code);?></td>
                                </tr>
                                <tr>
                                  <th>Payment Code</th>
                                  <td style="text-align: right;"><?php echo $code;?></td>
                                </tr>
                                <tr>
                                  <th>Total:</th>
                                  <td style="text-align: right; font-size: large; color: red;"><?php $gtt = $inv['ammount']; echo 'IDR '. number_format($gtt);?></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
						<div class="col-xs-6">
						<?php if($inv['paydate']!=NULL){ ?>
						<img src="images/paidty.png" alt="this invoice is paid">
						<?php } ?>
						</div>  
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <!-- this row will not appear when printing -->
                      <div class="row no-print">
					  
                        <div class="col-xs-12">
						<hr>
                          <button class="btn btn-default" id="printme" onclick="window.print('x_content');"><i class="fa fa-print"></i> Print</button>
                        </div>
                      </div>
                    </section>
                  </div>
                </div>
              
        <!-- /page content -->

        <!-- footer content -->
        
      </div>
    </div>
	</page>

 
  </body>
</html>