<?php
$host="localhost:32771"; // Host name 
$username="root"; // Mysql username 
$password=""; // Mysql password 
$db_name="admincms"; // Database name

 
$connectdb= mysqli_connect($host, $username, $password, $db_name);

  if(!$connectdb){
    die ("Koneksi dengan database gagal: ".mysqli_connect_errno().
    " - ".mysqli_connect_error());
  }
 ?>
