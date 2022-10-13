<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');

        $con = connect();
        $today = getCurrentDate();
        if(isset($_POST)){
            $petId = $_POST['pet_id'];
            $query = "SELECT * FROM pets WHERE id = '$petId'";
            $pet = $con->query($query) or die($con);
            if($petRow = $pet->fetch_assoc()){
                $userId = $petRow['user_id'];

                $query = "SELECT * FROM confinements WHERE pet_id = '$petId'";
                $confinementRecord = $con->query($query) or die($con->error);
                if($confinementRow = $confinementRecord->fetch_assoc()){
                    echo 'confinement exists';
                }else{
                    $query = "INSERT INTO confinements(`pet_id`,`created_at`,`updated_at`)VALUES('$petId','$today','$today')";
                    $con->query($query) or die($con->error);
                    echo 'ok';
                }
                
                
            }else{
                echo 'pet not exists';
            }
        }else{
            echo 'invalid';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>