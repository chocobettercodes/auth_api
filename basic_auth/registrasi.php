<?php
    require 'connection.php';
    // require 'validasi.php';

    header('content-Type: application/json');

    // terima data inputan 
    $raw_data = file_get_contents("php://input");
    $data = json_decode($raw_data, true);

    if(!isset($data['username']) || !isset($data['password']) || !isset($data['email'])){
        http_response_code(400);
        echo json_encode([
            'status' => false,
            'message' => 'Data tidak lengkap'
        ]);
        exit();
    }

    $username = mysqli_real_escape_string($conn,$data['username']);
    $password = mysqli_real_escape_string($conn, string: $data['password']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    

    // cek username ada atau tidak 
    $query_cek = "SELECT username FROM users WHERE username = '$username'";
    $hasil_cek = mysqli_query($conn, $query_cek);

    if(mysqli_num_rows($hasil_cek) > 0){
        http_response_code(400);
        echo json_encode([
            'status' => false,
            'message' => 'Username sudah digunakan'
        ]);
        exit();
    }

    // hash password user
    $pw_hash = password_hash($password, PASSWORD_DEFAULT);

    $query_input = "INSERT INTO users (username, password, email) VALUES ('$username', '$pw_hash', '$email')";
    $hasil_input = mysqli_query($conn, $query_input);

    if($hasil_input){
        http_response_code(201);
        echo json_encode([
            'status' => true,
            'message' => 'Registrasi berhasil dilakukan!',
            'data' => [
                'username' => $username,
                'email' => $email
            ]
        ]);
        exit();
    }else{
        http_response_code(400);
        echo json_encode([
            'status' => false,
            'message' => 'Gagal melakukan registrasi'
        ]);
        exit();
    }

//     header('Content-Type: application/json');

// // Aktifkan error reporting untuk debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// // Baca raw input
// $raw_input = file_get_contents("php://input");

// // Debug: cek raw input
// if (empty($raw_input)) {
//     echo json_encode([
//         'status' => false,
//         'message' => 'Tidak ada data yang dikirim'
//     ]);
//     exit();
// }

// // Parse JSON
// $data = json_decode($raw_input, true);

// // Debug: cek hasil parsing JSON
// if (json_last_error() !== JSON_ERROR_NONE) {
//     echo json_encode([
//         'status' => false,
//         'message' => 'Error parsing JSON: ' . json_last_error_msg()
//     ]);
//     exit();
// }

// // Cek kelengkapan data
// if (!isset($data['username']) || !isset($data['password']) || !isset($data['email'])) {
//     echo json_encode([
//         'status' => false,
//         'message' => 'Data tidak lengkap',
//         'debug' => [
//             'received_data' => $data,
//             'raw_input' => $raw_input
//         ]
//     ]);
//     exit();
// }

// $username = mysqli_real_escape_string($conn, $data['username']);
// $password = mysqli_real_escape_string($conn, $data['password']);
// $email = mysqli_real_escape_string($conn, $data['email']);

// // Cek username sudah ada atau belum
// $query_cek = "SELECT username FROM users WHERE username = '$username'";
// $result = mysqli_query($conn, $query_cek);

// if (mysqli_num_rows($result) > 0) {
//     echo json_encode([
//         'status' => false,
//         'message' => 'Username sudah digunakan'
//     ]);
//     exit();
// }

// // Hash password
// $password_hash = password_hash($password, PASSWORD_DEFAULT);

// // Simpan ke database
// $query = "INSERT INTO users (username, password, email) VALUES ('$username', '$password_hash', '$email')";

// if (mysqli_query($conn, $query)) {
//     echo json_encode([
//         'status' => true,
//         'message' => 'Registrasi berhasil',
//         'data' => [
//             'username' => $username,
//             'email' => $email
//         ]
//     ]);
// } else {
//     echo json_encode([
//         'status' => false,
//         'message' => 'Gagal melakukan registrasi: ' . mysqli_error($$conn)
//     ]);
// }

?>