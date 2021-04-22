<?php   
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        require "konekcija.php";
        if($konekcija){
            header("Content-Type: application/json");
            $upit = "SELECT builderId as id,builderName as name from builder";
            try{
                $graditelji = $konekcija->query($upit)->fetchAll();
                if($graditelji){
                    http_response_code(200);
                    echo json_encode($graditelji);
                }
            }
            catch(PDOException $mssg){
                echo $mssg;
            }
        }
    }
    else{
        header("location:../index.php");
    }
?>