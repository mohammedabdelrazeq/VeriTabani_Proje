<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Randevulari Listele</title>
</head>
<body>
    <h1>Tum Randevular</h1>
    <?php
    try {
        $pdo = new PDO("pgsql:host=127.0.0.1;dbname=VeriTabani_Proje", "postgres", "kaka2066");

        $sql = "SELECT * FROM Randevu";
        $stmt = $pdo->query($sql);

        echo "<table border='1'>";
        echo "<tr><th>Randevu ID</th><th>Hasta ID</th><th>Doktor ID</th><th>Tarih</th><th>Saat</th><th>Durum</th></tr>";
        foreach ($stmt as $row) {
            echo "<tr>";
            echo "<td>" . $row['randevuid'] . "</td>";
            echo "<td>" . $row['hastaid'] . "</td>";
            echo "<td>" . $row['doktorid'] . "</td>";
            echo "<td>" . $row['tarih'] . "</td>";
            echo "<td>" . $row['saat'] . "</td>";
            echo "<td>" . $row['durum'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Hata: " . $e->getMessage() . "</p>";
    }
    ?>
    <p>
    <a href="index.html" style="display: inline-block; padding: 10px 20px; background-color: #3498db; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">Ana Sayfaya Dön</a>
    </p>

</body>
</html>
