<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']){
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_POST)){
            $soaId = $_POST['soa_id'];
            $amount = $_POST['amount'];

            $totalAmount = 0;

            $query = "SELECT * FROM payments WHERE soa_id = '$soaId' ORDER BY created_at DESC";
            $payment = $con->query($query) or die($con->error);
            if($paymentRow = $payment->fetch_assoc()){
                $balance = $paymentRow['balance'];
                $totalAmount = $balance;
            }else{
                $balance = 0;
                $query = "SELECT * FROM statement_of_accounts WHERE id = '$soaId'";
                $soaQuery = $con->query($query) or die($con->error);
                $soaRow = $soaQuery->fetch_assoc();

                $soaDetails = $soaRow['details'];

                $soaDetailsArray = explode("**", $soaDetails);

                foreach($soaDetailsArray as $soaDetailsItem){
                    if($soaDetailsItem != ""){
                        $soaDetailsBreakdown = explode("*", $soaDetailsItem);
                        $discounted = $soaDetailsBreakdown[3];
                        $totalAmount += $discounted;
                    }
                }
            }
           

            


            $change = $amount - $totalAmount;


            if($change > 0){
                $balance = 0;
            }else if($change < 0){
                $balance = $change * -1;
                $change = 0;
            }else{
                $balance = 0;
                $change = 0;
            }

            $query = "INSERT INTO payments(`soa_id`,`amount_renderred`,`change_renderred`,`balance`,`created_at`,`updated_at`)VALUES('$soaId','$amount','$change','$balance','$today','$today')";
            $con->query($query) or die($con->error);

            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>