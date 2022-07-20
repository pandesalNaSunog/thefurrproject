<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $query = "SELECT * FROM users WHERE user_type = 'client' ORDER BY name";
        $user = $con->query($query) or die($con->error);
        $users = array();
        while($row = $user->fetch_assoc()){
            $users[] = $row;
        }
        echo json_encode($users);
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>