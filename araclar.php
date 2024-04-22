<?php
include 'database.php';
include 'bootstrap.php';

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boş Araçlar</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Boş Araçlar</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Marka</th>
                            <th>Model</th>
                            <th>Yıl</th>
                            <th>Renk</th>
                            <th>Günlük Ücret</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                             $sube_id = $_GET['sube'];
                             $baslangic_tarihi = $_GET['baslangic_tarihi'];
                             $bitis_tarihi = $_GET['bitis_tarihi'];
                             include 'database.php';
                             $sql = "SELECT * FROM Araclar WHERE Arac_durum='Bos' AND sube_id=$sube_id";
                             $result = $conn->query($sql);
                             while($row = $result->fetch_assoc()) {
                             echo "<tr>";
                             echo "<td>".$row['Arac_marka']."</td>";
                             echo "<td>".$row['Arac_model']."</td>";
                             echo "<td>".$row['Arac_yil']."</td>";
                             echo "<td>".$row['Arac_renk']."</td>";
                             echo "<td>".$row['Arac_gunluk_ucret']."</td>";
                             echo "</tr>";
                         }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
