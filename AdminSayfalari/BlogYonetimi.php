<?php
include 'database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/AracKiralama/AdminSayfalari/css/AdminSayfa.css">  <!-- Harici CSS dosyası -->
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <div class="menu">
            <ul>
                <li><a href="/AracKiralama/AdminSayfalari/AdminSayfa.php">Anasayfa</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/AracYonetimi.php">Araç Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/BlogYonetimi.php" class="active">Blog Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/HakkimizdaYonetimi.php">Hakkımızda Yönetimi</a></li>
                <li><a href="/AracKiralama/AdminSayfalari/IletisimYonetimi.php">İletişim Yönetimi</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <h2>Blog Yönetimi</h2>
        <!-- Buraya içerik gelecek -->
    </div>
</body>
</html>
