<?php
    require 'connection.php';
    require 'validasi.php';

    // set header api 
    header('content-Type: application/json');

    // mengambil autentikasi header 
    $header = getallheaders(); // => getallheaders fungsi bawaan php
    $auth = isset($header['Authorization']) ? $header['Authorization'] : '';

    // jika header kosong 
    if(empty($auth)){
        http_response_code(401);
        echo json_encode([
            'status' => false,
            'message' => 'Authorization header tidak ditemukan'
        ]);
        exit();
    }

    // ambil credential dari header 
    $auth = explode(' ', $auth)[1];
    $auth_decode = base64_decode($auth);
    list($username, $password) = explode(':', $auth_decode);

    $username = validasi_input($username);
    $password = validasi_input($password);

    // query untuk cek user di database 
    $query = "SELECT * FROM users WHERE username = '$username'";
    $hasil = mysqli_query($conn, $query);

    // cek hasil 
    if(mysqli_num_rows($hasil) > 0){
        // berhasil
        $user = mysqli_fetch_assoc($hasil);

        // varifikasi password 
        if(password_verify($password, $user['password'])){
            $respon = [
                'status' => true,
                'message' => 'Login berhasil',
                'data' => [
                    'user_id' => $user['id'],
                    'usernamse' => $user['username'],
                    'email' => $user['email'],
                    'waktu_akses' => date('Y-m-d H:i:s')
                ]
            ];
    
            http_response_code(200);
        }else{
            $respon = [
                'status' => false,
                'message' => 'Password salah'
            ];
            http_response_code(401);
        }
    }else{
        // gagal 
        $respon = [
            'status' => false,
            'message' => 'Username tidak ditemukan'
        ];
        http_response_code(401);
    }

    echo json_encode($respon);

?>