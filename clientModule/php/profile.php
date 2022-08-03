<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        if(isset($_SESSION['client_id'])){
            $clientId = $_SESSION['client_id'];
            $query = "SELECT * FROM users WHERE id = '$clientId'";
            $user = $con->query($query) or die($con->error);
            $userRow = $user->fetch_assoc();
            echo json_encode($userRow);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>