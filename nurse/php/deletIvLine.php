<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();
        $ivLineId = $_POST['iv_line_id'];
        $query = "DELETE FROM i_v_lines WHERE id = '$ivLineId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        error();
    }
?>