<?php
// sidebar adında bir fonksiyon tanımlanıyor
function sidebar(){
  // global anahtar kelimesi ile $baglan değişkenini fonksiyon içinde kullanabilir hale getiriliyor
  global $baglan;
?>
  <!-- Bootstrap tarafından sağlanan bir yan menü (sidebar) HTML şablonu başlıyor -->
  <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <!-- Yan menüde marka ve başlık bölümü -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
      <div class="sidebar-brand-icon">
        <img src="img/logo/folders.png">
      </div>
      <div class="sidebar-brand-text mx-3">
        <?=SITE_TITLE?>
      </div>
    </a>

    <?php 
      // Eğer kullanıcı yönetici ise yönetici menüsü görüntülenir
      if ( kullaniciTipiId() == 2 ) {
    ?>
    <!-- Yönetici menü başlığı -->
    <div class="sidebar-heading mt-4">
      Yönetici Menüsü
    </div>

    <li class="nav-item active">
      <a class="nav-link collapsed" href="index.php" data-target="#collapseBootstrap" aria-expanded="true" aria-controls="collapseBootstrap">
        <i class="fas fa-fw fa-home"></i>
        <span>Ana Sayfa</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="projeler.php" data-target="#collapseForm" aria-expanded="true"
        aria-controls="collapseForm">
        <i class="fas fa-file"></i>
        <span><b>Tüm Projeler</b></span>
      </a>
    </li>
    <!-- Yönetim alt menüsü -->
    <li class="nav-item active">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
        aria-expanded="true" aria-controls="collapseBootstrap">
        
        <i class="fas fa-tasks"></i>
        <span>Yönetim</span>
      </a>
      <!-- Yönetim alt menüsü öğeleri -->
      <div id="collapseBootstrap" class="collapse show" aria-labelledby="headingBootstrap"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Yönetici Ayrıcalıkları</h6>
          <a class="collapse-item" href="admin_kategori.php">Proje Kategorileri</a>
          <a class="collapse-item" href="admin_proje_liste.php">2209 A Projeleri</a>
          <a class="collapse-item" href="admin_proje_liste2.php">2209 B Projeleri</a>
        </div>
      </div>
    </li>

    <li class="nav-item active">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
        aria-expanded="true" aria-controls="collapseBootstrap">
        <i class="far fa-fw fa-window-maximize"></i>
        <span>Proje Ekle</span>
      </a>
      <!-- Yönetim alt menüsü öğeleri -->
      <div id="collapseBootstrap" class="collapse show" aria-labelledby="headingBootstrap"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Proje Türleri</h6>
          <a class="collapse-item" href="admin_proje_ekle.php">2209 A</a>
          <a class="collapse-item" href="admin_proje_ekle2.php">2209 B</a>
        </div>
      </div>
    </li>
    <!-- Kategori alt menüsü -->
    <div id="collapseKategori" class="collapse" aria-labelledby="headingBootstrap" data-parent="#collapseKategori">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="">
          <i class="fas fa-fist-raised fa-fw"></i> Kategori Ekle
        </a>
      </div>
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="">
          <i class=""></i> Kategori Listesi
        </a>
      </div>
    </div>
    <?php 
    } //admin menüsü
    ?>
    
    <!-- Ana Sayfa bağlantısı -->
    <!-- Filmler bağlantısı -->
    <!-- Kategoriler bağlantısı -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
        aria-expanded="true" aria-controls="collapseBootstrap">
        <i class="far fa-fw fa-folder"></i>
        <span><b>Kategoriler</b></span>
      </a>
      <!-- Kategori alt menüsü öğeleri -->
      <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <?php 
          // Tüm türleri çek ve liste oluştur
          $turQuery = mysqli_query($baglan, "select * from tur");
          if(mysqli_num_rows($turQuery)!=0)  {
            while($turRow = mysqli_fetch_array($turQuery)) {
            ?>
            <a class="collapse-item" href="projeler.php?tur=<?php echo $turRow['tur_ID']?>">
              <i class="far fa-fw fa-folder"></i> <?php echo $turRow['tur_Ad']?>
            </a>
            <?php
            }
          }
          ?>
        </div>
      </div>
    </li>
    
    <!-- Yan menü ayırıcı çizgisi -->
    <hr class="sidebar-divider">
    <!-- Yan menü altındaki versiyon bilgisi -->
    <div class="sidebar-heading">
      <div class="version" id="version-ruangadmin"></div>
    </div>
  </ul>
<?php
}
?>
