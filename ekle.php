<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Randevu Ekle</title>
</head>
<body>
    <h1>Yeni Randevu Ekle</h1>
    <form action="ekle.php" method="post">
        Hasta ID: <input type="text" name="hasta_id" required><br>
        Doktor ID: <input type="text" name="doktor_id" required><br>
        Tarih: <input type="date" name="tarih" required><br>
        Saat: <input type="time" name="saat" required><br>
        <input type="submit" value="Randevu Ekle">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $hasta_id = $_POST['hasta_id'];
        $doktor_id = $_POST['doktor_id'];
        $tarih = $_POST['tarih'];
        $saat = $_POST['saat'];

        try {
            $pdo = new PDO("pgsql:host=127.0.0.1;dbname=VeriTabani_Proje", "postgres", "kaka2066");

            $sql = "INSERT INTO Randevu (HastaID, DoktorID, Tarih, Saat, Durum) VALUES (:hasta_id, :doktor_id, :tarih, :saat, 'Planlandi')";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':hasta_id' => $hasta_id, ':doktor_id' => $doktor_id, ':tarih' => $tarih, ':saat' => $saat]);

            echo "<p style='color: green;'>Randevu basariyla eklendi!</p>";
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
