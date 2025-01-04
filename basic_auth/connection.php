<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "auth_api";

$conn = mysqli_connect($servername, $username, $password, $db);

// cek koneksi 
if($conn){
    // echo 'Koneksi database berhasil';
}else{
    echo 'koneksi database gagal. pesan error'.mysqli_connect_error();
}
?>