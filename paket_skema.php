<?php
    include "database/koneksi.php";
    include "database/check.php";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
 
        $skema = $_POST['skema'];
        $paketname = $_POST['paketname']; 
        $paketdesc = $_POST['paketdesc']; 
        $price1 = $_POST['price1']; 
        $price2 = $_POST['price2']; 
        $price3 = $_POST['price3']; 
        $price4 = $_POST['price4']; 
        $price5 = $_POST['price5']; 
        $price6 = $_POST['price6']; 
		    $price7 = $_POST['price7']; 
		    $price8 = $_POST['price8']; 

        $jmlpaket = mysqli_query($connectdb, "SELECT COUNT(id) as jmlpaket FROM ng_paket");
        $dtjmlpaket  = mysqli_fetch_array($jmlpaket);
        $kd_prod = substr(date("Y"),-2).'1'.$skema.($dtjmlpaket['jmlpaket']+1);
	
    if($skema == 1){
            $ng_paket = mysqli_query($connectdb, "INSERT INTO ng_paket (skema, paket, kd_prod,description, price1, price2, price3) VALUES (\"$skema\" ,\"$paketname\",\"$kd_prod\",\"$paketdesc\",\"$price1\" ,\"$price2\" ,\"$price3\")");
		}else if($skema == 2){
            $ng_paket = mysqli_query($connectdb, "INSERT INTO ng_paket (skema, paket, kd_prod,description, price4) VALUES (\"$skema\" ,\"$paketname\" ,\"$kd_prod\" ,\"$paketdesc\",\"$price4\")");
		}else if($skema == 3){
            $ng_paket = mysqli_query($connectdb, "INSERT INTO ng_paket (skema, paket, kd_prod,description, price5, price6) VALUES (\"$skema\" ,\"$paketname\" ,\"$kd_prod\" ,\"$paketdesc\",\"$price5\" ,\"$price6\")");
		}     
    echo '<script language="javascript">alert("Tambah Paket Sukses !")</script>';
		header ("location:paketlist.php");
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
        }else if($_SESSION['level'] == 1){
          include 'include/sidebar_manager.php';
        }else if($_SESSION['level'] == "" || $_SESSION['level'] == 2 ||
                $_SESSION['level'] == 10 || $_SESSION['level'] == 11){
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
            <h1>Create Paket</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Create Paket</li>
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
                <h3 class="card-title">Form Paket</h3>
              </div>
             <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="#" method=post>
                <div class="card-body">
                  <div class="form-group">
                    <label for="paketname">Paket Name</label>
                    <input type="text" class="form-control" id="paketname" placeholder="Input Paket Name" name="paketname" required>
                  </div>
                  <div class="form-group">
                    <label for="paketdesc">Paket Deskription</label>
                    <textarea type="text" class="form-control" id="paketdesc" placeholder="Input Paket Name" name="paketdesc" required></textarea>
                  </div>                     
                   <div class="form-group">
                    <label for="skema">Skema Harga</label>
                    <div class="col-md-4 col-sm-4">
                      
                      A: <input type="radio" name="skema"  value="1" checked="1" required />
                      B: <input type="radio" name="skema"  value="2" />
                      C: <input type="radio" name="skema" value="3" />
                                            </div>
                                        </div>
                                        
                                        <!-- <div id="log"></div> -->
                    <div class="form-group" id="skema_A" style="display:block;">
                    <label class="control-label col-md-3 col-sm-3" for="skema">Skema Description<span class="required">*</span>
                                        </label>
                                        <div  class="col-md-6 col-sm-6" >
                    <p>Skema harga untuk tipe A, Pelanggan akan dibebankan tarif khusus pada 3 bulan pertama. Setelah itu bulan ke-4 sampai dengan bulan ke-12
                    Pelanggan akan dibebankan tarif dasar. Setelah masuk bulan ke-13 dan seterusnya, pelanggan akan mendapat harga khusus</p>
                                        </div>
                    </div>
                    <div class="form-group" id="skema_A1" style="display:block;">
                    <label class="control-label col-md-3 col-sm-3" for="skema">Harga<span class="required">*</span>
                                        </label>
                    <div  class="col-md-4 col-sm-4" >
                    <table border=0>
                    <tr>
                    <td class="col-md-5 col-sm-5">
                    <label  for="price1">Bulan 1-3
                                        </label></td>
                    <td><span >:</span></td>
                    <td class="col-md-6 col-sm-6">
                    <input type="text" id="price1" name="price1" placeholder="500000" >
                    </td>
                    <tr>
                    <td class="col-md-5 col-sm-5">
                    <label for="price2" >Bulan 4-12
                                        </label></td>
                    <td><span >:</span></td>
                    <td class="col-md-6 col-sm-6">
                    <input type="text" id="price2" name="price2" placeholder="300000" >
                    </td>
                    <tr>
                    <td class="col-md-5 col-sm-5">
                    <label  for="price3">Bulan 13-dst
                                        </label></td>
                    <td><span >:</span></td>
                    <td class="col-md-6 col-sm-6">
                    <input type="text" id="price3" name="price3" placeholder="250000" >
                    </td>
                    </tr>
                    </table>
                    </div>
                    </div>
                    
                                        <div id="skema_B" class="form-group" style="display:none;">         
                    <label class="control-label col-md-3 col-sm-3" for="skema">Skema Description<span class="required">*</span>
                    </label>
                    <div  class="col-md-6 col-sm-6" >
                    <p>Skema harga untuk tipe B, Pelanggan dibebankan tarif flat selama berlangganan</p>
                    </div>
                    </div>
                                        <div class="form-group" id="skema_B1" style="display:none;">
                                        <label class="control-label col-md-3 col-sm-3" for="price4">Harga <span class="required">*</span>
                                        </label>
                                        <div  class="col-md-4 col-sm-4" >
                    <table border=0>
                    <tr>
                    <td class="col-md-5 col-sm-5">
                    <label  for="price4">Bulanan
                                        </label></td>
                    <td><span >:</span></td>
                    <td class="col-md-6 col-sm-6">
                    <input type="text" id="price4" name="price4" placeholder="500000" >
                    </td>
                    </tr>
                    </table>
                    </div>
                                        </div>
                                            
                    <div class="form-group" id="skema_C" style="display:none;">
                    <label class="control-label col-md-3 col-sm-3" for="skema">Skema Description<span class="required">*</span>
                                        </label>
                                        <div  class="col-md-4 col-sm-4" >
                    <p>Skema harga untuk tipe C, Pelanggan akan dibebankan tarif khusus selama 1 tahun. Setelah masuk bulan ke-13 dan seterusnya, pelanggan akan mendapat harga normal</p>
                                        </div>
                    </div>
                    <div class="form-group" id="skema_C1" style="display:none;">
                    <label class="control-label col-md-3 col-sm-3" for="skema">Harga<span class="required">*</span>
                                        </label>
                    <div  class="col-md-4 col-sm-4" >
                    <table border=0>
                    <tr>
                    <td class="col-md-5 col-sm-5">
                    <label  for="price1">Bulan 1-12
                                        </label></td>
                    <td><span >:</span></td>
                    <td class="col-md-6 col-sm-6">
                    <input type="text" id="price5" name="price5" placeholder="500000" >
                    </td>
                    </tr>
                    <tr>
                    <td class="col-md-5 col-sm-5">
                    <label  for="price3">Bulan 13-dst
                                        </label></td>
                    <td><span >:</span></td>
                    <td class="col-md-6 col-sm-6">
                    <input type="text" id="price6" name="price6" placeholder="250000" >
                    </td>
                    </tr>
                    </table>
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
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
    
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
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
    <script type="text/javascript">
    
    var skemaA = document.getElementById('skema_A');
    var skemaA1 = document.getElementById('skema_A1');
    var skemaB = document.getElementById('skema_B');
    var skemaB1 = document.getElementById('skema_B1');
    var skemaC = document.getElementById('skema_C');
    var skemaC1 = document.getElementById('skema_C1');

	$( "input:radio[name=skema]" ).click(function() {
	var skemais = $("input[name=skema]:checked").val();

	if( skemais == 1){
                skemaA.style.visibility='visible';
                skemaA1.style.visibility='visible';
                skemaA.style.display ='block';
                skemaA1.style.display ='block';
                skemaB.style.visibility='hidden';
                skemaB1.style.visibility='hidden';
                skemaB.style.display ='none';
                skemaB1.style.display ='none';
                skemaC.style.visibility='hidden';
                skemaC1.style.visibility='hidden';
                skemaC.style.display ='none';
                skemaC1.style.display ='none';
    }else if(skemais == 2){
            skemaA.style.visibility='hidden';
            skemaA1.style.visibility='hidden';
            skemaA.style.display ='none';
            skemaA1.style.display ='none';
            skemaB.style.visibility='visible';
            skemaB1.style.visibility='visible';
            skemaB.style.display ='block';
            skemaB1.style.display ='block';
            skemaC.style.visibility='hidden';
            skemaC1.style.visibility='hidden';
            skemaC.style.display ='none';
            skemaC1.style.display ='none';
    }else if(skemais == 3){
            skemaA.style.visibility='hidden';
            skemaA1.style.visibility='hidden';
            skemaA.style.display ='none';
            skemaA1.style.display ='none';
            skemaB.style.visibility='hidden';
            skemaB1.style.visibility='hidden';
            skemaB.style.display ='none';
            skemaB1.style.display ='none';
            skemaC.style.visibility='visible';
            skemaC1.style.visibility='visible';
            skemaC.style.display ='block';
            skemaC1.style.display ='block';
    }else{
            skemaA.style.display ='none';
            skemaA1.style.display ='none';
            skemaB.style.display ='none';
            skemaB1.style.display ='none';
            skemaC.style.display ='none';
            skemaC1.style.display ='none';
    }
	});



</script>
</body>
</html>