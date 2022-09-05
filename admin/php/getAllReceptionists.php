<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $query = "SELECT * FROM users WHERE user_type = 'receptionist'";
        $userQuery = $con->query($query) or die($con->error);
        $response = array();
        while($userRow = $userQuery->fetch_assoc()){
            $response[] = array(
                'name' => $userRow['name'],
                'email' => $userRow['email'],
                'id' => $userRow['id']
            );
        }
        echo json_encode($response);
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>