<?php
    if($_SERVER['REQUEST_METHOD']=="GET"){
        require "konekcija.php";
        header("Content-Type: application/json");
        $kveri = "SELECT logname as ime,loghref as href FROM navigationlog";
        if($konekcija){
        $navigacija = $konekcija->query($kveri)->fetchAll();
        }
        if($navigacija){
            http_response_code(200);
            echo json_encode($navigacija);
        }
    }
    else{
        header("Location:../index.php");
    }
?>