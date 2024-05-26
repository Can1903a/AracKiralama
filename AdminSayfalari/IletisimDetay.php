<?php
include 'database.php';

// Eğer URL'de id parametresi varsa ve bu parametre geçerli bir sayıysa, mesajın detaylarını al
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM iletisim WHERE idiletisim=$id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
} else {
    // Eğer id parametresi yoksa veya geçerli bir sayı değilse, kullanıcıyı geri yönlendir
    header("Location: /AracKiralama/AdminSayfalari/IletisimYonetimi.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim Mesajı Detayları</title>
    <link rel="stylesheet" href="/AracKiralama/AdminSayfalari/css/AdminSayfa.css"> 
    <link rel="stylesheet" href="/AracKiralama/AdminSayfalari/css/IletisimDetay.css"> 
    
</head>
<body>
    <div class="sidebar">
        <h2>Admin Paneli</h2>
        <div class="menu">
            <ul>
                
                <li><a href="/AracKiralama/AdminSayfalari/index.php">Araç Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/BlogYonetimi.php">Blog Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/HakkimizdaYonetimi.php">Hakkımızda Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/IletisimYonetimi.php">İletişim Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/RezervasyonYonetimi.php">Rezervasyon Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/KullanicilariYonet.php">Kullanıcıları Yönet</a></li>
                <li><a href="/AracKiralama/index.php">Çıkış Yap</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <h2>Mesaj Detayları</h2>
        <div class="message-details">
            <p><strong>Ad Soyad:</strong> <?php echo $row['adsoyad']; ?></p>
            <p><strong>E-Posta:</strong> <?php echo $row['eposta']; ?></p>
            <p><strong>Telefon:</strong> <?php echo $row['telno']; ?></p>           
            <p><strong>Konu:</strong> <?php echo $row['konu']; ?></p>
            <br>
            <p><strong>Mesaj:</strong></p>
            <div class="message"><?php echo $row['mesaj']; ?></div>
        </div>
    </div>
</body>
</html>
