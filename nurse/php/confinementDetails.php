<?php
    include('connection.php');

    if(isSecure()){
        $con = connect();
        $confinementId = $_POST['confinement_id'];
        $query = "SELECT * FROM confinements WHERE id = '$confinementId'";
        $confinement = $con->query($query) or die($con->error);
        $confinementRow = $confinement->fetch_assoc();

        //patient details
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

        //icus

        $query = "SELECT * FROM icus WHERE confinement_id = '$confinementId'";
        $icus = array();

        $icu = $con->query($query) or die($con->error);
        while($icuRow = $icu->fetch_assoc()){
            $icus[] = array(
                'id' => $icuRow['id'],
                'date' => date_format(date_create($icuRow['created_at']), 'M d, Y h:i A')
            );
        }
        //infusion pumps
        $query = "SELECT * FROM infusion_pumps WHERE confinement_id = '$confinementId'";
        $infusionPumps = array();

        $infusionPump = $con->query($query) or die($con->error);
        while($infusionPumpRow = $infusionPump->fetch_assoc()){
            $infusionPUmps[] = array(
                'id' => $infusionPumpRow['id'],
                'date' => date_format(date_create($infusionPumpRow['created_at']), 'M d, Y h:i A')
            );
        }
        //syringe pumps
        $query = "SELECT * FROM syringe_pumps WHERE confinement_id = '$confinementId'";
        $syringePumps = array();

        $syringePump = $con->query($query) or die($con->error);
        while($syringePumpRow = $syringePump->fetch_assoc()){
            $syringePumps[] = array(
                'id' => $syringePumpRow['id'],
                'date' => date_format(date_create($syringePumpRow['created_at']), 'M d, Y h:i A')
            );
        }





        $response = array(
            'id' => $confinementRow['id'],
            'pet_name' => $petName,
            'pet_weight' => $petWeight,
            'client_name' => $clientName,
            'attending_vet' => $doctorName,
            'icus' => $icus,
            'date' => $date
        );

        echo json_encode($response);
    }else{
        error();
    }
?>