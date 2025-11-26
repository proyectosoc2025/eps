<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Administrador') {
    die('Acceso denegado');
}

require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

echo "<h1>Limpiar Datos de Prueba</h1>";
echo "<p>Este script eliminará los datos de prueba generados.</p>";
echo "<hr>";

// Eliminar logs de prueba (excepto los del sistema)
echo "<h2>Eliminando Logs de Prueba...</h2>";

$query = "DELETE FROM logs WHERE usuario IN ('admin1', 'doctor1', 'paciente1', 'admin2', 'doctor2')";
$stmt = $db->prepare($query);
$stmt->execute();
$logs_eliminados = $stmt->rowCount();

echo "<p style='color: green;'>✓ Se eliminaron $logs_eliminados logs de prueba</p>";

// Eliminar visitas de prueba
echo "<h2>Eliminando Visitas de Prueba...</h2>";

$query = "DELETE FROM visitas_medicas WHERE motivo LIKE 'Consulta de prueba%'";
$stmt = $db->prepare($query);
$stmt->execute();
$visitas_eliminadas = $stmt->rowCount();

echo "<p style='color: green;'>✓ Se eliminaron $visitas_eliminadas visitas de prueba</p>";

echo "<hr>";
echo "<h2>Resumen</h2>";
echo "<ul>";
echo "<li><strong>Logs eliminados:</strong> $logs_eliminados</li>";
echo "<li><strong>Visitas eliminadas:</strong> $visitas_eliminadas</li>";
echo "</ul>";

echo "<hr>";
echo "<p><a href='dashboard.php' class='btn btn-primary'>Volver al Dashboard</a></p>";
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
</style>
