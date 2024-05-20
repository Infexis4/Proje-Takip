<?php

// Hata raporlaması ayarları
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Yönlendirmelerde ihtiyacımız var. Sayfa yönlendirmeleri
include_once 'connection.php';

// Eğer oturum (session) "login" değerini içeriyorsa, kullanıcıyı index.php sayfasına yönlendir
if (isset($_SESSION['login'])) {
  header("Location:index.php");
  exit;
}

// Eğer "girisButonu" adında bir POST isteği varsa işlemleri başlat
if(isset($_POST['girisButonu'])){
	
	// Formdan gelen email ve şifre değerlerini al
	$email = $_POST['email'];
	$pass = $_POST['password'];
	$password = md5($pass); // Şifreyi MD5 algoritması ile şifrele

	// Eğer email ve şifre değerleri varsa işlemleri devam ettir
	if($email && $password){

		// Veritabanında kullanıcı kontrolü yap
		$query = mysqli_query($baglan, "SELECT * FROM kullanicilar WHERE email='$email' AND password='$password'");
		$numrow = mysqli_num_rows($query);
		
		// Eğer kullanıcı varsa oturumu başlat ve ilgili bilgileri sakla
		if($numrow > 0){

			$query = mysqli_query($baglan, "SELECT * FROM kullanicilar WHERE email='$email' AND password='$password'");
			$row = mysqli_fetch_array($query);

      $_SESSION["login"] = 1;
			$_SESSION["email"] = $row["email"];
			$_SESSION["kullaniciID"] = $row["kullanici_ID"];
			$_SESSION["kullaniciTipi"] = $row["kullaniciTipi_ID"];
      $_SESSION["kullaniciAdi"] = $row["kullanici_Adi"];
      $_SESSION["kullaniciSoyadi"] = $row["kullanici_Soyadi"];
      $_SESSION["kullaniciAdiSoyadi"] = $row["kullanici_Adi"].' '.$row["kullanici_Soyadi"];

			// Kullanıcı tipine göre yönlendirme yap
			if ($row['kullaniciTipi_ID'] == 1){
				header('Location:index.php');
			}elseif ($row['kullaniciTipi_ID'] == 2){
				header('Location:index.php');
			}else{
				exit("User Group Id Bulunamadı");
			}

		}else{
			// Kullanıcı yoksa hata mesajı ver
			echo "<script type='text/javascript'>
			window.location='login.php?user=false';
			</script>";
		}
	}
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
  <title>Proje Takip Sistemi - Giriş Ekranı</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="text-center mb-7">
                  <img src="img/logo/image.png" alt="Your Logo" class="img-fluid" style="width: 250px; height: 150px;">
                 </div>
                <div class="login-form">
                  <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4" style="font-weight: bold;">Proje Takip Sistemi</h1>
                  </div>
                  <form class="user" method="POST">
                    <div class="form-group">
                      <input type="email" name="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                        placeholder="E-Posta Adresi">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control" id="exampleInputPassword" placeholder="Şifre">
                    </div>
                    <div class="form-group">
                      <button class="btn btn-primary btn-block" name="girisButonu">Giriş Yap</button>
                    </div>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="font-weight-bold small" href="register.php">Hesap Oluştur!</a>
                  </div>
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
</body>

</html>
