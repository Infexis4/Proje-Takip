<?php

// footer() adlı bir fonksiyon tanımlanıyor
function footer() {

}

?>

<!-- Çıkış Modalı -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Modal başlık -->
                <h5 class="modal-title" id="exampleModalLabelLogout">Çıkış Yap!</h5>
                <!-- Modal kapatma düğmesi -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Modal içerik -->
                <p>Çıkış Yapmak İstediğine Emin misin?</p>
            </div>
            <div class="modal-footer">
                <!-- Modal alt kısım düğmeleri -->
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Kapat</button>
                <a href="logout.php" class="btn btn-primary">Çıkış Yap</a>
            </div>
        </div>
    </div>
</div>
