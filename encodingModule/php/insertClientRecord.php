<?php
    include('connection.php');
    $con = connect();

    if(isset($_POST)){
        $ownerName = $_POST['client_name'];
        $clientCode = $_POST['client_code'];
        $contactNo = $_POST['contact_no'];
        $email = uniqid()."@gmail.com";
        $password = passwordGenerator();

        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users(`name`,`email`,`client_code`,`contact_no`,`password`)
                    VALUES('$ownerName','$email','$clientCode','$contactNo','$encryptedPassword')";
        $con->query($query) or die($con->error);
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
?>