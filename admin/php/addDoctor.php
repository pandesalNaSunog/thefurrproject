<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_POST)){
            $name = "Dr. " . htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);

            $password = password_hash('password', PASSWORD_DEFAULT);
            $query = "INSERT INTO users(`name`,`email`,`password`,`user_type`,`created_at`,`updated_at`)VALUES('$name','$email','$password','doctor','$today','$today')";
            $con->query($query) or die($con->error);

            $query = "SELECT * FROM users WHERE id = LAST_INSERT_ID()";
            $user = $con->query($query) or die($con->error);
            $userRow = $user->fetch_assoc();

            echo json_encode($userRow);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>