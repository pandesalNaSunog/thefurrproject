<?php
    
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_POST)){
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $code = htmlspecialchars($_POST['code']);
            $contact = htmlspecialchars($_POST['contact']);
            
            $query = "SELECT client_code FROM users WHERE client_code = '$code'";
            $user = $con->query($query) or die($con->error);
            if($userRow = $user->fetch_assoc()){
                echo 'client code exists';
            }else{
                $password = passwordGenerator();
                $query = "INSERT INTO users(`name`,`email`,`client_code`,`password`,`contact_no`,`user_type`,`banned`,`created_at`,`updated_at`)VALUES('$name','$email','$code','$password','$contact','client',0,'$today','$today')";
                $con->query($query) or die($con->error);

                $query = "SELECT name, client_code FROM users WHERE id = LAST_INSERT_ID()";
                $user = $con->query($query) or die($con->error);

                $userRow = $user->fetch_assoc();

                echo json_encode($userRow);
            }
            
        }

        
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }

    function passwordGenerator(){
        $characters = "QWERTYUIOPASDFGHJKLZXCVBNM1234567890";
        $password = "";
        for($i = 0; $i < 9; $i++){
            $index = rand(0, strlen($characters) - 1);

            $password .= $characters[$index];
        }
        return $password;
    }
    
?>