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

// Subeyi getir
if(isset($_GET['sube']) && !empty($_GET['sube'])) {
    $sube_id = $_GET['sube'];
    
    $sql = "SELECT * FROM Subeler WHERE Sube_id=$sube_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $sube = $result->fetch_assoc();

        // Şube adını al
        $secilen_sube_ad = $sube['Sube_adı'];
    } else {
        // Şube bulunamadı, hata mesajı gösterilebilir
        echo "Sube bulunamadı.";
        exit;
    }
} else {
    // Sube parametresi belirtilmemiş veya boş, hata mesajı gösterilebilir
    echo "Sube belirtilmemiş veya boş.";
    exit;
}



// Aracı getir
if(isset($_GET['id'])) {
    $arac_id = $_GET['id'];
    
    $sql = "SELECT * FROM Araclar WHERE Arac_id=$arac_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $arac = $result->fetch_assoc();

        // Aracın adını ve modelini al
        $secilen_arac_ad = $arac['Arac_marka'];
        $secilen_arac_model = $arac['Arac_model'];
        $secilen_arac_ad_model = $secilen_arac_ad . ' ' . $secilen_arac_model; // Marka ve modeli birleştir
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

$toplam_bedel = isset($_SESSION['toplam_bedel_' . $arac_id]) ? $_SESSION['toplam_bedel_' . $arac_id] : 0;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/AracKiralama/css/login.css">
    <link rel="stylesheet" href="/AracKiralama/css/aracdetay.css">
    <title>Document</title>
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
                        <a class="nav-link" href="/AracKiralama/index.php">Anasayfa</a>
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
    <li class="<?php echo $adim == 1 ? 'active' : ''; ?>"><?php echo aktifTik(1, $adim); ?> Tarih Aralığı ve Şube Seçimi: <?php echo $tarih_araligi; ?> - <?php echo $secilen_sube_ad; ?></li>
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
                <p class="lead">Toplam Ücret: <?php echo $toplam_bedel; ?> ₺</p>
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


        
</body>
</html>