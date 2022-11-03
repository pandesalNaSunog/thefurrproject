<?php
    include('connection.php');
    if(isSecure()){
        

        $con = connect();
        session_start();
        if(isset($_POST)){
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $query = "SELECT * FROM users WHERE email = '$email' && user_type = 'vet_nurse'";
            $user = $con->query($query) or die($con->error);

            if($userRow = $user->fetch_assoc()){
                if(password_verify($password, $userRow['password'])){
                    $_SESSION['nurse_id'] = $userRow['id'];
                    echo 'ok';
                }else{
                    echo 'invalid';
                }
            }else{
                echo 'invalid';
            }
        }
    }else{
        error();
    }
?>