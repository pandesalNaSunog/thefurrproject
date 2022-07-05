<?php
    include('connection.php');
    $con = connect();

    if(isset($_GET)){
        $query = "SELECT * FROM cashiers";
        $cashier = $con->query($query) or die($con->error);
        $data = array();
        while($row = $cashier->fetch_assoc()){
            $data[] = $row;
        }

        echo json_encode($data);
    }
?>