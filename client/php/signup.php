<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_POST)){
            $email = htmlspecialchars($_POST['email']);
            $name = htmlspecialchars($_POST['name']);
            $password = htmlspecialchars($_POST['password']);
            $contact = $_POST['contact'];
            $userType = "client";
            $banned = 0;
            $clientCode = clientCodeGenerator();
            $query = $con->prepare("INSERT INTO users(name, email, client_code, contact_no, password, user_type, created_at, updated_at, banned)VALUES(?,?,?,?,?,?,?,?,?)");
            $query->bind_param("ssssssssi", $name, $email, $clientCode, $contact, $password, $userType , $today, $today, $banned);
            $query->execute();

            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }


    function clientCodeGenerator(){
        $code = "A-0";
        $randomNumber = rand(0,500);

        $code .= $randomNumber;

        return $code;
    }
?>