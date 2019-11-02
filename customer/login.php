<?php
   include("../database/koneksi.php");
   session_start();
   $alert = "<p align='center'> Log in </p>";
   if($_SERVER["REQUEST_METHOD"] == "POST") {
 
	  $myusername = $_POST['username'];
    $mypassword = $_POST['password']; 

    $sql = "SELECT id, firstname, lastname FROM ng_customer WHERE username = \"$myusername\" and password = \"$mypassword\"";
      
	  $result = mysqli_query($connectdb, $sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	  
    $count = mysqli_num_rows($result);

      if($count == 1) {
 
         $_SESSION['login_user'] = $myusername;
         $_SESSION['last_activity'] = time();
         $_SESSION['userid'] = $row['id'];
         $_SESSION['name'] = $row['firstname'].' '.$row['lastname'];
         header("location: customer.php"); 
      }else {
         $alert = "<font color='red'>Username dan Password Salah</font>".$count;  
      }
   }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Citra Media Solusindo</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="images/logo_cms.jpg" type="image/ico" />

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><?php echo $alert ?></p>

      <form action="#" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">  
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="mb-1">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../js/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../js/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>