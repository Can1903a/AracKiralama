<?php
include 'database.php';

// Eğer form gönderildiyse
if(isset($_POST['kaydet'])) {
    $baslik = $_POST['baslik'];
    $icerik = $_POST['icerik'];

    // Yeni resim yüklendiyse
    if(isset($_FILES['yeni_resim']) && $_FILES['yeni_resim']['error'] == 0) {
        $resim = addslashes(file_get_contents($_FILES['yeni_resim']['tmp_name']));
        $insert_query = "INSERT INTO blog (baslik, icerik, resim) VALUES ('$baslik', '$icerik', '$resim')";
        
        // Blogu veritabanına ekle
        if(mysqli_query($conn, $insert_query)) {    
            echo "Yeni blog başarıyla eklendi.";
            // Formu temizle
            $_POST = array();
        } else {
            echo "Yeni blog eklenirken bir hata oluştu: " . mysqli_error($conn);
        }
    } else {
        echo "Lütfen bir resim seçin.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/AracKiralama/AdminSayfalari/css/AdminSayfa.css">
    <link rel="stylesheet" href="/AracKiralama/AdminSayfalari/css/BlogDuzenle.css"> <!-- Harici CSS dosyası -->
</head>
<body>
    <div class="sidebar">
        <h2>Admin Paneli</h2>
        <div class="menu">
            <ul>
                
                <li><a href="/AracKiralama/AdminSayfalari/AracYonetimi.php">Araç Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/BlogYonetimi.php">Blog Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/HakkimizdaYonetimi.php">Hakkımızda Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/IletisimYonetimi.php">İletişim Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/RezervasyonYonetimi.php">Rezervasyon Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/KullanicilariYonet.php">Kullanıcıları Yönet</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <h2>Blog Ekle</h2>
        <!-- Blog ekleme formu -->
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="baslik">Başlık:</label><br>
            <input type="text" id="baslik" name="baslik"><br>
            <label for="icerik">İçerik:</label><br>
            <textarea id="icerik1" name="icerik"></textarea><br>
            <label for="yeni_resim">Resim:</label><br>
            <input type="file" id="yeni_resim" name="yeni_resim"><br>
            <input type="submit" name="kaydet" value="Kaydet">
        </form>
    </div>
</body>
</html>
