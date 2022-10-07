<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();

        if(isset($_POST)){
            $keyword = htmlspecialchars($_POST['keyword']);
            $query = "SELECT * FROM statement_of_accounts WHERE soa_number LIKE '%$keyword%' ORDER BY created_at DESC";
            $soa = $con->query($query) or die($con->error);
            $soas = array();
            while($soaRow = $soa->fetch_assoc()){
                $soaId = $soaRow['id'];

                $soadetails = $soaRow['details'];
    
                $detailsArray = explode("**", $soadetails);
                $totalAmount = 0;
                foreach($detailsArray as $details){
                    if($details != ""){
                        $detailsBreakdown = explode("*", $details);
    
                        $service = $detailsBreakdown[0];
                        $basePrice = $detailsBreakdown[2];
                        $discountedPrice = $detailsBreakdown[3];
                        $quantity = $detailsBreakdown[4];
                        $discountRate = $detailsBreakdown[5];
                        $totalAmount += $discountedPrice * $quantity;
                        $response[] = array(
                            'service' => $service,
                            'base_price' => $basePrice,
                            'discounted_price' => $discountedPrice,
                            'quantity' => $quantity,
                            'discount_rate' => $discountRate
                        );
                    }
                }
                $query = "SELECT * FROM payments WHERE soa_id = '$soaId' ORDER BY created_at DESC";
                $payment = $con->query($query) or die($con->error);
                if($paymentRow = $payment->fetch_assoc()){
                    $balance = $paymentRow['balance'];
                }else{
                    $balance = $totalAmount;
                }
    
                $petId = $soaRow['pet_id'];
    
                $query = "SELECT * FROM pets WHERE id = '$petId'";
                $pet = $con->query($query) or die($con->error);
                $petRow = $pet->fetch_assoc();
    
                $clientId = $petRow['user_id'];
    
                $query = "SELECT * FROM users WHERE id = '$clientId'";
                $user = $con->query($query) or die($con->error);
                $userRow = $user->fetch_assoc();
                $clientName = $userRow['name'];
    
    
                $soaNumber = $soaRow['soa_number'];
                $date = date_format(date_create($soaRow['created_at']), "M d, Y h:i A");
                $soas[] = array(
                    'id' => $soaRow['id'],
                    'client_name' => $clientName,
                    'patient_name' => $petRow['name'],
                    'soa_number' => $soaNumber,
                    'balance' => $balance,
                    'date' => $date
                );
                // $petId = $soaRow['pet_id'];
    
                // $query = "SELECT * FROM pets WHERE id = '$petId'";
                // $pet = $con->query($query) or die($con->error);
                // $petRow = $pet->fetch_assoc();
    
                // $clientId = $petRow['user_id'];
    
                // $query = "SELECT * FROM users WHERE id = '$clientId'";
                // $user = $con->query($query) or die($con->error);
                // $userRow = $user->fetch_assoc();
                // $clientName = $userRow['name'];
    
    
                // $soaNumber = $soaRow['soa_number'];
                // $date = date_format(date_create($soaRow['created_at']), "M d, Y h:i A");
                // $soas[] = array(
                //     'id' => $soaRow['id'],
                //     'client_name' => $clientName,
                //     'patient_name' => $petRow['name'],
                //     'soa_number' => $soaNumber,
                //     'date' => $date
                // );
            }
            echo json_encode($soas);
        }
        
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>