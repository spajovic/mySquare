<?php
    session_start();
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        if($user['role'] == "admin"){
        include "views/headbaza.php";
        if(isset($_SESSION['user'])){
            include "views/navlog.php";
          }
          else{
            include "views/nav.php";
          }
        include "logic/konekcija.php";
        if($konekcija){
            $upit = "SELECT b.buildingid as id,b.categoryId as katid,b.builderId as gradid,k.categoryName as kategorija,g.builderName as graditelj,b.name as name,b.price as price ,b.location as location ,b.underconstruction as gradnja FROM builder g INNER JOIN buildings b ON b.builderId = g.builderId INNER JOIN category k ON b.categoryId = k.categoryId";
            try{
                $uhvatisve = $konekcija->query($upit)->fetchAll();
            }
            catch(PDOException $mssg){
                echo $mssg;
            }
        }
?>
            <h4 class="bazaNaslovi">Buildings</h4>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#insert-modal" id="insertDgm1">Create new building</button>

        <table class="table">
        <thead>
            <tr>
            <th scope="col">ID</th>
            <th scope="col">Category</th>
            <th scope="col">Builder</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Location</th>
            <th scope="col">Construction</th>
            <th scope="col">UPDATE</th>
            <th scope="col">DELETE</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($uhvatisve as $hvat) : ?>
            <tr>
            <td><?= $hvat['id'] ?></td>
            <td><?= $hvat['kategorija'] ?></td>
            <td><?= $hvat['graditelj'] ?></td>
            <td><?= $hvat['name'] ?></td>
            <td><?= $hvat['price'] ?></td>
            <td><?= $hvat['location'] ?></td>
            <td><?= $hvat['gradnja'] ?></td>
            <td><button type="button" class="btn btn-info dgmUp" data-toggle="modal" data-target="#update-modal" data-id = "<?=$hvat['id']?>">Update</button></td>
                <div class="modal fade" id="update-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" >Update</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- FORMA ZA UPDATE -->
                            <form method="post" action="updateZgrada.php">
                            <div class="form-group">
                                <label for="ddl-update" class="col-form-label">Builder:</label>
                                <select id="ddl-update">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ddl-update1" class="col-form-label">Category:</label>
                                <select id="ddl-update1">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="update-name">Name:</label>
                                <input class="form-control" type="text" id="update-name">
                                <small id="imeHelp3" class="form-text text-muted">Name can only include letters, first letter must be capital, max 29 characters</small>
                            </div>
                            <div class="form-group">
                                <label for="update-price">Price:</label>
                                <input class="form-control" type="text" id="update-price">
                                <small id="imeHelp3" class="form-text text-muted">price must be in ****.00 format, and maximum of 10 digits before dot</small>
                            </div>
                            <div class="form-group">
                                <label for="update-location">Location:</label>
                                <input class="form-control" type="text" id="update-location">
                                <small id="imeHelp4" class="form-text text-muted">Only letters and max of 29 charachters, location must be in format "city_name, state_name"</small>
                            </div>
                            <div class='form-group'>
                                      <label for='infoDug' class='col-form-label'>Info</label>
                                      <textarea class='form-control' id='infoDug'></textarea>
                                      <small id='infoDugHelp' class='form-text text-muted'>Info must include at least 3 words</small>
                            </div>
                            <div class='form-group'>
                                      <label for='infoKrat' class='col-form-label'>ShortInfo</label>
                                      <textarea class='form-control' id='infoKrat'></textarea>
                                      <small id='infoKratHelp' class='form-text text-muted'>Info must include at least 3 words</small>
                            </div>
                            <div class="form-group">
                                <label for="ddl-update2">Under Construction:</label>
                                <select id="ddl-update2">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <input type="hidden" id="sakriveno">
                            <button type="button" class="btn btn-primary" id="update-dugme">Update</button>
                            </form>
                            <!-- Kraj forme -->
                        </div>
                        </div>
                    </div>
                </div>
            <td><button type="button" class="btn btn-info dgmDelete" data-id="<?= $hvat['id'] ?>">Delete</button></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
        <div class="modal fade" id="insert-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" >Insert</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- FORMA ZA INSERT -->
                            <form>
                            <div class="form-group">
                                <label for="ddl-insert" class="col-form-label">Builder:</label>
                                <select id="ddl-insert">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ddl-insert1" class="col-form-label">Category:</label>
                                <select id="ddl-insert1">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="insert-name">Name:</label>
                                <input class="form-control" type="text" id="insert-name">
                                <small id="imeHelp3" class="form-text text-muted">Name can only include letters, first letter must be capital, max 29 characters</small>
                            </div>
                            <div class="form-group">
                                <label for="insert-price">Price:</label>
                                <input class="form-control" type="text" id="insert-price">
                                <small id="imeHelp3" class="form-text text-muted">price must be in ****.00 format, and maximum of 10 digits before dot</small>
                            </div>
                            <div class="form-group">
                                <label for="insert-location">Location:</label>
                                <input class="form-control" type="text" id="insert-location">
                                <small id="imeHelp4" class="form-text text-muted">Only letters and max of 29 charachters, location must be in format "city_name, state_name"</small>
                            </div>
                            <div class='form-group'>
                                      <label for='infoDug1' class='col-form-label'>Info</label>
                                      <textarea class='form-control' id='infoDug1'></textarea>
                                      <small id='infoDugHelp' class='form-text text-muted'>Info must include at least 3 words</small>
                            </div>
                            <div class='form-group'>
                                      <label for='infoKrat1' class='col-form-label'>ShortInfo</label>
                                      <textarea class='form-control' id='infoKrat1'></textarea>
                                      <small id='infoKratHelp' class='form-text text-muted'>Info must include at least 3 words</small>
                            </div>
                            <div class="form-group">
                                <label for="insert-src">Picture src:</label>
                                <input class="form-control" type="text" id="insert-src">
                                <small id="imeHelp3" class="form-text text-muted">Picture must have .jpg extension</small>
                            </div>
                            <div class="form-group">
                                <label for="ddl-insert2">Under Construction:</label>
                                <select id="ddl-insert2">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary" id="insertDgm">Insert new row</button>
                            </form>
                            <!-- Kraj forme -->
                        </div>
                        </div>
                    </div>
                </div>

                <!-- TABELA KOMENTARI -->
            <h4 class="bazaNaslovi">Reviews</h4>

            <table class="table">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Surname</th>
                <th scope="col">Email</th>
                <th scope="col">Username</th>
                <th scope="col">Role</th>
                <th scope="col">Content</th>
                <th scope="col">Remove</th>

                </tr>
            </thead>
            <?php
                if($konekcija){
                    $querykom = "SELECT r.comment as komentar,r.reviewid as id,u.name as ime,u.surname as prezime, u.email as mail,u.username as imence, t.rolename as uloga FROM review r INNER JOIN user u ON r.userId=u.UserId INNER JOIN role t ON u.roleId=t.RoleId";
                    try{
                        $komentari = $konekcija->query($querykom)->fetchAll();
                    }
                    catch(PDOException $err){
                        echo($err);
                    }
                }
            ?>
            <?php foreach($komentari as $kom) : ?>
                <tr>
                    <td><?= $kom['id'] ?></td>
                    <td><?= $kom['ime'] ?></td>
                    <td><?= $kom['prezime'] ?></td>
                    <td><?= $kom['mail'] ?></td>
                    <td><?= $kom['imence'] ?></td>
                    <td><?= $kom['uloga'] ?></td>
                    <td><?= $kom['komentar'] ?></td>
                    <td><button type="button" class="btn btn-info komDelete" data-id="<?= $kom['id'] ?>">Delete</button></td>
                    
                </tr>
            <?php endforeach; ?>
            </table>
            <!-- TABELA KORISNICI -->
            <h4 class="bazaNaslovi">Users</h4>
            <table class="table">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Surname</th>
                <th scope="col">Email</th>
                <th scope="col">Username</th>
                <th scope="col">Role</th>
                <th scope="col">Delete</th>
                </tr>
                
            </thead>
            <?php
                    if($konekcija){
                        $korisnici = "SELECT u.userid as idu,u.name as name,u.surname as surname, u.email as mail,u.username as userime, t.rolename as uloga1 FROM user u INNER JOIN role t ON u.roleId=t.RoleId WHERE t.rolename = 'user'";
                        try{
                            $users = $konekcija->query($korisnici)->fetchAll();
                        }
                        catch(PDOException $porukica){
                            echo $porukica;
                        }
                    }
                ?>
            <?php foreach($users as $usr) : ?>
                <tr>
                    <td><?= $usr['idu'] ?></td>
                    <td><?= $usr['name'] ?></td>
                    <td><?= $usr['surname'] ?></td>
                    <td><?= $usr['mail'] ?></td>
                    <td><?= $usr['userime'] ?></td>
                    <td><?= $usr['uloga1'] ?></td>
                    <td><button type="button" class="btn btn-info userDelete" data-id="<?= $usr['idu'] ?>">Delete</button></td></td>
                    
                </tr>
            <?php endforeach; ?>
            <!-- Kraj tabele korisnici -->
            </table>
             <!-- Tabela admin -->
             <h4 class="bazaNaslovi">Admins</h4>
            <table class="table">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Surname</th>
                <th scope="col">Email</th>
                <th scope="col">Username</th>
                <th scope="col">Role</th>
                </tr>
                
            </thead>
            <?php
                    if($konekcija){
                        $korisnici = "SELECT u.userid as idu,u.name as name,u.surname as surname, u.email as mail,u.username as userime, t.rolename as uloga1 FROM user u INNER JOIN role t ON u.roleId=t.RoleId WHERE t.rolename = 'admin'";
                        try{
                            $users = $konekcija->query($korisnici)->fetchAll();
                        }
                        catch(PDOException $porukica1){
                            echo $porukica1;
                        }
                    }
                ?>
            <?php foreach($users as $usr) : ?>
                <tr>
                    <td><?= $usr['idu'] ?></td>
                    <td><?= $usr['name'] ?></td>
                    <td><?= $usr['surname'] ?></td>
                    <td><?= $usr['mail'] ?></td>
                    <td><?= $usr['userime'] ?></td>
                    <td><?= $usr['uloga1'] ?></td>
                    
                </tr>
            <?php endforeach; ?>
            </table>

            <!-- Kraj tabele admin -->
            <h4 class="bazaNaslovi">Vote results :</h4>
            <table class="table vote-result">
                <thead>
                    <tr>
                        <th scope="col">Number of votes</th>
                        <th scope="col">Average grade</th>
                    </tr>
                    <?php
                        if($konekcija){
                            $queryVote = "SELECT COUNT(voteid) as broj,ROUND(AVG(result),2) as prosek FROM votes";
                            try{
                                $rezultatVotes = $konekcija->query($queryVote)->fetch();
                            }
                            catch(PDOException $mms){
                                echo $mms;
                            }
                        }
                    ?>
                    <tr>
                        <td scope="col"><?= $rezultatVotes['broj'] ?></td>
                        <td scope="col"><?= $rezultatVotes['prosek'] ?></td>
                    </tr>

                    
                </thead>
            </table>
            



<?php
        include "views/footer.php";
    }
        else{
        header('Location:index.php');
        }
    }
    else{
        header('Location:index.php');
    }



?>