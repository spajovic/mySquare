<?php
    session_start();
    if(isset($_POST['stiglo'])){
        header("Content-Type: application/json");
        $imence = $_POST['username'];
        $sifrica = $_POST['sifra'];
        $greskice = [];
        // Braca regexi
        $usernameProvera = "/^[A-ZĐŠŽĆČa-zđšžćč0-9]+(?:[ _-][A-Za-z0-9]+)*$/";
        $sifraProvera = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,21}$/";
        // provera 
        if(!preg_match($usernameProvera,$imence)){
            $greskice[] = "Username is incorrect";
        }
        if(!preg_match($sifraProvera,$sifrica)){
            $greskice[] = "Password is incorrect";
        }
        if(count($greskice)== 0){
            require "konekcija.php";
            if($konekcija){
                $upit = "SELECT u.userid as id,u.username,r.rolename as role FROM user u INNER JOIN role r ON u.roleid=r.roleid AND u.username = :username AND u.password = :sifra";
                $sifrica = md5($sifrica);
                $log = $konekcija->prepare($upit);
                $log->bindParam(":username",$imence);
                $log->bindParam(":sifra",$sifrica);
                try{
                    $uspelo = $log->execute();
                    if($uspelo && $log->rowCount()==1){
                        $user = $log->fetch();
                        $_SESSION['user'] = $user;
                        http_response_code(200);
                        echo json_encode($user);
                    }
                    else{
                        echo "Username or password is invalid";
                    }

                }
                catch(PDOException $mssg){
                    echo $mssg;
                }
            }
        }

    }
    else{
        header("Location:../login.php");
    }


?>