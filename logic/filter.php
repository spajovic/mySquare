<?php
    if($_GET['id']){
        require_once "konekcija.php";
        header("Content-Type: application/json");
        $id = $_GET['id'];
        $upit = "SELECT b.buildingId as id,b.name as name,b.price as price,b.shortInfo as shortInfo,b.categoryid as categoryid,p.src as src,p.alt as alt FROM buildings b INNER JOIN picture p ON b.buildingid = p.buildingid WHERE b.categoryId = :id";
        $filter = $konekcija->prepare($upit);
        $filter->bindParam(":id",$id);
        try{
            $upit = $filter->execute();
            if($upit){
                $podaci = $filter->fetchAll();
                http_response_code(200);
                echo json_encode($podaci);
            }
            else{
                http_response_code(404);
            }
        }
        catch(PDOException $msg){
            http_response_code(404);
        }
    }
    else{
        header('Location:../index.php');
    }
?>