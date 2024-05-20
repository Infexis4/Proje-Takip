<?php

// Navbar fonksiyonunu tanımla
function navbar() {
?>

      <!-- Navbar başlangıcı -->
      <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
        
        <!-- Sidebar'ı açma/kapatma butonu -->
        <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
          <i class="fa fa-bars"></i>
        </button>
        
        <!-- Sağ üst köşede kullanıcı bilgileri -->
        <ul class="navbar-nav ml-auto">
          <?php 
          
          // Eğer kullanıcı oturumu açıksa
          if (kullaniciId() != 0) {
          ?>
          
          <!-- Kullanıcı bilgileri -->
          <div class="topbar-divider d-none d-sm-block"></div>
          <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              <img class="img-profile rounded-circle" src="img/boy.png" style="max-width: 60px">
              <span class="ml-2 d-none d-lg-inline text-white small">
                <?php echo $_SESSION["kullaniciAdi"] ?>
              </span>
            </a>
            
            <!-- Kullanıcı için dropdown menü -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
              <a class="dropdown-item" href="profil.php">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Profil
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Çıkış
              </a>
            </div>
          </li> 
          
          <?php
          } else { // Eğer kullanıcı oturumu kapalıysa
          ?>
          
          <!-- Giriş yap ve Kayıt ol linkleri -->
          <li class="nav-item">
            <a href="login.php" class="nav-link">Giriş Yap</a>
          </li>
          |
          <li class="nav-item">
            <a href="register.php" class="nav-link">Kayıt Ol</a>
          </li>
          
          <?php } ?>
        </ul>
      </nav>
      <?php
}

?>
