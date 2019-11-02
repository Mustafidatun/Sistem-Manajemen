<?php
include "database/koneksi.php";

if(!empty($_GET['username'])){
    $username = $_GET['username'];
    $decode_username = base64_decode($username);

    if (isset($username)) {
        $find = mysqli_query($connectdb, "SELECT username FROM ng_customer WHERE username ='.$decode_username.'");

        if (mysqli_fetch_row($find) == NULL) {
            $konfirmasi = mysqli_query ($connectdb, "UPDATE ng_customer SET active = 1 WHERE username = \"$decode_username\"");
            $ng_customer = mysqli_query($connectdb, "SELECT firstname, lastname, username, password, email FROM ng_customer WHERE username = \"$decode_username\"");
            $data_customer = mysqli_fetch_assoc($ng_customer);
            $password = $data_customer['password'];
            $fname = $data_customer['firstname'];
            $lname = $data_customer['lastname'];
            $userpass = $data_customer['username'];
            $email = $data_customer['email'];
            verifikasiDataCustomer($fname, $lname, $userpass, $password, $email);
           
            if ($konfirmasi) {
                echo '<script language="javascript">alert("Konfirmasi sukses")</script>';
            }

        } else {
            echo '<script language="javascript">alert("Akun tidak terdaftar")</script>';
        }
    }

        //verifikasi Email
        function verifikasiDataCustomer($fname, $lname, $userpass, $password, $email){
            require_once('PHPMailer/class.phpmailer.php'); //menginclude librari phpmailer
            $mail             = new PHPMailer();
            $body             = 
            "<body style='margin: 10px;'>
                    <div style='width: 640px; font-family: Helvetica, sans-serif; font-size: 13px; padding:10px; line-height:150%; border:#eaeaea solid 10px;'>
                        <br>
                        <strong>Terimakasih telah menjadi pelanggan iMax5. Berikut adalah detail subscription anda :</strong><br>
                                    <b>Customer : </b>".$fname." ".$lname."<br>
                                    <b>Customer ID : </b>".$userpass."<br>
                                    <b>Username : </b>".$userpass."<br>
                                    <b>Password : </b>".$password."<br> 
                                    <b>Email : </b>".$email."<br>
                                    <b>URL Konfirmasi : </b>http://localhost/adminCMS/customer/login.php<br>
                        <br>
                    </div>
                </body>";

            $mail->IsSMTP(); 	// menggunakan SMTP
            $mail->SMTPDebug  = 1;   // mengaktifkan debug SMTP
            $mail->SMTPSecure = 'tls'; 
            $mail->SMTPAuth   = true;   // mengaktifkan Autentifikasi SMTP
            $mail->Host 	= 'smtp.gmail.com'; // host sesuaikan dengan hosting mail anda
            $mail->Port       = 587;  // post gunakan port 25
            $mail->Username   = "mustafidatunnashihah@gmail.com"; // username email akun
            $mail->Password   = "fida2012.";        // password akun
            $mail->SetFrom('mustafidatunnashihah@gmail.com', 'PT. Citra Media Solusindo');
            $mail->Subject    = "User Activation Complete";
            $mail->MsgHTML($body);
            $address = $email; //email tujuan
            $mail->AddAddress($address, "Hello ".$fname." ".$lname);
            $mail->Send();
        }
        //end verifikasi Email

        header("location:./include/page_404.html");
    
?>