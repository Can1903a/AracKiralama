<?php
include 'database.php';

// Mevcut araçları veritabanından al
$query = "SELECT * FROM araclar";
$result = mysqli_query($conn, $query);

// Araçları silme işlemini burada gerçekleştir
if(isset($_POST['sil']) && is_array($_POST['sil'])) {
    $silinenler = $_POST['sil'];
    
    // Eğer seçili araç varsa işlemi gerçekleştir
    if(!empty($silinenler)) {
        foreach($silinenler as $arac_id) {
            // Silme sorgusu
            $sil_query = "DELETE FROM araclar WHERE Arac_id = $arac_id";
            
            // Sorguyu çalıştır
            if(mysqli_query($conn, $sil_query)) {
                echo "Araç(ID: $arac_id) başarıyla silindi.<br>";
                header("Refresh:0");
            } else {
                echo "Araç(ID: $arac_id) silinirken bir hata oluştu: " . mysqli_error($conn) . "<br>";
            }
        }
    }
} else {
    // $_POST['sil'] bir dizi değilse, yani araç seçilmemişse, bir mesaj göster
    echo "Lütfen silinecek araçları seçin.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/AracKiralama/AdminSayfalari/css/AdminSayfa.css">
    <link rel="stylesheet" href="/AracKiralama/AdminSayfalari/css/AracYonetimi.css"> <!-- Harici CSS dosyası -->
</head>
<body>
    <div class="sidebar">
        <h2>Admin Paneli</h2>
        <div class="menu">
            <ul>
                <li><a href="/AracKiralama/AdminSayfalari/AdminSayfa.php">Anasayfa</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/AracYonetimi.php" class="active">Araç Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/BlogYonetimi.php">Blog Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/HakkimizdaYonetimi.php">Hakkımızda Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/IletisimYonetimi.php">İletişim Yönetimi</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <h2>Araç Yönetimi</h2>
        <a href="/AracKiralama/AdminSayfalari/aracEkle.php" class="add-button">Yeni Araç Ekle</a> <!-- Yeni araç ekleme butonu -->
        
        <form method="POST" action="">
            <input type="submit" name="sil" value="Seçili Araçları Sil" class="delete-button">
            <div class="card-container">
                <!-- Her bir aracı döngüyle listele -->
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='card'>";
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row['Arac_Görsel']) . '" alt="' . $row['Arac_marka'] . '">';
                    // Burada araç bilgilerini listeleme işlemini gerçekleştir
                    echo "<div class='card-content'>";
                    echo "<h3><strong>" . $row['Arac_marka'] . " " . $row['Arac_model'] . "</strong></h3>";
                    echo "<p><strong>Yıl:</strong> " . $row['Arac_yil'] . "</p>";
                    echo "<p><strong>Renk:</strong> " . $row['Arac_renk'] . "</p>";
                    echo "<p><strong>Günlük Ücret:</strong> " . $row['Arac_gunluk_ucret'] . "</p>";
                    echo "<p><strong>Durum:</strong> " . $row['Arac_durum'] . "</p>";
                    
                    // Şube adını almak için sorgu oluştur
                    $sube_query = "SELECT Sube_adi FROM subeler WHERE Sube_id = " . $row['sube_id'];
                    $sube_result = mysqli_query($conn, $sube_query);
                    $sube_row = mysqli_fetch_assoc($sube_result);

                    echo "<p><strong>Bulunduğu Şube:</strong> " . $sube_row['Sube_adi'] . "</p>";
                    echo "<br>";
                    echo "Seç: <input type='checkbox' name='sil[]' value='" . $row['Arac_id'] . "' class='checkbox'>"; // Her araç için bir seçim kutusu oluştur
                    echo "<br>";                    
                    echo "<button type='button' onclick=\"window.location.href='/AracKiralama/AdminSayfalari/aracDuzenle.php?id=" . $row['Arac_id'] . "'\" class='edit-button'>Aracı Düzenle</button>"; // Her araç için aracı düzenleme butonu
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </form>
    </div>
</body>
</html>
