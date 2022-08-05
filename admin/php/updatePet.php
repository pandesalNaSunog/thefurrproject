<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        if(isset($_POST)){
            $petId = htmlspecialchars($_POST['pet_id']);
            $name = htmlspecialchars($_POST['name']);
            $breed = htmlspecialchars($_POST['breed']);
            $species = htmlspecialchars($_POST['species']);
            $sex = htmlspecialchars($_POST['sex']);
            $birthDate = $_POST['birth_date'];


            $query = "UPDATE pets SET birth_date = '$birthDate', name = '$name', breed = '$breed', species = '$species', sex = '$sex' WHERE id = '$petId'";
            $con->query($query) or die($con->error);

            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>