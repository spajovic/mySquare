<?php
    if(isset($_GET['id'])){
        session_start();
        require "logic/konekcija.php";
        if($konekcija){
            $id = $_GET['id'];
            $query = "SELECT  b.buildingId as id ,b.name as ime,b.location as lokacija ,b.price as cena ,b.Info as info ,c.builderName as graditelj,b.underconstruction as konstrukcija,p.src as src,p.alt as alt FROM buildings b INNER JOIN builder c ON b.builderId = c.builderId INNER JOIN picture p ON b.buildingid = p.buildingid WHERE b.buildingId = :id";
            $dohvati = $konekcija->prepare($query);
            $dohvati->bindParam(":id",$id);
            try{
                $akcija = $dohvati->execute();
                $broj = $dohvati->rowCount();
                if(!$akcija ){
                    header('Location:index.php'); 
                }
                else if($broj < 1){
                    header("Location: 404.php");
                }
                else{
                    $zgrada = $dohvati->fetch();
                }
            }
            catch(PDOException $msg){
                echo $msg;
            }
        }
        include "views/headzgrada.php";
        if(isset($_SESSION['user'])){
            include "views/navlog.php";
          }
          else{
            include "views/nav.php";
          }
        
?>
 <div class="container">

    <div class="row">

        <div class="col-lg-9">
                <div class="card mt-4">
                <img class="card-img-top img-fluid" src="assets/img/<?php echo $zgrada['src'];?>" alt="<?php echo $zgrada['alt'];?>">
                <div class="card-body">
                    <h3 class="card-title naslovzgrade"><?php echo $zgrada['ime'];?></h3>
                    <h4 class="cenazgrade"><?php echo $zgrada['cena'];?> $</h4>
                    <p class="card-text"><?php echo $zgrada['info'];?></p>
                    <h6 class="ozgradi"><b>Builder</b>: <?php echo $zgrada['graditelj'];?></h6>
                    <h6 class="ozgradi"><b>Location</b>: <?php echo $zgrada['lokacija'];?></h6>
                    <h6>
                        <?php
                            $konstrukcija = $zgrada['konstrukcija'];
                            if($konstrukcija){
                                echo "<del>READY TO BE USED</del>";
                            }
                            else{
                                echo "<h5 class='spremno'>READY TO BE USED</h5>";
                            }
                        ?>
                    </h6>



                </div>
                </div>
                <!-- /.card -->

                <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    <span id="naslov-komentar">Property reviews</span></br>
                    <small>(you must be logged in to comment)</small>
                </div>
                <div class="card-body">
                    <?php
                        $upitKomentar = "SELECT r.comment as komentar,u.username as nickname FROM review r INNER JOIN user u ON r.userid = u.userid WHERE r.buildingid=:id";
                        $dohvatiKomentar = $konekcija->prepare($upitKomentar);
                        $dohvatiKomentar->bindParam(":id",$id);
                        try{
                            $uspesnost = $dohvatiKomentar->execute();
                            if($uspesnost && $dohvatiKomentar->rowCount()>0){
                                $komentari = $dohvatiKomentar->fetchAll();
                                foreach($komentari as $comm){
                                    $nik = $comm['nickname'];
                                    $vrednostKomentara = $comm['komentar'];
                                    echo"
                                    <div class='card card-kom'>
                                    <div class='card-body'>
                                        <h5 class='card-title usernameKom'> $nik</h5>
                                        <p class='card-text vrednostKom'>- &nbsp;$vrednostKomentara</p>
                                    </div>
                                </div>
                                    ";
                                }  
                            }
                            else{
                                echo "<div class='card card-kom'>
                                <div class='card-body'>
                                    <span>There are no comments...</span>
                                </div>
                            </div>";
                            }
                        }
                        catch(PDOException $mssg){
                            echo $mssg;
                        }
                    ?>
                    <?php   
                        if(isset($_SESSION['user'])){
                            echo '<button type="button" class="btn btn-info dgmKom" data-toggle="modal" data-target="#exampleModal">Leave a comment</button>';
                            echo "<div class='modal fade' id='exampleModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                            <div class='modal-dialog' role='document'>
                              <div class='modal-content'>
                                <div class='modal-header'>
                                  <h5 class='modal-title' id='exampleModalLabel'>New comment</h5>
                                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                  </button>
                                </div>
                                <div class='modal-body'>
                                  <form>
                                    <div class='form-group'>
                                      <label for='komentar' class='col-form-label'>Comment:</label>
                                      <textarea class='form-control' id='komentar'></textarea>
                                      <small id='komentarHelp' class='form-text text-muted'>Comment must include at least 3 words</small>
                                    </div>
                                  </form>
                                </div>
                                <div class='modal-footer'>
                                  <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                  <button type='button' class='btn btn-primary' id='dugme-komentar' data-id='$id'>Send message</button>
                                </div>
                              </div>
                            </div>
                          </div>";

                        }
                        else{
                            echo '<a href="login.php" class="btn btn-info">Log In</a>';
                        }  
                    ?>
                    
                </div>
                </div>
            <!-- /.card -->

        </div>
    <!-- /.col-lg-9 -->

    </div>

</div>
<?php
  include "views/footer.php";
    }
else{
    header("Location:index.php");    
}
?>