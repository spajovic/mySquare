<?php
    if($_POST['uspelo']){
        require_once "konekcija.php";
        header("Content-Type: application/json");
        if($konekcija){
            $query = "SELECT categoryId,categoryName FROM category WHERE parentId IS NULL";
            try{
                $kategorije = $konekcija->query($query)->fetchAll();
                echo json_encode($kategorije);
            }
            catch(PDOException $mssg){
                echo $mssg;
            }
        }
    }
    else{
        header("Location:../index.php");
    }
?>