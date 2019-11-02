<?php
include "database/koneksi.php";
include "database/check.php";


$userid = $_SESSION['userid'];
$n=10; 
function rdpass($n) { 
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $randomString = ''; 
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
  
    return $randomString; 
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
            <h1>Create Sub Manager</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Create Sub Manager</li>
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
                <h3 class="card-title">Form Sub Manager</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="#" method=post enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputUsername">Username</label>
                    <input type="text" class="form-control" id="inputUsername"placeholder="Input Username" name="username" required>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail">E-mail</label>
                    <input type="email" class="form-control" id="inputEmail" placeholder="Input E-mail" name="email" required>
                  </div>
                  <div class="form-group">
                    <label for="inputFile">Foto</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputFile" name="image-file" required>
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

    $username = $_POST['username'];
    $password = rdpass($n);
    $email = $_POST['email'];
    $extension = explode("/", $_FILES["image-file"]["type"]);
    $name_photo = $username.".".$extension[1];    
    $temp_photo = $_FILES['image-file']['tmp_name'];
    $size_photo = $_FILES['image-file']['size'];
    $type_photo = $_FILES['image-file']['type'];
    $path = "foto/$name_photo";

    
    $ng_submanagercheck = mysqli_query($connectdb, "SELECT username, 
                                                            email 
                                                    FROM ng_submanager 
                                                    WHERE username =\"$username\" OR email =\"$email\"");

    if(mysqli_fetch_row($ng_submanagercheck) == NULL ){
       if (!empty($_FILES['image-file']['name'])) {
              if($type_photo == "image/jpg" || $type_photo == "image/png" || $type_photo == "image/jpeg"){
                            if($size_photo <= 10000000){
                                if(move_uploaded_file($temp_photo,$path)){

                      $ng_submanager = mysqli_query($connectdb, "INSERT INTO ng_submanager (username,password,email,foto, userid) VALUES (\"$username\" ,\"$password\", \"$email\", \"$name_photo\", \"$userid\")");
                
                $ng_submanagercheckid = mysqli_query($connectdb, "SELECT id FROM ng_submanager WHERE username=\"$username\" AND password=\"$password\" AND email=\"$email\"");

                $getid = mysqli_fetch_assoc($ng_submanagercheckid);
                $id = $getid['id'];

                            $ng_userlogin = mysqli_query($connectdb, "INSERT INTO ng_userlogin (username,password,userid,level) VALUES (\"$username\" ,\"$password\", \"$id\", \"2\")");
                
                            verifikasiEmail($username,$password,$email);

                }else{ //jika gambar gagal diupload
                           echo '<script language="javascript">alert("Foto gagal diupload")</script>';
                      }
              }else{ //jika ukuran gambar lebih dari 10 mb
                       echo '<script language="javascript">alert("Ukuran foto tidak boleh lebih dari 10 mb")</script>';
                }
           }else{ //jika tipe gambar bukan jpg atau png
                    echo '<script language="javascript">alert("Tipe gambar yang diupload harus JPG atau PNG.")</script>';
           }
       }else{ //jika belum upload gambAr
              echo '<script language="javascript">alert("Please upload your photo profile")</script>';
       }
    }else{ //jika data user sudah ada
            echo '<script language="javascript">alert("User is registered")</script>';
          }
  
        }
  //verifikasi Email
      function verifikasiEmail($username,$password,$email){
      
        require_once('PHPMailer/class.phpmailer.php'); //menginclude librari phpmailer
    
        $encryp_username  = base64_encode($username);
        $mail             = new PHPMailer();
        $body             = 
                "<body style='margin: 10px;'>
                      <div style='width: 640px; font-family: Helvetica, sans-serif; font-size: 13px; padding:10px; line-height:150%; border:#eaeaea solid 10px;'>
                        <br>
                        <strong>Terima Kasih Telah Mendaftar</strong><br>
                        <b>Username : </b>".$username."<br>
                        <b>Password : </b>".$password."<br>
                        <b>URL Konfirmasi : </b>http://10.10.10.222/ng4dm1n/production/login<br>
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
  ?>