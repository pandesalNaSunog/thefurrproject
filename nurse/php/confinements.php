<?php
    include('connection.php');
    
    if(isSecure()){
        $con = connect();
        $query = "SELECT * FROM confinements";
        $confinement = $con->query($query) or die($con->error);
        $response = array();
        while($confinementRow = $confinement->fetch_assoc()){
            $petId = $confinementRow['pet_id'];
            $doctorId = $confinementRow['doctor_id'];


            $query = "SELECT * FROM pets WHERE id = '$petId'";
            $pet = $con->query($query) or die($con->error);
            $petRow = $pet->fetch_assoc();

            $petName = $petRow['name'];
            $petWeight = $confinementRow['pet_weight'];
            $clientId = $petRow['user_id'];
            $query = "SELECT name FROM users WHERE id = '$clientId'";
            $client = $con->query($query) or die($con->error);

            $clientRow = $client->fetch_assoc();
            $clientName = $clientRow['name'];

            $query = "SELECT name FROM users WHERE id = '$doctorId'";
            $doctor = $con->query($query) or die($con->error);
            $doctorRow = $doctor->fetch_assoc();
            $doctorName = $doctorRow['name'];

            $date = date_format(date_create($confinementRow['created_at']), 'M d, Y h:i A');

            $response[] = array(
                'id' => $confinementRow['id'],
                'pet_name' => $petName,
                'pet_weight' => $petWeight,
                'client_name' => $clientName,
                'attending_vet' => $doctorName,
                'date' => $date
            );
        }
        echo json_encode($response);
    }else{
        error();
    }
?>