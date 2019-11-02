<?php
include "database/koneksi.php";
include "database/check.php";

$vendorlist = mysqli_query($connectdb, "SELECT id, vendor FROM ng_vendor");
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
            <h1>Create Internal Memo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Create Internal Memo</li>
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
                <h3 class="card-title">Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal form-label-left" action="#" method="post" novalidate>
                <div class="item form-group">
                  <label class="control-label col-md-1 col-sm-3 col-xs-12" for="vendor">Vendor <span class="required">*</span>
                  </label>
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <select id="vendor" type="option" class="form-control col-md-7 col-xs-12" name="vendor" required>
                      <option value=''>Pilih</option>
                        <?php 
                          while($dtvendor = mysqli_fetch_array($vendorlist)){
                            echo "<option value=".$dtvendor['id'].">".$dtvendor['vendor']."</option>";
                          }
                        ?>   
                    </select>
                  </div>
                </div>
                <div id="insert-form">
                                            <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                    <th>Type</th>
                                                    <th>Merk</th>
                                                    <th>Price</th>
                                                    <th>Qty</th>
                                                    <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="xx_t">
                        
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                    <td><button type="button" id="btn-tambah-form" class="btn btn-info btn-xs"> +add</button></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td><input type="text" size="8" class="grdtot" id="grandtt" value="" name="" readonly/></input></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="form-group">                                           
                                            <button id="send" type="submit" class="btn btn-success">Submit</button>  
                                        </div>
                                    </form>
                                    <input type="hidden" id="jumlah-form" value="0">
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
<!-- Bootstrap -->
<script src="./js/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="./js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="./js/demo.js"></script>

<!-- Memanggil Autocomplete.js -->
<script src="js/jquery.autocomplete.min.js"></script>
  <script>
        $(document).ready(function(){
            var dtvendor = document.getElementById('vendor');
            var tot = 0;
      $('table tbody tr').remove();
      $('.dataTables_length').remove();
      $('.dataTables_filter').remove();
      $('.dataTables_paginate').remove();
      $('.dataTables_info').remove();
            $("#btn-tambah-form").click(function(){ 
                if (dtvendor.value !== '') {
                    var jumlah = parseInt($("#jumlah-form").val()); 
                    var nextform = jumlah + 1; 
                    var inside = 
                        "<tr id='row"+nextform+"'>" +
                        "<td><input type='hidden' id='equipmasterid"+nextform+"' name='inputs["+nextform+"][equipmasterid]' value=''><input type='text' id='type"+nextform+"' name='type' placeholder='Nama Type' value=''></td>" +
                        "<td><input type='text' id='merk"+nextform+"' name='merk' placeholder='Nama Merk' value='' readonly></td>" +
                        "<td><input type='text' id='price"+nextform+"' name='inputs["+nextform+"][price]' class='prc'  value='0'></td>" +
                        "<td><input type='text' size='3' id='qty"+nextform+"' name='inputs["+nextform+"][qty]' class='qty'  value='0'></td>" +
                        "<td><input type='text' id='sub_total"+nextform+"' name='sub_total' class='subtot'  placeholder='Sub Total' value='0' readonly><button style='margin-left:15px;' type='button' class='btn btn-danger btn-xs' id='btnremove"+nextform+"'>delete</button></td>"
                        "</tr>"
                    $("table tbody").append(inside);
                    $( "#type"+nextform ).autocomplete({
                            serviceUrl: "autocomplete_typebarang.php?vendor=" + dtvendor.value +"&",    
                            dataType: "JSON",           
                            onSelect: function (suggestion) {
                                $( "#equipmasterid"+nextform ).val("" + suggestion.equipmasterid);
                                $( "#type"+nextform ).val("" + suggestion.type);
                                $( "#merk"+nextform ).val("" + suggestion.merk);
                                $( "#price"+nextform).val("" + suggestion.price);
                            }
                        });
                    $("#btnremove"+nextform).click(function(){
                        var subtotal = document.getElementById('sub_total'+nextform).value;
                        var total = document.getElementById('grandtt').value;
                        updatetotal = total - subtotal;
                        
                        $('.grdtot').val(updatetotal.toFixed(0));
                        $('#row'+nextform).remove();
                    });
                    var $tblrows = $("#datatable-fixed-header tbody tr");
                    $tblrows.each(function (index) {
                    var $tblrow = $(this);
                    $(document).on('keyup', '#qty'+nextform, function() {
                        var qtx = $tblrow.find('.qty').val();
                        var prx =  $tblrow.find('.prc').val();
                        var subTotal = parseInt(qtx,10) * parseFloat(prx);
                        if (!isNaN(subTotal)) {
                        $tblrow.find('.subtot').val(subTotal.toFixed(0));
                            var grandTotal = 0;
                            $(".subtot").each(function () {
                            var stval = parseFloat($(this).val());
                                grandTotal += isNaN(stval) ? 0 : stval;
                            });
                            $('.grdtot').val(grandTotal.toFixed(0));
                        } 
                    });
          $(document).on('keyup', '#price'+nextform, function() {
                        var qtx = $tblrow.find('.qty').val();
                        var prx =  $tblrow.find('.prc').val();
                        var subTotal = parseInt(qtx,10) * parseFloat(prx);
                        if (!isNaN(subTotal)) {
                        $tblrow.find('.subtot').val(subTotal.toFixed(0));
                            var grandTotal = 0;
                            $(".subtot").each(function () {
                            var stval = parseFloat($(this).val());
                                grandTotal += isNaN(stval) ? 0 : stval;
                            });
                            $('.grdtot').val(grandTotal.toFixed(0));
                        } 
                    });
                });    
                    $("#jumlah-form").val(nextform); 
                }else{
                    alert("Vendor tidak boleh kosong!")
                }
            });

        });
        </script>

</body>
</html> 
        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST") {
        
                $jmlmemo = mysqli_query($connectdb, "SELECT SUM(DISTINCT memoid) AS jmlmemo FROM ng_internalmemo GROUP BY memoid ORDER BY memoid DESC LIMIT 1");
                $dtjmlmemo = mysqli_fetch_array($jmlmemo);
                $dtbarang = $_POST['inputs'];
                $purchasingid = $_SESSION['userid'];
                $date = date("Y-m-d");
                $memoid = ($dtjmlmemo['jmlmemo']+1).'/IM/'.date('m').'/'.date('Y');
            foreach ($dtbarang as $dt){
                    $equipmasterid = $dt['equipmasterid'];
                    $price = $dt['price'];
                    $quantity = $dt['qty'];
                    $ng_internalmemo = mysqli_query($connectdb, "INSERT INTO ng_internalmemo (memoid,equipmasterid, price, quantity, purchasingid, date, status) VALUES (\"$memoid\",\"$equipmasterid\", \"$price\", \"$quantity\", \"$purchasingid\", \"$date\", \"0\")");
                }

                echo("<meta http-equiv='refresh' content='1'>"); //Refresh by HTTP META 
            }
            ?>