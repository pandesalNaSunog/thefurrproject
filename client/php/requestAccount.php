<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();

        if(isset($_POST)){
            $contact = $_POST['contact'];

            $query = "SELECT * FROM users WHERE contact_no = '$contact'";

            $user = $con->query($query) or die($con->error);
            if($userRow = $user->fetch_assoc()){

                $userId = $userRow['id'];
                $email = uniqid() . "@gmail.com";
                $password = $userRow['password'];
                sendSMS($email, $password, $contact);

                $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
                $query = "UPDATE users SET email = '$email', password = '$encryptedPassword' WHERE id = '$userId'";
                $con->query($query) or die($con->error);
                echo 'ok';
            }else{
                echo 'no';
            }
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }

    function sendSMS($email, $password, $contact){
        $ch = curl_init();
        $parameters = array(
            'apikey' => '34a51284e39cc4d5f1d6bace2cbbf124',
            'number' => $contact,
            'message' => 'You have been given an account for The Furr Project Animal Clinic & Vet Pharmacy. Your email is '.$email.', and your password is '.$password.'. Log in to furrproject.com to book appointments, view your pet status, and track your bills.',
            'sendername' => 'SEMAPHORE'
        );
        curl_setopt( $ch, CURLOPT_URL,'https://api.semaphore.co/api/v4/messages' );
        curl_setopt( $ch, CURLOPT_POST, 1 );

        //Send the parameters set above with the request
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

        // Receive response from server
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close ($ch);
    }
?>