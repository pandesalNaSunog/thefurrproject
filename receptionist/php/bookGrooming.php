<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $con = connect();

        $today = getCurrentDate();

        if(isset($_POST)){

            $userId = $_POST['user_id'];
            $petIds = $_POST['pet_ids'];
            $weight = $_POST['weight'];
            $price = $_POST['price'];
            $petIdString = "";

            $doctorIdString = "";
            
            foreach($petIds as $key => $petId){
                $thisWeight = $weight[$key];
                if($thisWeight == ""){
                    $thisWeight = "NOT INDICATED";
                }
                if($key == 0){
                    $petIdString .= $petId;
                    $doctorIdString .= "0";
                }else{
                    $petIdString .= "**".$petId;
                    $doctorIdString .= "**0";
                }
                $query = "INSERT INTO wellness_records(`pet_id`,`doctor_id`,`service`,`remarks`,`date`,`next_appointment`,`created_at`,`updated_at`,`pet_weight`)VALUES('$petId',0,'GROOMING','GROOMING','$date','$date','$today','$today','$thisWeight')";
                $con->query($query) or die($con->error);

                $thisSoaDetails = "grooming*grooming*".$price."*".$price."*1*0";

                $query = "INSERT INTO statement_of_accounts(`pet_id`,`doctor_id`,`details`,`created_at`,`updated_at`)VALUES('$petId',0,'$thisSoaDetails','$today','$today')";
                $con->query($query) or die($con->error);

                $query = "SELECT * FROM statement_of_accounts WHERE id = LAST_INSERT_ID()";
                $soaQuery = $con->query($query) or die($con->error);
                $soaRow = $soaQuery->fetch_assoc();

                $soaId = $soaRow['id'];

                $soaNumber = generateSoaNumber($soaId);

                $query = "UPDATE statement_of_accounts SET soa_number = '$soaNumber' WHERE id = '$soaId'";
                $con->query($query) or die($con->error);
            }

            $query = "INSERT INTO appointments(`user_id`,`doctor_id`,`concern`,`date`,`time`,`arrival_status`,`pet_ids`,`created_at`,`updated_at`)VALUES('$userId','$doctorIdString','grooming','$date','$time','Arrived','$petIdString','$today','$today')";
            $con->query($query) or die($con->error);

            

            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }

    function generateSoaNumber($soaId){
        return "G-00".$soaId;
    }
?>