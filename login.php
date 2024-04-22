<?php
include 'database.php';
include 'bootstrap.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $KullaniciEmail = $_POST['Kullanici_eposta'];
    $KullaniciSifre = $_POST['Kullanici_sifre'];

    // Veritabanında bu kullanıcıyı kontrol et
    $sql = "SELECT * FROM kullanici WHERE Kullanici_eposta = '$KullaniciEmail'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Şifre kontrolü
        if (password_verify($KullaniciSifre, $row['Kullanici_sifre']) || $KullaniciEmail == $row['Kullanici_eposta']) {
            // Giriş başarılı, oturumu başlat
            $_SESSION['Kullanici_id'] = $row['Kullanici_id'];
            header("Location: /AracKiralama/index.php");
            exit();
        } else {
            echo "Hatalı şifre";
        }
    } else {
        echo "Böyle bir kullanıcı bulunamadı";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/AracKiralama/css/register.css">
    <link rel="stylesheet" href="/AracKiralama/css/login.css">
</head>
<div class="ustkisim">
<body>

   <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
   
      <div class="navbar">
        <img src="/AracKiralama/images/CarDuckLogo.png" alt="Resim" class="logo">
        <ul class="navbar-nav ml-auto">
         
          <li class="nav-item d-flex align-items-center">
            <a class="nav-link active" aria-current="page" href="#">AnaSayfa</a>
            <span class="ayrac">|</span>
          </li>
  
          <li class="nav-item d-flex align-items-center">
            <a class="nav-link" href="#">Hakkımızda</a>
            <span class="ayrac">|</span>
          </li>
  
          <li class="nav-item d-flex align-items-center">
            <a class="nav-link" href="#">Araçlar</a>
            <span class="ayrac">|</span>
          </li>
  
          <li class="nav-item d-flex align-items-center">
            <a class="nav-link" href="#">Üye Girişi</a>
            <span class="ayrac">|</span>
          </li>
  
        </ul>
    
  
    </div >
  
  </nav>-->
  </div>
  
  
  <div class="container">
<<<<<<< Updated upstream
    <form action="login.php" method="post"> <!-- Form action düzeltilmeli -->
=======
    <form action="register.php" method="post">
>>>>>>> Stashed changes
      <div class="header">
        <img src="/AracKiralama/images/CarDuckLogo.png" alt="Resim" class="  logo">
        <h1 class="baslik">HOŞGELDİNİZ</h1>
      </div>
      <div class="input-box">
        <input type="email" placeholder="Eposta Adresi" id="eposta" name="Kullanici_eposta" required>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Şifre" id="sifre" name="Kullanici_sifre"required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <button type="submit" class="btn">Giriş Yap</button>
    </form>
  </div>
</body>
</html>