<?php
    include "views/headregister.php";
    include "views/nav.php";
    session_start();
    if(isset($_SESSION['user'])){
        header('Location:index.php');
    }
?>
<div class="container">
    <div class="row d-flex justify-content-around">
        <div class="col-lg-7" id="registracija">
            <div class="card">
                <div class="card-header">
                    <span class="span-naslov">Become our member today</span>
                </div>
                <div class="card-body">
                <form method="POST" action="registracija.php">
                        <div class="form-group">
                            <label for="ime1" class="labela-input">First Name</label>
                            <input class="form-control" type="text" id="ime1">
                            <small id="imeHelp" class="form-text text-muted">Name must have first capital letter, no numbers or special characters, and max 22 characters</small>
                        </div>
                        <div class="form-group">
                            <label for="prezime1" class="labela-input">Last Name</label>
                            <input class="form-control" type="text" id="prezime1">
                            <small id="imeHelp" class="form-text text-muted">Last name must have first capital letter, no numbers or special characters, and max 22 characters</small>
                        </div>
                        <div class="form-group">
                            <label for="username1" class="labela-input">Username</label>
                            <input class="form-control" type="text" id="username1">
                            <small id="userlHelp" class="form-text text-muted">Username can include letters, numbers, - Or _  ,space is not allowed</small>
                        </div>
                        <div class="form-group">
                            <label for="mail1" class="labela-input">Email address</label>
                            <input type="email" class="form-control" id="mail1" aria-describedby="emailHelp">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label for="sifra1" class="labela-input">Password</label>
                            <input type="password" class="form-control" id="sifra1">
                            <small id="passwordHelp" class="form-text text-muted">Password must include at least one capital letter, one number, at least 8 characters, and maximum of 21 characters, special characters aren't allowed</small>
                        </div>
                        <div class="form-group">
                            <label for="sifra1" class="labela-input">Confirm Password</label>
                            <input type="password" class="form-control" id="sifra2">
                            <small id="passwordHelp" class="form-text text-muted">Make sure your passwords match</small>
                        </div>
                        <button type="button" class="btn btn-primary" id="dugme">Register</button>
                        <small id="redirekcija" class="form-text text-muted">Already a member? <a href="login.php"> LogIn</a></small>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include "views/footer.php";
?>