<?php
    include('encodingModule/php/connection.php');
    $con = connect();

    $query = "SELECT * FROM users WHERE user_type = 'client' AND contact_no != '' AND email = ''";

    $user = $con->query($query) or die($con->error);
    $users = array();

    while($row = $user->fetch_assoc()){
        $userId = $row['id'];
        $email = uniqid() . "@gmail.com";
        $contact = $row['contact_no'];
        if(strlen($row['password']) == 8){
            sendSms($email, $row['password'], $contact);
            $password = password_hash($row['password']);
            $query = "UPDATE FROM users SET email = '$email', password = '$password' WHERE id = '$userId'";
            $con->query($query) or die($con->error);
        }
    }
    echo 'done';


    function sendSms($email, $password, $contact){
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