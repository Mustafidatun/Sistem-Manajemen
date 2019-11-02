<?php
include "database/koneksi.php";
include "database/check.php";

$memoid = $_GET['memoid'];

$vendorlist = mysqli_query($connectdb, "SELECT ng_vendor.*
                                        FROM ng_vendor 
                                        INNER JOIN ng_equipmaster ON ng_equipmaster.vendorid = ng_vendor.id
                                        INNER JOIN ng_internalmemo ON ng_internalmemo.equipmasterid = ng_equipmaster.id
                                        WHERE ng_internalmemo.memoid = \"$memoid\" lIMIT 1");
$dtvendor = mysqli_fetch_assoc($vendorlist); 

$internalmemolist = mysqli_query($connectdb, "SELECT ng_internalmemo.quantity, 
                                                    ng_equipmaster.vol,
                                                    CONCAT(ng_equipmaster.type, ' - ', ng_equipmaster.merk) AS item, 
                                                    FORMAT(SUM(ng_internalmemo.price), 0) AS itemprice, 
                                                    (ng_internalmemo.price*ng_internalmemo.quantity) AS total
                                            FROM ng_internalmemo 
                                            INNER JOIN ng_equipmaster ON ng_equipmaster.id = ng_internalmemo.equipmasterid
                                            WHERE ng_internalmemo.memoid = \"$memoid\" AND
                                            ng_internalmemo.status = 2");

$user = mysqli_query($connectdb, "SELECT ng_userlogin.username AS usersupermanager, ng_managerpurchase.username AS userpurchasing, ng_managerfinance.username AS userfinance FROM ng_internalmemo
                                  INNER JOIN ng_userlogin ON ng_userlogin.id = ng_internalmemo.userid
                                  INNER JOIN ng_user ng_managerpurchase ON ng_managerpurchase.id = ng_internalmemo.purchasingid
                                  INNER JOIN ng_user ng_managerfinance ON ng_managerfinance.id = ng_internalmemo.financeid
                                  WHERE ng_internalmemo.memoid = \"$memoid\" AND
                                        ng_internalmemo.status = 2");
$dtuser = mysqli_fetch_assoc($user); 

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
                      <h1>Purchase Order</h1>
                  </div>
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                  <div class="col-sm-6 invoice-col">
                    <address>
                      Vendor 
                        <br><b>Name : </b> <?php echo $dtvendor['vendor']; ?>
                        <br><b>Attn : </b> 
                        <br><b>Address : </b> <?php echo $dtvendor['alamat']; ?>
                        <br><b>Telp : </b> <?php echo $dtvendor['no_telp']; ?>
                    </address>
                  </div>
                  <div class="col-sm-6 invoice-col">
                    <address>
                      Ship To
                         <br><b>Name : </b> PT Bentang Selaras Teknologi
                        <br><b>Attn : Nisa / 0812 3500 9122</b> 
                        <br><b>Address : </b> Ruko Sukarno Hatta Indah Blok E8, Lowokwaru Malang - Jawa Timur
                        <br><b>Telp : </b> 0341 - 404286
                    </address>
                  </div>
                </div>
                  <!-- /info row -->

                  <!-- Table row -->
                      <div class="row">
                        <div class="col-sm-12 table">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th>Qty</th>
                                <th>Vol</th>
                                <th style="width: 59%">Item</th>
                                <th>Item Price</th>
                                <th>Total</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                                $total = 0;
                                $subtotal = 0;
                                while ($dtinternalmemo = mysqli_fetch_assoc($internalmemolist)){
                                $total += $dtinternalmemo['total'];
                            ?>
                              <tr>
                                <td><?php echo $dtinternalmemo['quantity']; ?></td>
                                <td><?php echo $dtinternalmemo['vol']; ?></td>
                                <td><?php echo $dtinternalmemo['item']; ?></td>
                                <td align="right"><?php echo $dtinternalmemo['itemprice']; ?></td>
                                <td align="right"><?php echo number_format($dtinternalmemo['total']); ?></td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                        <!-- /.col -->
                      </div>
                    <!-- /table row -->

                    <div class="row invoice-info">
                      <div class="col-sm-8 invoice-col">
                          <p class="lead">Payment Methods:</p>
                            <div class="row invoice-info">
                              <div class="col-sm-3 invoice-col">
                                  <div class="radio">
                                      <label>
                                      <input type="radio" name="iCheck"> Cash
                                      </label>
                                  </div>
                                  <div class="radio">
                                      <label>
                                      <input type="radio" checked name="iCheck"> Transfer
                                      </label>
                                  </div>
                                  <div class="radio">
                                      <label>
                                      <input type="radio" name="iCheck"> Check
                                      </label>
                                  </div>
                              </div>
                              <div class="col-sm-3 invoice-col">
                                  <div class="radio">
                                      <label>
                                      <input type="radio" checked name="iCheck2"> IDR
                                      </label>
                                  </div>
                                  <div class="radio">
                                      <label>
                                      <input type="radio" name="iCheck2"> USD
                                      </label>
                                  </div>
                              </div>
                              <div class="col-sm-3 invoice-col">
                                  <div class="radio">
                                      <label>
                                      <input type="radio" name="iCheck3"> Full
                                      </label>
                                  </div>
                                  <div class="radio">
                                      <label>
                                      <input type="radio" checked name="iCheck3"> Term
                                      </label>
                                  </div>
                              </div>
                          </div>
                      </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                          <p class="lead">Amount Total</p>
                          <div class="table-responsive">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <th>Total:</th>
                                  <td style="text-align: right; font-size: large; color: red;"><?php echo number_format($total); ?></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <div class="row invoice-info">
                        <div class="col-sm-8">
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th style="text-align: center; width:30%;">Purchasing</th>
                                <th style="text-align: center; width:30%;">Project Manager</th>
                                <th style="text-align: center; width:30%;">Finance Manager</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td style="text-align: center; vertical-align: bottom; height: 100;"><?php echo $dtuser['userpurchasing']; ?></td>
                                <td style="text-align: center; vertical-align: bottom; height: 100;"><?php echo $dtuser['usersupermanager']; ?></td>
                                <td style="text-align: center; vertical-align: bottom; height: 100;"><?php echo $dtuser['userfinance']; ?></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <!-- /.row -->
                      
                      <hr>

                      <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-sm-8">
                            Notes/Remark
                            <textarea class="resizable_textarea form-control" name="notes" style="height: 120;"></textarea>
                         
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            Received By
                            <textarea class="resizable_textarea form-control" name="received_by" style="height: 120;"></textarea>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- this row will not appear when printing -->
                      <?php if($_SESSION['level'] == 11){ ?>
                      <div class="row no-print">
                        <div class="col-xs-12">
                          <hr>
                          <button class="btn btn-default" id="printme" onclick="window.print('x_content');"><i class="fa fa-print"></i> Print</button>
                        </div>
                      </div>
                      <?php }?>
                    </section>
                  </div>
                </div>