<?php

include 'database.php';
include 'bootstrap.php';
session_start();

$welcomeMessage = "";
$logoutLink = "";
<<<<<<< Updated upstream
$loginLink = "<a class='nav-link' href='/AracKiralama/login.php'>Giriş Yap</a>";
$signupLink = "<a class='nav-link' href='/AracKiralama/register.php'>Kayıt Ol</a>";
=======
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
>>>>>>> Stashed changes

// Kullanıcı giriş yapmışsa
if (isset($_SESSION['Kullanici_id'])) {
    $KullaniciID = $_SESSION['Kullanici_id'];

    // Müşteri bilgilerini çek
    $KullaniciQuery = "SELECT * FROM kullanici WHERE Kullanici_id= $KullaniciID";
    $KullaniciResult = $conn->query($KullaniciQuery);

    if ($KullaniciResult->num_rows > 0) {
        $kullanici = $KullaniciResult->fetch_assoc();
        $isim = $kullanici['Kullanici_isim']; 
        $welcomeMessage = "<h1 id='hosgeldin' class='welcome-message'>Hoşgeldiniz, " . $isim . "</h1>";
    }

    $logoutLink = "<a class='nav-link' href='/AracKiralama/logout.php'>Çıkış Yap</a>";
    $loginLink = ""; // Giriş yap linkini görünmez yap
    $signupLink = ""; // Kayıt ol linkini görünmez yap
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/AracKiralama/css/login.css">
    <title>Araç Kiralama</title>
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
                    <a class="nav-link" href="#">Anasayfa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Hakkımızda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">İletişim</a>
                </li>
                <?php echo $loginLink; ?>
                <?php echo $signupLink; ?>
                <?php echo $logoutLink; ?>
                <?php echo $welcomeMessage; ?>
            </ul>
        </div>
    </div>
</nav>


    <!-- Ana içerik -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Araç Kiralama Sistemi</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="araclar.php" method="get">
                    <div class="form-group">
                        <label for="sube">Şube:</label>
                        <select name="sube" id="sube" class="form-control" required>
                            <option value="">Şube Seçiniz</option>
                            <?php
                             $sql = "SELECT * FROM Subeler";
                             $result = $conn->query($sql);
                             while($row = $result->fetch_assoc()) {
                                 echo "<option value='".$row['Sube_id']."'>".$row['Sube_adı']."</option>";
                             }
                            ?> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="baslangic_tarihi">Başlangıç Tarihi:</label>
                        <input type="text" id="baslangic_tarihi" name="baslangic_tarihi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="bitis_tarihi">Bitiş Tarihi:</label>
                        <input type="text" id="bitis_tarihi" name="bitis_tarihi" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Araçları Göster</button>
                </form>
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