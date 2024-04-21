<?php
include 'database.php';
include 'bootstrap.php';

$welcomeMessage = "";
$logoutLink = "";
$loginLink = "<a class='nav-link' aria-current='page' href='/AracKiralama/login.php'>Giriş Yap</a>";
$signupLink = "<a class='nav-link' href='/AracKiralama/register.php'>Kayıt Ol</a>";

// Kullanıcı giriş yapmışsa
if (isset($_SESSION['Kullanici_id'])) {
    $musteriID = $_SESSION['Kullanici_id'];

    // Müşteri bilgilerini çek
    $musteriQuery = "SELECT * FROM kullanicilar WHERE kullanici_id = $musteriID";
    $musteriResult = $conn->query($musteriQuery);

    if ($musteriResult->num_rows > 0) {
        $musteri = $musteriResult->fetch_assoc();
        $isim = $musteri['kullanici_adi']; // "Musteriler_Adi" sütun adını kullanarak adı çekin
        $welcomeMessage = "<h1 id='hosgeldin' class='welcome-message'>Hoşgeldiniz, " . $isim . "</h1>";
        
    }

    $logoutLink = "<a class='nav-link' href='/PHP-Project/logout.php'>Çıkış Yap</a>";
    $loginLink = ""; // Giriş yap linkini görünmez yap
    $signupLink = ""; // Kayıt ol linkini görünmez yap
}





// Araç listesini getir
$sql = "SELECT * FROM Araclar";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <?php echo $welcomeMessage; ?>
                <?php echo $logoutLink; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Ana içerik -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Araç Kiralama Sistemi</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="rezervasyon.php" method="post">
                    <div class="form-group">
                        <label for="sube">Şube:</label>
                        <select name="sube" id="sube" class="form-control">
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
                    <div id="araclar" class="mb-3"></div>
                    <button type="submit" class="btn btn-primary btn-block">Rezervasyon Yap</button>
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