<?php 

// Bağlantı dosyasını dahil ediyoruz
require_once 'connection.php';

// 'islem' parametresi boş değilse işlemlere başlıyoruz
if ( !empty($_GET['islem']) ) {

    // HTTP_REFERER kontrolü yapılıyor
	if (isset($_SERVER['HTTP_REFERER'])) {
		$ref = $_SERVER['HTTP_REFERER'];
		$refUrl = $ref;
	} else {
		// HTTP_REFERER yoksa varsayılan olarak index.php'ye yönlendirme yapılıyor
		$refUrl = "index.php";
	}
	
	// 'islem' değerine göre işlemler yapılıyor
	if ($_GET['islem'] == 'kategori_sil') {
		
		// 'id' parametresi alınıyor ve güvenli bir şekilde işleniyor
		$id = mysqli_real_escape_string($baglan, $_GET['id']);
		
		// 'tur' tablosundan belirtilen 'id' değerine sahip kategori siliniyor
		$sorgu = mysqli_query($baglan, "DELETE FROM tur WHERE tur_ID = '$id'");
		
		// Silme işlemi başarılıysa referer URL'ye yönlendirme yapılıyor
		if ($sorgu) {
			header("Location:".$refUrl);
		} else {
			// Silme işlemi başarısızsa yine referer URL'ye yönlendirme yapılıyor
			header("Location:".$refUrl);
		}

	} else if ($_GET['islem'] == 'film_sil') {
		
		// 'id' parametresi alınıyor ve güvenli bir şekilde işleniyor
		$id = mysqli_real_escape_string($baglan, $_GET['id']);

		// 'proje_tur' tablosundan belirtilen 'id' değerine sahip filmin türleri siliniyor
		$sorguFilmTurler = mysqli_query($baglan, "DELETE FROM proje_tur WHERE projeler_ID = '$id'");
		
		// proje türleri silme işlemi başarılıysa, 'projeler' tablosundan belirtilen 'id' değerine sahip film siliniyor
		if ($sorguFilmTurler) {
			$sorgu = mysqli_query($baglan, "DELETE FROM projeler WHERE projeler_ID = '$id'");
			// İkinci silme işlemi de başarılıysa referer URL'ye yönlendirme yapılıyor
			if ($sorgu) {
				header("Location:".$refUrl);
			} else {
				// İkinci silme işlemi başarısızsa yine referer URL'ye yönlendirme yapılıyor
				header("Location:".$refUrl);
			}
		}

	} else if ($_GET['islem'] == 'kullanici_sil') {
		
		// 'id' parametresi alınıyor ve güvenli bir şekilde işleniyor
		$id = mysqli_real_escape_string($baglan, $_GET['id']);

		// 'kullanicilar' tablosundan belirtilen 'id' değerine sahip kullanıcı siliniyor
		$kullaniciSil = mysqli_query($baglan, "DELETE FROM kullanicilar WHERE kullanici_ID = '$id'");
		// Kullanıcı silme işlemi başarılıysa referer URL'ye yönlendirme yapılıyor
		if ($kullaniciSil) {
			header("Location:".$refUrl);
		}

	} else if ($_GET['islem'] == 'kullanici_durum_guncelle') {
		
		// 'kullanici_ID' ve 'tip_ID' parametreleri alınıyor ve güvenli bir şekilde işleniyor
		$id = mysqli_real_escape_string($baglan, $_GET['kullanici_ID']);
		$tipid = mysqli_real_escape_string($baglan, $_GET['tip_ID']);

		// 'kullanicilar' tablosundan belirtilen 'id' değerine sahip kullanıcının tipi güncelleniyor
		$kullaniciTipGuncelle = mysqli_query($baglan, "UPDATE kullanicilar SET kullaniciTipi_ID = '$tipid' WHERE kullanici_ID = '$id'");
		// Güncelleme işlemi başarılıysa 'Tamamlandı' mesajı döndürülüyor
		if ($kullaniciTipGuncelle) {
			return print 'Tamamlandı';
			header("Location:".$refUrl);
		}
		// Güncelleme işlemi başarısızsa false döndürülüyor
		return false;

	}
	

}

?>
