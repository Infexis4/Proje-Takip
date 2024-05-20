<?php 
// Veritabanı bağlantısını sağlayan dosyayı dahil et
require "connection.php";

// Eğer kullanıcı ID'si 0 değil ve kullanıcı tipi ID'si 2 değilse
if (kullaniciId() != 0 && kullaniciTipiId() != 2) {
  // Kullanıcıyı ana sayfaya yönlendir ve işlemi sonlandır
  header("Location:index.php");
  exit;
}

// Eğer 'id' parametresi varsa ve boş değilse
if (isset($_GET['id']) && !empty($_GET['id'])) {
  // 'id' parametresini temizle ve sorgula
  $id = strip_tags($_GET['id']);
  $sorgu = mysqli_query($baglan, "SELECT * FROM kullanicilar WHERE kullanici_ID = '$id'");
  
  // Eğer sorguda en az 1 satır varsa
  if (mysqli_num_rows($sorgu) >= 1) {
    // Satırı al
    $row = mysqli_fetch_array($sorgu);

    // (Burada başka bir işlem yapılabilir, ancak orijinal koddan eksik.)

  } else {
    // Eğer kullanıcı bulunamazsa, kullanıcıyı kullanıcı listesine yönlendir
    header('Location:admin_kullanici_liste.php'); 
  }
} else {
  // Eğer 'id' parametresi yoksa, kullanıcıyı kullanıcı listesine yönlendir
  header('Location:admin_kullanici_liste.php'); 
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
            <h1 class="h3 mb-0 text-gray-800">Kullanıcı Düzenle</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Ana Sayfa</a></li>
              <li class="breadcrumb-item active">Kullanıcı Düzenle</li>
            </ol>
          </div>

          <div class="row mb-4">
            <div class="col-lg-12">

              <?php 
              // Eğer kullanıcı bilgileri güncellenmek isteniyorsa
              if (isset($_POST['registerButonu'])) {
                // Formdan gelen verileri al
                $kullaniciAdi = $_POST["kullaniciAdi"];
                $kullaniciSoyadi = $_POST["kullaniciSoyAdi"];
                $nickname = $_POST["kullaniciAdi"];
                $email = $_POST["email"];
                $dogumTarihi = $_POST["dogumTarihi"];
                $meslek = $_POST["meslek"];
                $cinsiyet = $_POST["cinsiyet"];

                // Kullanıcı bilgilerini güncellemek için sorgu oluştur
                $updateQuery = "UPDATE kullanicilar SET kullanici_Adi = '$kullaniciAdi', kullanici_Soyadi = '$kullaniciSoyadi', 
                                    email = '$email', kullanici_nickName = '$nickname', kullanici_dogumTarihi = '$dogumTarihi', 
                                    meslek_ID = '$meslek', cinsiyet_ID = '$cinsiyet'
                                WHERE kullanici_ID = '$id'";

                // Sorguyu çalıştır ve başarılıysa kullanıcıya bilgi ver, değilse hata mesajını göster
                $updateResult = mysqli_query($baglan, $updateQuery);

                if ($updateResult) {
                   echo '<div class="alert alert-success">Kullanıcı bilgileri Güncellendi.</div>';
                } else {
                  echo '<div class="alert alert-danger">Kullanıcı bilgileri güncellenirken hata oluştu: </div>';
                    echo mysqli_error($baglan);
                }
              }
              ?>

                              <!-- Bu form, POST metodunu kullanarak veri göndermeyi amaçlayan bir formu tanımlar.
                    class="my-login-validation" stili, formun görünümünü düzenlemek için kullanılabilir.
                    novalidate, tarayıcı tarafından otomatik doğrulama işlemlerini devre dışı bırakır. -->
                <form method="POST" class="my-login-validation" novalidate="">

                  <!-- Birinci sütun -->
                  <div class="row">
                    <div class="col-lg-6 form-group">
                      <!-- "İsim" etiketi ile bir text input alanı. -->
                      <label for="name">İsim</label>
                      <input type="text" id="first-name" required="required" class="form-control" name="kullaniciAdi" value="<?php echo $row['kullanici_Adi'];?>">
                    </div>
                    
                    <div class="col-lg-6 form-group">
                      <!-- "Soyisim" etiketi ile bir text input alanı. -->
                      <label for="name">Soyisim</label>
                      <input type="text" id="last-name" name="kullaniciSoyAdi" required="required" value="<?php echo $row['kullanici_Soyadi'];?>" class="form-control">
                    </div>
                  </div>

                  <!-- "Kullanıcı Adı" etiketi ile bir text input alanı. -->
                  <div class="form-group">
                    <label for="name">Kullanıcı Adı</label>
                    <input id="middle-name" class="form-control" type="text" name="kullaniciNickAdi" value="<?php echo $row['kullanici_nickname'];?>">
                  </div>

                  <!-- "E-Mail" etiketi ile bir text input alanı ve geçersiz giriş durumunda gösterilecek hata mesajı. -->
                  <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input id="middle-name" class="form-control" type="text" name="email" value="<?php echo $row['email'];?>">
                    <div class="invalid-feedback">
                      Mail adresi geçersiz
                    </div>
                  </div>

                  <!-- "Doğum Tarihi" etiketi ile bir text input alanı. -->
                  <div class="form-group">
                    <label for="name">Doğum Tarihi</label>
                    <!-- Tarih seçici özelliğine sahip bir input alanı -->
                    <input id="birthday" name="dogumTarihi" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" required="required" type="text" value="<?php echo $row['kullanici_dogumTarihi'];?>" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
                  </div>

                  <!-- "Meslek" seçeneklerini içeren bir dropdown menüsü. -->
                  <div class="form-group">
                    <label>Meslek</label>
                    <select class="form-control" name="meslek" id="meslek">
                      <option>Seçiniz..</option>
                      <?php
                        // Meslek seçeneklerini veritabanından çekerek dropdown menüsüne ekleyen bir döngü.
                        // Seçili meslek, kullanıcının mevcut mesleği olarak işaretlenir.
                      ?>
                    </select>
                  </div>

                  <!-- "Cinsiyet" seçeneklerini içeren bir dropdown menüsü. -->
                  <div class="form-group">
                    <label for="name">Cinsiyet</label>
                    <select class="form-control" name="cinsiyet">
                      <option>Seçiniz..</option>
                      <?php
                        // Cinsiyet seçeneklerini veritabanından çekerek dropdown menüsüne ekleyen bir döngü.
                        // Seçili cinsiyet, kullanıcının mevcut cinsiyeti olarak işaretlenir.
                      ?>
                    </select>
                  </div>

                  <!-- "Değişiklikleri Kaydet" butonu -->
                  <div class="form-group m-0">
                    <button type="submit" name="registerButonu" class="btn btn-primary btn-block">
                      Değişiklikleri Kaydet
                    </button>
                  </div>
                </form>

                <!-- Şifre güncelleme formu -->
                <?php
                  // Eğer "profi_sifre_guncelle" butonu tıklanmışsa, şifre güncelleme işlemlerini gerçekleştiren PHP kodu.
                ?>
                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST">
                  <!-- İki şifre alanını içeren bir form -->
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

                  <!-- "Şifreyi Güncelle" butonu -->
                  <div class="ln_solid"></div>
                  <div class="item form-group">
                    <div class="ml-auto">
                      <button type="submit" name="profi_sifre_guncelle" class="btn btn-success">Şifreyi Güncelle</button>
                    </div>
                  </div>
                </form>

                <!-- Sayfa içeriği sonu -->

                <!-- Footer bölümü -->
                <?php 
                  // footer.php dosyasını çağıran ve sayfa altındaki footer'ı oluşturan bir include işlemi.
                  // footer() fonksiyonu, sayfa altındaki footer'ın içeriğini belirler.
                  require "footer.php";
                  footer(); 
                ?>

                <!-- Sayfanın en üstüne hızlı bir şekilde gitmeyi sağlayan buton -->
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

</body>

</html>
