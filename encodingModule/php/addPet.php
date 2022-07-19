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
            $query = "INSERT INTO pets(`name`,`breed`,`species`,`sex`,`created_at`,`updated_at`,`user_id`)VALUES('$name','$breed','$species','$sex','$today','$today','$clientId')";
            $con->query($query) or die($con->error);

            $query = "SELECT * FROM pets WHERE id = LAST_INSERT_ID()";
            $pet = $con->query($query) or die($con->error);
            $petRow = $pet->fetch_assoc();

            echo json_encode($petRow);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>