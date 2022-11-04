<?php

    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $query = "SELECT * FROM confinement_soas";
        $confinementSoa = $con->query($query) or die($con->error);
        $response = array();
        while($confinementSoaRow = $confinementSoa->fetch_assoc()){
            $confinementSoaId = $confinementSoaRow['id'];
            $confinementId = $confinementSoaRow['confinement_id'];
            $query = "SELECT * FROM confinements WHERE id = '$confinementId'";
            $confinement = $con->query($query) or die($con->error);
            $confinementRow = $confinement->fetch_assoc();
            $petId = $confinementRow['pet_id'];

            $query = "SELECT * FROM pets WHERE id = '$petId'";
            $pet = $con->query($query) or die($con->error);
            $petRow = $pet->fetch_assoc();
            $clientId = $petRow['user_id'];

            $query = "SELECT * FROM users WHERE id = '$clientId'";
            $user = $con->query($query) or die($con->error);
            $userRow = $user->fetch_assoc();
            $clientName = $userRow['name'];
            $petName = $petRow['name'];
            $soaNumber = $confinementSoaRow['soa_number'];
            $date = date_format(date_create($confinementSoaRow['created_at']), 'M d, Y h:i A');


            $query = "SELECT * FROM confinement_payments WHERE confinement_soa_id = '$confinementSoaId' ORDER BY created_at DESC";
            $payment = $con->query($query) or die($con->error);
            if($paymentRow = $payment->fetch_assoc()){
                $balance = $paymentRow['balance'];
            }else{
                
                $query = "SELECT * FROM confinements WHERE id = '$confinementId'";
                $confinement = $con->query($query) or die($con->error);
                $confinementRow = $confinement->fetch_assoc();
                //icus

                $query = "SELECT * FROM icus WHERE confinement_id = '$confinementId'";
                $icus = array();

                $total = 0;
                $icu = $con->query($query) or die($con->error);
                while($icuRow = $icu->fetch_assoc()){
                    $total += $icuRow['price'];
                }
                //infusion pumps
                $query = "SELECT * FROM infusion_pumps WHERE confinement_id = '$confinementId'";
                $infusionPumps = array();

                $infusionPump = $con->query($query) or die($con->error);
                while($infusionPumpRow = $infusionPump->fetch_assoc()){
                    $total += $infusionPumpRow['price'];
                }
                //syringe pumps
                $query = "SELECT * FROM syringe_pumps WHERE confinement_id = '$confinementId'";
                $syringePumps = array();

                $syringePump = $con->query($query) or die($con->error);
                while($syringePumpRow = $syringePump->fetch_assoc()){
                    $total += $syringePumpRow['price'];
                }

                //confinement records
                $query = "SELECT * FROM confinement_records WHERE confinement_id = '$confinementId'";
                $confinementRecords = array();

                $confinementRecord = $con->query($query) or die($con->error);
                while($confinementRecordRow = $confinementRecord->fetch_assoc()){
                    $total += $confinementRecordRow['price'];
                }

                //antibiotics
                $query = "SELECT * FROM antibiotics WHERE confinement_id = '$confinementId'";
                $antibiotics = array();

                $antibiotic = $con->query($query) or die($con->error);
                while($antibioticRow = $antibiotic->fetch_assoc()){
                    $total += $antibioticRow['price'];
                }

                //antibiotics
                $query = "SELECT * FROM vitamins WHERE confinement_id = '$confinementId'";
                $vitamins = array();

                $vitamin = $con->query($query) or die($con->error);
                while($vitaminRow = $vitamin->fetch_assoc()){
                    $total += $vitaminRow['price'];
                }

                //special medicines
                $query = "SELECT * FROM special_medicines WHERE confinement_id = '$confinementId'";
                $specialMedicines = array();

                $specialMedicine = $con->query($query) or die($con->error);
                while($specialMedicineRow = $specialMedicine->fetch_assoc()){
                    $total += $specialMedicineRow['price'];
                }

                //special medicines
                $query = "SELECT * FROM other_medicines WHERE confinement_id = '$confinementId'";
                $otherMedicines = array();

                $otherMedicine = $con->query($query) or die($con->error);
                while($otherMedicineRow = $otherMedicine->fetch_assoc()){
                    $total += $otherMedicineRow['price'];
                }

                //laboratories
                $query = "SELECT * FROM confinement_lab_requests WHERE confinement_id = '$confinementId'";
                $laboratories = array();

                $laboratory = $con->query($query) or die($con->error);
                while($laboratoryRow = $laboratory->fetch_assoc()){
                    $total += $laboratoryRow['price'];
                }

                //food
                $query = "SELECT * FROM food WHERE confinement_id = '$confinementId'";
                $foods = array();

                $food = $con->query($query) or die($con->error);
                while($foodRow = $food->fetch_assoc()){
                    $total += $foodRow['price'];
                }

                //iv canulla
                $query = "SELECT * FROM i_v_canullas WHERE confinement_id = '$confinementId'";
                $ivCanullas = array();

                $ivCanulla = $con->query($query) or die($con->error);
                while($ivCanullaRow = $ivCanulla->fetch_assoc()){
                    $total += $ivCanullaRow['price'];
                }


                $query = "SELECT * FROM i_v_lines WHERE confinement_id = '$confinementId'";
                $ivLines = array();

                $ivLine = $con->query($query) or die($con->error);
                while($ivLineRow = $ivLine->fetch_assoc()){
                    $total += $ivLineRow['price'];
                }

                $query = "SELECT * FROM i_v_fluids WHERE confinement_id = '$confinementId'";
                $ivFluids = array();

                $ivFluid = $con->query($query) or die($con->error);
                while($ivFLuidRow = $ivFluid->fetch_assoc()){
                    $total += $ivFLuidRow['price'];
                }

                $query = "SELECT * FROM underpads WHERE confinement_id = '$confinementId'";
                $underpads = array();

                $underpad = $con->query($query) or die($con->error);
                while($underpadRow = $underpad->fetch_assoc()){
                    $total += $underpadRow['price'];
                }

                $query = "SELECT * FROM nebulizations WHERE confinement_id = '$confinementId'";
                $nebulizations = array();

                $nebulization = $con->query($query) or die($con->error);
                while($nebulizationRow = $nebulization->fetch_assoc()){
                    $total += $nebulizationRow['price'];
                }

                $query = "SELECT * FROM laser_therapies WHERE confinement_id = '$confinementId'";
                $lasers = array();

                $laser = $con->query($query) or die($con->error);
                while($laserRow = $laser->fetch_assoc()){
                    $total += $laserRow['price'];
                }

                $query = "SELECT * FROM oxygens WHERE confinement_id = '$confinementId'";
                $oxygens = array();

                $oxygen = $con->query($query) or die($con->error);
                while($oxygenRow = $oxygen->fetch_assoc()){
                    $total += $oxygenRow['price'];
                }
                

                $balance = $total;
            }
        }

        echo json_encode(
            array(
                'client_name' => $clientName,
                'pet_name' => $petName,
                'soa_number' => $soaNumber,
                'date' => $date,
                'balance' => $balance,
            )
        );
            
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
    

?>