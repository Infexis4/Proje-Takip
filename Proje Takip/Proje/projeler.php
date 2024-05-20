<?php
// Bağlantı dosyasını dahil et
require "connection.php";

// Yan menüyü dahil et
require "sidebar.php";

// Navbar'ı dahil et
require "navbar.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/folders.png" rel="icon">
  <title> <?=SITE_TITLE?> </title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
  
  <div id="wrapper">
    <!-- Yan menüyü göster -->
    <?php sidebar(); ?>
    
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- Navbar'ı göster -->
        <?php navbar(); ?>
        
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <!-- Sayfa başlığı -->
            <h1 class="h3 mb-0 text-gray-800">Tüm Projeler</h1>
            
            <!-- Sayfa içi breadcrumb (navigasyon) -->
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Ana Sayfa</a></li>
              <li class="breadcrumb-item active" aria-current="page">Projeler</li>
            </ol>
          </div>

          <div class="row"> 
            <!-- Film Paneli -->
            <div class="col-lg-12 row mb-12">

              <?php 
              // Eğer "tur" parametresi varsa
              if ( isset($_GET['tur']) ) {
                // turID'yi güvenli bir şekilde al
                $turID = mysqli_real_escape_string($baglan, $_GET['tur']);
                
                // projeler ve proje_Tur tablolarını birleştirerek belirtilen tur ID'sine sahip projeleri sorgula
                $filmlerSorgu = "SELECT f.* 
                FROM projeler f
                INNER JOIN proje_tur pt ON f.projeler_ID = pt.projeler_ID 
                WHERE pt.tur_ID = '$turID'";
              } else {
                // Tur parametresi yoksa tüm filmleri sorgula
                $filmlerSorgu = "SELECT * FROM projeler";
              }

              // projeleri sorgula
              $filmler = mysqli_query($baglan, $filmlerSorgu);

              // Eğer projeler varsa
              if(mysqli_num_rows($filmler) != 0)  {
                // Tüm projeleri döngü ile göster
                while($row = mysqli_fetch_array($filmler)) {
                  $projeler_id = $row['projeler_ID'];
                  $film_poster_id = $row['resim_ID'];
                  
                  // Poster için SQL sorgusu
                  $poster_sql = mysqli_query($baglan, "SELECT * FROM resimler WHERE resim_ID = '$film_poster_id'");
                  $posterRow = mysqli_fetch_array($poster_sql);
                ?>
                <div class="col-lg-4">
                  <div class="card">
                    <!-- proje posterini göster -->
                    
                    <div class="card-body">
                      <h5 class="card-title"><?php echo $row['proje_Adi']; ?></h5>
                      <p class="card-text">
                        <?php 
                          // proje yılı ve türlerini göster
                          echo '<b>Proje Yılı: </b>'.$row['proje_yil'].'<br>'; 
                          print '<b>Proje Türü: </b>' . filmTurleriGetir($row['projeler_ID']);
                        ?>
                      </p>
                      <a href="proje.php?id=<?php echo $projeler_id;?>" class="btn btn-primary w-100">Gözat</a>
                    </div>
                  </div>
                </div>
                <?php
                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Alt kısım (footer) -->
      <?php 
      require "footer.php";
      footer(); 
      ?>
    </div>
  </div>

  <!-- Sayfanın en üstüne gitmek için buton -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>

</body>

</html>
