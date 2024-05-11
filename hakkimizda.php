<?php
include 'database.php';
include 'bootstrap.php';
session_start();

// Hakkımızda bilgilerini veritabanından al
$hakkimizdaQuery = "SELECT * FROM hakkimizda";
$hakkimizdaResult = $conn->query($hakkimizdaQuery);

// Hakkımızda bilgilerini dizi olarak al
$hakkimizdaBilgileri = $hakkimizdaResult->fetch_assoc();

// Hakkımızda başlık ve açıklamasını değişkenlere ata
$baslik = $hakkimizdaBilgileri['baslik'];
$aciklama = $hakkimizdaBilgileri['aciklama'];

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <link rel="stylesheet" href="/AracKiralama/css/hakkimizda.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
    <title>Hakkımızda</title>
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
    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">Araç Kiralama &copy; 2024</span>
        </div>
    </footer>

    <script type="text/javascript" src="js/arac.js"></script>
</body>
</html>
