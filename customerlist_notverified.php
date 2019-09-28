<?php
include "database/koneksi.php";
include "database/check.php";

$userid = $_SESSION['userid'];
$managerid = $_SESSION['managerid'];

if($_SESSION['level'] == 0){
  $ng_user_verifikasi = mysqli_query($connectdb, "SELECT firstname, 
                                                        lastname, 
                                                        username, 
                                                        password, 
                                                        email, 
                                                        active 
                                                  FROM ng_customer 
                                                  WHERE active = 0");

}else if($_SESSION['level'] == 1){
  $ng_user_verifikasi = mysqli_query($connectdb, "SELECT ng_customer.firstname, 
                                                        ng_customer.lastname, 
                                                        ng_customer.username, 
                                                        ng_customer.password, 
                                                        ng_customer.email, 
                                                        ng_customer.active 
                                                  FROM ng_customer 
                                                  INNER JOIN ng_userlogin ON ng_userlogin.id = ng_customer.userid
                                                  INNER JOIN ng_manager ON ng_manager.id = ng_userlogin.managerid
                                                  WHERE ng_userlogin.id = \"$userid\" AND ng_customer.active = 0
                                                 
                                                  UNION
                 
                                                  SELECT ng_customer.firstname, 
                                                        ng_customer.lastname, 
                                                        ng_customer.username, 
                                                        ng_customer.password, 
                                                        ng_customer.email, 
                                                        ng_customer.active 
                                                  FROM ng_customer
                                                  INNER JOIN ng_userlogin ON ng_userlogin.id = ng_customer.userid
                                                  INNER JOIN ng_submanager ON ng_userlogin.managerid = ng_submanager.id 
                                                  INNER JOIN ng_manager ON ng_submanager.managerid = ng_manager.id
                                                  WHERE ng_manager.id = \"$userid\" AND ng_customer.active = 0 ");

}else if($_SESSION['level'] == 2){
  $ng_user_verifikasi = mysqli_query($connectdb, "SELECT ng_customer.firstname, 
                                                        ng_customer.lastname, 
                                                        ng_customer.username, 
                                                        ng_customer.password, 
                                                        ng_customer.email, 
                                                        ng_customer.active 
                                                  FROM ng_customer 
                                                  INNER JOIN ng_userlogin ON ng_userlogin.id = ng_customer.userid
                                                  INNER JOIN ng_submanager ON ng_submanager.id = ng_userlogin.managerid
                                                  WHERE ng_userlogin.id = \"$userid\" AND ng_customer.active = 0");

}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | DataTables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

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
            <h1>DataTables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
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
            <div class="card-header">
              <h3 class="card-title">DataTable with default features</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Firstname</th>
                  <th>Lastname</th>
                  <th>Username</th>
                  <th>Password</th>
                  <th>Email</th>
                  <th>Verify Email</th>
                </tr>
                </thead>
                <tbody>
                  <?php while ($dtuser = mysqli_fetch_assoc($ng_user_verifikasi)){?>
                  <tr>
                    <td><?php echo $dtuser['firstname']; ?></td>
                    <td><?php echo $dtuser['lastname']; ?></td>
                    <td><?php echo $dtuser['username']; ?></td>
                    <td><?php echo $dtuser['password']; ?></td>
                    <td><?php echo $dtuser['email']; ?></td>
                    <td><form action="#" method=post novalidate>
                          <input id="firstname" name="firstname" type="hidden" value="<?php echo $dtuser['firstname']; ?>">
                          <input id="lastname" name="lastname" type="hidden" value="<?php echo $dtuser['lastname']; ?>">
                          <input id="username" name="username" type="hidden" value="<?php echo $dtuser['username']; ?>">
                          <input id="email" name="email" type="hidden" value="<?php echo $dtuser['email']; ?>">       
                          <button id="send" type="submit" class="btn btn-success">Submit</button>                                    
                        </form>
                    </td>
                  </tr>

                  <?php } ?>
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
</script>
</body>
</html>

<?php
  if($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    verifikasiEmail($firstname,$lastname,$username,$email);
    echo '<script language="javascript">alert("Email has been send")</script>';
  
  }
  
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
                    <b>URL Konfirmasi : </b><a href='localhost/SI_PKL/confirmemail.php?username=".$encryp_username."'>disini</a><br>
                    <br>
                  </div>
            </body>";
    // $body             =  preg_replace_callback("/([^A-Za-z0-9!*+\/ -])/e",'',$body);
    $mail->IsSMTP();  // menggunakan SMTP
    $mail->SMTPDebug  = 1;   // mengaktifkan debug SMTP
    $mail->SMTPSecure = 'tls'; 
    $mail->SMTPAuth   = true;   // mengaktifkan Autentifikasi SMTP
    $mail->Host   = 'smtp.gmail.com'; // host sesuaikan dengan hosting mail anda
    $mail->Port       = 587;  // post gunakan port 25
    $mail->Username   = "admproduction96@gmail.com"; // username email akun
    $mail->Password   = "admin2019.";        // password akun

    $mail->SetFrom('admproduction96@gmail.com', 'Verifikasi Email');


    $mail->Subject    = "Verifikasi Email";
    $mail->MsgHTML($body);

    $address = $email; //email tujuan
    $mail->AddAddress($address, "Hello ".$firstname." ".$lastname);
    $mail->Send();
  }
  //end verifikasi Email
  ?>