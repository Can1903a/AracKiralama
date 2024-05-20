<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gemail = $_POST['eposta'];

    // Prepared statement to prevent SQL injection
    $query = $conn->prepare("SELECT * FROM kullanici WHERE Kullanici_eposta = ?");
    $query->bind_param('s', $gemail);
    $query->execute();
    $result = $query->get_result();
    $num_row = $result->num_rows;

    if ($num_row >= 1) {
        $row = $result->fetch_assoc();
        $gideceksifre = $row['Kullanici_sifre']; // Note: This is not secure. Do not send plain text passwords.

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->Host = "smtp.gmail.com";
        $mail->Username = "eucar4941@gmail.com"; //bu kısma ayarlarını yaptığınız mail adresi
        $mail->Password = "icuccfbliqcppucj"; //bu kısma 16 basamaklı şifrenizi yapıştırmalısınız
        $mail->setFrom('eucar4941@gmail.com', 'Şifre Hatırlatma');
        $mail->addAddress($gemail);
        $mail->Subject = "Sifre Hatirlatma";
        $mail->Body = "Sifreniz: ".$gideceksifre;

        if ($mail->send()) {
            echo "Şifre hatırlatma e-postası gönderildi.";
        } else {
            echo "E-posta gönderilemedi. Hata: " . $mail->ErrorInfo;
        }
    } else {
        echo "Bu e-posta adresi ile kayıtlı bir kullanıcı bulunamadı.";
    }

    $query->close();
    $conn->close();
}
?>
