<?php
include 'database.php';

// Kullanıcıları veritabanından al
$query = "SELECT Kullanici_id, Kullanici_isim, Kullanici_soyisim, Kullanici_eposta, kullanici_telefon FROM kullanici";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Yönetimi</title>
    <link rel="stylesheet" href="/AracKiralama/AdminSayfalari/css/AdminSayfa.css">
    <link rel="stylesheet" href="/AracKiralama/AdminSayfalari/css/KullanicilariYonet.css">
    <style>
        tbody tr:hover {
            cursor: pointer;
        }
    </style>
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
                <li><a href="/AracKiralama/AdminSayfalari/KullanicilariYonet.php" class="active">Kullanıcı Yönetimi</a></li>
                <li><a href="/AracKiralama/index.php">Çıkış Yap</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <h2>Kullanıcı Yönetimi</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>İsim</th>
                    <th>Soyisim</th>
                    <th>Email</th>
                    <th>Telefon</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr onclick="window.location.href='kullanicidetay.php?id=<?php echo $row['Kullanici_id']; ?>'">
                        <td><?php echo $row['Kullanici_id']; ?></td>
                        <td><?php echo $row['Kullanici_isim']; ?></td>
                        <td><?php echo $row['Kullanici_soyisim']; ?></td>
                        <td><?php echo $row['Kullanici_eposta']; ?></td>
                        <td><?php echo $row['kullanici_telefon']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>