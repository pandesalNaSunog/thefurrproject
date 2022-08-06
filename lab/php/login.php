<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        if(isset($_POST)){
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_PIST['password']);
            $query = "SELECT * FROM users WHERE user_type = 'lab_tech' AND email = '$email'";
            $labTech = $con->query($query) or die($con->error);
            if($labTechRow = $labTech->fetch_assoc()){
                if(password_verify($passowrd, $labTechRow['password'])){
                    $_SESSION['lab_tech_id'] = $labTechRow['id'];
                    echo 'dashboard.html';
                }else{
                    echo 'invalid';
                }

            }else{
                echo 'invalid';
            }
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>