<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        session_start();

        if(isset($_SESSION['doctor_id']) && isset($_POST)){
            $doctorId = $_SESSION['doctor_id'];

            $password = htmlspecialchars($_POST['password']);

            $query = "SELECT * FROM users WHERE id = '$doctorId'";

            $user = $con->query($query) or die($con->error);

            $userRow = $user->fetch_assoc();

            if(password_verify($password, $userRow['password'])){
                echo 'ok';
            }else{
                echo 'invalid';
            }
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>