<?php
include 'database.php';
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
        if (password_verify($KullaniciSifre, $row['Kullanici_sifre']) && $KullaniciEmail == $row['Kullanici_eposta']) {
            // Giriş başarılı
            $_SESSION['Kullanici_id'] = $row['Kullanici_id'];
            echo 'success';
            exit();
        } else {
            // Hatalı giriş
            echo 'Kullanıcı adı veya şifre hatalı.';
            exit();
        }
    } else {
        // Kullanıcı bulunamadı
        echo 'Kullanıcı bulunamadı.';
        exit();
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
    <form action="login.php" method="post" onsubmit="event.preventDefault(); login(); "> <!-- Form action düzeltilmeli -->
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

  <script>
    function login() {
        // Form verilerini al
        var email = document.getElementById('eposta').value;
        var password = document.getElementById('sifre').value;

        // Ajax isteği gönder
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "login.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = xhr.responseText;
                if (response.trim() === 'success') { // trim ile boşlukları temizle
                    // Başarılı giriş
                    window.location.href = "/AracKiralama/index.php";
                } else {
                    // Hatalı giriş, uyarı göster
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: response,
                        confirmButtonText: 'Tamam'
                    });
                }
            }
        };
        xhr.send("Kullanici_eposta=" + email + "&Kullanici_sifre=" + password);
    }
</script>
</body>
</html>