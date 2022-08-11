<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        session_start();
        include('connection.php');
        $con = connect();

        if(isset($_SESSION['doctor_id'])){
            $doctorId = $_SESSION['doctor_id'];
            $query = "SELECT * FROM rendered_services WHERE doctor_id = '$doctorId'";
            $serviceQuery = $con->query($query) or die($con->error);
            $services = array();
            while($serviceRow = $serviceQuery->fetch_assoc()){

                $date = date_format(date_create($serviceRow['created_at']), "M d, Y h:i A");
                $category = $serviceRow['category'];
                $service = $serviceRow['service'];
                
                $labTechId = $serviceRow['lab_tech_id'];
                if($labTechId == 0){
                    $labTech = "None";
                }else{
                    $query = "SELECT * FROM users WHERE id = '$labTechId'";
                    $labTechQuery = $con->query($query) or die($con->error);
                    $labTechRow = $labTechQuery->fetch_assoc();

                    $labTech = $labTechRow['name'];
                }

                $soaNo = $serviceRow['soa_number'];
                

                $services[] = array(
                    'date' => $date,
                    'category' => $category,
                    'service' => $service,
                    'lab_tech' => $labTech,
                    'soa_no' => $soaNo
                );
            }
            echo json_encode($services);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>