<?php
include 'database.php';
include 'bootstrap.php';
session_start();

$welcomeMessage = "";
$logoutLink = "";
$loginLink = "<a class='nav-link' aria-current='page' href='/AracKiralama/login.php'>Giriş Yap</a>";
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
        $welcomeMessage = "<span class='nav-link'>Hoşgeldiniz, " . $isim . "</span>";
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

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/AracKiralama/css/araclar.css">
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

   <!-- Ana içerik -->
<div class="container mt-5">
    <div class="row justify-content-center mt-5">
        <?php
        include 'database.php';
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
                            <p class="card-text">Toplam Ücret: <?php echo $toplam_bedel; ?> ₺</p>
                            <!-- Ek olarak görsel de ekleyebilirsiniz -->
                            <?php 
                            // Aracın görsel varsa
                            if ($row['Arac_Görsel']) {
                                echo '<img src="data:image/jpeg;base64,'.base64_encode($row['Arac_Görsel']).'" class="card-img-top" alt="Arac_Görsel">';
                            }
                            ?>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-primary btn-block">Teklifi İncele</a>
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
