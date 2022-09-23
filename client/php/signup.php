<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_POST)){
            $email = htmlspecialchars($_POST['email']);
            $name = htmlspecialchars($_POST['name']);
            $password = htmlspecialchars($_POST['password']);
            $contact = "0" . $_POST['contact'];
            $userType = "client";
            $banned = 0;

            $initial = $name[0];

            do{
                $clientCode = clientCodeGenerator($initial);
                $query = "SELECT * FROM users WHERE client_code = '$clientCode'";
                $user = $con->query($query) or die($con->error);
            }while($userRow = $user->fetch_assoc());
            

            $query = $con->prepare("INSERT INTO users(name, email, client_code, contact_no, password, user_type, created_at, updated_at, banned)VALUES(?,?,?,?,?,?,?,?,?)");
            $query->bind_param("ssssssssi", $name, $email, $clientCode, $contact, $password, $userType , $today, $today, $banned);
            $query->execute();

            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }


    function clientCodeGenerator($initial){
        $code = "";
        $randomNumber = rand(0,4000);

        $code .= $initial . "-" . $randomNumber;

        return $code;
    }
?>