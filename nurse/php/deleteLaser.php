<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();
        $laserId = $_POST['laser_id'];
        $query = "DELETE FROM laser_therapies WHERE id = '$laserId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        error();
    }
?>