<?php
    include('connection.php');
    $con = connect();

    if(isset($_GET)){
        $petId = $_GET['pet_id'];
        $query = "SELECT * FROM patient_details WHERE id = '$petId'";
        $pet = $con->query($query) or die($con->error);
        $petRow = $pet->fetch_assoc();

        echo json_encode($petRow);
    }
?>