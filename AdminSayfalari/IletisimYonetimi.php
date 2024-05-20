<?php
include 'database.php';

// İletişim bilgilerini veritabanından al
$query = "SELECT * FROM iletisim ORDER BY idiletisim DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/AracKiralama/AdminSayfalari/css/AdminSayfa.css">
    <link rel="stylesheet" href="/AracKiralama/AdminSayfalari/css/IletisimYonetimi.css">  
</head>
<body>
    <div class="sidebar">
        <h2>Admin Paneli</h2>
        <div class="menu">
            <ul>
                <li><a href="/AracKiralama/AdminSayfalari/AdminSayfa.php">Anasayfa</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/AracYonetimi.php">Araç Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/BlogYonetimi.php">Blog Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/HakkimizdaYonetimi.php">Hakkımızda Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/IletisimYonetimi.php" class="active">İletişim Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/RezervasyonYonetimi.php">Rezervasyon Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/KullanicilariYonet.php">Kullanıcıları Yönet</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <h2 class="IletisimYonetimi">İletişim Yönetimi</h2>
        <table>
            <tr>
                <th>Ad Soyad</th>
                <th>E-Posta</th>
                <th>Telefon</th>
                <th>Konu</th>
                <th>Mesaj</th>
            </tr>
            <?php
            // Her bir iletişim bilgisini döngüyle listele
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr onclick='window.location=\"/AracKiralama/AdminSayfalari/IletisimDetay.php?id=" . $row['idiletisim'] . "\";'>";
                echo "<td>" . $row['adsoyad'] . "</td>";
                echo "<td>" . $row['eposta'] . "</td>";
                echo "<td>" . $row['telno'] . "</td>";
                echo "<td>" . $row['konu'] . "</td>";
                echo "<td>";
                // Mesajın uzunluğunu kontrol et
                if (strlen($row['mesaj']) > 90) {
                    // Eğer mesaj 50 karakterden uzunsa, sadece ilk 50 karakteri göster ve bağlantı ekle
                    echo substr($row['mesaj'], 0, 90) . '... (Devamı İçin Tıklayınız)';
                } else {
                    // Eğer mesaj 90 karakterden kısa ise tamamını göster
                    echo $row['mesaj'];
                }
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
