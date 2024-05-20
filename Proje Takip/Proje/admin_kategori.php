<?php
// Veritabanı bağlantısını sağlayan dosyayı dahil et
require "connection.php";

// Eğer kullanıcı ID'si 0 değil ve kullanıcı tipi ID'si 2 değilse
if (kullaniciId() != 0 && kullaniciTipiId() != 2) {
  // Kullanıcıyı ana sayfaya yönlendir ve işlemi sonlandır
  header("Location:index.php");
  exit;
}

// Kenar çubuğunu dahil et
require "sidebar.php";
// Navigasyon çubuğunu dahil et
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
  
  <!-- Sayfa başlığı -->
  <link href="img/logo/folders.png" rel="icon">
  <title> <?=SITE_TITLE?> </title>
  
  <!-- CSS dosyalarını dahil et -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  
</head>

<body id="page-top">
  
  <div id="wrapper">
    <!-- Kenar Çubuğu -->
    <?php sidebar(); ?>
    <!-- Kenar Çubuğu -->
    
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- Üst Çubuk -->
        <?php navbar(); ?>
        <!-- Üst Çubuk -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kategori Listesi</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Ana Sayfa</a></li>
              <li class="breadcrumb-item active">Kategori Yönetimi</li>
            </ol>
          </div>

          <?php 
          // Eğer kategori kaydet butonuna tıklanmışsa
          if(isset($_POST['kategori_kaydet'])) {
            // Kategori adı boş değilse
            if (!empty($_POST['kategori_adi'])) {
              // Kategori adını temizle ve güvenli bir hale getir
              $kategori_adi = strip_tags($_POST['kategori_adi']);
              $temiz_kategori_adi = mysqli_real_escape_string($baglan, $kategori_adi);
              
              // Kategori adının veritabanında olup olmadığını kontrol et
              $sorguKontrol = "SELECT tur_Ad FROM tur WHERE tur_Ad = '$temiz_kategori_adi'";
              $kategoriKontrol = mysqli_query($baglan, $sorguKontrol);
              
              // Eğer kategori veritabanında varsa
              if ( mysqli_num_rows($kategoriKontrol) >= 1 ) {
                // Kullanıcıya uyarı ver
                print '<div class="alert alert-warning">Kategori eşleşmesi tespit edildi.</div>';
              } else {
                // Yeni kategoriyi veritabanına ekle
                $sorgu = "INSERT INTO tur (tur_Ad) VALUES ('$temiz_kategori_adi')";
                
                // Sorguyu çalıştır ve başarılıysa kullanıcıya bilgi ver, değilse hata mesajını göster
                if (mysqli_query($baglan, $sorgu)) {
                  echo '<div class="alert alert-success">Kategori başarıyla eklendi.</div>';
                } else {
                  echo "Hata oluştu: " . mysqli_error($baglanti);
                }
              }
              
            }
          }
          ?>
          <!-- Kategori Ekle/Düzenle Formu -->
          <div class="row mb-4">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">
                    <?php if(!empty($_GET['kategori_duzenle'])) { ?>
                          Kategori Düzenle
                        <?php } else { ?> 
                          Kategori Ekle
                        <?php } ?>
                  </h6>
                </div>
                <div class="card-body pt-0 pb-3">
                  <!-- Kategori Ekle/Düzenle Formu -->
                  <form method="POST" action="" class="form-inline">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-4 col-form-label">
                        Kategori Adı
                      </label>
                      <div class="col-sm-8">
                        <!-- Kategori Adı Giriş Alanı -->
                        <input type="text" name="kategori_adi" class="form-control" id="inputEmail3" placeholder="Kategori Adı" value="<?php !empty($_GET['kategori_duzenle']) ? print kategoriBul($_GET['kategori_duzenle'])['tur_Ad'] : null?>" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-12">
                        <!-- Düzenleme modunda ise düzenleme işlemini iptal et ve İptal butonunu göster -->
                        <?php if(!empty($_GET['kategori_duzenle'])) { ?>
                          <input type="hidden" name="duzenle" value="<?php echo $_GET['kategori_duzenle']?>">
                          <a href="admin_kategori.php" class="btn btn-danger">İptal</a>
                        <?php }?>
                        <!-- Kaydet butonu -->
                        <button type="submit" name="kategori_kaydet" class="btn btn-primary">Kaydet</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Kategori Listesi Tablosu -->
          <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Basit Tablolar -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">
                    Kategori Listesi
                  </h6>
                </div>
                <div class="table-responsive p-3">
                  <!-- Kategori Listesi Tablosu -->
                  <table class="table align-items-center table-flush" id="dataTable">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Kategori</th>
                        <th>İşlemler</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      // Veritabanından kategorileri getiren sorgu
                      $sorgu = mysqli_query($baglan, "SELECT * FROM tur");
                      // Eğer sorguda en az 1 satır varsa
                      if (mysqli_num_rows($sorgu) >= 1) {
                        // Satırları döngü ile al
                        while ($row = mysqli_fetch_array($sorgu)) {
                          ?>
                          <!-- Kategori Listesi Satırı -->
                          <tr>
                            <td><a href="#"><?=$row['tur_ID']?></a></td>
                            <td><?=$row['tur_Ad']?></td>
                            <!-- Düzenleme ve Silme İşlemleri -->
                            <td>
                              <a href="?kategori_duzenle=<?php echo $row['tur_ID'];?>" class="btn btn-sm btn-warning">Düzenle</a>
                              <a href="islem.php?islem=kategori_sil&id=<?php echo $row['tur_ID'];?>" class="btn btn-sm btn-danger">Sil</a>
                            </td>
                          </tr>
                          <?php
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php 
      // Altbilgi dosyasını dahil et ve altbilgiyi görüntüle
      require "footer.php";
      footer(); 
      ?>
      <!-- Altbilgi -->
    </div>
  </div>

  <!-- Sayfayı en üste kaydır -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- JavaScript dosyalarını dahil et -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  

  <!-- Sayfa seviyesi eklentiler -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Sayfa seviyesi özel betikler -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // dataTable ID'sinden
      $('#dataTableHover').DataTable(); // Hover ile dataTable ID'sinden
    });
  </script>

</body>

</html>
