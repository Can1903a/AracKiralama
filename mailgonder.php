<?php
session_start();
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
        $gideceksifre = $row['Kullanici_sifre']; 

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->Host = "smtp.gmail.com";
        $mail->Username = "eucar4941@gmail.com"; //bu kısma ayarlarını yaptığınız mail adresi
        $mail->Password = "icuccfbliqcppucj"; //bu kısma 16 basamaklı şifrenizi yapıştırmalısınız
        $mail->setFrom('eucar4941@gmail.com', 'Sifre Hatirlatma');
        $mail->addAddress($gemail);
        $mail->Subject = "Sifre Hatırlatma";
        $mail->Body = "Sifreniz: ".$gideceksifre;

        if ($mail->send()) {
            $_SESSION['message'] = array(
                "type" => "success",
                "text" => "Şifre hatırlatma e-postası gönderildi."
            );
        } else {
            $_SESSION['message'] = array(
                "type" => "error",
                "text" => "E-posta gönderilemedi. Hata: " . $mail->ErrorInfo
            );
        }
    } else {
        $_SESSION['message'] = array(
            "type" => "error",
            "text" => "Bu e-posta adresi ile kayıtlı bir kullanıcı bulunamadı."
        );
    }

    $query->close();
    $conn->close();

    // Redirect to login page
    header("Location: login.php");
    exit();
}
?>
