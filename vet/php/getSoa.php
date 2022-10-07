<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');

        $con = connect();
        if(isset($_POST)){
            $soaNumber = $_POST['soa_number'];

            $query = "SELECT * FROM statement_of_accounts WHERE soa_number = '$soaNumber'";
            $soa = $con->query($query) or die($con->error);
            $soaRow = $soa->fetch_assoc();
            $soaId = $soaRow['id'];
            $response = array();
            
            $petId = $soaRow['pet_id'];
            $query = "SELECT * FROM pets WHERE id = '$petId'";
            $pet = $con->query($query) or die($con->error);
            $petRow = $pet->fetch_assoc();
            $doctorName = "";

            $query = "SELECT medication, doctor_id FROM medical_records WHERE pet_id = '$petId' ORDER BY id DESC";
            $medRecord = $con->query($query) or die($con->error);
            if($medRow = $medRecord->fetch_assoc()){
                $doctorId = $medRow['doctor_id'];
                $query = "SELECT name FROM users WHERE id = '$doctorId'";
                $doctor = $con->query($query) or die($con->error);
                $doctorRow = $doctor->fetch_assoc();

                $doctorName = $doctorRow['name'];
                if($medRow['medication'] != ""){
                    $medication = $medRow['medication'];

                }else{
                    $medication = "NONE";
                }
                
            }else{
                $medication = "NONE";
            }


            $userId = $petRow['user_id'];
            $query = "SELECT * FROM users WHERE id = '$userId'";
            $user = $con->query($query) or die($con->error);
            $userRow = $user->fetch_assoc();
            $clientName = $userRow['name'];
            $clientCode = $userRow['client_code'];
            $petName = $petRow['name'];
            $statementOfAccounts = array();
            $totalAmount = 0;
            
            $soaDetails = $soaRow['details'];

            $soaDetailsArray = explode("**", $soaDetails);

            foreach($soaDetailsArray as $soaDetailsItem){
                if($soaDetailsItem != ""){
                    $soaDetailsBreakdown = explode("*", $soaDetailsItem);

                    $service = $soaDetailsBreakdown[0];
                    $basePrice = $soaDetailsBreakdown[2];
                    $amount = $soaDetailsBreakdown[2] * $soaDetailsBreakdown[4];
                    $quantity = $soaDetailsBreakdown[4];
                    $discounted = $soaDetailsBreakdown[3];
                    $discount = $soaDetailsBreakdown[5];

                    $totalAmount += $discounted;


                    $statementOfAccounts[] = array(
                        'service' => $service,
                        'base_price' => $basePrice,
                        'amount' => $amount,
                        'quantity' => $quantity,
                        'discounted' => $discounted,
                        'discount' => $discount
                    );
                }
            }

            $query = "SELECT amount_renderred, balance FROM payments WHERE soa_id = '$soaId' ORDER BY created_at DESC";
            $payment = $con->query($query) or die($con->error);
            $paymentHistory = array();
            while($paymentRow = $payment->fetch_assoc()){
                
                $paymentHistory[] = $paymentRow;
            }
            
            

            echo json_encode(
                array(
                    'soa' => $statementOfAccounts,
                    'payments_history' => $paymentHistory,
                    'client_name' => $clientName,
                    'patient_name' => $petName,
                    'client_code' => $clientCode,
                    'total_amount' => $totalAmount,
                    'medication' => $medication,
                    'attending_vet' => $doctorName
                )
            );
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>