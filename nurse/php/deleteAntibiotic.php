<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();

        $antibioticId = $_POST['antibiotic_id'];
        $query = "DELETE FROM antibiotics WHERE id = '$antibioticId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        error();
    }
?>