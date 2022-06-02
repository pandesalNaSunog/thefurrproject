<?php

    if(!isset($_SESSION)){
        session_start();
    }
    include('connection.php');
    $con = connect();

    
    if(isset($_GET) && isset($_SESSION['client_email'])){
        $email = $_SESSION['client_email'];
        $query = "SELECT * FROM users WHERE email = '$email'";
        $user = $con->query($query) or die($con->error);
        $data = array();
        while($row = $user->fetch_assoc()){
            $data[] = $row;
        }
        if(count($data) > 0){
            echo 'clientDashboard.html';
        }else{
            echo 'no';
        }
    }else{
        echo 'no';
    }
?>