<?php
    session_start();
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = "SELECT * FROM cashiers WHERE email = '$email'";
        $cashier = $con->query($query) or die($con->error);
        if($row = $cashier->fetch_assoc()){
            if(password_verify($password, $row['password'])){
                $_SESSION['cashier_id'] = $row['id'];
                echo 'panel.html';
            }else{
                echo 'invalid';
            }
        }else{
            echo 'invalid';
        }
    }
?>