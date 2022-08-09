<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
        include('connection.php');
        $con = connect();
        $query = "SELECT * FROM users WHERE user_type = 'lab_tech'";
        $labTech = $con->query($query) or die($con->error);
        $labtechs = array();

        while($labTechRow = $labTech->fetch_assoc()){
            $labtechs[] = $labTechRow;
        }
        echo json_encode($labtechs);
    }else{
        echo header('HTTP/1.1 403 Forbidden');
    }
?>