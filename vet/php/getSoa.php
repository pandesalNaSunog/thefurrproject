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

            $details = $soaRow['details'];

            $detailsArray = explode("**", $details);

            foreach($detailsArray as $details){
                if($details != ""){
                    $detailsBreakdown = explode("*", $details);

                    $service = $detailsBreakdown[0];
                    $basePrice = $detailsBreakdown[2];
                    $discountedPrice = $detailsBreakdown[3];
                    $quantity = $detailsBreakdown[4];
                    $discountRate = $detailsBreakdown[5];

                    $response[] = array(
                        'service' => $service,
                        'base_price' => $basePrice,
                        'discounted_price' => $discountedPrice,
                        'quantity' => $quantity,
                        'discount_rate' => $discountRate
                    );
                }
            }
            echo json_encode($response);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>