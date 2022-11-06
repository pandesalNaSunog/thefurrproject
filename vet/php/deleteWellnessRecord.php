<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $id = $_POST['id'];
        $query = "DELETE FROM wellness_records WHERE id = '$id'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>