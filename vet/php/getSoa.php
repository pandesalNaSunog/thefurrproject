<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']){
        include('connection.php');
        $con = connect();
        if(isset($_POST)){
            $soaNumber = $_POST['soa_number'];

            $query = "SELECT * FROM statement_of_accounts WHERE soa_number = '$soaNumber'";
            $soa = $con->query($query) or die($con->error);
            $response = array();
            $soaRow = $soa->fetch_assoc();
            $totalAmount = 0.0;
            $details = $soaRow['details'];
            $soaId = $soaRow['id'];

            
            $detailsArray = explode("**", $details);

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
            echo json_encode(
                array(
                    'details' => $response,
                    'total' => $totalAmount,
                    'balance' => $balance
                )
            );
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>