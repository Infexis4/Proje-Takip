<?php
include("baglanti.php");

if ($_GET['islem'] == 'durum_guncelle' && isset($_POST['projeler_id']) && isset($_POST['durum_id'])) {
    $filmID = mysqli_real_escape_string($baglan, $_POST['projeler_id']);
    $durumID = mysqli_real_escape_string($baglan, $_POST['durum_id']);

    // Güncelleme sorgusu
    $updateQuery = mysqli_query($baglan, "UPDATE projeler SET durum_id = '$durumID' WHERE projeler_ID = '$filmID'");

    if ($updateQuery) {
        // Başarıyla güncellendiğini kullanıcıya bildir
        echo "Durum başarıyla güncellendi!";
    } else {
        // Güncelleme hatası durumunda kullanıcıya bildir
        echo "Durum güncelleme hatası: " . mysqli_error($baglan);
    }
}
?>
