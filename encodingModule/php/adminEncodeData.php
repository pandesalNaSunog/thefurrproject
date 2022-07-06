<?php
    include('connection.php');
    $con = connect();


    if(isset($_POST)){
        $vetId  = $_POST['attending_vet_id']; 
        $userId = $_POST['user_id'];
        $petName = $_POST['pet_name'];
        $clientConcern = $_POST['client_concern'];
        $appointmentDate = $_POST['appointment_date'];
        $age = $_POST['pet_age'];
        $breed = $_POST['pet_breed'];
        $species = $_POST['pet_species'];
        $weight = $_POST['pet_weight'];
        $sex = $_POST['pet_sex'];

        echo json_encode($_POST);
    }
?>