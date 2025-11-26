<?php
$log_file = __DIR__ . '/logs/activity.log';

echo "<h1>Test de Escritura de Logs</h1>";
echo "<p><strong>Archivo:</strong> $log_file</p>";

// Verificar si existe
if (file_exists($log_file)) {
    echo "<p style='color:green;'>✓ El archivo existe</p>";
    echo "<p><strong>Permisos:</strong> " . substr(sprintf('%o', fileperms($log_file)), -4) . "</p>";
    echo "<p><strong>Es escribible:</strong> " . (is_writable($log_file) ? 'Sí' : 'No') . "</p>";
} else {
    echo "<p style='color:red;'>✗ El archivo NO existe</p>";
}

// Intentar escribir
$fecha = date('Y-m-d H:i:s');
$linea = "[$fecha] [login] Test desde PHP\n";

echo "<hr>";
echo "<h2>Intentando escribir...</h2>";
echo "<p><strong>Línea a escribir:</strong> <code>" . htmlspecialchars($linea) . "</code></p>";

$result = @file_put_contents($log_file, $linea, FILE_APPEND | LOCK_EX);

if ($result === false) {
    $error = error_get_last();
    echo "<p style='color:red;'>✗ Error al escribir</p>";
    echo "<pre>" . print_r($error, true) . "</pre>";
} else {
    echo "<p style='color:green;'>✓ Escritura exitosa: $result bytes</p>";
    
    // Leer últimas líneas
    echo "<hr>";
    echo "<h2>Últimas 5 líneas del archivo:</h2>";
    $content = file_get_contents($log_file);
    $lines = explode("\n", $content);
    $lines = array_filter($lines);
    $last_lines = array_slice($lines, -5);
    
    echo "<pre>";
    foreach ($last_lines as $line) {
        echo htmlspecialchars($line) . "\n";
    }
    echo "</pre>";
}

echo "<hr>";
echo "<p><a href='generar_logs.php'>Volver al Generador</a></p>";
?>
