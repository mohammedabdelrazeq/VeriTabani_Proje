<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Randevu Guncelle</title>
</head>
<body>
    <h1>Randevu Guncelle</h1>
    <form action="guncelle.php" method="post">
        Randevu ID: <input type="text" name="randevu_id" required><br>
        Yeni Tarih: <input type="date" name="tarih" required><br>
        Yeni Saat: <input type="time" name="saat" required><br>
        <input type="submit" value="Güncelle">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $randevu_id = $_POST['randevu_id'];
        $tarih = $_POST['tarih'];
        $saat = $_POST['saat'];

        try {
            // Veritabanı bağlantısı
            $pdo = new PDO("pgsql:host=127.0.0.1;dbname=VeriTabani_Proje", "postgres", "kaka2066");

            // Girilen randevu ID mevcut mu kontrol et
            $check_sql = "SELECT COUNT(*) FROM randevu WHERE randevuid = :randevu_id";
            $check_stmt = $pdo->prepare($check_sql);
            $check_stmt->execute([':randevu_id' => $randevu_id]);

            $exists = $check_stmt->fetchColumn();

            if ($exists) {
                // Randevu mevcutsa güncelle
                $update_sql = "UPDATE randevu SET tarih = :tarih, saat = :saat WHERE randevuid = :randevu_id";
                $update_stmt = $pdo->prepare($update_sql);
                $update_stmt->execute([
                    ':tarih' => $tarih,
                    ':saat' => $saat,
                    ':randevu_id' => $randevu_id
                ]);

                echo "<p style='color: green;'>Randevu basariyla guncellendi.</p>";
            } else {
                // Randevu mevcut değilse hata mesajı
                echo "<p style='color: red;'>Hata: Girilen randevu numarasi mevcut değil.</p>";
            }
        } catch (PDOException $e) {
            // Veritabanı hatası
            echo "<p style='color: red;'>Veritabani hatasi: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
    ?>
    <p>
    <a href="index.html" style="display: inline-block; padding: 10px 20px; background-color: #3498db; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">Ana Sayfaya Dön</a>
    </p>
</body>
</html>
