<?php
// Hata raporlamasını etkinleştir ve hataları görüntüle
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Oturumu başlat
session_start();
ob_start();

// Veritabanı bağlantı bilgileri
$host = "localhost";
$user = "root";
$pass = "";
$vt_adi = "proje takip";

// MySQL bağlantısını oluştur
$baglan = mysqli_connect($host, $user, $pass, $vt_adi) or die (mysql_error());

// Türkçe karakter sorununu çözmek için karakter setini ayarla
mysqli_query($baglan, "SET CHARACTER SET 'utf8'");
mysqli_query($baglan, "SET NAMES 'utf8'");

// MySQLi nesnesiyle bağlantıyı oluştur
$baglanOop = new mysqli($host, $user, $pass, $vt_adi);

// Sitenin başlığını ve URL'sini tanımla
define('SITE_TITLE', 'Proje Takip Sistemi');
define('SITE_URL', '');

// Kullanıcının oturum durumunu kontrol etmek için fonksiyonlar
function kullaniciId(){
	if ( isset($_SESSION['login']) ) {
		return $_SESSION["kullaniciID"];
	} else {
		return 0;
	}
}

function kullaniciTipiId(){
	if ( isset($_SESSION['login']) ) {
		if ( isset($_SESSION['kullaniciTipi']) ) {
			if ($_SESSION['kullaniciTipi'] == 1) {
				return 1;
			} else if ($_SESSION['kullaniciTipi'] == 2){
				return 2;
			} 
		}
	}
	return 0;
}

// Kullanıcı tipini adına çeviren fonksiyon
function kullaniciAdiBul($kullaniciTipiID) {
	global $baglan;
    $temizKullaniciTipiID = mysqli_real_escape_string($baglan, $kullaniciTipiID);
    
    $sorgu = "SELECT kullaniciTipi_Adi FROM kullanici_tipi WHERE kullaniciTipi_ID = '$temizKullaniciTipiID'";
    $sonuc = mysqli_query($baglan, $sorgu);

    if ($sonuc) {
        $kayit = mysqli_fetch_assoc($sonuc);
        if ($kayit) {
            return $kayit['kullaniciTipi_Adi'];
        } else {
            return "Kullanıcı tipi bulunamadı.";
        }
    }
    return false;
}

// Belirtilen ID'ye sahip kategoriyi bulan fonksiyon
function kategoriBul($id){
	global $baglan;
    $temizId = mysqli_real_escape_string($baglan, $id);
    
    $sorgu = "SELECT * FROM tur WHERE tur_ID = '$temizId'";
    $sonuc = mysqli_query($baglan, $sorgu);
    if ( mysqli_num_rows($sonuc) > 0 ) {
    	$row = mysqli_fetch_array($sonuc);
    	return $row;
    }
    return false;
}

// Belirtilen ID'ye sahip Danışmanı bulan fonksiyon
function danismanBul($id){
	global $baglan;
    $temizId = mysqli_real_escape_string($baglan, $id);
    
    $sorgu = "SELECT * FROM danısman WHERE danısman_ID = '$temizId'";
    $sonuc = mysqli_query($baglan, $sorgu);
    if ( mysqli_num_rows($sonuc) > 0 ) {
    	$row = mysqli_fetch_array($sonuc);
    	return $row;
    }
    return false;
}

// Belirtilen proje ID'sine sahip proje türlerini getiren fonksiyon
function filmTurleriGetir($id) {
	global $baglan;
	$sorgu = "SELECT t.tur_Ad 
	          FROM proje_tur pt
	          INNER JOIN tur t ON pt.tur_ID = t.tur_ID 
	          WHERE pt.projeler_ID = '$id'";

	$sonuc = mysqli_query($baglan, $sorgu);

	if ($sonuc && mysqli_num_rows($sonuc) > 0) {
	    $genreList = [];
	    while ($row = mysqli_fetch_array($sonuc)) {
	        $genreList[] = $row['tur_Ad'];
	    }
	    $formattedGenres = implode(", ", $genreList);
	    return "$formattedGenres";
	} else {
	   	return "-";
	}
}
?>
