<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');

        $con = connect();

        $price = htmlspecialchars($_POST['price']);
        $antibioticId = $_POST['antibiotic_id'];
        $antibiotic = htmlspecialchars($_POST['antibiotic']);
        $query = "UPDATE antibiotics SET price = '$price', antibiotic = '$antibiotic' WHERE id = '$antibioticId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>