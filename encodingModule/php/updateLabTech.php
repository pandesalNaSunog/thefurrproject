<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
    
        if(isset($_POST)){
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $id = htmlspecialchars($_POST['labtech_id']);
    
            $query = "UPDATE users SET name = '$name', email = '$email' WHERE id = '$id'";
            $con->query($query) or die($con->error);
    
            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
    
?>