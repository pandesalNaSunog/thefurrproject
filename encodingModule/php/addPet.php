<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $today = getCurrentDate();


        if(isset($_POST)){
            $name = htmlspecialchars($_POST['name']);
            $breed = htmlspecialchars($_POST['breed']);
            $species = htmlspecialchars($_POST['species']);
            $sex = htmlspecialchars($_POST['sex']);
            $clientId = htmlspecialchars($_POST['client_id']);
            $birthDate = $_POST['birth_date'];
            $query = "INSERT INTO pets(`name`,`breed`,`species`,`sex`,`created_at`,`updated_at`,`user_id`,`birth_date`)VALUES('$name','$breed','$species','$sex','$today','$today','$clientId','$birthDate')";
            $con->query($query) or die($con->error);

            $query = "SELECT * FROM pets WHERE id = LAST_INSERT_ID()";
            $pet = $con->query($query) or die($con->error);
            $petRow = $pet->fetch_assoc();

            $birthDateObject = date_create($petRow['birth_date']);
            $todayObject = date_create($today);

            $dateDiff = date_diff($todayObject, $birthDateObject);

            $age = $dateDiff->format("%y Years %m months");
            $response = array(
                'id' => $petRow['id'],
                'name' => $petRow['name'],
                'sex' => $petRow['sex'],
                'breed' => $petRow['breed'],
                'species' => $petRow['species'],
                'age' => $age
            );
            echo json_encode($response);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>