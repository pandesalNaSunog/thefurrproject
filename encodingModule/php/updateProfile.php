<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        if(isset($_POST) && isset($_SESSION['admin_id'])){
            $id = $_SESSION['admin_id'];
            $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);

            $query = "UPDATE users SET password = '$password' WHERE id = '$id' && user_type = 'admin'";
            $con->query($query) or die($con->error);
            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>