<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();

        $id = $_POST['id'];

        $query = "SELECT * FROM lab_results WHERE id = '$id'";
        $labResult = $con->query($query) or die($con->error);
        $labResultRow = $labResult->fetch_assoc();
        $labResultImage = $labResultRow['result'];

        unlink('../../lab/php/' . $labResultImage);

        $query = "DELETE FROM lab_results WHERE id = '$id'";
        $con->query($query) or die($con->error);

        echo 'ok';
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>