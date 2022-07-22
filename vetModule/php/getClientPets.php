<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_SESSION['doctor_id'])){
            $clientId = $_POST['client_id'];

            $query = "SELECT * FROM pets WHERE user_id = '$clientId'";
            $pets = array();
            $pet = $con->query($query) or die($con->error);
            while($row = $pet->fetch_assoc()){
                $name = $row['name'];
                $breed = $row['breed'];
                $species = $row['species'];
                $sex = $row['sex'];

                $todayObject = date_create($today);
                $birthDateObject = date_create($row['birth_date']);

                $dateDiff = date_diff($todayObject, $birthDateObject);
                $age = $dateDiff->format("%y Year(s) %m Month(s)");

                $pets[] = array(
                    'name' => $name,
                    'breed' => $breed,
                    'species' => $species,
                    'sex' => $sex,
                    'age' => $age
                );
            }

            echo json_encode($pets);
           
        }else{
            echo 'invalid';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>