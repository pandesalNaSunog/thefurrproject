<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && isset($_SERVER['HTTP_X_REQUESED_WITH']) == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();

        if(isset($_POST)){
            $petId = $_POST['pet_id'];
            $query = "SELECT * FROM pets WHERE id = '$petId'";
            $pet = $con->query($query) or die($con->error);
            $petRow = $pet->fetch_assoc();
            $petName = $petRow['name'];
            $clientId = $petRow['user_id'];
            $query = "SELECT * FROM users WHERE id = '$clientId'";
            $user = $con->query($query) or die($con->error);

            $userRow = $user->fetch_assoc();
            $name = $userRow['name'];
            $code = $userRow['client_code'];
            $response = array(
                'name' => $name,
                'pet_name' => $petName,
                'client_code' => $code,
            );

            echo json_encode($response);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>