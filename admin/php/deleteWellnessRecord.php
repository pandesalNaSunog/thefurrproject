<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        if(isset($_POST['wellness_id'])){
            include('connection.php');
            $con = connect();
            $wellnessId = $_POST['wellness_id'];
            $query = "DELETE FROM wellness_records WHERE id = '$wellnessId'";
            $con->query($query) or die($con->error);
            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>