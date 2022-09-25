<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        session_start();

        if(isset($_SESSION['doctor_id']) && isset($_POST)){
            $doctorId = $_SESSION['doctor_id'];

            $password = htmlspecialchars($_POST['password']);

            $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE users SET password = '$encryptedPassword' WHERE id = '$doctorId'";
            $con->query($query) or die($con->error);
            echo 'ok';
        }else{
            echo 'session expired';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>