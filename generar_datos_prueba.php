<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Administrador') {
    die('Acceso denegado');
}

require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

echo "<h1>Generador de Datos de Prueba</h1>";
echo "<p>Este script generará datos de ejemplo para probar la paginación.</p>";
echo "<hr>";

// Generar logs de prueba
echo "<h2>Generando Logs de Prueba...</h2>";

$acciones = ['LOGIN', 'LOGOUT', 'CREAR', 'MODIFICAR', 'ELIMINAR'];
$usuarios = ['admin1', 'doctor1', 'paciente1', 'admin2', 'doctor2'];
$descripciones = [
    'Acceso al sistema',
    'Cierre de sesión',
    'Registro creado',
    'Datos modificados',
    'Registro eliminado'
];

$logs_creados = 0;

for($i = 0; $i < 50; $i++) {
    $usuario = $usuarios[array_rand($usuarios)];
    $accion = $acciones[array_rand($acciones)];
    $descripcion = $descripciones[array_rand($descripciones)];
    $ip = '192.168.1.' . rand(1, 255);
    
    // Fecha aleatoria en los últimos 30 días
    $fecha = date('Y-m-d H:i:s', strtotime('-' . rand(0, 30) . ' days -' . rand(0, 23) . ' hours'));
    
    $query = "INSERT INTO logs (usuario, accion, descripcion, ip_address, fecha) 
              VALUES (:usuario, :accion, :descripcion, :ip, :fecha)";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':accion', $accion);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':ip', $ip);
    $stmt->bindParam(':fecha', $fecha);
    
    if($stmt->execute()) {
        $logs_creados++;
    }
}

echo "<p style='color: green;'>✓ Se crearon $logs_creados logs de prueba</p>";

// Verificar si hay pacientes y doctores para crear visitas
$query = "SELECT COUNT(*) as total FROM pacientes";
$stmt = $db->prepare($query);
$stmt->execute();
$total_pacientes = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$query = "SELECT COUNT(*) as total FROM doctores";
$stmt = $db->prepare($query);
$stmt->execute();
$total_doctores = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

if($total_pacientes > 0 && $total_doctores > 0) {
    echo "<h2>Generando Visitas Médicas de Prueba...</h2>";
    
    // Obtener IDs de pacientes y doctores
    $query = "SELECT id FROM pacientes LIMIT 10";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $pacientes = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $query = "SELECT id FROM doctores LIMIT 10";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $doctores = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $visitas_creadas = 0;
    
    for($i = 0; $i < 30; $i++) {
        if(empty($pacientes) || empty($doctores)) break;
        
        $paciente_id = $pacientes[array_rand($pacientes)];
        $doctor_id = $doctores[array_rand($doctores)];
        $motivo = 'Consulta de prueba ' . ($i + 1);
        
        // Fecha aleatoria en los últimos 60 días
        $fecha_visita = date('Y-m-d H:i:s', strtotime('-' . rand(0, 60) . ' days -' . rand(8, 18) . ' hours'));
        
        $query = "INSERT INTO visitas_medicas (paciente_id, doctor_id, fecha_visita, motivo) 
                  VALUES (:paciente_id, :doctor_id, :fecha_visita, :motivo)";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(':paciente_id', $paciente_id);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->bindParam(':fecha_visita', $fecha_visita);
        $stmt->bindParam(':motivo', $motivo);
        
        if($stmt->execute()) {
            $visitas_creadas++;
        }
    }
    
    echo "<p style='color: green;'>✓ Se crearon $visitas_creadas visitas médicas de prueba</p>";
} else {
    echo "<p style='color: orange;'>⚠ No hay pacientes o doctores registrados. Primero registra algunos para crear visitas de prueba.</p>";
}

echo "<hr>";
echo "<h2>Resumen</h2>";
echo "<ul>";
echo "<li><strong>Logs creados:</strong> $logs_creados</li>";
echo "<li><strong>Visitas creadas:</strong> " . ($visitas_creadas ?? 0) . "</li>";
echo "</ul>";

echo "<hr>";
echo "<h2>Ahora puedes ver la paginación funcionando</h2>";
echo "<p><a href='dashboard.php' class='btn btn-primary'>Ir al Dashboard</a></p>";

echo "<hr>";
echo "<h3>¿Quieres limpiar los datos de prueba?</h3>";
echo "<p><a href='limpiar_datos_prueba.php' class='btn btn-danger'>Limpiar Datos de Prueba</a></p>";
?>

<style>
    body {
        font-family: Arial, sans-serif;
        max-width: 900px;
        margin: 30px auto;
        padding: 20px;
        background: #f5f5f5;
    }
    h1 {
        color: #0d6efd;
        border-bottom: 3px solid #0d6efd;
        padding-bottom: 10px;
    }
    .btn-primary {
        display: inline-block;
        padding: 10px 20px;
        background: #0d6efd;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 10px;
    }
    .btn-danger {
        display: inline-block;
        padding: 10px 20px;
        background: #dc3545;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 10px;
    }
</style>
