<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']){
        include('connection.php');
        $con = connect();
        if(isset($_POST)){
            $soaNumber = $_POST['soa_number'];

            $query = "SELECT * FROM statement_of_accounts WHERE soa_number = '$soaNumber'";
            $soa = $con->query($query) or die($con->error);
            $soas = array();
            while($soaRow = $soa->fetch_assoc()){
                $soas[] = $soaRow;
            }
            echo json_encode($soas);
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>