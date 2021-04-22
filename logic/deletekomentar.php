<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($_POST['stiglo']){
            require 'konekcija.php';
            $id = $_POST['id'];
            if($konekcija){
                $upit = "DELETE FROM review WHERE reviewid = :id";
                $delete = $konekcija->prepare($upit);
                $delete->bindParam(":id",$id);
                try{
                    $uspeh = $delete->execute();
                    if($uspeh){
                        echo "Comment deleted successfully,please refresh page";
                    }
                    else{
                        echo "Error";
                    }
                }
                catch(PDOException $mssg){
                    echo $mssg;
                }
            }
        }
        else{
            header('Location:../index.php');

        }
    }
    else{
        header('Location:../index.php');
    }
?>