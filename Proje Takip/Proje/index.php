<?php
require "connection.php";
require "sidebar.php";
require "navbar.php";

if ( kullaniciId() == 0 ) {
  header("Location:login.php");
  exit;
}

$sorgu = "SELECT tur.tur_Ad, COUNT(projeler.projeler_ID) AS proje_sayisi
          FROM tur
          LEFT JOIN proje_tur ON tur.tur_ID = proje_tur.tur_ID
          LEFT JOIN projeler ON proje_tur.projeler_ID = projeler.projeler_ID
          GROUP BY tur.tur_Ad";
$sonuc = mysqli_query($baglan, $sorgu);
$filmTurleri = []; // proje türleri için boş bir dizi oluştur
if ($sonuc->num_rows > 0) {
    while ( $row = mysqli_fetch_array($sonuc) ) {
      // Tur adını filmTurleri dizisine ekle
      $filmSayilari[$row['tur_Ad']] = $row['proje_sayisi'];
    }
} else {
  //echo "Hiçbir film türü bulunamadı.";
}
$filmSayilariJSON = json_encode($filmSayilari);

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
        <!-- Topbar -->
<?php

$turQuery = mysqli_query($baglan, "
    SELECT tur.tur_Ad, COUNT(projeler.projeler_ID) AS turSayisi
    FROM tur
    LEFT JOIN proje_tur ON tur.tur_ID = proje_tur.tur_ID
    LEFT JOIN projeler ON proje_tur.projeler_ID = projeler.projeler_ID
    GROUP BY tur.tur_Ad
");

$cturler = ""; // Boş bir string tanımlıyoruz

if (mysqli_num_rows($turQuery) != 0) {
    while ($readtur = mysqli_fetch_array($turQuery)) {
        $cturler .= "{ value: " . $readtur['turSayisi'] . ", name: '" . $readtur['tur_Ad'] . "' }, ";
    }
}

// Son virgülü kaldırmak için rtrim kullanıyoruz
$cturler = rtrim($cturler, ', ');

?>

<?php

$ProjeQuery = mysqli_query($baglan, "
   SELECT pt.proje_Adi, COUNT(f.proje_ID) AS projeSayisi
   FROM proje_türü pt
   LEFT JOIN projeler f ON pt.proje_ID = f.proje_ID
   GROUP BY pt.proje_Adi

");

$cproje = ""; // Boş bir string tanımlıyoruz

if (mysqli_num_rows($turQuery) != 0) {
    while ($readProje = mysqli_fetch_array($ProjeQuery)) {
        $cproje .= "{ value: " . $readProje['projeSayisi'] . ", name: '" . $readProje['proje_Adi'] . "' }, ";
    }
}

// Son virgülü kaldırmak için rtrim kullanıyoruz
$cproje = rtrim($cproje, ', ');

?>
<?php

$yilQuery = mysqli_query($baglan, "
SELECT projeler.proje_yil, COUNT(projeler.projeler_ID) AS projeYilSayisi
FROM projeler
GROUP BY projeler.proje_yil
ORDER BY projeler.proje_yil ASC
");

$cyil = ""; // Boş bir string tanımlıyoruz

if (mysqli_num_rows($turQuery) != 0) {
    while ($readYil = mysqli_fetch_array($yilQuery)) {
        $cyil .= "{ value: " . $readYil['projeYilSayisi'] . ", name: '" . $readYil['proje_yil'] . "' }, ";
    }
}

// Son virgülü kaldırmak için rtrim kullanıyoruz
$cyil = rtrim($cyil, ', ');

?>



        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <?php 
              if ( kullaniciTipiId() == 2 ) {
            ?>
            <h1 class="h3 mb-0 text-gray-800">Yönetim Paneli</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Ana Sayfa</a></li>
              <li class="breadcrumb-item active" aria-current="page">Gösterge Paneli</li>
            </ol>
            <?php
            } else {
            ?>
            <h1 class="h3 mb-0 text-gray-800">İstatistikler</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Ana Sayfa</a></li>
              <li class="breadcrumb-item active" aria-current="page">Gösterge Paneli</li>
            </ol>
            <?php } ?>
          </div>

          <?php 
          $cinsiyetErkekQuery = mysqli_query($baglan, "
          SELECT cinsiyet_Adi, COUNT(kullanici_ID) AS kullaniciSayisi
          FROM kullanicilar
          INNER JOIN cinsiyet ON kullanicilar.cinsiyet_ID = cinsiyet.cinsiyet_ID
          WHERE kullanicilar.cinsiyet_ID = '1'
          GROUP BY cinsiyet.cinsiyet_ID");

          $cinsiyetKadinQuery = mysqli_query($baglan, "
          SELECT cinsiyet_Adi, COUNT(kullanici_ID) AS kullaniciSayisi
          FROM kullanicilar
          INNER JOIN cinsiyet ON kullanicilar.cinsiyet_ID = cinsiyet.cinsiyet_ID
          WHERE kullanicilar.cinsiyet_ID = '2'
          GROUP BY cinsiyet.cinsiyet_ID");
          ?>

<div class="row mb-3">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Toplam Proje Sayısı</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php 
                        $proje_sayisi_query = mysqli_query($baglan, "SELECT * FROM projeler");
                        $proje_sayisi = mysqli_num_rows($proje_sayisi_query);
                        echo $proje_sayisi;
                        ?>
                      </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-file-alt fa-lg"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">2209 A Proje Sayısı</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                         <?php
                                $projeA_sayisi_query = mysqli_query($baglan, "SELECT * FROM projeler WHERE proje_ID = 1");
                                $projeA_sayisi = mysqli_num_rows($projeA_sayisi_query);
                                echo $projeA_sayisi;
                         ?>
                      </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-file-alt fa-lg"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- New User Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">2209 B Proje Sayısı</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                      <?php
                         $projeB_sayisi_query = mysqli_query($baglan, "SELECT * FROM projeler WHERE proje_ID = 2");
                         $projeB_sayisi = mysqli_num_rows($projeB_sayisi_query);
                         echo $projeB_sayisi;
                         ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-file-alt fa-lg"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Ortalama Proje Bütçesi</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                        <?php 
                            $ortalama_butce_query = mysqli_query($baglan, "SELECT ROUND(AVG(proje_butce)) AS ortalama_butce FROM projeler");
                            $ortalama_butce_row = mysqli_fetch_assoc($ortalama_butce_query);
                            $ortalama_butce = $ortalama_butce_row['ortalama_butce'];
                            echo $ortalama_butce;
                        ?> TL
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-money-bill-wave-alt fa-lg"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
<div class="row mb-3">
    <div class="col-lg-6">
        <div class="card shadow mb-6">
            <div class="card-header py-6">
                <h6 class="m-0 font-weight-bold text-primary">
                    Projelerin Türüne Göre Dağılımı
                </h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-6">
                    <div id="container" style="height: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow mb-6">
            <div class="card-header py-6">
                <h6 class="m-0 font-weight-bold text-primary">
                    Kategorisine Göre Proje Sayısı
                </h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-6">
                    <div id="container2" style="height: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
 
          
<div class="row"> 
    <div class="col-lg-6">
        <div class="card shadow mb-6">
            <div class="card-header py-6">
                <h6 class="m-0 font-weight-bold text-primary">
                    Yıllara Göre Ortalama Proje Bütçesi
                </h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-6">
                    <div id="container3" style="height: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow mb-6">
            <div class="card-header py-6">
                <h6 class="m-0 font-weight-bold text-primary">
                    Yıllara Göre Proje Sayısı
                </h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-6">
                    <div id="container4" style="height: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
      <!-- Footer -->
      <?php 
      require "footer.php";
      footer(); 
      ?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
  <!-- Page level custom scripts -->
  

  <script type="text/javascript">
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    // Pie Chart Example
    var ctx = document.getElementById("myPieChart_cinsiyet");
    var myPieChart_cinsiyet = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["2209A", "2209B"],
        datasets: [{
          data: [<?php echo $cinsiyetErkekQuery->num_rows;?>, <?php echo $cinsiyetKadinQuery->num_rows;?>],
          backgroundColor: ['#4e73df', 'pink'],
          hoverBackgroundColor: ['#2e59d9', 'pink'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: true,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: true
        },
        cutoutPercentage: 80,
      },
    });


    
    /*Proje türleri*/
    var filmSayilari = <?php echo $filmSayilariJSON; ?>;

    var ctx1 = document.getElementById('filmTurleriGrafik').getContext('2d');

    var filmTurleriVerileri = {
        labels: Object.keys(filmSayilari), // Kategori isimleri
        datasets: [{
            label: 'Proje Sayısı',
            data: Object.values(filmSayilari), // Film sayıları
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };

    var filmTurleriGrafik = new Chart(ctx1, {
        type: 'bar',
        data: filmTurleriVerileri,
        options: {
            // Grafik seçenekleri buraya eklenebilir (örneğin, başlık, gösterim ayarları vb.)
        }
    });
  </script>

<script type="text/javascript">
    var dom = document.getElementById('container');
    var myChart = echarts.init(dom, null, {
      renderer: 'canvas',
      useDirtyRect: false
    });
    var app = {};
    
    var option;

    option = {
  title: {
    text: 'Proje Grafiği',
    subtext: 'Veriler anlık olarak güncellenmektedir.',
    left: 'center'
  },
  tooltip: {
    trigger: 'item'
  },
  legend: {
    orient: 'vertical',
    left: 'left'
  },
  series: [
    {
      name: 'Access From',
      type: 'pie',
      radius: '50%',
      data: [
        <?php echo $cproje; ?>
      ],
      emphasis: {
        itemStyle: {
          shadowBlur: 10,
          shadowOffsetX: 0,
          shadowColor: 'rgba(0, 0, 0, 0.5)'
        }
      }
    }
  ]
};

    if (option && typeof option === 'object') {
      myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);

  </script>
  <script type="text/javascript">
    var dom = document.getElementById('container2');
    var myChart = echarts.init(dom, null, {
      renderer: 'canvas',
      useDirtyRect: false
    });
    var app = {};
    
    var option;

    option = {
  tooltip: {
    trigger: 'item'
  },
  legend: {
    top: '5%',
    left: 'center'
  },
  series: [
    {
      name: 'Access From',
      type: 'pie',
      radius: ['40%', '70%'],
      avoidLabelOverlap: false,
      itemStyle: {
        borderRadius: 10,
        borderColor: '#fff',
        borderWidth: 2
      },
      label: {
        show: false,
        position: 'center'
      },
      emphasis: {
        label: {
          show: true,
          fontSize: 40,
          fontWeight: 'bold'
        }
      },
      labelLine: {
        show: false
      },
      data: [
        <?php echo $cturler;  ?>
      ]
    }
  ]
};

    if (option && typeof option === 'object') {
      myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);
  </script>


<?php
    // Bu sorgu ile projeleri yıllara göre gruplayıp sayılarını alıyoruz
    $filmSayilariQuery = mysqli_query($baglan, "
        SELECT proje_yil, COUNT(*) AS projeSayisi
        FROM projeler
        GROUP BY proje_yil
        ORDER BY proje_yil;
    ");

    // proje sayıları dizisi
    $filmSayilari = [];

    while ($row = mysqli_fetch_assoc($filmSayilariQuery)) {
        $filmSayilari[$row['proje_yil']] = $row['projeSayisi'];
    }

    // Yılları JSON formatına çeviriyoruz
    $jsonYillar = json_encode(array_keys($filmSayilari));
    // proje sayılarını JSON formatına çeviriyoruz
    $jsonFilmSayilari = json_encode(array_values($filmSayilari));
?>

<script type="text/javascript">
    // PHP tarafında integer'a çevrildiği için bu kısımda direkt kullanabilirsiniz
    var dom = document.getElementById('container4');
    var myChart = echarts.init(dom, null, {
        renderer: 'canvas',
        useDirtyRect: false
    });

    var option;

    option = {
        xAxis: {
            type: 'category',
            data: <?php echo $jsonYillar; ?>
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                data: <?php echo $jsonFilmSayilari; ?>,
                type: 'bar'
            }
        ]
    };

    if (option && typeof option === 'object') {
        myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);
</script>
<?php

// ortalama proje bütçesi sorgusu
$ortalamaProjeButcesiQuery = mysqli_query($baglan, "
    SELECT proje_yil, AVG(proje_butce) AS ortalamaProjeButcesi
    FROM projeler
    GROUP BY proje_yil
    ORDER BY proje_yil;
");

$ortalamaProjeButcesi = [];

while ($row = mysqli_fetch_assoc($ortalamaProjeButcesiQuery)) {
    $ortalamaProjeButcesi[$row['proje_yil']] = $row['ortalamaProjeButcesi'];
}

// Yılları JSON formatına çeviriyoruz
$jsonYillarProjeButcesi = json_encode(array_keys($ortalamaProjeButcesi));
// Ortalama proje bütçelerini JSON formatına çeviriyoruz
$jsonOrtalamaProjeButcesi = json_encode(array_values($ortalamaProjeButcesi));
?>
<script type="text/javascript">
    // PHP tarafında integer'a çevrildiği için bu kısımda direkt kullanabilirsiniz
    var domProjeButcesi = document.getElementById('container3');
    var myChartProjeButcesi = echarts.init(domProjeButcesi, null, {
        renderer: 'canvas',
        useDirtyRect: false
    });

    var optionProjeButcesi = {
        xAxis: {
            type: 'category',
            data: <?php echo $jsonYillarProjeButcesi; ?>
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                data: <?php echo $jsonOrtalamaProjeButcesi; ?>,
                type: 'line'
            }
        ]
    };

    if (optionProjeButcesi && typeof optionProjeButcesi === 'object') {
        myChartProjeButcesi.setOption(optionProjeButcesi);
    }

    window.addEventListener('resize', myChartProjeButcesi.resize);
</script>









</body>

</html>