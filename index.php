<?php
include 'database.php';
include 'bootstrap.php';
session_start();

$welcomeMessage = "";
$logoutLink = "";
$loginLink = "<a class='nav-link' href='/AracKiralama/login.php'>Giriş Yap</a>";
$signupLink = "<a class='nav-link' href='/AracKiralama/register.php'>Kayıt Ol</a>";


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


    <!-- Ana içerik -->
<div class="container mt-5">
    <h1 class="text-center mb-4">Araç Kiralama Sistemi</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="araclar.php" method="get">
                <div class="form-group">
                    <label for="alis_sube">Alış Şubesi:</label>
                    <select name="alis_sube" id="alis_sube" class="form-control" required>
                        <option value="">Alış Şubesi Seçiniz</option>
                        <?php
                         $sql = "SELECT * FROM Subeler";
                         $result = $conn->query($sql);
                         while($row = $result->fetch_assoc()) {
                             echo "<option value='".$row['Sube_id']."'>".$row['Sube_adı']."</option>";
                         }
                        ?> 
                    </select>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="farkli_varis_sube" name="farkli_varis_sube">
                    <label class="form-check-label" for="farkli_varis_sube">Farklı Varış Şubesi</label>
                </div>
                <div id="varis_sube_container" style="display: none;">
                    <div class="form-group">
                        <label for="varis_sube">Varış Şubesi:</label>
                        <select name="varis_sube" id="varis_sube" class="form-control">
                            <option value="">Varış Şubesi Seçiniz</option>
                            <?php
                             mysqli_data_seek($result, 0); // İlk satıra geri dön
                             while($row = $result->fetch_assoc()) {
                                 echo "<option value='".$row['Sube_id']."'>".$row['Sube_adı']."</option>";
                             }
                            ?> 
                        </select>
                    </div>
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

<script>
    // Farklı varış şubesi kutucuğunun durumuna göre varış şubesi seçim alanını göster/gizle
    document.getElementById('farkli_varis_sube').addEventListener('change', function() {
        var varisSubeContainer = document.getElementById('varis_sube_container');
        if (this.checked) {
            varisSubeContainer.style.display = 'block';
        } else {
            varisSubeContainer.style.display = 'none';
        }
    });
</script>


    
    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">Araç Kiralama &copy; 2024</span>
        </div>
    </footer>


    <script type="text/javascript" src="js/arac.js"></script>
    <script type="text/javascript" src="js/logout.js"></script>

</body>
</html>