<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug - Generador de Logs</h1>";
echo "<hr>";

echo "<h2>Información del Request:</h2>";
echo "<p><strong>Método:</strong> " . $_SERVER['REQUEST_METHOD'] . "</p>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<p style='color:green;'>✓ Formulario enviado</p>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    if (isset($_POST['accion']) && isset($_POST['descripcion'])) {
        $accion = $_POST['accion'];
        $descripcion = $_POST['descripcion'];
        
        echo "<p><strong>Acción:</strong> $accion</p>";
        echo "<p><strong>Descripción:</strong> $descripcion</p>";
        
        $log_file = __DIR__ . '/logs/activity.log';
        $fecha = date('Y-m-d H:i:s');
        $linea = "[$fecha] [$accion] $descripcion\n";
        
        echo "<hr>";
        echo "<h2>Intentando escribir:</h2>";
        echo "<p><strong>Archivo:</strong> $log_file</p>";
        echo "<p><strong>Línea:</strong> <code>" . htmlspecialchars($linea) . "</code></p>";
        
        $result = file_put_contents($log_file, $linea, FILE_APPEND | LOCK_EX);
        
        if ($result === false) {
            echo "<p style='color:red;'>✗ Error al escribir</p>";
        } else {
            echo "<p style='color:green;'>✓ Escritura exitosa: $result bytes</p>";
            echo "<p><a href='generar_logs.php'>Volver al generador</a></p>";
        }
    }
} else {
    echo "<p>No se ha enviado el formulario</p>";
}
?>

<hr>
<h2>Formulario de Prueba:</h2>
<form method="POST">
    <div style="margin-bottom:10px;">
        <label>Acción:</label><br>
        <select name="accion" required style="width:300px; padding:5px;">
            <option value="login">login</option>
            <option value="failed_login">failed_login</option>
            <option value="add_user">add_user</option>
        </select>
    </div>
    
    <div style="margin-bottom:10px;">
        <label>Descripción:</label><br>
        <textarea name="descripcion" required style="width:300px; height:80px; padding:5px;">Test de log desde debug</textarea>
    </div>
    
    <button type="submit" style="padding:10px 20px; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer;">
        Enviar Log
    </button>
</form>
