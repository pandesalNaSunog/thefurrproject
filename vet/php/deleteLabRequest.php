<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']){
        include('connection.php');
        $con = connect();
        if(isset($_POST)){
            $id = $_POST['id'];

            $query = "DELETE FROM lab_requests WHERE id = '$id'";
            $con->query($query) or die($con->error);
            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>