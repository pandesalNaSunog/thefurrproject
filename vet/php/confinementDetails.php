<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        if(isset($_POST)){
            $response = array();
            $confinementId = $_POST['confinement_id'];
            $query = "SELECT * FROM confinements WHERE id = '$confinementId'";
            $confinement = $con->query($query) or die($con->error);
            while($confinementRow = $confinement->fetch_assoc()){
                $petId = $confinementRow['pet_id'];
                $query = "SELECT * FROM pets WHERE id = '$petId'";
                $pet = $con->query($query) or die($con->error);
                $petRow = $pet->fetch_assoc();
                $userId = $petRow['user_id'];

                $query = "SELECT * FROM users WHERE id = '$userId'";
                $user = $con->query($query) or die($con->error);
                $userRow = $user->fetch_assoc();

                $clientName = $userRow['name'];
                $contactNo = $userRow['contact_no'];
                $clientCode = $userRow['client_code'];
                $petName = $petRow['name'];
                $species = $petRow['species'];
                $breed = $petRow['breed'];

                if($petRow['birth_date'] == "0000-00-00"){
                    $dateOfBirth = "N/A";
                }else{
                    $dateOfBirth = $petRow['birth_date'];
                }

                $sex = $petRow['sex'];
                $typeOfFluid = $confinementRow['type_of_fluid'];
                $dripRate = $confinementRow['drip_rate'];
                $temp = $confinementRow['temp_def_diagnosis'];
                $duration = $confinementRow['duration_of_fluid_per_day'];
                $query = "SELECT * FROM confinement_records WHERE confinement_id = '$confinementId'";
                $records = $con->query($query) or die($con->error);
                $status = array();
                while($confinementRecordsRow = $records->fetch_assoc()){
                    $status[] = array(
                        'status' => $confinementRecordsRow['status'],
                        'date' => date_format(date_create($confinementRecordsRow['created_at']), "M d, Y")
                    );
                }
            }

            

            $response = array(
                'client_name' => $clientName,
                'contact_no' => $contactNo,
                'client_code' => $clientCode,
                'pet_name' => $petName,
                'species' => $species,
                'breed' => $breed,
                'date_of_birth' => $dateOfBirth,
                'sex' => $sex,
                'type_of_fluid' => $typeOfFluid,
                'drip_rate' => $dripRate,
                'temp_def_diagnosis' => $temp,
                'duration' => $duration,
                'status' => $status
            );

            echo json_encode($response);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>