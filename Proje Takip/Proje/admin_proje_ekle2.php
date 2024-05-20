<?php
// connection.php dosyasını çağır
require "connection.php";

// Eğer kullanıcı giriş yapmışsa ve kullanıcı tipi 2 değilse, index.php'ye yönlendir ve işlemi sonlandır
if (kullaniciId() != 0 && kullaniciTipiId() != 2) {
  header("Location:index.php");
  exit;
}

// sidebar.php ve navbar.php dosyalarını çağır
require "sidebar.php";
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
  <!-- Font Awesome ve Bootstrap CSS dosyalarını dahil et -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<!-- SweetAlert2 kütüphanesini ekler -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
</head>

<body id="page-top">
  
  <div id="wrapper">
    <!-- Sidebar -->
   <?php sidebar(); ?>
    <!-- Sidebar -->

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php navbar(); ?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">2209 B Proje Ekleme Formu</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Ana Sayfa</a></li>
              <li class="breadcrumb-item active">Kategori Yönetimi</li>
            </ol>
          </div>

          <?php 
          // Kategori kaydet butonuna basıldığında
          if(isset($_POST['kategori_kaydet'])) {
            if (!empty($_POST['kategori_adi'])) {
              // Post edilen kategori adını al, güvenli hale getir ve veritabanında kontrol et
              $kategori_adi = strip_tags($_POST['kategori_adi']);
              $temiz_kategori_adi = mysqli_real_escape_string($baglan, $kategori_adi);
              $sorguKontrol = "SELECT tur_Ad FROM tur WHERE tur_Ad = '$temiz_kategori_adi'";
              $kategoriKontrol = mysqli_query($baglan, $sorguKontrol);
              // Eğer kategori varsa uyarı ver, yoksa veritabanına ekle
              if ( mysqli_num_rows($kategoriKontrol) >= 1 ) {
                print '<div class="alert alert-warning">Kategori eşleşmesi tespit edildi.</div>';
              } else {
                $sorgu = "INSERT INTO tur (tur_Ad) VALUES ('$temiz_kategori_adi')";
                if (mysqli_query($baglan, $sorgu)) {
                  echo '<div class="alert alert-success">Kategori başarıyla eklendi.</div>';
                } else {
                  echo "Hata oluştu: " . mysqli_error($baglanti);
                }
              }
            }
          }
          ?>
          <div class="row mb-4">
            <div class="col-lg-12">

              <?php 
              // proje ekle butonuna basıldığında
              if (isset($_POST['film_ekle'])) {
                // Post edilen proje bilgilerini al
                $proje_Adi = $_POST['proje_Adi'];
                $proje_butce = $_POST['proje_butce'];
                $proje_yil = $_POST['proje_yil'];
                $proje_sayı = $_POST['proje_sayı'];
                $proje_aciklama = $_POST['proje_aciklama'];
                $danısman_ID = $_POST['danısman_ID'];
                $sanayı_danısman = $_POST['sanayı_danısman'];
                $proje_tur = $_POST['proje_tur'];
                $proje_ID = $_POST['proje_ID'];
                $proje_firma = $_POST['proje_firma'];
                $durum_id = $_POST['durum_id'];

                // Proje adı kontrolü
                $sql_film_kontrol = "SELECT * FROM projeler WHERE proje_Adi = '$proje_Adi'";
                $query_sql_film_kontrol = mysqli_query($baglan, $sql_film_kontrol);
                // Eğer proje daha önce eklenmemişse devam et
                if ( mysqli_num_rows($query_sql_film_kontrol) < 1 ) {
                
                  // Danışman adını kontrol et
                  $query = "SELECT danısman_ID FROM danısman WHERE danısman_ad = '$danısman_ID'";
                  $result = mysqli_query($baglan, $query);

                  if (mysqli_num_rows($result) > 0) {
                      // Var olan danışman varsa ID'sini al
                      $row = mysqli_fetch_assoc($result);
                      $danısman_ID = $row['danısman_ID'];
                  } else {
                      // Yeni danışman ekleyerek ID'sini al
                      $sql = "INSERT INTO danısman (danısman_ad) VALUES ('$danısman_ID')";
                      if (mysqli_query($baglan, $sql)) {
                          $danısman_ID = mysqli_insert_id($baglan);
                      } else {
                          echo "Danışman eklenemedi: " . mysqli_error($baglan);
                      }
                  }

                  // Proje eklemesi
                  $sql_film = "INSERT INTO projeler (proje_Adi, proje_butce, proje_yil, proje_aciklama, danısman_ID, sanayı_danısman, proje_sayı , proje_ID, proje_firma, durum_id ) 
                              VALUES ('$proje_Adi', '$proje_butce', '$proje_yil','$proje_aciklama', '$danısman_ID', '$sanayı_danısman', '$proje_sayı', '$proje_ID', '$proje_firma' , '$durum_id' )";

                  if (mysqli_query($baglan, $sql_film)) {
                      $projeler_ID = mysqli_insert_id($baglan);

                      // proje türlerini eklemek için döngü
                      if (is_array($proje_tur) && count($proje_tur) >= 1) {
                        foreach ($proje_tur as $filmturkey => $filmturvalue) {
                          $filmTurKontrol = mysqli_query($baglan, "INSERT into proje_tur (tur_ID, projeler_ID) VALUES($filmturvalue,$projeler_ID)");     
                        }
                      } else {
                         $filmTurKontrol = mysqli_query($baglan, "INSERT into proje_tur (tur_ID, projeler_ID) VALUES($proje_tur,$projeler_ID)");  
                      }

                      // Eğer dosya seçilmişse ve boş değilse devam et
                      if (isset($_FILES['dosya']) && !empty($_FILES['dosya'])) {
                        if ($_FILES['dosya']['size'] > 0) {
                          $uploads_dir = 'uploads'; // Dosya yolu
                          $tmp_name = $_FILES['dosya']['tmp_name'];
                          $name = $_FILES['dosya']['name'];

                          // Eğer dosya yolu yoksa oluştur
                          if (!is_dir($uploads_dir)) {
                              mkdir($uploads_dir, 0777, true);
                          }

                          // Dosyayı taşı ve kaydet
                          if (move_uploaded_file($tmp_name, "$uploads_dir/$name")) {

                            // Resimler tablosuna kayıt ekleme
                            $sql_resim = "INSERT INTO resimler (resim) VALUES ('$uploads_dir/$name')";
                            if (mysqli_query($baglan, $sql_resim)) {
                              $resim_ID = mysqli_insert_id($baglan);
                              $updatePoster = mysqli_query($baglan, "UPDATE projeler set resim_ID = '$resim_ID' WHERE projeler_ID='$projeler_ID'");
                            }
                          }

                        }
                      }
                      
                      echo '<div class="alert alert-success">Proje başarıyla eklendi!</div>';
                  } else {
                    echo '<div class="alert alert-danger">Proje eklenemedi: ' . mysqli_error($baglan).'</div>';
                  }

                } else {
                  echo '<div class="alert alert-danger"> Eşleşen bir Proje bulundu! </div>';
                }
              }
              ?>

              <form method="POST" class="my-login-validation" enctype="multipart/form-data" novalidate="">
                
                <!-- Proje adı giriş alanı -->
                <div class="form-group">
                  <label for="name">Proje Adı</label>
                  <input type="text" class="form-control" name="proje_Adi" required>
                </div>

                <!-- Proje türü seçim alanı -->
                <div class="form-group">
                  <label for="name">Proje İçeriği</label>
                  <select class="form-control" name="proje_tur[]" id="turler" multiple>
                    <option>Seçiniz..</option>                  
                    <?php
                    // Veritabanından türleri çek ve seçenekleri oluştur
                    $turAdi='tur_Ad';
                    $turID='tur_ID';
                    $tur_query = mysqli_query($baglan, "select * from tur");
                    if(mysqli_num_rows($tur_query)!=0)  {
                      while($turlar = mysqli_fetch_array($tur_query)) {
                        echo '<option value="'.$turlar['tur_ID'].'">'.$turlar['tur_Ad'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </div>

                <!-- Projedeki kişi sayısı giriş alanı -->
                <div class="form-group">
                  <label for="name">Projedeki Kişi Sayısı</label>
                  <input type="number" class="form-control" name="proje_sayı" min="0" max="20"  value="0" required>
                </div>
                
                <!-- Başvuru dönemi seçim alanı -->
                <div class="form-group">
                  <label for="name">Başvuru Dönemi</label>
                  <select class="form-control" name="proje_yil">
                    <option>Seçiniz..</option>                        
                    <?php
                    // Mevcut yıldan 2 yıl geriye kadar seçenekleri oluştur
                    $simdikiYil = date("Y");
                    $baslangicYili =  $simdikiYil - 2;
                    for ($i = $simdikiYil; $i >= $baslangicYili; $i--) {
                      for ($j = 1; $j <= 2; $j++) {
                        $siraNumarasi = $i . '/' . $j;
                        echo '<option value="'.$siraNumarasi.'">'.$siraNumarasi . '. Dönem</option>';
                      }
                  }
          
                    ?>
                  </select>
                </div>

                <!-- Proje Bütçesi giriş alanı -->
                <div class="form-group">
                  <label for="name">Proje Bütçesi</label>
                  <input type="number" class="form-control" name="proje_butce" min="0" max="50000" placeholder="0TL" required>
                </div>

                <!-- Proje açıklama giriş alanı -->
                <div class="form-group">
                  <label for="name">Proje Açıklama</label>
                  <textarea class="form-control" name="proje_aciklama" placeholder="Proje açıklaması"></textarea>
                </div>

                <!-- Proje danışman giriş alanı -->
                <div class="form-group">
                  <label for="name">Akademik Danışman</label>
                  <textarea class="form-control" name="danısman_ID" placeholder="Akademik Danışman"></textarea>
                </div>

                <!-- Sanayi danışman giriş alanı -->
                <div class="form-group">
                  <label for="name">Sanayi Danışmanı</label>
                  <textarea class="form-control" name="sanayı_danısman" placeholder="Sanayi Danışman"></textarea>
                </div>

                <div class="form-group">
                  <label for="name">Firma </label>
                  <input type="text" class="form-control" name="proje_firma" required>
                </div>

              
                <!-- Proje kaydet butonu -->
                <div class="form-group m-0">
                  <input type="hidden" name="proje_ID" value="2">
                  <input type="hidden" name="durum_id" value="3">
                  <button type="submit" name="film_ekle" class="btn btn-primary btn-block">
                    Projeyi Kaydet
                  </button>    
                </div>
                
              </form>
            </div>
          </div>

        </div>
        <!---Container Fluid-->

      </div>
      <!---Content-->

      <!-- Footer -->
      <?php 
      // footer.php dosyasını çağır ve footer fonksiyonunu çalıştır
      require "footer.php";
      footer(); 
      ?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Sayfanın en üstüne kaydır -->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Gerekli JavaScript kütüphaneleri -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/ruang-admin.min.js"></script>
<script src="vendor/chart.js/Chart.min.js"></script>
<script src="js/demo/chart-area-demo.js"></script>

<!-- Sayfa düzeyi eklentiler -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!--Sweat ALERT2 -->
<script type="text/javascript" src="sweetalert2.all.min.js"></script>

<!-- Sayfa düzeyi özel betikler -->
<script>
  $(document).ready(function () {
    $('#dataTable').DataTable(); // dataTable ID'sine sahip tabloyu oluştur
    $('#dataTableHover').DataTable(); // Hover efekti olan dataTable ID'sine sahip tabloyu oluştur
  });
</script>

</body>
</html>
