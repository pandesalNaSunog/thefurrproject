<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();

        if(isset($_POST)){

            $id = $_POST['id'];
            $weight = htmlspecialchars($_POST['weight']);
            $temp = htmlspecialchars($_POST['temp']);
            $hr = htmlspecialchars($_POST['hr']);
            $rr = htmlspecialchars($_POST['rr']);
            $history = htmlspecialchars($_POST['history']);
            $chiefComplain = htmlspecialchars($_POST['chief_complain']);
            $tests = htmlspecialchars($_POST['tests']);
            $procedures = htmlspecialchars($_POST['procedures']);
            $tdx = htmlspecialchars($_POST['tdx']);
            $medication = htmlspecialchars($_POST['medication']);
            $caseClosed = htmlspecialchars($_POST['case_closed']);
            $query = "UPDATE medical_records SET case_closed = '$caseClosed', pet_weight = '$weight', temp = '$temp', hr = '$hr', rr = '$rr', medical_history = '$history', chief_complain = '$chiefComplain', tests = '$tests', `procedure` = '$procedures', tdx_ddx_case = '$tdx', medication = '$medication' WHERE id = '$id'";
            $con->query($query) or die($con->error);
            echo 'ok';
        }
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>