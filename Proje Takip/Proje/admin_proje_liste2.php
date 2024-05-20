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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  
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
            <h1 class="h3 mb-0 text-gray-800">Proje Listesi</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Ana Sayfa</a></li>
              <li class="breadcrumb-item active">Proje Yönetimi</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Basit Tablolar -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">
                    Proje Listesi
                  </h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table table-striped" id="dataTable">
                    <thead class="thead-light">
                      <tr>
                        <th>Proje Adı</th>
                        <th>Proje Kategorisi</th>
                        <th>Proje Yılı</th>
                        <th>Proje Bütçesi</th>
                        <th>Kişi Sayısı</th>
                        <th>Akademik Danışman</th>
                        <th>Sanayi Danışmanı</th>
                        <th>Firma</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                      <?php 
                      // Veritabanından filmleri getiren sorgu
                      $sorgu = mysqli_query($baglan, "SELECT * FROM projeler WHERE proje_id = 2");
                      // Eğer sorguda en az 1 satır varsa
                      if (mysqli_num_rows($sorgu) >= 1) {
                        // Satırları döngü ile al
                        while ($row = mysqli_fetch_array($sorgu)) {
                          ?>
                          <tr>
                            <td><?=$row['proje_Adi']?></td>
                            <td><?php print filmTurleriGetir($row['projeler_ID']);?></td>
                            <td><?=$row['proje_yil']?></td>
                            <td><?=$row['proje_butce']?></td>
                            <td><?=$row['proje_sayı']?></td>
                            <!-- Danışmanid'sini kullanarak yönetmenin adını al -->
                            <td><?php echo getYonetmenAdi($row['danısman_ID']); ?></td>
                            <td><?=$row['sanayı_danısman']?></td>
                            <td><?=$row['proje_firma']?></td>
                            <td><?php echo getDurumAdi($row['durum_id']);?></td>
                            <td>
                              <!-- Proje düzenleme bağlantısı -->
                              <a href="admin_proje_duzenle.php?id=<?php echo $row['projeler_ID'];?>" class="btn btn-sm btn-warning">Düzenle</a>
                              <!-- Proje silme bağlantısı -->
                              <a href="islem.php?islem=film_sil&id=<?php echo $row['projeler_ID'];?>" class="btn btn-sm btn-danger" onclick="confirmDelete(event)">Sil</a>
                            </td>
                          </tr>
                          <?php
                        }
                      }
                      ?>
                    </tbody>
                    <?php
                      // danışman ID'sine göre danışmanın adını almak için fonksiyon
                      function getYonetmenAdi($danısmanID) {
                        global $baglan;
                        $yonetmenSorgu = mysqli_query($baglan, "SELECT danısman_ad FROM danısman WHERE danısman_ID = '$danısmanID'");
                        $yonetmenRow = mysqli_fetch_array($yonetmenSorgu);
                        return $yonetmenRow['danısman_ad'];
                       }
                    ?>
                    <?php
                    function getDurumAdi($durum_id) {
                      global $baglan;
                     $sorgu = mysqli_query($baglan, "SELECT durum FROM proje_durumu WHERE durum_id = $durum_id");
                     if ($sorgu && mysqli_num_rows($sorgu) > 0) {
                     $row = mysqli_fetch_assoc($sorgu);
                     $durumAdi = $row['durum'];
                     if ($durum_id == 1) {
                      $durumAdi = '<b><span style="color: green;">' . $durumAdi . '</span></b>';
                     }
                     elseif ($durum_id == 2) {
                      $durumAdi = '<b><span style="color: red;">' . $durumAdi . '</span></b>';
                     }
                     elseif ( $durum_id == 3) {
                      $durumAdi = '<b><span style="color: blue;">' . $durumAdi . '</span></b>';
                     }
                     return $durumAdi;
                     } 
                    }
                    ?>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
          </div>
          <!-- Satır -->

        </div>
        <!-- Container Fluid -->

      </div>
      <!-- İçerik -->

      <!-- Altbilgi -->
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

<script>
function confirmDelete(event) {
  event.preventDefault(); // Öntanımlı davranışı engelle (yani linkin tıklanmasını engelle)

  Swal.fire({
    title: "Emin misiniz?",
    text: "Bu işlemi geri alamayacaksınız!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Evet, sil!"
  }).then((result) => {
    if (result.isConfirmed) {
      // Kullanıcı onayladıysa, linkin adresine git
      window.location.href = event.target.href;
    }
  });
}
</script>

</body>

</html>
