<?php

// Bağlantı dosyasını çağır
require "connection.php";

// Kullanıcı oturumu kapalıysa ana sayfaya yönlendir
if ( kullaniciId() == 0 ) {
  header("Location:index.php");
  exit;
}

// Sidebar'ı dahil et
require "sidebar.php";

// Navbar'ı dahil et
require "navbar.php";

// Kullanıcı kimliğini al
$authId = kullaniciId();
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
    <!-- Sidebar -->
    <?php sidebar(); ?>
    <!-- Sidebar -->

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php navbar(); ?>

        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Profil</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Ana Sayfa</a></li>
              <li class="breadcrumb-item active">Profil Yönetimi</li>
            </ol>
          </div>

          <div class="row mb-4">
            <div class="col-lg-12">

              <?php
              // Profil güncelleme formu gönderildiyse
              if (isset($_POST['profil_guncelle'])) {

                // Formdan gelen verileri al
                $kullaniciAdi = $_POST["kullaniciAdi"];
                $kullaniciSoyadi = $_POST["kullaniciSoyAdi"];
                $nickname = $_POST["kullaniciNickAdi"];
                $email = $_POST["email"];
                $dogumTarihi = $_POST["dogumTarihi"];
                
                // Boş alan kontrolü
                if(!$kullaniciAdi || !$kullaniciSoyadi || !$nickname || !$email || !$dogumTarihi ){
                  echo "Lütfen boş alan bırakmayınız.";
                } else {
                  // Veritabanında kullanıcı bilgilerini güncelle
                  $uyeEkle = mysqli_query($baglan, "UPDATE kullanicilar SET kullanici_Adi = '$kullaniciAdi', kullanici_Soyadi = '$kullaniciSoyadi', email = '$email', kullanici_nickname = '$nickname', kullanici_dogumTarihi = '$dogumTarihi' WHERE kullanici_ID = '$authId'");
                  
                  if($uyeEkle){
                    echo '<div class="alert alert-success">Üyeliğiniz Güncellendi.</div>';
                  }
                }  
              }

              // Kullanıcının mevcut profil bilgilerini al
              $sorgu = "SELECT * FROM kullanicilar WHERE kullanici_ID = '$authId'";
              $sonuc = mysqli_query($baglan, $sorgu);
              $row = mysqli_fetch_array($sonuc);
              ?>

              <!-- Profil Güncelleme Formu -->
              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST">
                <div class="row">
                  <div class="item form-group col-lg-6">
                    <label class="col-form-label label-align" for="first-name">Adı</label>
                    <input type="text" id="first-name" required="required" class="form-control" name="kullaniciAdi" value="<?php echo $row['kullanici_Adi'];?>">
                  </div>
                  <div class="item form-group col-lg-6">
                    <label class="col-form-label label-align" for="last-name">Soyadı</label>
                    <input type="text" id="last-name" name="kullaniciSoyAdi" required="required" value="<?php echo $row['kullanici_Soyadi'];?>" class="form-control">
                  </div>
                </div>

                <div class="row">
                  <div class="item form-group col-lg-6">
                    <label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Kullanıcı Adı</label>
                    <input id="middle-name" class="form-control" type="text" name="kullaniciNickAdi" value="<?php echo $row['kullanici_nickname'];?>">
                  </div>
                  <div class="item form-group col-lg-6">
                    <label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">E-Posta</label>
                    <input id="middle-name" class="form-control" type="text" name="email" value="<?php echo $row['email'];?>">
                  </div>
                </div>

                <div class="row">
                  <div class="item form-group col-lg-6">
                    <label class="col-form-label col-md-3 col-sm-3 label-align">Doğum Tarihi</label>
                    <input id="birthday" name="dogumTarihi" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" required="required" value="<?php echo $row['kullanici_dogumTarihi'];?>" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
                  </div>
                </div>

                <div class="ln_solid"></div>
                <div class="item form-group">
                  <div class="ml-auto">
                    <button type="submit" name="profil_guncelle" class="btn btn-success">Güncelle</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <!-- Şifre Güncelleme Formu -->
          <div class="row mb-4">
            <div class="col-lg-12">

              <?php
              // Şifre güncelleme formu gönderildiyse
              if (isset($_POST['profi_sifre_guncelle'])) {

                // Formdan gelen verileri al
                $sifre = $_POST["sifre"];
                $sifre_tekrar = $_POST["sifre_tekrar"];
                $sifre_md5 = md5($_POST["sifre"]);
        
                // Şifre eşleşme kontrolü
                if( !$sifre ){
                  echo "Lütfen bir şifre girin!";
                } else {
                  if ($sifre == $sifre_tekrar) {
                    // Veritabanında şifreyi güncelle
                    $uyeEkle = mysqli_query($baglan, "UPDATE kullanicilar SET password = '$sifre_md5' WHERE kullanici_ID = '$authId'");
                    
                    if($uyeEkle){
                      echo '<div class="alert alert-success">Üyeliğinizin şifresi Güncellendi.</div>';
                    }
                  } else {
                    echo '<div class="alert alert-danger">Şifreleriniz eşleşmiyor!</div>';  
                  }
                }  
              }
              ?>

              <!-- Şifre Güncelleme Formu -->
              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST">
                <div class="row">
                  <div class="item form-group col-lg-6">
                    <label class="col-form-label label-align" for="first-name">Şifre</label>
                    <input type="text" required="required" class="form-control" name="sifre">
                  </div>
                  <div class="item form-group col-lg-6">
                    <label class="col-form-label label-align" for="last-name">Şifre (Tekrar)</label>
                    <input type="text" name="sifre_tekrar" required="required" class="form-control">
                  </div>
                </div>

                <div class="ln_solid"></div>
                <div class="item form-group">
                  <div class="ml-auto">
                    <button type="submit" name="profi_sifre_guncelle" class="btn btn-success">Şifremi Güncelle</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php 
      // Footer dosyasını çağır
      require "footer.php";
      // Footer fonksiyonunu çağır
      footer(); 
      ?>
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Gerekli JS dosyalarını çağır -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  

  <!-- Sayfa düzeyinde eklentiler -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <script>
    // DataTable başlat
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>

</body>

</html>
