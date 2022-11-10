<?php
    include('connection.php');

    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        $con = connect();
        $confinementId = $_POST['confinement_id'];
        $query = "SELECT * FROM confinements WHERE id = '$confinementId'";
        $confinement = $con->query($query) or die($con->error);
        $confinementRow = $confinement->fetch_assoc();
        $typeOfFluid = $confinementRow['type_of_fluid'];
        $diagnosis = $confinementRow['diagnosis'];
        $dripRate = $confinementRow['drip_rate'];
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
                'price' => $icuRow['price'],
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
                'price' => $infusionPumpRow['price'],
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
                'price' => $syringePumpRow['price'],
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
                'price' => $confinementRecordRow['price'],
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
                'price' => $antibioticRow['price'],
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
                'price' => $vitaminRow['price'],
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
                'price' => $specialMedicineRow['price'],
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
                'price' => $otherMedicineRow['price'],
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
                'price' => $laboratoryRow['price'],
                'date' => date_format(date_create($laboratoryRow['created_at']), 'M d, Y h:i A')
            );
        }

        //food
        $query = "SELECT * FROM food WHERE confinement_id = '$confinementId'";
        $foods = array();

        $food = $con->query($query) or die($con->error);
        while($foodRow = $food->fetch_assoc()){
            $foods[] = array(
                'id' => $foodRow['id'],
                'price' => $foodRow['price'],
                'date' => date_format(date_create($foodRow['created_at']), 'M d, Y h:i A')
            );
        }

        //iv canulla
        $query = "SELECT * FROM i_v_canullas WHERE confinement_id = '$confinementId'";
        $ivCanullas = array();

        $ivCanulla = $con->query($query) or die($con->error);
        while($ivCanullaRow = $ivCanulla->fetch_assoc()){
            $ivCanullas[] = array(
                'id' => $ivCanullaRow['id'],
                'price' => $ivCanullaRow['price'],
                'date' => date_format(date_create($ivCanullaRow['created_at']), 'M d, Y h:i A')
            );
        }


        $query = "SELECT * FROM i_v_lines WHERE confinement_id = '$confinementId'";
        $ivLines = array();

        $ivLine = $con->query($query) or die($con->error);
        while($ivLineRow = $ivLine->fetch_assoc()){
            $ivLines[] = array(
                'id' => $ivLineRow['id'],
                'price' => $ivLineRow['price'],
                'date' => date_format(date_create($ivLineRow['created_at']), 'M d, Y h:i A')
            );
        }

        $query = "SELECT * FROM i_v_fluids WHERE confinement_id = '$confinementId'";
        $ivFluids = array();

        $ivFluid = $con->query($query) or die($con->error);
        while($ivFLuidRow = $ivFluid->fetch_assoc()){
            $ivFluids[] = array(
                'id' => $ivFLuidRow['id'],
                'price' => $ivFLuidRow['price'],
                'date' => date_format(date_create($ivFLuidRow['created_at']), 'M d, Y h:i A')
            );
        }

        $query = "SELECT * FROM underpads WHERE confinement_id = '$confinementId'";
        $underpads = array();

        $underpad = $con->query($query) or die($con->error);
        while($underpadRow = $underpad->fetch_assoc()){
            $underpads[] = array(
                'id' => $underpadRow['id'],
                'price' => $underpadRow['price'],
                'date' => date_format(date_create($underpadRow['created_at']), 'M d, Y h:i A')
            );
        }

        $query = "SELECT * FROM nebulizations WHERE confinement_id = '$confinementId'";
        $nebulizations = array();

        $nebulization = $con->query($query) or die($con->error);
        while($nebulizationRow = $nebulization->fetch_assoc()){
            $nebulizations[] = array(
                'id' => $nebulizationRow['id'],
                'price' => $nebulizationRow['price'],
                'date' => date_format(date_create($nebulizationRow['created_at']), 'M d, Y h:i A')
            );
        }

        $query = "SELECT * FROM laser_therapies WHERE confinement_id = '$confinementId'";
        $lasers = array();

        $laser = $con->query($query) or die($con->error);
        while($laserRow = $laser->fetch_assoc()){
            $lasers[] = array(
                'id' => $laserRow['id'],
                'price' => $laserRow['price'],
                'date' => date_format(date_create($laserRow['created_at']), 'M d, Y h:i A')
            );
        }

        $query = "SELECT * FROM oxygens WHERE confinement_id = '$confinementId'";
        $oxygens = array();

        $oxygen = $con->query($query) or die($con->error);
        while($oxygenRow = $oxygen->fetch_assoc()){
            $oxygens[] = array(
                'id' => $oxygenRow['id'],
                'price' => $oxygenRow['price'],
                'hours' => $oxygenRow['hours'],
                'date' => date_format(date_create($oxygenRow['created_at']), 'M d, Y h:i A')
            );
        }

        $query = "SELECT * FROM treatment_plans WHERE confinement_id = '$confinementId'";
        $treatmentPlan = array();

        $treatment = $con->query($query) or die($con->error);
        while($treatmentRow = $treatment->fetch_assoc()){
            $treatmentPlan[] = $treatmentRow;
        }






        $response = array(
            'id' => $confinementRow['id'],
            'pet_name' => $petName,
            'pet_weight' => $petWeight,
            'client_name' => $clientName,
            'attending_vet' => $doctorName,
            'icus' => $icus,
            'type_of_fluid' => $typeOfFluid,
            'diagnosis' => $diagnosis,
            'drip_rate' => $dripRate,
            'confinement_records' => $confinementRecords,
            'infusion_pumps' => $infusionPumps,
            'syringe_pumps' => $syringePumps,
            'antibiotics' => $antibiotics,
            'vitamins' => $vitamins,
            'special_medicines' => $specialMedicines,
            'other_medicines' => $otherMedicines,
            'laboratories' => $laboratories,
            'food' => $foods,
            'iv_canullas' => $ivCanullas,
            'iv_lines' => $ivLines,
            'iv_fluids' => $ivFluids,
            'underpads' => $underpads,
            'nebulizations' => $nebulizations,
            'laser_therapies' => $lasers,
            'oxygens' => $oxygens,
            'treatment_plan' => $treatmentPlan,
            'date' => $date
        );

        echo json_encode($response);
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>