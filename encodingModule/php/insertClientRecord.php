<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $ownerName = $_POST['client_name'];
        $clientCode = $_POST['client_code'];
        $contactNo = $_POST['contact_no'];
        $email = uniqid()."@gmail.com";
        $password = passwordGenerator();
        //check if client code already exists
        $query = "SELECT * FROM users WHERE client_code = '$clientCode'";
        $user = $con->query($query) or die($con->error);
        $data = array();

        while($row = $user->fetch_assoc()){
            $data[] = $row;
        }
        if(count($data) == 0){
            $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users(`name`,`email`,`client_code`,`contact_no`,`password`)
                        VALUES('$ownerName','$email','$clientCode','$contactNo','$encryptedPassword')";
            $con->query($query) or die($con->error);

            $query = "SELECT * FROM users WHERE id = LAST_INSERT_ID()";
            $user = $con->query($query) or die($con->error);
            $userRow = $user->fetch_assoc();
            sendSMS($contactNo, $email, $password);
            echo json_encode($userRow);
        }else{
            echo 'exists';
        }
    }
    function passwordGenerator(){
        $counter = 1;
        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $generatedPassword = "";
        do{
            $random = rand(0, strlen($characters) - 1);
            $generatedPassword .= $characters[$random];
            $counter++;
        }while($counter < 9);

        return $generatedPassword;
    }
    function sendSMS($contactNo, $email, $password){
        $ch = curl_init();
        $parameters = array(
            'apikey' => '34a51284e39cc4d5f1d6bace2cbbf124',
            'number' => $contactNo,
            'message' => "You have been given an account for The Furr Project Veterinary Clinic \nEmail: ".$email."\nPassword: ".$password.". Visit furrproject.com to book an appointment.",
            'sendername' => 'SEMAPHORE'
        );
        curl_setopt( $ch, CURLOPT_URL,'https://api.semaphore.co/api/v4/priority' );
        curl_setopt( $ch, CURLOPT_POST, true);

        //Send the parameters set above with the request
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

        // Receive response from server
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close ($ch);
    }
?>