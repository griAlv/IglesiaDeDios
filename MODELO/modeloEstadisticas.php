<?php
include_once(__DIR__ . "/../config/database.php");
class modeloEstadisticas{
    private $pdo;
    public function __construct() {
        $this->pdo = getConnection();
    }
    public function contar()
    {
        $query="SELECT 
    (SELECT COUNT(*) FROM departamento) AS total_ministerios,
    (SELECT COUNT(*) FROM distrito) AS total_distritos,
    (SELECT COUNT(*) FROM iglesia) AS total_iglesias,
    (SELECT COUNT(*) FROM usuario WHERE estado = 'activo') AS usuarios_activos,
    (SELECT COUNT(*) FROM evento WHERE fecha >= CURDATE()) AS eventos_proximos,
    (SELECT COUNT(*) FROM documentos) AS total_documentos,
    (SELECT COUNT(*) FROM predicas) AS total_predicas;";
        $stmt=$this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  
    }

    public function EVENTOSPRÓXIMOS(){
    $query="SELECT 
    e.idevento,
    e.titulo,
    e.tipo,
    e.fecha,
    e.hora,
    e.lugar,
    e.descripcion,
    dist.nombre AS distrito,
    dep.nombre AS departamento,
    u.nombre AS creado_por,
    DATEDIFF(e.fecha, CURDATE()) AS dias_restantes
FROM evento e
LEFT JOIN distrito dist ON e.iddistrito = dist.iddistrito
LEFT JOIN departamento dep ON e.iddepartamento = dep.iddepartamento
LEFT JOIN usuario u ON e.creadopor = u.idusuario
WHERE e.fecha >= CURDATE()
ORDER BY e.fecha ASC, e.hora ASC
LIMIT 10;";
$stmt = $this->pdo->prepare($query);
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    
}
?>