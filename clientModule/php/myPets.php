<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_SESSION['client_id'])){
            $clientId = $_SESSION['client_id'];
            $query = "SELECT * FROM pets WHERE user_id = '$clientId'";
            $pet = $con->query($query) or die($con->error);
            $pets = array();
            while($petRow = $pet->fetch_assoc()){
                $pets[] = $petRow;
                $todayObject = date_create($today);
                $birthdateObject = date_create($petRow['birth_date']);

                $dateDiff = date_diff($todayObject, $birthdateObject);

                $age = $dateDiff->format("%y Year(s) %m Month(s)");
                $response[] = array(
                    'id' => $petRow['id'],
                    'name' => $petRow['name'],
                    'breed' => $petRow['breed'],
                    'species' => $petRow['species'],
                    'sex' => $petRow['sex'],
                    'age' => $age
                );
            }
            echo json_encode($response);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>