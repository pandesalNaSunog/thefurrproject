<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();

        if(isset($_POST)){
            $clientId = $_POST['client_id'];
            $query = "SELECT * FROM users WHERE id = '$clientId'";
            $user = $con->query($query) or die($con->error);
            $userRow = $user->fetch_assoc();
            $banned = $userRow['banned'];

            if($banned == 0){
                $banned = 1;
                $response = "banned";
            }else{
                $banned = 0;
                $response = "unbanned";
            }
            $query = "UPDATE users SET banned = '$banned' WHERE id = '$clientId'";
            $con->query($query) or die($con->error);

            echo $response;
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>