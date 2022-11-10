<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();

        if(isset($_SESSION['doctor_id'])){
            $doctorId = $_SESSION['doctor_id'];
            include('connection.php');
            $con = connect();
            $query = "SELECT * FROM confinements WHERE doctor_id = '$doctorId'";
            $confined = $con->query($query) or die($con->error);
            $confinedPets = array();
            while($confinedRow = $confined->fetch_assoc()){
                $petId = $confinedRow['pet_id'];
                $query = "SELECT name,id FROM pets WHERE id = '$petId'";
                $pet = $con->query($query) or die($con->error);
                $petRow = $pet->fetch_assoc();
                $confinementId = $confinedRow['id'];
                $query = "SELECT * FROM confinement_endorsements WHERE confinement_id = '$confinementId'";
                $endorsement = $con->query($query) or die($con->error);
                if($endorsementRow = $endorsement->fetch_assoc()){
                    $endorsementDoctorId = $endorsementRow['doctor_id'];
                    $query = "SELECT * FROM users WHERE id = '$endorsementDoctorId' AND user_type = 'doctor'";
                    $doctorQuery = $con->query($query) or die($con->error);
                    $doctorRow = $doctorQuery->fetch_assoc();
                    $endorsedTo = $doctorRow['name'];
                }else{
                    $endorsedTo = "None";
                }


                $confinedPets[] = array(
                    'name' => $petRow['name'],
                    'id' => $confinedRow['id'],
                    'endorsed_to' => $endorsedTo
                );
            }


            $query = "SELECT * FROM confinement_endorsements WHERE doctor_id = '$doctorId'";
            $endorsementQuery = $con->query($query) or die($con->error);
            $endorsements = array();
            while($endorsementRowTwo = $endorsementQuery->fetch_assoc()){
                $confinementId = $endorsementRowTwo['confinement_id'];
                $query = "SELECT * FROM confinements WHERE id = '$confinementId'";
                $confinementQuery = $con->query($query) or die($con->error);
                $confinementRow = $confinementQuery->fetch_assoc();

                $petId = $confinementRow['pet_id'];
                $query = "SELECT * FROM pets WHERE id = '$petId'";
                $petQuery = $con->query($query) or die($con->error);
                $petRow = $petQuery->fetch_assoc();
                $petName = $petRow['name'];

                $doctorId = $endorsementRowTwo['endorser_id'];
                $query = "SELECT name FROM users WHERE id = '$doctorId'";
                $doctorQuery = $con->query($query) or die($con->error);
                $doctorRow = $doctorQuery->fetch_assoc();
                $doctorName = $doctorRow['name'];
                $endorsements[] = array(
                    'name' => $petName,
                    'endorsed_by' => $doctorName,
                    'id' => $endorsementRowTwo['id']
                );
            }


            $response = array(
                'confined_pets' => $confinedPets,
                'endorsements' => $endorsements
            );
            echo json_encode($response);
        }else{
            echo 'invalid';
        }
        
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>