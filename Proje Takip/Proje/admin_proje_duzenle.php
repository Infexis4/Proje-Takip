<?php
// connection.php dosyasını içe aktar
require "connection.php";

// Kullanıcı oturumu kontrolü
if (kullaniciId() != 0 && kullaniciTipiId() != 2) {
  header("Location:index.php");
  exit;
}

// URL'den proje ID'sini alınır
if ( isset($_GET['id']) && !empty($_GET['id']) ) {
  $id = strip_tags($_GET['id']);

  // Veritabanından Proje bilgilerini sorgula
  $sorgu = mysqli_query($baglan, "SELECT * FROM projeler WHERE projeler_ID = '$id'");

  // Proje bulunduysa
  if (mysqli_num_rows($sorgu) >= 1) {
    $row = mysqli_fetch_array($sorgu);

    // proje türlerini sorgula
    $filmTurlariSQL = mysqli_query($baglan, "SELECT * FROM proje_tur WHERE projeler_ID = '$id'");
    $filmFilmTurlar = [];

    // proje türlerini diziye ekleyerek sakla
    while ( $filmTurlariGetir = mysqli_fetch_array($filmTurlariSQL) ) {
      if ($filmTurlariGetir['projeler_ID'] == $id) {
        $filmFilmTurlar[] = $filmTurlariGetir['tur_ID'];
      }
    }

  } else {
    // Film bulunamazsa, admin_proje_liste sayfasına yönlendir
    header('Location:admin_proje_liste.php'); 
  }
} else {
  // Film ID belirtilmemişse, admin_proje_liste sayfasına yönlendir
  header('Location:admin_proje_liste.php');
}

