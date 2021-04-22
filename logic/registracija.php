<?php
    if(isset($_POST['stiglo'])){
        session_start();
        $ime = $_POST['ime'];
        $prezime = $_POST['prezime'];
        $userime = $_POST['username'];
        $mail = $_POST['mail'];
        $sifra = $_POST['sifra'];
        $sifraopet = $_POST['sifraopet'];
        $greske = [];

        // MALO REGEKSI

        $tekstProvera = "/^[A-ZĐŠŽĆČ][a-zđšžćč]{1,21}$/";
        $usernameProvera = "/^[A-ZĐŠŽĆČa-zđšžćč0-9]+(?:[ _-][A-Za-z0-9]+)*$/";
        $mailProvera = "/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/";
        $sifraProvera = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,21}$/";

        if(!preg_match($tekstProvera,$ime)){
            $greske[] = "Malo je lose ime";
        }
        if(!preg_match($tekstProvera,$prezime)){
            $greske[] = "Malo je lose prezime";
        }
        if(!preg_match($usernameProvera,$userime)){
            $greske[] = "Malo je los username";
        }
        if(!filter_var($mail,FILTER_VALIDATE_EMAIL)){
            $greske[] = "Malo je los mail";
        }
        if(!preg_match($sifraProvera,$sifra)){
            $greske[] = "Malo je losa sifra";
        }
        if(!($sifra==$sifraopet)){
            $greske[] = "Sifre se ne poklapaju";
        }
        if(count($greske) == 0){
            require "konekcija.php";
            if($konekcija){
                $upit = "INSERT INTO user VALUE(null,:ime,:prezime,:mail,:sifra,:uloga,:date,:username)";
                // ULOGA ZA AUTORIZOVANOG KORISNIKA
                define("ULOGA",1);
                $uloga = ULOGA;
                // VREDNOST SIFRE SE STAVLJA U Md5 format
                $sifra = md5($sifra);
                $date = time();

                $upis = $konekcija->prepare($upit);
                $upis->bindParam(":ime",$ime);
                $upis->bindParam(":prezime",$prezime);
                $upis->bindParam(":mail",$mail);
                $upis->bindParam(":sifra",$sifra);
                $upis->bindParam(":uloga",$uloga);
                $upis->bindParam(":date",$date);
                $upis->bindParam(":username",$userime);
                try{
                    $uspelo = $upis->execute();
                    if($uspelo){
                        http_response_code(201);
                        echo "Registered successfully, head over to the LogIn page";
                    }
                }
                catch(PDOException $mess){
                    echo "Change your username or Email, there is already an instance of those registered";
                }
            }
        }
    }
    else{
        header('Location:../register.php');
    }





?>