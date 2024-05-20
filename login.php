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
<style>

        .baslik {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .input-box {
            margin: 15px 0;
        }
        .input-box input {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn {
            background-color: #5cb85c;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .link {
            display: block;
            margin: 10px 0;
            color: #007bff;
            cursor: pointer;
            text-decoration: none;
        }
        .link:hover {
            text-decoration: underline;
        }
        .hidden {
            display: none;
        }
        .mesaj {
            margin-top: 20px;
            font-size: 14px;
        }
        .mesaj a {
            color: #007bff;
            text-decoration: none;
        }
        .mesaj a:hover {
            text-decoration: underline;
        }
    </style>
<body>
  <div class="ustkisim">
    <!-- Navbar kodları buraya eklenebilir -->
  </div>
  <script>
        function showForgotPasswordForm() {
            document.getElementById('forgot-password-form').classList.remove('hidden');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
<?php
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        echo "<script>
            Swal.fire({
                icon: '" . $message['type'] . "',
                title: '" . ($message['type'] == 'success' ? 'Başarılı!' : 'Hata!') . "',
                text: '" . $message['text'] . "',
                confirmButtonText: 'Tamam'
            });
        </script>";
        unset($_SESSION['message']);
    }
    ?>
    <div class="container">
        <form action="login.php" method="post">
            <div class="header">
                <img src="/AracKiralama/images/CarDuckLogo.png" alt="Resim" class="logo">
                <h1 class="baslik">HOŞGELDİNİZ</h1>
            </div>
            <div class="input-box">
                <input type="email" placeholder="Eposta Adresi" id="eposta" name="Kullanici_eposta" required>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Şifre" id="sifre" name="Kullanici_sifre" required>
            </div>
            <button type="submit" class="btn">Giriş Yap</button>
        </form>

        <a class="link" onclick="showForgotPasswordForm()">Şifremi Unuttum</a>
        <form id="forgot-password-form" action="mailgonder.php" method="POST" class="hidden">
            <div class="input-box">
                <input type="email" name="eposta" placeholder="Eposta giriniz" required />
            </div>
            <button class="btn" type="submit">GÖNDER</button>
        </form>

        <p class="mesaj">Üye Değil Misin? <a href="register.php">Hesap Oluştur</a></p>
    </div>
</body>
</html>
