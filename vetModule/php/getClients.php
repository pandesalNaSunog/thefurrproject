<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        session_start();
        if(isset($_GET) && isset($_SESSION['doctor_id'])){
            $doctor_id = $_SESSION['doctor_id'];

            $query = "SELECT * FROM users WHERE user_type = 'client' ORDER BY name ASC";
            $user = $con->query($query) or die($con->error);
            $users = array();

            while($row = $user->fetch_assoc()){
                $users[] = $row;
            }

            echo json_encode($users);
        }else{
            echo 'invalid session';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>