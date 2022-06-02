<?php
    include('connection.php');
    $con = connect();

    if(!isset($_SESSION)){
        session_start();
    }
    if(isset($_POST)){
        $email = $_POST['email'];
        $password = $_POST['password'];


        $query = "SELECT * FROM users WHERE email = '$email'";
        $user = $con->query($query) or die($con->error);
        $data = array();
        while($row = $user->fetch_assoc()){
            $data[] = $row;
        }

        if(count($data) == 0){
            echo 'invalid email';
        }else{
            if(!password_verify($password, $data[0]['password'])){
                
                echo 'invalid password';
            }else{
                $_SESSION['client_email'] = $email;
                echo 'ok';
            }
        }
    }
?>