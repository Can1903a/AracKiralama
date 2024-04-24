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
$sube_id = $_GET['sube'];
// Seçilen tarih aralığı
$baslangic_tarihi = $_GET['baslangic_tarihi'];
$bitis_tarihi = $_GET['bitis_tarihi'];
// Seçilen tarih aralığına göre gün sayısı hesapla
$baslangic = strtotime($baslangic_tarihi);
$bitis = strtotime($bitis_tarihi);
$gun_sayisi = ($bitis - $baslangic) / (60 * 60 * 24);
// Toplam kiralama bedeli için değişken
$toplam_bedel = 0;

// Veritabanından araçların günlük ücretlerini al
$sql = "SELECT Arac_gunluk_ucret FROM Araclar WHERE Arac_durum='Bos' AND sube_id=$sube_id";
$result = $conn->query($sql);

// Her bir aracın günlük ücreti ile gün sayısını çarpıp toplam fiyatı hesapla
while($row = $result->fetch_assoc()) {
    $gunluk_ucret = $row['Arac_gunluk_ucret'];
    $toplam_bedel += $gunluk_ucret * $gun_sayisi;
}
$_SESSION['toplam_bedel'] = $toplam_bedel;
// Tarih aralığı
$baslangic_tarihi = isset($_GET['baslangic_tarihi']) ? $_GET['baslangic_tarihi'] : "Belirtilmedi";
$bitis_tarihi = isset($_GET['bitis_tarihi']) ? $_GET['bitis_tarihi'] : "Belirtilmedi";
$tarih_araligi = $baslangic_tarihi . ' - ' . $bitis_tarihi;
// Adım
$adim = isset($_GET['adim']) ? $_GET['adim'] : 1; 
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
// Aktif tik işaretini oluştur
function aktifTik($hedefAdim, $simdikiAdim) {
    if ($hedefAdim == $simdikiAdim) {
        return '<span class="tik">&#10003;</span>';
    } else {
        return '';
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/AracKiralama/css/araclar.css">
    <link rel="stylesheet" href="/AracKiralama/css/aracdetay.css">
    <link rel="stylesheet" href="/AracKiralama/css/login.css">
    <title>Boş Araçlar</title>
   
    <style>
        body {
            padding-top: 60px; /* Navbar'ı gölgelememesi için */
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f5f5f5;
            text-align: center;
            padding: 10px 0;
        }
    </style>
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
    <li class="<?php echo $adim == 2 ? 'active' : ''; ?>"><?php echo aktifTik(2, $adim); ?> Seçilen Araç: </li>
<li class="<?php echo $adim == 3 ? 'active' : ''; ?>"><?php echo aktifTik(3, $adim); ?> Ödeme Bilgileri</li>
        <!-- Diğer adımlar buraya eklenebilir -->
    </ul>
</nav>
   <!-- Ana içerik -->
<!-- Ana içerik -->
<div class="container mt-5">
    <div class="row justify-content-center mt-5">
        <?php
        $sql = "SELECT * FROM Araclar WHERE Arac_durum='Bos' AND sube_id=$sube_id";
        $result = $conn->query($sql);
        if ($result->num_rows === 0) {
            echo '<div class="col-md-12"><p class="text-center">Müsait aracımız kalmamıştır.</p></div>';
        } else {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['Arac_marka']; ?></h5>
                            <p class="card-text">Model: <?php echo $row['Arac_model']; ?></p>
                            <p class="card-text">Yıl: <?php echo $row['Arac_yil']; ?></p>
                            <p class="card-text">Renk: <?php echo $row['Arac_renk']; ?></p>
                            <p class="card-text">Toplam Ücret: <?php echo $row['Arac_gunluk_ucret'] * $gun_sayisi; ?> ₺</p>
                            <?php 
                            // Aracın görsel varsa
                            if ($row['Arac_Görsel']) {
                                echo '<img src="data:image/jpeg;base64,'.base64_encode($row['Arac_Görsel']).'" class="card-img-top" alt="Arac_Görsel">';
                            }
                            ?>
                        </div>
                        <div class="card-footer">
                            <a href="/AracKiralama/aracdetay.php?id=<?php echo $row['Arac_id']; ?>&sube=<?php echo $sube_id; ?>&baslangic_tarihi=<?php echo $baslangic_tarihi; ?>&bitis_tarihi=<?php echo $bitis_tarihi; ?>" class="btn btn-primary btn-block">Detayları Gör</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
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
</html>
