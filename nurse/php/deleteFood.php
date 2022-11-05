<?php
    include('connection.php');
    if(isSecure()){
        $con = connect();
        $foodId = $_POST['food_id'];
        $query = "DELETE FROM food WHERE id = '$foodId'";
        $con->query($query) or die($con->error);
        echo 'ok';
    }else{
        error();
    }
?>