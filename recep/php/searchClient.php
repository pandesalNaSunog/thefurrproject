<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();

        if(isset($_POST)){
            $keyword = htmlspecialchars($_POST['keyword']);

            $query = "SELECT * FROM users WHERE user_type = 'client' AND name LIKE '%$keyword%' OR client_code LIKE '%$keyword%'";
            $user = $con->query($query) or die($con->error);
            $response = array();
            while($userRow = $user->fetch_assoc()){
                $response[] = array(
                    'name' => $userRow['name'],
                    'client_code' => $userRow['client_code']
                );
            }

            echo json_encode($response);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>