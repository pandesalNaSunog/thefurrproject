<?php
    
    include('connection.php');
    $con = connect();
    if(!isset($_SESSION)){
        session_start();
        if(isset($_SESSION['client_email'])){
            $email = $_SESSION['client_email'];
            $query = "SELECT * FROM users WHERE email = '$email'";
            $user = $con->query($query) or die($con->error);
            $row = $user->fetch_assoc();

            $_SESSION['client_id'] = $row['id'];
            echo $_SESSION['client_id'];
        }else{
            echo 'index.html';
        }
        
    }
?>