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


            $query = "SELECT * FROM users WHERE client_code = '$code'";
            $user = $con->query($query) or die($con->error);
            $doctorName = "NO RECORDS";
            if($userRow = $user->fetch_assoc()){
                echo 'client code already exists';
            }else{
                $password = passwordGenerator();
                $query = "INSERT INTO users(`name`,`email`,`client_code`,`contact_no`,`password`,`user_type`,`created_at`,`updated_at`,`banned`)VALUES('$name','$email','$code','$contact','$password','client','$today','$today', '0')";
                $con->query($query) or die($con->error);

                $query = "SELECT id, name, client_code, contact_no FROM users WHERE id = LAST_INSERT_ID()";
                $user = $con->query($query) or die($con->error);

                $userRow = $user->fetch_assoc();

                $userId = $userRow['id'];

                $doctorName = "NO RECORD";
                $response = array(
                    'id' => $userRow['id'],
                    'name' => $userRow['name'],
                    'client_code' => $userRow['client_code'],
                    'contact_no' => $userRow['contact_no'],
                    'attending_vet' => $doctorName
                );

                echo json_encode($response);
            }
        }
    }else{
        echo heaer('HTTP/1.1 403 Forbidden');
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