<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');

        $con = connect();
        if(isset($_POST)){
            $soaId = $_POST['soa_id'];

            $query = "SELECT * FROM statement_of_accounts WHERE id = '$soaId'";
            $soa = $con->query($query) or die($con->error);
            $soaRow = $soa->fetch_assoc();

            echo json_encode($soaRow);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>