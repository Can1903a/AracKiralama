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
  <link rel="stylesheet" href="/AracKiralama/css/index.css">
    <title>Araç Kiralama</title>
   
</head>
<body>
    
    <!-- Navbar -->
<nav class="navbar navbar-expand-lg   #ff7b00 fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Araç Kiralama</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/AracKiralama/Index.php">Anasayfa |</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="/AracKiralama/hakkimizda.php">Hakkımızda |</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/AracKiralama/iletisim.php">İletişim |</a>
                </li>
                
                <?php echo $loginLink ;  ?>
               
                <?php echo $signupLink ; ?>
                
                 <?php echo $welcomeMessage ; ?>
            
                <?php echo $logoutLink ; ?>
        
            </ul>
        </div>
    </div>
</nav>

<br>    
<br>    

        <!-- Ana içerik -->
    <div class="main-container mt-5">
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
                        <input type="text" id="baslangic_tarihi" name="baslangic_tarihi"  class="form-control" readonly="readonly" required>
                    </div>
                    <div class="form-group">
                        <label for="bitis_tarihi">Bitiş Tarihi:</label>
                        <input type="text" id="bitis_tarihi" name="bitis_tarihi" class="form-control" readonly="readonly" required disabled>
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
<br>
<br>
<br>
<br>
<div class="foto">
</div>

<br>
<br>

<!-- Blog Bölümü -->
<section id="blog" class="container-fluid mt-5">
<br>    
    <h2 class="text-center mb-4">Son Blog Yazıları</h2>
    <div class="row justify-content-center">
        <!-- Blog Kartları -->
        <?php
        // İçerik sütunundaki metni kısaltmak için fonksiyon
function kisalt($metin, $uzunluk = 30, $son = '...') {
    if (strlen($metin) <= $uzunluk) {
        return $metin;
    }
    $kisaltilmisMetin = substr($metin, 0, $uzunluk);
    // Kısaltılan metni boşluğa göre ayır ve sondaki kelimeyi sil
    $kisaltilmisMetin = substr($kisaltilmisMetin, 0, strrpos($kisaltilmisMetin, ' '));
    return $kisaltilmisMetin . $son;
}
        // Blog gönderilerini veritabanından al
        $blogQuery = "SELECT * FROM blog ORDER BY id DESC LIMIT 3"; // Örnek sorgu, 3 adet en son blog gönderisini alır
        $blogResult = $conn->query($blogQuery);

        if ($blogResult->num_rows > 0) {
            while($row = $blogResult->fetch_assoc()) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['resim']) . '" class="card-img-top" alt="Blog Resmi">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['baslik'] . '</h5>';
                echo '<p class="card-text">' . kisalt($row['icerik'], 180   ) . '</p>';
                echo '<a href="blogdetay.php?id=' . $row['id'] . '" class="btn btn-primary">Devamını Oku</a>';
                echo '</div></div></div>';
            }
        } else {
            echo '<p class="text-center">Henüz blog gönderisi bulunmamaktadır.</p>';
        }
        
        ?>
        
    </div>

</section>

<br>
<br>
<br>    
    
    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="footer-container text-center">
            <span class="text-muted">Araç Kiralama &copy; 2024. Tüm hakları saklıdır.</span>
        </div>
    </footer>


    <script type="text/javascript" src="js/arac.js"></script>
    <script type="text/javascript" src="js/logout.js"></script>
    <script type="text/javascript" src="js/tarih.js"></script>
</body>
</html>