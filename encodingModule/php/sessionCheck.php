<?php

    include('connection.php');
    $con = connect();

    if(!isset($_SESSION)){
        session_start(); 
    }

    if(isset($_GET)){

        if(isset($_SESSION['username'])){
            $username = $_SESSION['username'];
            $query = "SELECT * FROM admin_creds WHERE username = '$username'";
            $admin = $con->query($query) or die($con->error);
            $data = array();

            while($row = $admin->fetch_assoc()){
                $data[] = $row;
            }

            if(count($data) > 0){
                echo 'panel.html';
            }else{
                echo 'nothing';
            }
        }else{
            $username = "";
            echo 'nothing';
        }
        
        

    }
?>