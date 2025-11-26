<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Actualizar Contraseña del Administrador</h1>";

// Generar hash de la contraseña
$password = "Blink182";
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "<h2>Información de la Contraseña</h2>";
echo "<p><strong>Contraseña:</strong> $password</p>";
echo "<p><strong>Hash generado:</strong> $hash</p>";

// Conectar a la base de datos
try {
    $conn = new PDO("mysql:host=localhost;dbname=EPS", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Actualizando Base de Datos...</h2>";
    
    // Actualizar la contraseña
    $query = "UPDATE administradores SET password = :password WHERE usuario = 'jarodriguez11'";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':password', $hash);
    
    if($stmt->execute()) {
        echo "<p style='color: green; font-weight: bold;'>✓ Contraseña actualizada exitosamente</p>";
        
        // Verificar que se actualizó
        $query = "SELECT usuario, nombres, apellidos FROM administradores WHERE usuario = 'jarodriguez11'";
        $stmt = $conn->query($query);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($admin) {
            echo "<h3>Usuario Administrador:</h3>";
            echo "<ul>";
            echo "<li><strong>Usuario:</strong> " . $admin['usuario'] . "</li>";
            echo "<li><strong>Nombre:</strong> " . $admin['nombres'] . " " . $admin['apellidos'] . "</li>";
            echo "<li><strong>Contraseña:</strong> Blink182</li>";
            echo "</ul>";
            
            echo "<hr>";
            echo "<h2 style='color: green;'>¡Listo! Ahora puede iniciar sesión</h2>";
            echo "<p><a href='index.php' style='display: inline-block; padding: 10px 20px; background: #0d6efd; color: white; text-decoration: none; border-radius: 5px;'>Ir al Login</a></p>";
            
            echo "<hr>";
            echo "<h3>Credenciales:</h3>";
            echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 5px; border-left: 4px solid #0d6efd;'>";
            echo "<p><strong>Usuario:</strong> jarodriguez11</p>";
            echo "<p><strong>Contraseña:</strong> Blink182</p>";
            echo "</div>";
        }
    } else {
        echo "<p style='color: red;'>✗ Error al actualizar la contraseña</p>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'><strong>Error:</strong> " . $e->getMessage() . "</p>";
    
    if(strpos($e->getMessage(), 'Unknown database') !== false) {
        echo "<hr>";
        echo "<h3 style='color: red;'>La base de datos 'EPS' no existe</h3>";
        echo "<p><strong>Solución:</strong></p>";
        echo "<ol>";
        echo "<li>Abra phpMyAdmin: <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a></li>";
        echo "<li>Haga clic en 'Importar'</li>";
        echo "<li>Seleccione el archivo: <code>database/eps_database.sql</code></li>";
        echo "<li>Haga clic en 'Continuar'</li>";
        echo "<li>Vuelva a ejecutar este script</li>";
        echo "</ol>";
    }
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background: #f5f5f5;
    }
    h1 {
        color: #0d6efd;
        border-bottom: 3px solid #0d6efd;
        padding-bottom: 10px;
    }
    h2 {
        color: #333;
        margin-top: 30px;
    }
    code {
        background: #e9ecef;
        padding: 2px 6px;
        border-radius: 3px;
        font-family: monospace;
    }
</style>
