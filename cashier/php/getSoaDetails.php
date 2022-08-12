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


                    $response[] = array(
                        'service' => $service,
                        'base_price' => $basePrice,
                        'amount' => $amount,
                        'quantity' => $quantity,
                        'discounted' => $discounted,
                        'discount' => $discount
                    );
                }
            }

            echo json_encode($response);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>