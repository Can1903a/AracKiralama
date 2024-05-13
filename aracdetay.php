<?php
include 'database.php';
include 'bootstrap.php';
session_start();

$welcomeMessage = "";
$logoutLink = "";
$loginLink = "<a class='nav-link'  href='/AracKiralama/login.php'>Giriş Yap</a>";
$signupLink = "<a class='nav-link' href='/AracKiralama/register.php'>Kayıt Ol</a>";

// Kullanıcı giriş yapmışsa
if (isset($_SESSION['Kullanici_id'])) {
    $kullaniciID = $_SESSION['Kullanici_id'];

    // Müşteri bilgilerini çek
    $kullaniciQuery = "SELECT * FROM kullanici WHERE Kullanici_id = $kullaniciID";
    $kullaniciResult = $conn->query($kullaniciQuery);

    if ($kullaniciResult->num_rows > 0) {
        $kullanici = $kullaniciResult->fetch_assoc();
        $isim = $kullanici['Kullanici_isim'];
        $welcomeMessage = "<h1 id='hosgeldin' class='welcome-message'>Hoşgeldiniz, " . $isim . "</h1>";
    }

    $logoutLink = "<a class='nav-link' href='/AracKiralama/logout.php'>Çıkış Yap</a>";
    $loginLink = ""; // Giriş yap linkini görünmez yap
    $signupLink = ""; // Kayıt ol linkini görünmez yap
}

// Alış şubesini belirle
if(isset($_GET['sube']) && !empty($_GET['sube'])) {
    $alis_sube = $_GET['sube'];
    
    $sql = "SELECT * FROM Subeler WHERE Sube_id=$alis_sube";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $sube = $result->fetch_assoc();

        // Alış şube adını al
        $alis_sube_ad = $sube['Sube_adı'];
        
    } else {
        // Şube bulunamadı, hata mesajı gösterilebilir
        echo "Alış şube bulunamadı.";
        exit;
    }
} else {
    // Alış şube parametresi belirtilmemiş veya boş, hata mesajı gösterilebilir
    echo "Alış şube belirtilmemiş veya boş.";
    exit;
}

// Varış şubesi (varsayılan olarak alış şubesi ile aynı)
if(isset($_GET['varis_sube']) && !empty($_GET['varis_sube'])) {
    $varis_sube = $_GET['varis_sube'];
    $sql = "SELECT * FROM Subeler WHERE Sube_id=$varis_sube";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $sube = $result->fetch_assoc();

        $varis_sube_ad = $sube['Sube_adı'];
    }
} else {
    // Eğer varış şubesi belirtilmemişse, alış şubesini varsayılan olarak kullan
    $varis_sube_ad = $alis_sube_ad;
}



// Aracı getir
if(isset($_GET['id'])) {
    $arac_id = $_GET['id'];
    
    $sql = "SELECT * FROM Araclar WHERE Arac_id=$arac_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $arac = $result->fetch_assoc();

        // Aracın adını ve modelini al
        $secilen_arac_ad_model = $arac['Arac_marka'] . ' ' . $arac['Arac_model'];
    } else {
        // Arac bulunamadı, hata mesajı gösterilebilir
        echo "Arac bulunamadı.";
        exit;
    }
} else {
    // Arac ID belirtilmemiş, hata mesajı gösterilebilir
    echo "Arac ID belirtilmemiş.";
    exit;
}

// Tarih aralığı
$baslangic_tarihi = isset($_GET['baslangic_tarihi']) ? $_GET['baslangic_tarihi'] : "Belirtilmedi";
$bitis_tarihi = isset($_GET['bitis_tarihi']) ? $_GET['bitis_tarihi'] : "Belirtilmedi";
$tarih_araligi = $baslangic_tarihi . ' - ' . $bitis_tarihi;

// Adım
$adim = isset($_GET['adim']) ? $_GET['adim'] : 2; 

// Aktif tik işaretini oluştur
function aktifTik($hedefAdim, $simdikiAdim) {
    if ($hedefAdim == $simdikiAdim) {
        return '<span class="tik">&#10003;</span>';
    } else {
        return '';
    }
}

$gunluk_bedel = $arac['Arac_gunluk_ucret'];


$gunsayisi = $_SESSION['gun_sayisi'];
if ($gunsayisi == 0) {
    $gunsayisi = 1;
}else {
    $gunsayisi += 1; // Başlangıç tarihinin de dahil edilmesi gerekiyor
}

$toplam_bedel = $arac['Arac_gunluk_ucret'] * $gunsayisi;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/AracKiralama/css/login.css">
    <link rel="stylesheet" href="/AracKiralama/css/aracdetay.css">
    <title>Araç Detay</title>
</head>

<body>
 <!-- Navbar -->
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Araç Kiralama</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/AracKiralama/Index.php">Anasayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/AracKiralama/hakkimizda.php">Hakkımızda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/AracKiralama/iletisim.php">İletişim</a>
                    </li>
                    <?php echo $loginLink; ?>
                    <?php echo $signupLink; ?>
                    <?php echo $welcomeMessage; ?>
                    <?php echo $logoutLink; ?>
                </ul>
            </div>
        </div>
    </nav>
    <nav class="detaylar">
    <ul>
    <li class="<?php echo $adim == 1 ? 'active' : ''; ?>"><?php echo aktifTik(1, $adim); ?> Tarih Aralığı: <?php echo $tarih_araligi; ?> | Alış Şube: <?php echo $alis_sube_ad; ?> |  Varış Şube: <?php echo $varis_sube_ad; ?></li>
    <li class="<?php echo $adim == 2 ? 'active' : ''; ?>"><?php echo aktifTik(2, $adim); ?> Seçilen Araç: <?php echo $secilen_arac_ad_model; ?></li>
<li class="<?php echo $adim == 3 ? 'active' : ''; ?>"><?php echo aktifTik(3, $adim); ?> Ödeme Bilgileri</li>
        <!-- Diğer adımlar buraya eklenebilir -->
    </ul>
</nav>



    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($arac['Arac_Görsel']); ?>" class="img-fluid rounded" alt="Arac_Görsel">
            </div>
            <div class="col-md-6">
                <h2 class="mt-4"><?php echo $arac['Arac_marka']; ?> <?php echo $arac['Arac_model']; ?></h2>
                <p class="lead">Yıl: <?php echo $arac['Arac_yil']; ?></p>
                <p class="lead">Renk: <?php echo $arac['Arac_renk']; ?></p>
                <p class="lead">Günlük Ücret: <?php echo $gunluk_bedel; ?> ₺</p>
                <p class="lead"><?php echo $gunsayisi; ?> Gün'ün Toplam Ücreti": <?php echo $toplam_bedel; ?> ₺</p>
                <hr>
                <!-- Diğer araç özellikleri buraya eklenebilir -->

                <!-- Ek seçenekler -->
                <div class="ek-secenekler mt-4">
                    <h3>Ek Seçenekler</h3>
                    <!-- Ek seçenekler buraya eklenebilir -->
                </div>
                <button type="button" class="btn btn-primary btn-lg btn-block mt-4">Kirala</button>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">Araç Kiralama &copy; 2024</span>
        </div>
    </footer>


    <script type="text/javascript" src="js/arac.js"></script>
    <script type="text/javascript" src="js/tarih.js"></script>


        
</body>
</html>
