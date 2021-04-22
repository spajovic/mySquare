<?php
    session_start();
    if(isset($_POST['stiglo'])){
        $id = $_POST['zgradaId'];
        $komentar = $_POST['komentar'];
        $covek = $_SESSION['user'];
        $covekId = $covek['id'];
        $proveraKomentar = "/^[a-zđšžćčA-ZĐŠŽĆČ.,;!?:'\%\-\.]{1,} [a-zđšžćčA-ZĐŠŽĆČ.,:?;!]{1,} .+$/";
        if(!preg_match($proveraKomentar,$komentar)){
            echo "Malo gresak";
        }
        else{
            require "konekcija.php";
            if($konekcija){
                $upit = "INSERT INTO review VALUES(null,:id,:userid,:komentar)";
                $upisKom = $konekcija->prepare($upit);
                $upisKom->bindParam(":id",$id);
                $upisKom->bindParam(":userid",$covekId);
                $upisKom->bindParam(":komentar",$komentar);
                try{
                    $uspelo = $upisKom->execute();
                    $last_id = mysqli_insert_id($conn);
                    if($uspelo){
                        http_response_code(201);
                        echo $last_id;
                        // echo "Successfully commented, please refresh page";
                    }
                }
                catch(PDOException $mssg){
                    echo $mssg;
                }
            }
        }
    }
    else{
        header("Location:../building.php");
    }

?>