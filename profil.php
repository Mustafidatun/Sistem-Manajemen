<?php
include "database/koneksi.php";
include "database/check.php";

$userloginid = $_SESSION['userloginid'];
$userid = $_SESSION['userid'];

if($_SESSION['level'] == 1 || $_SESSION['level'] == 10 || $_SESSION['level'] == 11){
    $user = mysqli_query($connectdb, "SELECT ng_user.* 
                                      FROM ng_user
                                      INNER JOIN ng_userlogin ON ng_userlogin.userid = ng_user.id
                                      WHERE ng_userlogin.id = \"$userloginid\" AND ng_user.id = \"$userid\"");
}else if($_SESSION['level'] == 2){ 
    $user = mysqli_query($connectdb, "SELECT ng_submanager.* 
                                      FROM ng_submanager
                                      INNER JOIN ng_userlogin ON ng_userlogin.userid = ng_submanager.id
                                      WHERE ng_userlogin.id = \"$userloginid\" AND ng_submanager.id = \"$userid\"");
}
$dtuser = mysqli_fetch_assoc($user);
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
            <h1>Profil</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Profil</li>
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
                <h3 class="card-title">Form Profil</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="#" method=post enctype="multipart/form-data">
                <input id="id" name="id" type="hidden" value="<?php echo $dtuser['id']; ?>">
                <input id="image-old" type="hidden" name="image-old" value="<?php echo $dtuser['foto'] ; ?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputUsername">Username</label>
                    <input type="text" class="form-control" id="inputUsername" placeholder="Input Username" name="username" value="<?php echo $dtuser['username']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail">Email Address</label>
                    <input type="email" class="form-control" id="inputEmail" placeholder="Input email" name="email" value="<?php echo $dtuser['email']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="inputOldPassword">Old Password</label>
                    <input type="password" class="form-control" id="inputOldPassword" placeholder="Input Old Password" name="oldpassword" required>
                  </div>
                  <div class="form-group">
                    <label for="inputNewPassword">New Password</label>
                    <input type="password" class="form-control" id="inputNewPassword" placeholder="Input New Password" name="newpassword" required>
                  </div>
                  <div class="form-group">
                    <label for="inputNewPassword2">Repeat Password</label>
                    <input type="password" class="form-control" id="inputNewPassword2" placeholder="Input Repeat Password" name="newpassword2" data-validate-linked="newpassword" required>
                  </div>
                  <div class="form-group">
                    <label for="inputFile">Upload Foto Profil</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputFile" name="image-file">
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
<!-- jQuery -->
    <script type="text/javascript">
  $(document).ready(function(){ 
    $("#send").on('click', function() {
    var len = {min:8,max:10};
    var oldpassword = $("#oldpassword").val();
    var newpassword = $("#newpassword").val();
    if (oldpassword.length < len.min || oldpassword.length > len.max) {
          alert("Old Password must be between 8 and 10");
          return false;
      }
    if (newpassword.length < len.min || newpassword.length > len.max) {
          alert("New Passwordmust be between 8 and 10");
          return false;
      } 
    });
    });
    $(document).ready(function () {
      bsCustomFileInput.init()
    });
  </script>
</body>
</html>

<?php

   if($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $username = $_POST['username'];
    $oldpassword = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];
    $email = $_POST['email'];
    $old_photo = $_POST['image-old'];
    $extension = explode("/", $_FILES["image-file"]["type"]);
    $name_photo = $username.".".$extension[1];    
    $temp_photo = $_FILES['image-file']['tmp_name'];
    $size_photo = $_FILES['image-file']['size'];
    $type_photo = $_FILES['image-file']['type'];
    $path = "/var/www/html/ng4dm1n/production/foto/$name_photo";
    $oldpath = "/var/www/html/ng4dm1n/production/foto/$old_photo";

        $passwordcheck = mysqli_query($connectdb, "SELECT password FROM ng_userlogin WHERE password =\"$oldpassword\" AND id = \"$userloginid\"");
    
    if(mysqli_fetch_row($passwordcheck) != NULL ){
          if (!empty($_FILES['image-file']['name'])) {
                        if($type_photo == "image/jpg" || $type_photo == "image/png" || $type_photo == "image/jpeg"){
                            if($size_photo <= 10000000){
                               
          unlink($oldpath);
          move_uploaded_file($temp_photo,$path);

          if($_SESSION['level'] == 1 || $_SESSION['level'] == 10 || $_SESSION['level'] == 11){  
                $updateuser = mysqli_query($connectdb, "UPDATE ng_user SET password = \"$newpassword\", email= \"$email\", foto = \"$name_photo\"
                                                  WHERE id = \"$id\"");
            $updateuserlogin = mysqli_query($connectdb, "UPDATE ng_userlogin SET password = \"$newpassword\"
                                                  WHERE id = \"$userloginid\"");

          }else if($_SESSION['level'] == 2){
                $updateuser = mysqli_query($connectdb, "UPDATE ng_submanager SET password = \"$newpassword\", email= \"$email\", foto = \"$name_photo\"
                    WHERE id = \"$id\"");
            $updateuserlogin = mysqli_query($connectdb, "UPDATE ng_userlogin SET password = \"$newpassword\"
                                                  WHERE id = \"$userloginid\"");

          }
                                                
          }else{ //jika ukuran gambar lebih dari 10 mb
                       echo '<script language="javascript">alert("Ukuran foto tidak boleh lebih dari 10 mb")</script>';
                    }
           }else{ //jika tipe gambar bukan jpg atau png
                    echo '<script language="javascript">alert("Tipe gambar yang diupload harus JPG atau PNG.")</script>';
           }
       }else{ //jika tidak upload gambar
              if($_SESSION['level'] == 1 || $_SESSION['level'] == 10 || $_SESSION['level'] == 11){
            $updateuser = mysqli_query($connectdb, "UPDATE ng_user SET password = \"$newpassword\", email= \"$email\"
                                                  WHERE id = \"$id\"");
        $updateuserlogin = mysqli_query($connectdb, "UPDATE ng_userlogin SET password = \"$newpassword\"
                                                  WHERE id = \"$userloginid\"");

          }else if($_SESSION['level'] == 2){
            $updateuser = mysqli_query($connectdb, "UPDATE ng_submanager SET password = \"$newpassword\", email= \"$email\"
                    WHERE id = \"$id\"");
        $updateuserlogin = mysqli_query($connectdb, "UPDATE ng_userlogin SET password = \"$newpassword\"
                                                  WHERE id = \"$userloginid\"");

          }
       }
    }else{ //jika password lama salah
             echo '<script language="javascript">alert("Password lama Salah")</script>';
    }

  echo("<meta http-equiv='refresh' content='1'>"); //Refresh by HTTP META 
        }
       ?>
