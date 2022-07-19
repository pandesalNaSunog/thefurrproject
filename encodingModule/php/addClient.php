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

            $password = generatePassword();
            $query = "SELECT * FROM users WHERE client_code = '$code'";
            $user = $con->query($query) or die($con->error);
            if($row = $user->fetch_assoc()){
                echo 'exists';
            }else{
                $query = "INSERT INTO users(`name`,`email`,`client_code`,`contact_no`,`password`,`user_type`,`created_at`,`updated_at`)VALUES('$name','$email','$code','$contact','$password','client','$today','$today')";
                $con->query($query) or die($con->error);

                $query = "SELECT * FROM users WHERE id = LAST_INSERT_ID()";
                $user = $con->query($query) or die($con->error);
                $userRow = $user->fetch_assoc();

                echo json_encode($userRow);
            }
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }


    function generatePassword(){
        $characters = "1234567890QWERTYUIOPASDFGHJKLZXCVBNM";
        $password = "";
        for($i = 0;$i < 8;$i++){
            $index = rand(0, strlen($characters) - 1);
            $password .= $characters[$index];
        }

        return $password;
    }
?>