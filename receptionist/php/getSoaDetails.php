<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');

        $con = connect();
        if(isset($_POST)){
            $soaId = $_POST['soa_id'];

            $query = "SELECT * FROM statement_of_accounts WHERE id = '$soaId'";
            $soa = $con->query($query) or die($con->error);
            $soaRow = $soa->fetch_assoc();
            $response = array();
            
            $petId = $soaRow['pet_id'];
            $query = "SELECT * FROM pets WHERE id = '$petId'";
            $pet = $con->query($query) or die($con->error);
            $petRow = $pet->fetch_assoc();

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

            echo json_encode(
                array(
                    'soa' => $statementOfAccounts,
                    'client_name' => $clientName,
                    'patient_name' => $petName,
                    'client_code' => $clientCode,
                    'total_amount' => $totalAmount
                )
            );
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>