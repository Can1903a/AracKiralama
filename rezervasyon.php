<?php
include 'database.php';

$sube_id = $_POST['sube'];
$baslangic_tarihi = date('Y-m-d', strtotime($_POST['baslangic_tarihi'])); // 'DD.MM.YYYY' -> 'YYYY-MM-DD' formatına dönüştür
$bitis_tarihi = date('Y-m-d', strtotime($_POST['bitis_tarihi'])); // 'DD.MM.YYYY' -> 'YYYY-MM-DD' formatına dönüştür
$toplam_ucret = 0;

// Toplam gün sayısını hesapla
$datetime1 = new DateTime($baslangic_tarihi);
$datetime2 = new DateTime($bitis_tarihi);
$interval = $datetime1->diff($datetime2);
$toplam_gun = $interval->format('%a');

// Günlük ücreti al
$sql = "SELECT Arac_gunluk_ucret FROM Araclar WHERE Arac_durum='Bos' AND sube_id=$sube_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$gunluk_ucret = $row['Arac_gunluk_ucret'];


$toplam_ucret = $toplam_gun * $gunluk_ucret;

// Rezervasyon yap
$sql = "INSERT INTO Rezervasyonlar (arac_id, baslangic_tarihi, bitis_tarihi, toplam_ucret) 
        SELECT Arac_id, '$baslangic_tarihi', '$bitis_tarihi', $toplam_ucret 
        FROM Araclar WHERE Arac_durum='Bos' AND sube_id=$sube_id LIMIT 1";
if ($conn->query($sql) === TRUE) {
    echo "Rezervasyon başarıyla yapıldı.";
} else {
    echo "Rezervasyon yaparken hata oluştu: " . $conn->error;
}

// Araç durumunu güncelle
$sql = "UPDATE Araclar SET Arac_durum='Dolu' WHERE Arac_durum='Bos' AND sube_id=$sube_id LIMIT 1";
$conn->query($sql);

$conn->close();
?>
