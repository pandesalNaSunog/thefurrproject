<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        session_start();
        if(isset($_POST) && isset($_SESSION['doctor_id'])){
            $petId = $_POST['pet_id'];
            $doctorId = $_SESSION['doctor_id'];
            $services = $_POST['services'];
            $basePrices = $_POST['base_prices'];
            $totalPrices = $_POST['total_prices'];
            $quantities = $_POST['quantities'];
            $discounts = $_POST['discounts'];
            $serviceCategories = $_POST['categories'];


            $details = "";
            foreach($services as $key => $service){
                $details .= $service . "*" . $serviceCategories[$key] . "*" . $basePrices[$key] . "*" . $totalPrices[$key] . "*" . $quantities[$key] . "*" . $discounts[$key] . "**";
            }

            $query = "INSERT INTO statement_of_accounts(`pet_id`,`doctor_id`,`soa_number`,`details`,`created_at`,`updated_at`)VALUES('$petId','$doctorId','no','$details','$today','$today')";
            $con->query($query) or die($con->error);

            

            $query = "SELECT * FROM statement_of_accounts WHERE id = LAST_INSERT_ID()";
            $soa = $con->query($query) or die($con->error);
            $soaRow = $soa->fetch_assoc();
            $soaNumber = generateSoaNumber($doctorId);
            $soaNumber = $soaNumber . $soaRow['id'];
            $soaId = $soaRow['id'];
            $query = "UPDATE statement_of_accounts SET soa_number = '$soaNumber' WHERE id = '$soaId'";
            $con->query($query) or die($con->error);

            $query = "SELECT * FROM statement_of_accounts WHERE id = LAST_INSERT_ID()";
            $soa = $con->query($query) or die($con->error);
            $soaRow = $soa->fetch_assoc();

            $renderedServices = $soaRow['details'];

            $renderedServicesArray = explode("**",$renderedServices);


            foreach($renderedServicesArray as $serviceRendered){
                if($serviceRendered != ""){
                    $query = "INSERT INTO rendered_services(`service`,`soa_number`,`lab_tech_id`,`doctor_id`,`created_at`,`updated_at`)VALUES('')";
                }
            }

            
        }else{
            echo 0;
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }

    function generateSoaNumber($doctorId){


        $initial = "";
        if($doctorId == 1){
            $initial = "Z-00";
        }else if($doctorId == 2){
            $initial = "H-00";
        }else if($doctorId == 3){
            $initial = "ZX-00";
        }else if($doctorId == 4){
            $initial = "ZH-00";
        }
        return $initial;
    }
?>