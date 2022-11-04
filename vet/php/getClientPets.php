<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_SESSION['doctor_id'])){
            $clientId = $_POST['client_id'];


            $query = "SELECT * FROM users WHERE id = '$clientId'";
            $client = $con->query($query) or die($con->error);
            $clientRow = $client->fetch_assoc();
            $clientName = $clientRow['name'];
            $clientCode = $clientRow['client_code'];
            $query = "SELECT * FROM pets WHERE user_id = '$clientId'";
            $pets = array();
            $pet = $con->query($query) or die($con->error);
            while($row = $pet->fetch_assoc()){
                if($row['birth_date'] == '0000-00-00'){
                    $age = "N/A";
                }else{
                    $todayObject = date_create($today);
                    $birthDateObject = date_create($row['birth_date']);
    
                    $dateDiff = date_diff($todayObject, $birthDateObject);
                    $age = $dateDiff->format("%y Year(s) %m Month(s)");
                }
                $name = $row['name'];
                $breed = $row['breed'];
                $species = $row['species'];
                $sex = $row['sex'];

                

                $pets[] = array(
                    'pet_id' => $row['id'],
                    'name' => $name,
                    'breed' => $breed,
                    'species' => $species,
                    'sex' => $sex,
                    'age' => $age
                );
            }

            echo json_encode(
                array(
                    'pets' => $pets,
                    'client_name' => $clientName,
                    'client_code' => $clientCode,
                )
            );
           
        }else{
            echo 'invalid';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>