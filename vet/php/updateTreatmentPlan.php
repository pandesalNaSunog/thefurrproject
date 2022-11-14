<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();

        if(isset($_POST)){
            $drug = htmlspecialchars($_POST['drug']);
            $route = htmlspecialchars($_POST['route']);
            $frequency = htmlspecialchars($_POST['frequency']);
            $time = htmlspecialchars($_POST['time']);
            $id = htmlspecialchars($_POST['id']);
            $query = "UPDATE treatment_plans SET drug = '$drug', route = '$route', frequency = '$frequency', time = '$time' WHERE id = '$id'";
            $con->query($query) or die($con->error);

            $query = "SELECT confinement_id FROM treatment_plans WHERE id = '$id'";
            $treatmentPlan = $con->query($query) or die($con->error);
            $treatmentPlanRow = $treatmentPlan->fetch_assoc();
            $confinementId = $treatmentPlanRow['confinement_id'];

            $query = "SELECT * FROM treatment_plans WHERE confinement_id = '$confinementId'";
            $treatmentPlan = $con->query($query) or die($con->error);
            $treatmentPlans = array();
            while($treatmentRow = $treatmentPlan->fetch_assoc()){
                $treatmentPlans[] = array(
                    'id' => $treatmentRow['id'],
                    'drug' => $treatmentRow['drug'],
                    'route' => $treatmentRow['route'],
                    'frequency' => $treatmentRow['frequency'],
                    'time' => $treatmentRow['time'],
                    'date' => humanReadableDate($treatmentRow['created_at'])
                );
            }

            echo json_encode($treatmentPlans);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>