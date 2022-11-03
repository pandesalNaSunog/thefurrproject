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
            $infusionPumps[] = array(
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

        //confinement records
        $query = "SELECT * FROM confinement_records WHERE confinement_id = '$confinementId'";
        $confinementRecords = array();

        $confinementRecord = $con->query($query) or die($con->error);
        while($confinementRecordRow = $confinementRecord->fetch_assoc()){
            $confinementRecords[] = array(
                'id' => $confinementRecordRow['id'],
                'date' => date_format(date_create($confinementRecordRow['created_at']), 'M d, Y h:i A')
            );
        }

        //antibiotics
        $query = "SELECT * FROM antibiotics WHERE confinement_id = '$confinementId'";
        $antibiotics = array();

        $antibiotic = $con->query($query) or die($con->error);
        while($antibioticRow = $antibiotic->fetch_assoc()){
            $antibiotics[] = array(
                'id' => $antibioticRow['id'],
                'antibiotic' => $antibioticRow['antibiotic'],
                'date' => date_format(date_create($antibioticRow['created_at']), 'M d, Y h:i A')
            );
        }

        //antibiotics
        $query = "SELECT * FROM vitamins WHERE confinement_id = '$confinementId'";
        $vitamins = array();

        $vitamin = $con->query($query) or die($con->error);
        while($vitaminRow = $vitamin->fetch_assoc()){
            $vitamins[] = array(
                'id' => $vitaminRow['id'],
                'vitamins' => $vitaminRow['vitamin'],
                'date' => date_format(date_create($vitaminRow['created_at']), 'M d, Y h:i A')
            );
        }

        //special medicines
        $query = "SELECT * FROM special_medicines WHERE confinement_id = '$confinementId'";
        $specialMedicines = array();

        $specialMedicine = $con->query($query) or die($con->error);
        while($specialMedicineRow = $specialMedicine->fetch_assoc()){
            $specialMedicines[] = array(
                'id' => $specialMedicineRow['id'],
                'special_medicine' => $specialMedicineRow['special_medicine'],
                'date' => date_format(date_create($specialMedicineRow['created_at']), 'M d, Y h:i A')
            );
        }

        //special medicines
        $query = "SELECT * FROM other_medicines WHERE confinement_id = '$confinementId'";
        $otherMedicines = array();

        $otherMedicine = $con->query($query) or die($con->error);
        while($otherMedicineRow = $otherMedicine->fetch_assoc()){
            $otherMedicines[] = array(
                'id' => $otherMedicineRow['id'],
                'other_medicine' => $otherMedicineRow['other_medicine'],
                'date' => date_format(date_create($otherMedicineRow['created_at']), 'M d, Y h:i A')
            );
        }

        //laboratories
        $query = "SELECT * FROM confinement_lab_requests WHERE confinement_id = '$confinementId'";
        $laboratories = array();

        $laboratory = $con->query($query) or die($con->error);
        while($laboratoryRow = $laboratory->fetch_assoc()){
            $laboratories[] = array(
                'id' => $laboratoryRow['id'],
                'laboratory' => $laboratoryRow['laboratory'],
                'date' => date_format(date_create($laboratoryRow['created_at']), 'M d, Y h:i A')
            );
        }






        $response = array(
            'id' => $confinementRow['id'],
            'pet_name' => $petName,
            'pet_weight' => $petWeight,
            'client_name' => $clientName,
            'attending_vet' => $doctorName,
            'icus' => $icus,
            'confinement_records' => $confinementRecords,
            'infusion_pumps' => $infusionPumps,
            'syringe_pumps' => $syringePumps,
            'antibiotics' => $antibiotics,
            'vitamins' => $vitamins,
            'special_medicines' => $specialMedicines,
            'other_medicines' => $otherMedicines,
            'laboratories' => $laboratories,
            'date' => $date
        );

        echo json_encode($response);
    }else{
        error();
    }
?>