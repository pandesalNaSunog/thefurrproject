<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();

        if(isset($_POST)){
            $userId = $_POST['user_id'];
            $query = "SELECT * FROM pets WHERE user_id = '$userId'";
            $pet = $con->query($query) or die($con->error);
            $response = array();
            while($petRow = $pet->fetch_assoc()){
                $response[] = array(
                    'name' => $petRow['name'],
                    'species' => $petRow['species'],
                    'breed' => $petRow['breed'],
                    'id' => $petRow['id'],
                );
            }

            echo json_encode($response);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>