<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $petId = $_POST['pet_id'];
        $name = htmlspecialchars($_POST['name']);
        $breed = htmlspecialchars($_POST['breed']);
        $species = htmlspecialchars($_POST['species']);
        $birthDate = htmlspecialchars($_POST['birth_date']);
        $sex = $_POST['sex'];

        $query = "UPDATE pets SET name = '$name', breed = '$breed', species = '$species', birth_date = '$birthDate', sex = '$sex' WHERE id = '$petId'";
        $con->query($query) or die($con->error);

        echo 'ok';
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>