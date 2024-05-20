<?php
include 'database.php';

// Hakkımızda bilgilerini veritabanından al
$query = "SELECT * FROM hakkimizda";
$result = mysqli_query($conn, $query);
$hakkimizda = mysqli_fetch_assoc($result);

// Form gönderildiğinde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $baslik = $_POST["baslik"];
    $aciklama = $_POST["aciklama"];

    // Veritabanında güncelleme yap
    $update_query = "UPDATE hakkimizda SET baslik='$baslik', aciklama='$aciklama' WHERE idhakkimizda=1";
    mysqli_query($conn, $update_query);

    // Sayfayı yenile
    header("Refresh:0");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/AracKiralama/AdminSayfalari/css/AdminSayfa.css"> 
    <link rel="stylesheet" href="/AracKiralama/AdminSayfalari/css/HakkimizdaYonetimi.css"> 
</head>
<body>
    <div class="sidebar">
    <h2>Admin Paneli</h2>
        <div class="menu">
            <ul>
                <li><a href="/AracKiralama/AdminSayfalari/AdminSayfa.php">Anasayfa</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/AracYonetimi.php">Araç Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/BlogYonetimi.php">Blog Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/HakkimizdaYonetimi.php" class="active">Hakkımızda Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/IletisimYonetimi.php">İletişim Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/RezervasyonYonetimi.php">Rezervasyon Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/KullanicilariYonet.php">Kullanıcıları Yönet</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <h2>Hakkımızda Yönetimi</h2>
        <form method="POST">
            <label for="baslik">Başlık:</label><br>
            <input type="text" id="baslik" name="baslik" value="<?php echo $hakkimizda['baslik']; ?>"><br><br>
            <label for="aciklama">Açıklama:</label><br>
            <textarea id="aciklama" name="aciklama" rows="4" cols="50"><?php echo $hakkimizda['aciklama']; ?></textarea><br><br>
            <input type="submit" value="Kaydet">
        </form>
    </div>
</body>
</html>
