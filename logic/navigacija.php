<?php
    if(isset($_POST['stiglo'])){
        require "konekcija.php";
        header("Content-Type: application/json");
        $kveri = "SELECT navName as ime,href FROM navigation";
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