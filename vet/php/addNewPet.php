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
            $userId = $_POST['user_id'];
            $birthDate = $_POST['birth_date'];

            $query = "INSERT INTO pets(`name`,`breed`,`species`,`sex`,`user_id`,`birth_date`,`created_at`,`updated_at`)VALUES('$name','$breed','$species','$sex','$userId','$birthDate','$today','$today')";

            $con->query($query) or die($con->error);

            $query = "SELECT * FROM pets WHERE id = LAST_INSERT_ID()";
            $pet = $con->query($query) or die($con->error);

            $petRow = $pet->fetch_assoc();

            $dateDiff = date_diff(date_create($birthDate), date_create($today));
            $age = $dateDiff->format("%y year(s) %m month(s)");

            echo json_encode(
                array(
                    'pet_id' => $petRow['id'],
                    'name' => $petRow['name'],
                    'breed' => $petRow['breed'],
                    'species' => $petRow['species'],
                    'sex' => $petRow['sex'],
                    'age' => $age
                )
            );
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>