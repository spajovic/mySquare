<?php
    include "views/headlogin.php";
    include "views/nav.php";
    session_start();
    if(isset($_SESSION['user'])){
        header('Location:index.php');
    }
?>
    <div class="container">
        <div class="row d-flex justify-content-around">
            <div class="col-lg-7" id="logovanje">
         
                <div class="card">
                        <div class="card-header">
                            <span class="span-naslov">Log In |</span>
                        </div>
                        <div class="card-body">
                        <form method="POST" action="logovanje.php">
                            <div class="form-group">
                                <label for="username2" class="labela-input">Username</label>
                                <input class="form-control" type="text" id="username2">
                            </div>
                            <div class="form-group">
                                <label for="sifra3" class="labela-input">Password</label>
                                <input type="password" class="form-control" id="sifra3">
                            </div>
                            <button type="button" class="btn btn-primary" id="dugme1">Login</button>
                        </form>
                        </div>
                </div>

            </div>
        </div>
    </div>

<?php
    include "views/footer.php";
?>