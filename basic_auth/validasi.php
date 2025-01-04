<?php
    function validasi_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validasi_username($username){
        // if(!preg_match("[a-zA-Z0-9]{5,20}$/", $username)){
        //     return false;
        // }

        if (!preg_match("/^[a-zA-Z0-9]{5,20}$/", $username)) {
            return false;
        }
        return true;
    }

    function validasi_email($email){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return false;
        }
        return true;
    }
?>