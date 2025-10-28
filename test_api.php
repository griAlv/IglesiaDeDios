<?php
// Archivo de prueba para verificar la API de localidades
echo "<h1>Prueba de API de Localidades</h1>";

// Probar conexión a la base de datos
include_once(__DIR__ . "/config/database.php");

try {
    $pdo = getConnection();
    echo "<p style='color:green;'>✅ Conexión a la base de datos exitosa</p>";
    
    // Verificar si la tabla existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'localidades'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color:green;'>✅ Tabla 'localidades' existe</p>";
        
        // Contar registros
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM localidades");
        $result = $stmt->fetch();
        echo "<p style='color:blue;'>📊 Total de registros: " . $result['total'] . "</p>";
        
        // Mostrar todos los registros
        $stmt = $pdo->query("SELECT * FROM localidades ORDER BY id DESC");
        $localidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h2>Registros en la base de datos:</h2>";
        echo "<table border='1' cellpadding='10' style='border-collapse:collapse;'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Departamento</th><th>Ciudad</th><th>Tipo</th><th>Lat</th><th>Lng</th></tr>";
        
        foreach ($localidades as $loc) {
            echo "<tr>";
            echo "<td>" . $loc['id'] . "</td>";
            echo "<td>" . $loc['nombre'] . "</td>";
            echo "<td>" . $loc['departamento'] . "</td>";
            echo "<td>" . $loc['ciudad'] . "</td>";
            echo "<td>" . $loc['tipo'] . "</td>";
            echo "<td>" . $loc['lat'] . "</td>";
            echo "<td>" . $loc['lng'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
    } else {
        echo "<p style='color:red;'>❌ La tabla 'localidades' NO existe</p>";
        echo "<p>Ejecuta el archivo SQL: database/localidades.sql</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>Probar API:</h2>";
echo "<p><a href='api/localidades.php?action=listar' target='_blank'>📋 Listar Localidades (JSON)</a></p>";
?>
