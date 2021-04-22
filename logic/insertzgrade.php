<?php
    if($_SERVER['REQUEST_METHOD']=="POST"){
        if($_POST['stiglo']){
            $ime = $_POST['ime'];
            $src = $_POST['src'];
            $gradid = $_POST['gradid'];
            $katid = $_POST['katid'];
            $cena = $_POST['cena'];
            $lokacija = $_POST['lokacija'];
            $shorttxt1 = $_POST['shorttxt1'];
            $longtxt1 = $_POST['longtxt1'];
            $konst = $_POST['konst'];
            $gresak = [];
            $proveraIme = "/^[A-ZĐŠŽĆČa-zđšžćč0-9\s]{2,29}$/";
            $proveraCene = "/^[0-9]{1,10}.00$/";
            $proveraLokacije = "/^[A-ZĐŠŽĆČ][a-zđšžćč]{1,40},\s{0,1}[A-ZĐŠŽĆČ][a-zđšžćč]{1,40}$/";
            $proveraInfo = "/^[a-zđšžćčA-ZĐŠŽĆČ.,;!?:'\%\-\.]{1,} [a-zđšžćčA-ZĐŠŽĆČ.,:?;!]{1,} .+$/";

            if(!preg_match($proveraIme,$ime)){
                $gresak[] = "Name is invalid";
            }
            if(!preg_match($proveraCene,$cena)){
                $gresak[] = "Price is invalid";
            }
            if(!preg_match($proveraLokacije,$lokacija)){
                $gresak[] = "Price is invalid";
            }
            if(!preg_match($proveraInfo,$longtxt1)){
                $gresak[] = "Long info is invalid";
            }
            if(!preg_match($proveraInfo,$shorttxt1)){
                $gresak[] = "Short info is invalid";
            }
            if(count($gresak)){
                foreach($gresak as $err){
                    echo $err;
                }
            }
            else{
                require "konekcija.php";
                if($konekcija){
                    $query = "INSERT INTO buildings VALUES(null,:katid,:gradid,:ime,:longtxt1,:cena,:lokacija,:konst,:shorttxt1)";
                    $insert = $konekcija->prepare($query);
                    $insert->bindParam(":katid",$katid);
                    $insert->bindParam(":gradid",$gradid);
                    $insert->bindParam(":ime",$ime);
                    $insert->bindParam(":longtxt1",$longtxt1);
                    $insert->bindParam(":cena",$cena);
                    $insert->bindParam(":lokacija",$lokacija);
                    $insert->bindParam(":konst",$konst);
                    $insert->bindParam(":shorttxt1",$shorttxt1);
                    try{
                        $uspeh = $insert->execute();
                        if($uspeh){
                           $query1 = "SELECT buildingid FROM buildings ORDER BY buildingid DESC LIMIT 1";
                           $zadnji = $konekcija->query($query1)->fetch();
                           if($zadnji['buildingid']){
                            $id = $zadnji['buildingid'];
                            $slikaquery = "INSERT INTO picture VALUES(:id,:src,'property')";
                            $ubacisliku = $konekcija->prepare($slikaquery);
                            $ubacisliku->bindParam(":id",$id);
                            $ubacisliku->bindParam(":src",$src);
                            try{
                                $uspeh1 = $ubacisliku->execute();
                                if($uspeh1){
                                    echo "Property inserted successfully, please refresh page";
                                }
                            }
                            catch(PDOException $poruka){
                                echo $poruka;
                            }
                           }
                        }
                    }
                    catch(PDOException $mssg){
                        echo $mssg;
                    }
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