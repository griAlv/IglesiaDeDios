<?php
// Script de prueba para verificar las predicaciones en la base de datos
include_once(__DIR__ . "/config/database.php");

try {
    $pdo = getConnection();
    
    // Contar total
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM predicas");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<h2>Total de predicaciones en BD: " . $count['total'] . "</h2>";
    
    // Listar todas
    $stmt = $pdo->query("SELECT idpredica, titulo, predicador, fecha_publicacion FROM predicas ORDER BY fecha_publicacion DESC");
    $predicas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Listado completo:</h3>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Título</th><th>Predicador</th><th>Fecha</th></tr>";
    
    foreach ($predicas as $p) {
        echo "<tr>";
        echo "<td>" . $p['idpredica'] . "</td>";
        echo "<td>" . htmlspecialchars($p['titulo']) . "</td>";
        echo "<td>" . htmlspecialchars($p['predicador']) . "</td>";
        echo "<td>" . $p['fecha_publicacion'] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
