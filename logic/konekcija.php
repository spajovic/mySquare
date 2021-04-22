<?php
    $server = "localhost";
    $bazaPodataka= "buildings";
    $username = "root";
    $password = "";

    try{
        $konekcija = new PDO("mysql:host=$server;dbname=$bazaPodataka",$username,$password);
        $konekcija->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo "Doslo je do greske sa konekcijom:".$e->getMessage();
    }
?>