 <?php
    session_start();
    include "views/head.php";
    if(isset($_SESSION['user'])){
      include "views/navlog.php";
    }
    else{
      include "views/nav.php";
    }
    require "logic/konekcija.php";
    if($konekcija){ 
      try{
          $stranica = isset($_GET['page'])? $_GET['page'] : 1;
          $limit = 6;
          $start = ($stranica - 1)*$limit;
          $zgrade = $konekcija->query("SELECT b.buildingId as id,b.name as ime,b.price as cena ,b.shortInfo as sinfo,b.categoryid as kat ,p.src as src,p.alt as alt FROM buildings b INNER JOIN picture p ON b.buildingid = p.buildingid LIMIT $start,$limit")->fetchAll();

          $zgrade1 = $konekcija->query("SELECT count(buildingId) as broj FROM buildings");
          $ukupanBroj = $zgrade1->fetchAll();
          $total = $ukupanBroj[0]['broj'];
          $brojStrania = ceil($total/$limit);
      }
      catch(PDOException $msg){
          echo $msg;
      }   
  }
 ?> 

  <div class="container">

    <div class="row">
      <div class="col-lg-3">

        <h1 class="my-4" id="naslov">Our properties</h1>
        <div class="list-group" id="kategorije">
          
        </div>
        

      </div>

      <div class="col-lg-9">
        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner" role="listbox" id="slajdza">
              <div class="carousel-item active">
                <img class="d-block img-fluid" src="assets/img/slajder1.jpg" alt="First slide">
              </div>
              <div class="carousel-item">
                <img class="d-block img-fluid" src="assets/img/slajder2.jpg" alt="Second slide">
              </div>
              <div class="carousel-item">
                <img class="d-block img-fluid" src="assets/img/slajder3.jpg" alt="Third slide">
              </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

        <div class="row" id="zgrade">
          <!-- Ispis zgrada -->
          <?php foreach($zgrade as $zgrada) : ?>
            <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="building.php?id=<?= $zgrada['id']?>"><img class="card-img-top" src="assets/img/<?=$zgrada['src']?>" alt="<?=$zgrada['alt']?>"></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="building.php?id=<?= $zgrada['id']?>" data-id="<?=$zgrada['id']?>"><?= $zgrada['ime'] ?></a>
                </h4>
                <h5 class="cenazgrade"><?= $zgrada['cena']?> $</h5>
                <p class="card-text"><?= $zgrada['sinfo']?></p>
              </div>
              <div class="card-footer">
                <a href="building.php?id=<?= $zgrada['id']?>" data-id="<?=$zgrada['id']?>">More info -></a>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
          <!-- Zgrade gotove -->
    <nav aria-label="Page navigation example">
            <ul class="pagination">
                <!-- ISPIS PAGINACIJE -->
                <?php for($i = 1; $i <= $brojStrania;$i++) :?>
                <li class="page-item"><a class="page-link" href="index.php?page=<?=$i?>"><?=$i?></a></li>
                <?php endfor;?>
                <!-- Zavrsen ispis paginacije -->
            </ul>
        </nav>

        <!-- Proizvodi -->
    
        <!-- Kraj Proizvoda -->
        </div>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>

  <!-- Footer -->
  <?php
  include "views/footer.php";
  ?>
