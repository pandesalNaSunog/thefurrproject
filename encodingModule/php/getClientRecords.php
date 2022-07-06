<?php
    include('connection.php');
    $con = connect();

    if(isset($_GET)){
        $query = "SELECT * FROM users";

        $user = $con->query($query) or die($con->error);

        $data = array();
        while($row = $user->fetch_assoc()){
            $data[] = $row;
        }
        echo json_encode($data);
    }
?>