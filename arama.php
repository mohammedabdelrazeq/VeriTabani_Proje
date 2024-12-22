<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Randevu Ara</title>
</head>
<body>
    <h1>Randevu Ara</h1>
    <form action="arama.php" method="get">
        Hasta ID: <input type="text" name="hasta_id"><br>
        Doktor ID: <input type="text" name="doktor_id"><br>
        <input type="submit" value="Ara">
    </form>

    <?php
    // Yalnızca kullanıcı formu doldurduğunda çalıştır
    if (isset($_GET['hasta_id']) || isset($_GET['doktor_id'])) {
        $hasta_id = isset($_GET['hasta_id']) ? $_GET['hasta_id'] : null;
        $doktor_id = isset($_GET['doktor_id']) ? $_GET['doktor_id'] : null;

        try {
            $pdo = new PDO("pgsql:host=127.0.0.1;dbname=VeriTabani_Proje", "postgres", "kaka2066");

            // Dinamik sorgu oluştur
            $sql = "SELECT * FROM Randevu WHERE 1=1";
            $params = [];

            if (!empty($hasta_id)) {
                $sql .= " AND HastaID = :hasta_id";
                $params[':hasta_id'] = $hasta_id;
            }

            if (!empty($doktor_id)) {
                $sql .= " AND DoktorID = :doktor_id";
                $params[':doktor_id'] = $doktor_id;
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            // Sonuçları kontrol et
            if ($stmt->rowCount() > 0) {
                echo "<table border='1'>";
                echo "<tr><th>Randevu ID</th><th>Hasta ID</th><th>Doktor ID</th><th>Tarih</th><th>Saat</th><th>Durum</th></tr>";
                foreach ($stmt as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['randevuid']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['hastaid']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['doktorid']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tarih']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['saat']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['durum']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='color: red;'>Sonuc bulunamadi.</p>";
            }
        } catch (PDOException $e) {
            echo "<p style='color: red;'>Hata: " . $e->getMessage() . "</p>";
        }
    }
    ?>
    <p>
    <a href="index.html" style="display: inline-block; padding: 10px 20px; background-color: #3498db; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">Ana Sayfaya Dön</a>
    </p>

</body>
</html>
