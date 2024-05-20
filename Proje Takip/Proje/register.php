<?php
/*
include_once: Dışarıdan bir dosyayı bir kez dahil etmek için kullanılır. 
Eğer dosya daha önce dahil edildiyse, tekrar dahil etmez.
*/
include_once 'connection.php';

/*
isset: Belirtilen değişkenin tanımlı olup olmadığını kontrol eder.
$_SESSION['login'] değişkeni tanımlıysa kullanıcıyı ana sayfaya yönlendirir.
*/
if (isset($_SESSION['login'])) {
  header("Location:index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Meta etiketleri, sayfanın karakter seti, görünüm ölçeği ve başlık bilgilerini içerir. -->
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="img/logo/folders.png" rel="icon">
	<title>Proje Takip Sistemi Kayıt Ekranı</title>
	<!-- Bootstrap stil dosyasını ekler -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- Özel stil dosyasını ekler -->
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
	<!-- Favicon ikonunu ekler -->
	<link rel="icon" href="<?php echo $favicon; ?>" type="image/ico" />
	<!-- Select2 stil dosyasını ekler -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<!-- SweetAlert2 kütüphanesini ekler -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
					</div>
					<div class="card fat mt-5">
						<div class="card-body">
							<h4 class="card-title">Kayıt Ekranı</h4>
							
							<?php
							// Kayıt formu gönderildiyse
							if (isset($_POST['registerButonu'])) {

								// Formdan gelen verileri al
								$kullaniciAdi = $_POST["kullaniciAdi"];
								$kullaniciSoyadi = $_POST["kullaniciSoyadi"];
								$nickname = $_POST["kullaniciAdi"];
								$email = $_POST["email"];
								$sifre = $_POST["sifre"];
								$kullaniciTipi = '2'; 
								$sifre_md5 = md5($sifre);
								$sifre2 = $_POST["sifre2"];
								$dogumTarihi = $_POST["dogumTarihi"];
								$meslek = $_POST["meslek"];
								$cinsiyet = $_POST["cinsiyet"];
								$katilimTarihi = date("Y-m-d");

								// Boş alan kontrolü
								if(!$kullaniciAdi || !$kullaniciSoyadi || !$nickname || !$email || !$sifre || !$sifre2 || !$dogumTarihi || !$meslek || !$cinsiyet ) {
									echo "Lütfen boş alan bırakmayınız.";
								} else {
									// Şifre eşleşme kontrolü
									if($sifre != $sifre2) {
										echo "Girdiğiniz şifreler uyuşmuyor.";
									} else {
										// Veritabanına kullanıcıyı ekle
										$uyeEkle = mysqli_query($baglan, "
										INSERT INTO kullanicilar (kullanici_Adi, kullanici_Soyadi, email, kullanici_nickName, password, kullanici_dogumTarihi, meslek_ID, cinsiyet_ID, kullaniciTipi_ID) 
										VALUES ('$kullaniciAdi','$kullaniciSoyadi','$email','$nickname','$sifre_md5','$dogumTarihi','$meslek','$cinsiyet','$kullaniciTipi')");
										
										if($uyeEkle) {
											// Başarılı üyelik mesajı ve anasayfaya yönlendirme
											echo '<script>Swal.fire({
												  title: "Üyelik Başarılı!",
												  text: "Birazdan anasayfaya yönlendirileceksiniz!",
												  icon: "success"
												});</script>';
											header("refresh: 6; url=login.php");
										} else {
											echo "Üyeliğiniz oluşturulamadı";
										}
									}
								}
							}
							?>
							
							<!-- Kayıt Formu -->
							<form method="POST" class="my-login-validation" novalidate="">
								<div class="row">
									<div class="col-lg-6 form-group">
										<label for="name">İsim</label>
										<input type="text" class="form-control" name="kullaniciAdi" required autofocus>
									</div>						
									<div class="col-lg-6 form-group">
										<label for="name">Soyisim</label>
										<input type="text" class="form-control" name="kullaniciSoyadi" required autofocus>
									</div>
								</div>
								
								<div class="form-group">
									<label for="name">Öğrenci Numarası</label>
									<input type="text" class="form-control" name="nickname" required autofocus>
								</div>

								<div class="form-group">
									<label for="email">E-Mail</label>
									<input type="email" class="form-control" name="email" required>
									<div class="invalid-feedback">
										Mail adresi geçersiz
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6 form-group">
										<label for="password">Şifre</label>
										<input type="password" class="form-control" name="sifre" required data-eye>
										<div class="invalid-feedback">
											Şifre Gereklidir
										</div>
									</div>
									<div class="col-lg-6 form-group">
										<label for="password">Şifre (Tekrar)</label>
										<input type="password" class="form-control" name="sifre2" required data-eye>
										<div class="invalid-feedback">
											Şifre Gereklidir
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="name">Doğum Tarihi</label>
									<input type="date" class="form-control" name="dogumTarihi" required autofocus>
								</div>
								
								<div class="form-group d-none">
									<label for="name">Kullanıcı Tipi</label>
									<select class="form-control d-none" name="kullaniciTipi">
										<option value="1" selected>Kullanıcı</option>
									</select>
								</div>
								
								<div class="form-group">
									<label for="name" class="d-block">Meslek</label>									
									<select class="form-control" name="meslek" id="meslek">
										<option>Seçiniz..</option>									
										<?php
										$meslekAdi='meslek_Adi';
										$meslekID='meslek_ID';
										$meslekQuery = mysqli_query($baglan, "select * from meslekler");
										if(mysqli_num_rows($meslekQuery)!=0)	{
											while($readMeslek = mysqli_fetch_array($meslekQuery))	{
												echo "<option value='$readMeslek[$meslekID]'>$readMeslek[$meslekAdi]</option>";
											}
										}
										?>
									</select>
								</div>
								
								<div class="form-group">
									<label for="name">Cinsiyet</label>
									<select class="form-control" name="cinsiyet">
										<option>Seçiniz..</option>												
										<?php
										$genderName='cinsiyet_Adi';
										$genderID='cinsiyet_ID';
										$genderQuery = mysqli_query($baglan, "select * from cinsiyet");
										if(mysqli_num_rows($genderQuery)!=0) {
											while($readGender = mysqli_fetch_array($genderQuery))	{
												echo "<option value='$readGender[$genderID]'>$readGender[$genderName]</option>";
											}
										}
										?>
									</select>
								</div>

								<div class="form-group m-0">
									<button type="submit" name="registerButonu" class="btn btn-primary btn-block">
										Kayıt Ol
									</button>
								</div>
								<div class="mt-4 text-center">
									<a href="login.php">Giriş Sayfası</a>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
						Copyright &copy; 2024 &mdash; BAUM Proje Takip Sistemi 
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<!-- Gerekli JS dosyalarını çağır -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!-- Özel script dosyasını ekler -->
	<script src="js/my-login.js"></script>
	<!-- Select2 kütüphanesini ekler -->
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<script>
		// Select2'yi başlat
		$(document).ready(function() {
		$('#meslek').select2();
		});
	</script>
</body>
</html>
