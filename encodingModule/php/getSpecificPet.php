<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();

        if(isset($_POST['pet_id'])){
            $petId = htmlspecialchars($_POST['pet_id']);

            $query = "SELECT * FROM pets WHERE id = '$petId'";
            $pet = $con->query($query) or ide($con->error);

            $petRow = $pet->fetch_assoc();

            echo json_encode($petRow);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>