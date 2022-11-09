<?php
    include('connection.php');
    $con = connect();
    session_start();
    $today = getCurrentDate();
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        if(isset($_SESSION['doctor_id']) && isset($_POST)){
            $confinementId = $_POST['confinement_id'];
            $doctorId = $_SESSION['doctor_id'];
            $soaNumber = generateSoaNumber($doctorId);
            $query = "INSERT INTO confinement_soas(`confinement_id`,`soa_number`,`created_at`,`updated_at`)VALUES('$confinementId','$soaNumber','$today','$today')";
            $con->query($query) or die($con->error);
            $query = "SELECT * FROM confinement_soas WHERE id = LAST_INSERT_ID()";
            $confinementSoa = $con->query($query) or die($con->error);
            $confinementSoaRow = $confinementSoa->fetch_assoc();
            $confinementSoaId = $confinementSoaRow['id'];

            $soaNumber .= $confinementId;

            $query = "UPDATE confinement_soas SET soa_number = '$soaNumber' WHERE id = '$confinementSoaId'";
            $con->query($query) or die($con->error);
            echo 'ok';

            // $confinementTables = array(
            //     'food','icus','infusion_pumps','i_v_canullas','i_v_fluids','i_v_lines','laser_therapies','nebulizations', 'other_medicines','oxygens','special_medicines','syringe_pumps','underpads','vitamins'
            // );

            // foreach($confinementTables as $confinementTable){
            //     $query = "SELECT count(*) as columns FROM INFORMATION_SCHEMA.columns WHERE table_name = '$confinementTable'";
            //     $columnsQuery = $con->query($query) or die($con->error);
            //     $columnsRow = $columnsQuery->fetch_assoc();
            //     $columns = $columnsRow['columns'];


            //     $query = "SELECT * FROM " . $confinementTable . " WHERE confinement_id = '$confinementId'";
            //     $queryHolder = $con->query($query) or die($con->error);
                
            //     while($queryHolderRow = $queryHolder->fetch_assoc()){

                    

            //         if($columns == 6){
            //             $query = "INSERT INTO renderred_services(`service`,`soa_number`,`lab_tech_id`,`doctor_id`,`created_at`,`updated_at`,`category`)VALUES('$confinementTable')";
            //         }
                    
            //     }
            // }
        }
        
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }

    function generateSoaNumber($doctorId){
        $initial = "";
        if($doctorId == 1){
            $initial = "ZCC-00";
        }else if($doctorId == 2){
            $initial = "HCC-00";
        }else if($doctorId == 3){
            $initial = "ZXCC-00";
        }else if($doctorId == 4){
            $initial = "ZHCC-00";
        }
        return $initial;
    }
?>