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
            echo 'ok';
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
?>