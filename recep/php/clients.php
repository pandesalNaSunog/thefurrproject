<?php
    include('secure.php');
    if(secured()){
        include('connection.php');
        $con = connect();
        $query = "SELECT id, name, client_code FROM users WHERE user_type = 'client'";
        $user = $con->query($query) or die($con->error);
        $users = array();
        while($userRow = $user->fetch_assoc()){
            $users[] = $userRow;
        }

        echo json_encode($users);
    }else{
        showError();
    }
?>