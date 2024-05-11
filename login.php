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
        if ($KullaniciSifre == $row['Kullanici_sifre'] && $KullaniciEmail == $row['Kullanici_eposta']) {
            // Giriş başarılı, oturumu başlat
            $_SESSION['Kullanici_id'] = $row['Kullanici_id'];
            header("Location: /AracKiralama/index.php");
            exit();
        } else {
            // Hatalı giriş, SweetAlert2 ile kullanıcıya uyarı göster
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Hata!",
                        text: "Hatalı şifre veya kullanıcı adı!",
                        confirmButtonText: "Tamam"
                    });
                </script>';
        }
    } else {
        // Kullanıcı bulunamadı, SweetAlert2 ile kullanıcıya uyarı göster
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Hata!",
                    text: "Böyle bir kullanıcı bulunamadı!",
                    confirmButtonText: "Tamam"
                });
            </script>';
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
<body>
  <div class="ustkisim">
    <!-- Navbar kodları buraya eklenebilir -->
  </div>
  
  <div class="container">
    <form action="login.php" method="post">
      <div class="header">
        <img src="/AracKiralama/images/CarDuckLogo.png" alt="Resim" class="  logo">
        <h1 class="baslik">HOŞGELDİNİZ</h1>
      </div>
      <div class="input-box">
        <input type="email" placeholder="Eposta Adresi" id="eposta" name="Kullanici_eposta" required>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Şifre" id="sifre" name="Kullanici_sifre" required>
        <i class='bx bxs-lock-alt'></i>
      </div>
      <button type="submit" class="btn">Giriş Yap</button>
    </form>
  </div>
</body>
</html>
