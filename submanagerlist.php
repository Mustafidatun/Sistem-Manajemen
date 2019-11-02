<?php
include "database/koneksi.php";
include "database/check.php";

$userid = $_SESSION['userid'];
if($_SESSION['level'] == 1){
  $submanager = mysqli_query($connectdb, "SELECT ng_submanager.id,
                                                  ng_submanager.username AS username_submanager, 
                                                  ng_submanager.password, 
                                                  ng_submanager.email 
                                          FROM ng_submanager
                                          INNER JOIN ng_user ON ng_user.id = ng_submanager.managerid
                                          WHERE ng_user.id = \"$userid\"");
  
}else if($_SESSION['level'] == 0){
  $submanager = mysqli_query($connectdb, "SELECT ng_submanager.id,
                                                  ng_submanager.username AS username_submanager, 
                                                  ng_submanager.password, 
                                                  ng_submanager.email,
                                                  ng_user.username AS username_manager
                                          FROM ng_submanager
                                          INNER JOIN ng_user ON ng_user.id = ng_submanager.managerid"
                                );
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
            <h1>Sub Manager List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Sub Manager List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Username</th>
                  <th>Password</th>
                  <th>Email</th>
                  <?php if($_SESSION['level'] == 0){ ?>
                    <th>Manager</th>
                    <th>Up Level</th>
                  <?php } ?>
                </tr>
                </thead>
                <tbody>
                  <?php while ($dtsubmanager = mysqli_fetch_assoc($submanager)){
                    //password
                    $countpass = strlen(substr($dtsubmanager['password'],0,-3));
                    $replacepass = '';
                    for($i = 0; $i < $countpass; $i++){
                      $replacepass .= 'x';
                    }
                    $password = str_replace(substr($dtsubmanager['password'],0,-3), $replacepass ,$dtsubmanager['password']);
                    //end password
                    
                    ?>
                  <tr>
                    <td><?php echo $dtsubmanager['username_submanager']; ?></td>
                    <td><?php echo $password; ?></td>
                    <td><?php echo $dtsubmanager['email']; ?></td>
                    <?php if($_SESSION['level'] == 0){ ?>
                    <td> <?php echo $dtsubmanager['username_manager']; ?></td>
                    <td>
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                        Up Level
                      </button>

                      <!-- Modal -->
                      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel">Up Level Sub Manager</h4>
                              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>      
                            </div>
                            <form action="" method=post>
                              <div class="modal-body">
                                  <input id="submanagerid" name="submanagerid" type="hidden" value="<?php echo $dtsubmanager['id']; ?>" required>
                                  <div class="form-group">
                                    <label>Level User</label>
                                    <select class="form-control" name="level">
                                      <option value=''>Pilih</option>
                                      <option value='1'>Manager</option>
                                      <option value='10'>Finance</option>
                                      <option value='11'>Purchasing</option>
                                    </select>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                               <button id="send" type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <!-- End Modal -->
                  </td>
                  <?php } ?>
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
            $submanagerid = $_POST['submanagerid'];
            $submanager = mysqli_query($connectdb, "SELECT ng_submanager.*, ng_userlogin.id AS userloginid FROM ng_submanager 
                                                    INNER JOIN ng_userlogin ON ng_userlogin.userid = ng_submanager.id
                                                    WHERE ng_submanager.id = \"$submanagerid\"");
            $showsubmanager = mysqli_fetch_assoc($submanager);
            $userloginid = $showsubmanager['userloginid'];
            $username = $showsubmanager['username'];
            $password = $showsubmanager['password'];
            $email = $showsubmanager['email'];
            $foto = $showsubmanager['foto'];
            $level = $_POST['level'];

            $assigmentlevel =  mysqli_query($connectdb, "CALL spAssigmentLevel(\"$userloginid\",\"$submanagerid\",\"$username\",\"$password\",\"$email\",\"$foto\",\"$level\")");
          echo("<meta http-equiv='refresh' content='1'>"); //Refresh by HTTP META 
        }
?>
