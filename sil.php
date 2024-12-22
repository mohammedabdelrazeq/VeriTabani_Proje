<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Randevu Sil</title>
</head>
<body>
    <h1>Randevu Sil</h1>
    <form action="sil.php" method="post">
        Randevu ID: <input type="text" name="randevu_id" required><br>
        <input type="submit" value="Sil">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $randevu_id = $_POST['randevu_id'];

        try {
            // Veritabanı bağlantısı
            $pdo = new PDO("pgsql:host=127.0.0.1;dbname=VeriTabani_Proje", "postgres", "kaka2066");

            // Girilen randevu ID mevcut mu kontrol et
            $check_sql = "SELECT COUNT(*) FROM randevu WHERE randevuid = :randevu_id";
            $check_stmt = $pdo->prepare($check_sql);
            $check_stmt->execute([':randevu_id' => $randevu_id]);

            $exists = $check_stmt->fetchColumn();

            if ($exists) {
                // Randevu mevcutsa sil
                $delete_sql = "DELETE FROM randevu WHERE randevuid = :randevu_id";
                $delete_stmt = $pdo->prepare($delete_sql);
                $delete_stmt->execute([':randevu_id' => $randevu_id]);

                echo "<p style='color: green;'>Randevu basariyla silindi.</p>";
            } else {
                // Randevu mevcut değilse hata mesajı
                echo "<p style='color: red;'>Hata: Girilen randevu numarasi mevcut degil.</p>";
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
