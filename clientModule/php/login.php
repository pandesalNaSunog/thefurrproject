<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        if(isset($_POST)){
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $query = $con->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
            $query->bind_param("ss", $email, $password);
            $query->execute();
            $result = $query->get_result();

            if($data = $result->fetch_assoc()){
                $_SESSION['client_id'] = $data['id'];
                echo 'ok';
            }else{
                echo 'invalid';
            }
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>