// sidebar.php ve navbar.php dosyalarını içe aktar
require "sidebar.php";
require "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Meta etiketleri -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- Favicon -->
  <link href="img/logo/folders.png" rel="icon">
  <!-- Başlık -->
  <title> <?=SITE_TITLE?> </title>
  <!-- Stil dosyalarını içe aktar -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body id="page-top">
  
  <div id="wrapper">
    <!-- Yan menü -->
    <?php sidebar(); ?>
    <!-- Yan menü -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- Üst çubuk -->
        <?php navbar(); ?>
        <!-- Üst çubuk -->

        <!-- Ana içerik alanı -->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Projeler</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Ana Sayfa</a></li>
              <li class="breadcrumb-item active">Proje Düzenle</li>
            </ol>
          </div>

          <!-- Form alanı -->
          <div class="row mb-4">
            <div class="col-lg-12">

              <?php 
              // Proje güncelleme formu gönderildiyse
              if (isset($_POST['update_film'])) {
                // Eski proje verilerini al
                $projeler_ID = $id; // Güncellenecek proje ID'si
                $proje_Adi = $_POST['proje_Adi'];
                $proje_butce = str_replace(',', '.', $_POST['proje_butce']);
                $proje_danısman = $_POST['proje_danısman'];
                $proje_yil = $_POST['proje_yil'];
                $proje_sayı = $_POST['proje_sayı'];
                $proje_aciklama = $_POST['proje_aciklama'];
                $sanayı_danısman = $_POST['sanayı_danısman'];
                $proje_butce = $_POST['proje_butce'];
                $proje_tur = $_POST['proje_tur'];
                $durum_id = $_POST['durum_id'];
                $proje_firma = $_POST['proje_firma'];

                // Eğer proje varsa güncelleme işlemini yap
                $sql_film_kontrol = "SELECT * FROM projeler WHERE proje_Adi = '$proje_Adi' AND projeler_ID != '$projeler_ID'";
                $query_sql_film_kontrol = mysqli_query($baglan, $sql_film_kontrol);
        

                if (mysqli_num_rows($query_sql_film_kontrol) < 1) {
                  // proje güncelleme sorgusu
                  $sql_film_guncelle = "UPDATE projeler SET proje_Adi = '$proje_Adi', proje_butce = '$proje_butce', proje_yil = '$proje_yil', proje_sayı = '$proje_sayı', proje_aciklama = '$proje_aciklama', danısman_ID = '$proje_danısman', sanayı_danısman = '$sanayı_danısman', durum_id = '$durum_id', proje_firma = '$proje_firma' WHERE projeler_ID = '$projeler_ID'";

                  // proje güncellenirse
                  if (mysqli_query($baglan, $sql_film_guncelle)) {
                    // Eski proje türlerini sil
                    $sql_tur_sil = "DELETE FROM proje_tur WHERE projeler_ID = '$projeler_ID'";
                    mysqli_query($baglan, $sql_tur_sil);

                    // Yeni proje türlerini ekle
                    if (is_array($proje_tur) && count($proje_tur) >= 1) {
                      foreach ($proje_tur as $filmturkey => $filmturvalue) {
                        $filmTurKontrol = mysqli_query($baglan, "INSERT into proje_tur (tur_ID, projeler_ID) VALUES($filmturvalue,$projeler_ID)");
                      }
                    } else {
                      $filmTurKontrol = mysqli_query($baglan, "INSERT into proje_tur (tur_ID, projeler_ID) VALUES($proje_tur,$projeler_ID)");
                    }
                    

                    // Eğer dosya seçildiyse poster güncelle
                    if (isset($_FILES['dosya']) && $_FILES['dosya']['size'] > 0) {
                      $uploads_dir = 'uploads'; // Dosya yolu
                      $tmp_name = $_FILES['dosya']['tmp_name'];
                      $name = $_FILES['dosya']['name'];

                      // Eğer dosya yolu yoksa oluştur
                      if (!is_dir($uploads_dir)) {
                        mkdir($uploads_dir, 0777, true);
                      }

                      // Dosyayı yükleyip veritabanına kayıt ekleme
                      if (move_uploaded_file($tmp_name, "$uploads_dir/$name")) {
                        $sql_resim = "INSERT INTO resimler (resim) VALUES ('$uploads_dir/$name')";
                        if (mysqli_query($baglan, $sql_resim)) {
                          $poster_ID = mysqli_insert_id($baglan);
                          $updatePoster = mysqli_query($baglan, "UPDATE projeler set poster_ID = '$poster_ID' WHERE projeler_ID='$proje_ID'");
                        }
                      }
                    }
                    echo '<div class="alert alert-success">Proje başarıyla eklendi!</div>';
                    header('Location:admin_proje_duzenle.php?id='.$id);
                  } else {
                    // Güncelleme başarısızsa hata mesajı
                    echo '<div class="alert alert-danger">Proje güncellenemedi: ' . mysqli_error($baglan) . '</div>';
                  }
                } else {
                  // Eşleşen bir proje bulunursa hata mesajı
                  echo '<div class="alert alert-danger">Eşleşen bir Proje bulundu!</div>';
                }
              }
              ?>

              <!-- proje güncelleme formu -->
              <form method="POST" class="my-login-validation" enctype="multipart/form-data" novalidate="">
                <div class="form-group">
                  <label for="name">Proje Adı</label>
                  <input type="text" class="form-control" name="proje_Adi" value="<?php echo $row['proje_Adi'];?>" required>
                </div>

                <div class="form-group">
                  <label for="name">Proje Türü</label>
                  <select class="form-control" name="proje_tur[]" id="turler" multiple>
                    <option>Seçiniz..</option>                  
                    <?php
                    $turAdi='tur_Ad';
                    $turID='tur_ID';
                    $tur_query = mysqli_query($baglan, "select * from tur");
                    if(mysqli_num_rows($tur_query)!=0)  {
                      while($turlar = mysqli_fetch_array($tur_query)) {
                        echo '<option value="'.$turlar['tur_ID'].'" '.(in_array($turlar['tur_ID'], $filmFilmTurlar) ? 'selected' : null).'>'.$turlar['tur_Ad'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="name">Akademik Danışman</label>
                  <select class="form-control" name="proje_danısman" id="yonetmenler">
                    <option>Seçiniz..</option>                  
                    <?php
                    $yonetmen_query = mysqli_query($baglan, "select * from danısman");
                    if(mysqli_num_rows($yonetmen_query)!=0)  {
                      while($danısman = mysqli_fetch_array($yonetmen_query)) {
                        echo '<option value="'.$danısman['danısman_ID'].'" '.($row['danısman_ID']==$danısman['danısman_ID'] ? 'selected' : null).'>'.$danısman['danısman_ad'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="name">Proje Bütçesi</label>
                  <input type="number" class="form-control" name="proje_butce" min="0" max="10" step="0.25" value="<?php echo $row['proje_butce'];?>" required>
                </div>
                
                <div class="form-group">
                  <label for="name">Proje Yılı</label>
                  <select class="form-control" name="proje_yil">
                    <option>Seçiniz..</option>                        
                    <?php
                    $simdikiYil = date("Y");
                    $baslangicYili =  $simdikiYil - 40;
                    for ($i = $simdikiYil; $i >= $baslangicYili; $i--) {
                      echo '<option value="'.$i.'" '.($row['proje_yil']==$i ? 'selected' : null).'>'.$i.'</option>';
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="name">Projedeki Kişi Sayısı</label>
                  <input type="number" class="form-control" name="proje_sayı"  value="<?php echo $row['proje_sayı'];?>" required>
                </div>

                <div class="form-group">
                  <label for="name">Proje Açıklama</label>
                  <textarea class="form-control" name="proje_aciklama" rows='6' placeholder="Proje açıklaması"><?php echo $row['proje_aciklama'];?></textarea>
                </div>

                <div class="form-group">
                   <label for="name">Proje Durumu</label>
                      <select class="form-control" name="durum_id" required>
                      <option>Seçiniz..</option>
                      <?php
                      $durum_query = mysqli_query($baglan, "SELECT * FROM proje_durumu");
                      if(mysqli_num_rows($durum_query) != 0) {
                      while($durum = mysqli_fetch_array($durum_query)) {
                      echo '<option value="'.$durum['durum_id'].'" '.($row['durum_id']==$durum['durum_id'] ? 'selected' : null).'>'.$durum['durum'].'</option>';
                      }
                      }
                      ?>
                      </select>
                </div>

                <?php if ($row['proje_ID'] != 1): ?>
                   <div class="form-group">
                   <label for="name">Sanayi Danışmanı</label>
                   <input type="text" class="form-control" name="sanayı_danısman" value="<?php echo $row['sanayı_danısman'];?>" required>
                   </div>
                   <div class="form-group">
                   <label for="name">Firma</label>
                   <input type="text" class="form-control" name="proje_firma" value="<?php echo $row['proje_firma'];?>" required>
                   </div>
                   
                <?php endif; ?>

                <div class="form-group m-0">
                  <button type="submit" name="update_film" class="btn btn-primary btn-block">
                    Proje Bilgilerini Kaydet
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php 
      require "footer.php";
      footer(); 
      ?>
      <!-- Altbilgi -->
    </div>
  </div>

 <!-- Sayfanın başına git -->
 <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- jQuery kütüphanesi -->
  <script src="vendor/jquery/jquery.min.js"></script>
  
  <!-- Bootstrap JavaScript kütüphanesi -->
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  <!-- jQuery Easing kütüphanesi -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  
  <!-- Özel admin scriptleri -->
  <script src="js/ruang-admin.min.js"></script>
  
  <!-- Grafikler için Chart.js kütüphanesi -->
  <script src="vendor/chart.js/Chart.min.js"></script>
  
  <!-- Grafik demo scripti -->
  <script src="js/demo/chart-area-demo.js"></script>  

  <!-- Sayfa seviyesi eklentiler -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Sayfa seviyesi özel scriptler -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // dataTable ID'siyle
      $('#dataTableHover').DataTable(); // Hover efekti olan dataTable ID'siyle
    });
  </script>

</body>
</html>
