<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();
        if(isset($_POST['client_id'])){
            $clientId = htmlspecialchars($_POST['client_id']);
            $pets = array();
            $query = "SELECT * FROM pets WHERE user_id = '$clientId'";
            $pet = $con->query($query) or die($con->error);
            while($row = $pet->fetch_assoc()){
                if($row['birth_date'] == '0000-00-00'){
                    $age = "N/A";
                }else{
                    $todayObject = date_create($today);
                    $birthdateObject = date_create($row['birth_date']);
                    
                    $dateDiff = date_diff($todayObject, $birthdateObject);
                    $age = $dateDiff->format('%y Year(s) %m Month(s)');
                }
                

                
                $pets[] = array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'age' => $age,
                    'breed' => $row['breed'],
                    'species' => $row['species'],
                    'sex' => $row['sex']
                );
            }
            echo json_encode($pets);
            
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>