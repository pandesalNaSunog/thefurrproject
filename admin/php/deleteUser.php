<?php

    include('server.php');
    if(isSecure()){
        include('connection.php');
        $con = connect();
        if(isset($_POST)){
            $userId = $_POST['user_id'];
            $query = "DELETE FROM users WHERE id = '$userId'";
            $con->query($query) or die($con->error);

            echo 'ok';
        }
    }else{
        error();
    }
?>