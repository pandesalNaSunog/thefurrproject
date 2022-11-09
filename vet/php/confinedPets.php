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
                $confinedPets[] = array(
                    'name' => $petRow['name'],
                    'id' => $confinedRow['id']
                );
            }
            echo json_encode($confinedPets);
        }else{
            echo 'invalid';
        }
        
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>