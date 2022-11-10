<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        if(isset($_POST)){
            $confinementId = $_POST['confinement_id'];
            $typeOfFluid = htmlspecialchars($_POST['type_of_fluid']);
            $diagnosis = htmlspecialchars($_POST['diagnosis']);
            $dripRate = htmlspecialchars($_POST['drip_rate']);


            $query = "UPDATE confinements SET type_of_fluid = '$typeOfFluid', diagnosis = '$diagnosis', drip_rate = '$dripRate' WHERE id = '$confinementId'";
            $con->query($query) or die($con->error);

            echo 'ok';
        }else{
            echo 'invalid';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>