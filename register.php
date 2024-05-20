<?php
include 'database.php';
include 'bootstrap.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $KullaniciIsim = $_POST['Kullanici_isim'];
  $KullaniciSoyisim = $_POST['Kullanici_soyisim'];
  $KullaniciEposta = $_POST['Kullanici_eposta'];
  $KullaniciSifre = $_POST['Kullanici_sifre'];
  $Kullanicitelefon = $_POST['Kullanici_telefon'];


  $sql = "INSERT INTO kullanici (Kullanici_isim, Kullanici_soyisim, Kullanici_eposta, Kullanici_sifre, Kullanici_telefon)
          VALUES ('$KullaniciIsim', '$KullaniciSoyisim', '$KullaniciEposta', '$KullaniciSifre', '$Kullanicitelefon')";


  if ($conn->query($sql) === TRUE) {
    header("Location: /AracKiralama/index.php");
    exit();
      } else {
      echo "Hata: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/AracKiralama/css/register.css">
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
    <form action="register.php" method="post">
      <div class="header">
        <img src="/AracKiralama/images/CarDuckLogo.png" alt="Resim" class="  logo">
        <h1 class="baslik">HOŞGELDİNİZ</h1>
      </div>
      <div class="input-box">
        <input type="text" placeholder="İsim" id="isim" name="Kullanici_isim"required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <div class="input-box">
        <input type="text" placeholder="Soyisim" id="soyisim" name="Kullanici_soyisim"required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <div class="input-box">
        <input type="email" placeholder="Eposta Adresi" id="eposta" name="Kullanici_eposta" required>
      </div>
      <div class="input-box">
      <input type="text" placeholder="Telefon(5** *** ** **)" id="telefon" name="Kullanici_telefon" required>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Şifre" id="sifre" name="Kullanici_sifre"required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <button type="submit" class="btn">Kayıt Ol</button>
    </form>
  </div>
</body>
</html>
