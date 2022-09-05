<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        session_start();
        if(isset($_POST)){
            $email = htmlspecialchars($_POST['email']);
            $password = $_POST['password'];

            $query = $con->prepare("SELECT * FROM users WHERE email = ? AND user_type = 'receptionist'");
            $query->bind_param("s", $email);
            $query->execute();
            $result = $query->get_result();
            if($data = $result->fetch_assoc()){
                if(password_verify($password, $data['password'])){
                    $_SESSION['cashier_id'] = $data['id'];
                    echo 'panel.html';
                }else{
                    echo 'invalid';
                }
            }else{
                echo 'invalid';
            }


        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>