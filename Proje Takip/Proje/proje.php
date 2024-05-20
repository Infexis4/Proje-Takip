<?php
// Bağlantı dosyasını dahil et
require "connection.php";

// Yan menüyü dahil et
require "sidebar.php";

// Navbar'ı dahil et
require "navbar.php";

// Eğer "id" parametresi varsa
if ( isset($_GET['id']) ) {
    // filmId'yi güvenli bir şekilde al
    $filmId = mysqli_real_escape_string($baglan, $_GET['id']);
    
    // projeler tablosundan belirtilen film ID'sine sahip filmi sorgula
    $filmlerSorgu = "SELECT * FROM projeler WHERE projeler_ID = '$filmId'";
    $film = mysqli_query($baglan, $filmlerSorgu);

    // Eğer proje bulunduysa
    if(mysqli_num_rows($film) >= 1)  { 
        // proje bilgilerini al
        $row = mysqli_fetch_array($film);

        // projeve poster ID'lerini al
        $film_id = $row['projeler_ID'];
        $film_poster_id = $row['resim_ID'];

        // Poster için SQL sorgusu
        $poster_sql = mysqli_query($baglan, "SELECT * FROM resimler WHERE resim_ID = '$film_poster_id'");
        $posterRow = mysqli_fetch_array($poster_sql);
    } else {
        // proje bulunamazsa filmler sayfasına yönlendir
        header("Location: projeler.php");
    }
} else {
    // ID parametresi yoksa projeler sayfasına yönlendir
    header("Location: projeler.php");
}
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
            <h1 class="h3 mb-0 text-gray-800"><?php echo $row['proje_Adi']; ?></h1>
            
            <!-- Sayfa içi breadcrumb (navigasyon) -->
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Ana Sayfa</a></li>
              <li class="breadcrumb-item" aria-current="page">Projeler</li>
              <li class="breadcrumb-item active" aria-current="page">
                <?php echo $row['proje_Adi']; ?>
              </li>
            </ol>
          </div>

          <div class="row"> 
            <!-- proje Paneli -->
            <div class="col-lg-12 row mb-12">

              <?php 
              // Burada ek bir işlem yapılabilir, şu an boş
              ?>
              
              <div class="col-lg-8">
                <h5 class="card-title"><?php echo $row['proje_Adi']; ?></h5>
                <div>
                  <?php 
                    // proje yılı bilgisini göster
                    echo '<b>Proje Yılı: </b>'.$row['proje_yil'].'<br>'; 
                  ?>
                  <?php 
                    // proje danışmanı göster
                    echo '<b>Akademik Danışman: </b>'.danismanBul($row['danısman_ID'])['danısman_ad'].'<br>'; 
                  ?>
                  <?php 
                    // proje türlerini göster
                    print '<b>Proje Türü: </b>' . filmTurleriGetir($row['projeler_ID']);
                  ?>
                </div>
                <p class="card-text">
                  <?php 
                    // proje açıklamasını göster
                    echo '<b>Proje Açıklaması: </b>'.$row['proje_aciklama'].'<br>'; 
                  ?>
                </p>
                <div>
                  <?php 
                      // proje danışmanını göster
                      $filmFragmani = $row['sanayı_danısman'];

                      if ($filmFragmani !== '') {
                        echo '<b>Sanayi Danışmanı: </b>'.$filmFragmani.'<br>'; 
                      }
                  ?>

                  <?php 
                    // Proje bütçesini göster
                    echo '<b>Proje Bütçesi: </b>'.$row['proje_butce'].'<br>'; 
                  ?>

                </div>
              </div>
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
