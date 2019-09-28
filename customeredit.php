<?php
include "database/koneksi.php";
include "database/check.php";

if (isset($_GET['id'])) {
    
    $userid = $_SESSION['userid'];
    $customerid = $_GET['id'];

    $user = mysqli_query($connectdb, "SELECT ng_customer.firstname, 
                                            ng_customer.lastname, 
                                            ng_customer.alamat, 
                                            ng_customer.node AS nodeid, 
                                            ng_customer.paket AS paketid, 
                                            ng_customer.email, 
                                            ng_customer.no_telp, 
                                            ng_customer.identitas, 
                                            ng_customer.foto, 
                                            ng_kota.kota, 
                                            ng_node.node
                                        FROM ng_customer 
                                        INNER JOIN ng_kota ON ng_kota.id = ng_customer.kota
                                        INNER JOIN ng_node ON ng_node.nodeid = ng_customer.node
                                        WHERE ng_customer.id =\"$customerid\"");
    $data = mysqli_fetch_assoc($user);

    $ng_paket = mysqli_query($connectdb, "SELECT ng_paket.id, 
                                                ng_paket.paket 
                                          FROM ng_paket,ng_childpool,ng_node,ng_pool 
                                          WHERE ng_node.nodeid=ng_pool.nodeid AND 
                                                  ng_childpool.poolid=ng_pool.id AND 
                                                  ng_childpool.kd_prod=ng_paket.kd_prod AND 
                                                  ng_node.nodeid= ".$data['nodeid']." GROUP BY ng_paket.paket");
    
  } else {
    header("location:userlist.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | General Form Elements</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

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
            <h1>Manager Registration</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Manager Registration</li>
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
              <form role="form" action="#" method=post enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputFirstName">First Name</label>
                    <input type="text" class="form-control" id="inputFirstName" placeholder="Input First Name" name="firstname" vaLue="<?php echo $data['firstname']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="inputLastname">Last Name</label>
                    <input type="text" class="form-control" id="inputLastname" placeholder="Input Last Name" name="lastname" vaLue="<?php echo $data['lastname']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="inputKota">Kota</label>
                    <input type="text" class="form-control" id="inputKota" placeholder="Input Kota" name="kota" vaLue="<?php echo $data['kota']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="inputNode">Node</label>
                    <input type="text" class="form-control" id="inputNode" placeholder="Input Node" name="node" vaLue="<?php echo $data['node']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label>Paket</label>
                    <input type="hidden" class="form-control" id="oldpaket" name="oldpaket" vaLue="<?php echo $data['paketid']; ?>" readonly>
                    <select id="paket" class="form-control" name="paket">
                      <option value=''>Pilih</option>
                      <?php 
                        while ($dtpaket = mysqli_fetch_array($ng_paket)){
                      ?>
                        <option value="<?php echo $dtpaket['id']; ?>" <?php if($dtpaket['id'] == $data['paketid']) echo 'selected = "selected"'; ?>><?php echo $dtpaket['paket']; ?>
                        </option>
                      <?php 
                        }
                      ?>  
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="inputAddress">Alamat</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="Input Address" name="alamat" vaLue="<?php echo $data['alamat']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="inputEmail">E-mail</label>
                    <input id="oldemail" name="oldemail" type="hidden"  vaLue="<?php echo $data['email']; ?>">
                    <input type="email" class="form-control" id="inputEmail" placeholder="Input E-mail" name="email" vaLue="<?php echo $data['email']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="inputNoTelp">No. Telp</label>
                    <input type="tel" class="form-control" id="inputNoTelp" placeholder="Input Telephone Number" name="no_telp" vaLue="<?php echo $data['no_telp']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="inputIdentitas">No. Identitas</label>
                    <input id="oldidentitas" name="oldidentitas" type="hidden"  vaLue="<?php echo $data['identitas']; ?>">
                    <input type="number" class="form-control" id="inputNoTelp" placeholder="Input ID Number KTP/SIM/Pasport" name="identitas" vaLue="<?php echo $data['identitas']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="inputFile">Upload KTP/SIM/Pasport</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputFile" name="image-file">
                        <input id="image-old" type="hidden" name="image-old" value="<?php echo $data['foto'] ; ?>">
                        <label class="custom-file-label" for="inputFile">Choose file</label>
                      </div>
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
<!-- Bootstrap -->
<script src="./js/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="./js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="./js/demo.js"></script>
</body>
</html>

<?php

   if($_SERVER["REQUEST_METHOD"] == "POST") {
 
          $firstname= $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $oldpaket = $_POST['oldpaket'];
            $paket = $_POST['paket'];
            $oldemail = $_POST['oldemail'];
          $email = $_POST['email'];
          $no_telp = $_POST['no_telp'];
            $alamat = $_POST['alamat'];
            $oldidentitas = $_POST['oldidentitas'];
            $identitas = $_POST['identitas'];
            $old_photo = $_POST['image-old'];
            $extension = explode("/", $_FILES["image-file"]["type"]);
            $name_photo = $identitas.".".$extension[1];   
            $temp_photo = $_FILES['image-file']['tmp_name'];
            $size_photo = $_FILES['image-file']['size'];
            $type_photo = $_FILES['image-file']['type'];
            $path = "foto/$name_photo";
            $oldpath = "foto/$old_photo";


    //random childpool
    $netaddress = 24;
    $ng_childpool = mysqli_query($connectdb, "SELECT ng_childpool.id, ng_childpool.start_address, ng_childpool.end_address FROM ng_childpool, ng_paket where ng_childpool.kd_prod=ng_paket.kd_prod and ng_paket.id='".$paket."'");
    $ng_usedpoolcheck = mysqli_query($connectdb, "SELECT address FROM ng_usedpool");
    $getusedpool = mysqli_fetch_assoc($ng_usedpoolcheck );
    $dtusedpool = array();
    array_push($dtusedpool,$getusedpool['address']);
    
    function cidr2NetmaskAddr($cidr) {
           $ta = substr($cidr, strpos($cidr, '/') + 1) * 1;
                   $netmask = str_split(str_pad(str_pad('', $ta, '1'), 32, '0'), 8);
                   foreach ($netmask as &$element) $element = bindec($element);
                      return join('.', $netmask);
    }

    $data = array();
    while ($dtchildpool = mysqli_fetch_assoc($ng_childpool)){
    
          $poolid = $dtchildpool['id'];
          $start_address = $dtchildpool['start_address'];
          $end_address = $dtchildpool['end_address'];
          $start = substr($start_address, strrpos($start_address, '.') + 1);
          $end = substr($end_address, strrpos($end_address, '.') + 1);
    
          $mask = cidr2NetmaskAddr($start_address.'/'.$netaddress);

          $ips = ip2long($start_address);
          $addressmask = ip2long($mask);
          $ipa = ((~$addressmask) & $ips) ;
          $network = long2ip(($ips ^ $ipa)).'/'.$netaddress;

          $index = 0;
          for ($i = $start ; $i <= $end; $i++) {
              $ipaddr = long2ip(($ips ^ $ipa) + $i);
              if(array_search($ipaddr, $dtusedpool) != true){
                     array_push($data, array(
                                       'poolid'=>$poolid, 
                                       'address'=>$ipaddr,
                           ));
                        $index++;
                          }
               }  
         }
        $randomArray = array_rand($data); 
    $randpooid = $data[$randomArray]['poolid'];
        $randaddress = $data[$randomArray]['address'];
    //end random childpool

    //verifikasi Email
    function verifikasiEmail($firstname,$lastname,$username,$email){
    
    require_once('PHPMailer/class.phpmailer.php'); //menginclude librari phpmailer

    $encryp_username  = base64_encode($username);
    $mail             = new PHPMailer();
    $body             = 
            "<body style='margin: 10px;'>
                  <div style='width: 640px; font-family: Helvetica, sans-serif; font-size: 13px; padding:10px; line-height:150%; border:#eaeaea solid 10px;'>
                    <br>
                    <strong>Terima Kasih Telah Mendaftar</strong><br>
                    <b>Nama Anda : </b>".$firstname." ".$lastname."<br>
                    <b>Email : </b>".$email."<br>
                    <b>URL Konfirmasi : </b>http://10.10.10.222/ng4dm1n/production/confirmemail.php?username=".$encryp_username."<br>
                    <br>
                  </div>
            </body>";
    $body             = eregi_replace("[\]",'',$body);
    $mail->IsSMTP();  // menggunakan SMTP
    $mail->SMTPDebug  = 1;   // mengaktifkan debug SMTP
    $mail->SMTPSecure = 'tls'; 
    $mail->SMTPAuth   = true;   // mengaktifkan Autentifikasi SMTP
    $mail->Host   = 'smtp.gmail.com'; // host sesuaikan dengan hosting mail anda
    $mail->Port       = 587;  // post gunakan port 25
    $mail->Username   = ""; // username email akun
    $mail->Password   = "";        // password akun

    $mail->SetFrom('', 'Hello imax');


    $mail->Subject    = "Aktivasi Email User";
    $mail->MsgHTML($body);

    $address = $email; //email tujuan
    $mail->AddAddress($address, "Hello (Reciever name)");
    $mail->Send();
    }
    //end verifikasi Email


        if($oldidentitas != $identitas){
          $ng_customercheck = mysqli_query($connectdb, "SELECT identitas FROM ng_customer WHERE identitas =\"$identitas\"");
        }

        if($oldemail != $email){
            $ng_emailcheck = mysqli_query($connectdb, "SELECT email FROM ng_customer WHERE email =\"$email\"");
        }

        if(mysqli_fetch_row($ng_customercheck) == NULL ){
        if(mysqli_fetch_row($ng_emailcheck ) == NULL ){
            if (!empty($_FILES['image-file']['name'])) {
                    if($type_photo == "image/jpg" || $type_photo == "image/png" || $type_photo == "image/jpeg"){
                        if($size_photo <= 10000000){
                        
                            unlink($oldpath);
                            move_uploaded_file($temp_photo,$path);

                            $ng_customer = mysqli_query($connectdb, "UPDATE ng_customer 
                                                                        SET firstname = \"$firstname\", 
                                                                            lastname = \"$lastname\", 
                                                                            paket = \"$paket\", 
                                                                            alamat = \"$alamat\", 
                                                                            email = \"$email\", 
                                                                            no_telp = \"$no_telp\", 
                                                                            identitas = \"$identitas\", 
                                                                            foto = \"$name_photo\" 
                                                                        WHERE id = \"$customerid\"") ; 
                        
                        }else{ //jika ukuran gambar lebih dari 10 mb
                            echo '<script language="javascript">alert("Ukuran foto tidak boleh lebih dari 10 mb")</script>';
                        }
                    }else{ //jika tipe gambar bukan jpg atau png
                        echo '<script language="javascript">alert("Tipe gambar yang diupload harus JPG atau PNG.")</script>';
                    }
                }else{ 
                    $ng_customer = mysqli_query($connectdb, "UPDATE ng_customer 
                                                                SET firstname = \"$firstname\", 
                                                                    lastname = \"$lastname\", 
                                                                    paket = \"$paket\", 
                                                                    alamat = \"$alamat\", 
                                                                    email = \"$email\", 
                                                                    no_telp = \"$no_telp\", 
                                                                    identitas = \"$identitas\"
                                                                WHERE id = \"$customerid\"") ; 
                }
           
                if($oldpaket != $paket){
                    $radreply = mysqli_query($connectdb, "UPDATE radreply 
                                                            INNER JOIN ng_customer ON ng_customer.username = radreply.username 
                                                            SET value = \"$randaddress\"
                                                            WHERE ng_customer.id = \"$customerid\"");
                    
                    $usedpoolold = mysqli_query($connectdb, "SELECT ng_usedpool.poolid, ng_childpool.available FROM ng_usedpool 
                                                            INNER JOIN ng_customer ON ng_customer.username = ng_usedpool.username
                                                            INNER JOIN ng_childpool ON ng_childpool.id = ng_usedpool.poolid
                                                            WHERE ng_customer.id = \"$customerid\"");

                    $getusedpoolold = mysqli_fetch_assoc($usedpoolold);

                    $update_availableold = mysqli_query($connectdb, "UPDATE ng_childpool SET available = ".$getusedpoolold['available']." + 1 WHERE id = ".$getusedpoolold['poolid']."");

                    $available_childpool = mysqli_query($connectdb, "SELECT available FROM ng_childpool WHERE id =\"$randpooid\"");

                    $getavailable = mysqli_fetch_assoc($available_childpool);
                
                    $update_available = mysqli_query($connectdb, "UPDATE ng_childpool SET available = ".$getavailable['available']." - 1 WHERE id = \"$randpooid\"");

                    $ng_usedpool = mysqli_query($connectdb, "UPDATE ng_usedpool 
                                                                INNER JOIN ng_customer ON ng_customer.username = ng_usedpool.username 
                                                                SET poolid = \"$randpooid\",
                                                                    address = \"$randaddress\"
                                                                WHERE ng_customer.id = \"$customerid\"");
                }
                
                if($oldemail != $email){
                    verifikasiEmail($firstname,$lastname,$username,$email);
                }

        }else{ //jika data email sudah ada
            echo '<script language="javascript">alert("Email COBa'. $email.' is registered")</script>';
          }
    }else{ //jika data user sudah ada
            echo '<script language="javascript">alert("User '. $firstname.' '. $lastname .' is registered")</script>';
        }

        echo("<meta http-equiv='refresh' content='1'>"); //Refresh by HTTP META 
   }
  ?>