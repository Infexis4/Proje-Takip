<?php
// Bağlantı dosyasını dahil et
require "connection.php";

// Eğer kullanıcı girişi yapılmışsa ve kullanıcı tipi 2 (yönetici) değilse, ana sayfaya yönlendir
if (kullaniciId() != 0 && kullaniciTipiId() != 2) {
  header("Location:index.php");
  exit;
}

// Sidebar ve navbar dosyalarını dahil et
require "sidebar.php";
require "navbar.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Meta etiketleri ve başlık -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/folders.png" rel="icon">
  <title> <?=SITE_TITLE?> </title>

  <!-- Kullanılan CSS dosyalarını ekleyin -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  
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

        <!-- Container Fluid -->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Projede Bulunan Öğrenci Listesi</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Ana Sayfa</a></li>
              <li class="breadcrumb-item active">Proje Yönetimi</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">
                    Öğrenci Listesi
                  </h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table table-striped" id="dataTable">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Proje Adı</th>
                        <th>Proje İçeriği</th>
                        <th>Kişi Sayısı</th>
                        <th>Bütçesi</th>
                        <th>Akademik Danışman</th>
                        <th>İşlemler</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      // Kullanıcılar tablosundan verileri çek
                      $sorgu = mysqli_query($baglan, "SELECT * FROM kullanicilar");
                      if (mysqli_num_rows($sorgu) >= 1) {
                        while ($row = mysqli_fetch_array($sorgu)) {
                          ?>
                          <!-- Kullanıcı bilgilerini tabloya ekle -->
                          <tr>
                            <td><a href="#"><?=$row['kullanici_ID']?></a></td>
                            <td><?=$row['kullanici_Adi']?> <?=$row['kullanici_Soyadi']?></td>
                            <td><?=$row['kullanici_nickname']?></td>
                            <td><?=$row['email']?></td>
                            <td><?=$row['kullanici_dogumTarihi']?></td>
                            <td><?=($row['cinsiyet_ID']==1 ? 'Erkek' : 'Kadın')?></td>
                            
                            <td>
                              <!-- Kullanıcı düzenleme ve silme bağlantıları -->
                              <a href="admin_kullanici_duzenle.php?id=<?php echo $row['kullanici_ID'];?>" class="btn btn-sm btn-warning w-100">Düzenle</a>
                              <a href="islem.php?islem=kullanici_sil&id=<?php echo $row['kullanici_ID'];?>" class="btn btn-sm btn-danger w-100">Sil</a>
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
      require "footer.php";
      footer(); 
      ?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Kullanılan JavaScript kütüphaneleri -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  

  <!-- DataTables için gerekli olan JavaScript kütüphaneleri -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- DataTables için özelleştirilmiş JavaScript kodu -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // dataTable ID'sine sahip tablo
      $('#dataTableHover').DataTable(); // Hover efekti eklenmiş dataTable ID'sine sahip tablo
    });
  </script>

  <!-- Kullanıcı durumunu güncellemek için AJAX işlemleri -->
  <script>
    function kullaniciDurumGuncelle(kullaniciID, yeniDurum) {
        // Yeni durum ve kullanıcı ID'sini alarak AJAX isteği gönderelim
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Cevap alındığında burada gerekli işlemleri yapabilirsiniz
                console.log(this.responseText); // Cevabı konsola yazdır
            }
        };
        xhttp.open("GET", "islem.php?islem=kullanici_durum_guncelle&kullanici_ID=" + kullaniciID + "&tip_ID=" + yeniDurum, true);
        xhttp.send();
    }
  </script>

</body>

</html>
