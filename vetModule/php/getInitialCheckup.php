<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();

        if(isset($_POST)){
            $petId = $_POST['pet_id'];
            $query = "SELECT * FROM initial_checkups WHERE pet_id = '$petId'";
            $initCheckup = $con->query($query) or die($con->error);
            $initCheckups = array();

            while($checkupRow = $initCheckup->fetch_assoc()){
                $initCheckups[] = $checkupRow;
            }
            
            echo json_encode($initCheckups);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>