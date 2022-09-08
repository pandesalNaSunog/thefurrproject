<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();

        if(isset($_POST)){
            $keyword = htmlspecialchars($_POST['keyword']);
            $query = "SELECT * FROM statement_of_accounts WHERE soa_number LIKE '%$keyword%'";
            $soa = $con->query($query) or die($con->error);
            $soas = array();
            while($soaRow = $soa->fetch_assoc()){
    
                $petId = $soaRow['pet_id'];
    
                $query = "SELECT * FROM pets WHERE id = '$petId'";
                $pet = $con->query($query) or die($con->error);
                $petRow = $pet->fetch_assoc();
    
                $clientId = $petRow['user_id'];
    
                $query = "SELECT * FROM users WHERE id = '$clientId'";
                $user = $con->query($query) or die($con->error);
                $userRow = $user->fetch_assoc();
                $clientName = $userRow['name'];
    
    
                $soaNumber = $soaRow['soa_number'];
                $date = date_format(date_create($soaRow['created_at']), "M d, Y h:i A");
                $soas[] = array(
                    'id' => $soaRow['id'],
                    'client_name' => $clientName,
                    'patient_name' => $petRow['name'],
                    'soa_number' => $soaNumber,
                    'date' => $date
                );
            }
            echo json_encode($soas);
        }
        
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>