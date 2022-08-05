<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();

        if(isset($_POST) && isset($_SESSION['admin_id'])){
            $password = $_POST['password'];
            $id = $_SESSION['admin_id'];
            $query = "SELECT * FROM users WHERE id = '$id'";
            $user = $con->query($query) or die($con->error);
            $userRow = $user->fetch_assoc();

            if(password_verify($password, $userRow['password'])){
                echo 'ok';
            }else{
                echo 'invalid';
            }
        }else{
            echo 'unable';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>