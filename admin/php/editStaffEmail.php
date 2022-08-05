<?php

    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        if(isset($_POST)){
            $userId = $_POST['user_id'];
            $email = htmlspecialchars($_POST['email']);
            $name = htmlspecialchars($_POST['name']);
            $query = "UPDATE users SET email = '$email', name = '$name' WHERE id = '$userId'";
            $con->query($query) or die($con->error);
            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>