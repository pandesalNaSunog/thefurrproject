<?php
    include('connection.php');
    $con = connect();

    if(isset($_GET)){
        $query = "SELECT * FROM doctors";
        $doctor = $con->query($query) or die($con->error);
        $data = array();

        while($row = $doctor->fetch_assoc()){
            $data[] = $row;
        }

        echo json_encode($data);
    }
?>