<?php
// Habilitar visualización de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Verificación del Sistema</h1>";

// Verificar versión de PHP
echo "<h2>1. Versión de PHP</h2>";
echo "Versión: " . phpversion() . "<br>";

// Verificar extensiones necesarias
echo "<h2>2. Extensiones PHP</h2>";
echo "PDO: " . (extension_loaded('pdo') ? '✓ Instalado' : '✗ NO instalado') . "<br>";
echo "PDO MySQL: " . (extension_loaded('pdo_mysql') ? '✓ Instalado' : '✗ NO instalado') . "<br>";
echo "Session: " . (extension_loaded('session') ? '✓ Instalado' : '✗ NO instalado') . "<br>";

// Verificar conexión a base de datos
echo "<h2>3. Conexión a Base de Datos</h2>";
try {
    $conn = new PDO("mysql:host=localhost", "root", "");
    echo "✓ Conexión a MySQL exitosa<br>";
    
    // Verificar si existe la base de datos EPS
    $stmt = $conn->query("SHOW DATABASES LIKE 'EPS'");
    if($stmt->rowCount() > 0) {
        echo "✓ Base de datos 'EPS' existe<br>";
        
        // Conectar a la base de datos EPS
        $conn = new PDO("mysql:host=localhost;dbname=EPS", "root", "");
        echo "✓ Conexión a base de datos 'EPS' exitosa<br>";
        
        // Verificar tablas
        echo "<h3>Tablas en la base de datos:</h3>";
        $stmt = $conn->query("SHOW TABLES");
        while($row = $stmt->fetch(PDO::FETCH_NUM)) {
            echo "- " . $row[0] . "<br>";
        }
    } else {
        echo "✗ Base de datos 'EPS' NO existe<br>";
        echo "<strong>ACCIÓN REQUERIDA:</strong> Debe importar el archivo database/eps_database.sql en phpMyAdmin<br>";
    }
} catch(PDOException $e) {
    echo "✗ Error de conexión: " . $e->getMessage() . "<br>";
}

// Verificar archivos
echo "<h2>4. Archivos del Sistema</h2>";
$archivos = [
    'index.php',
    'dashboard.php',
    'config/database.php',
    'config/security.php',
    'api/login.php',
    'assets/css/login.css',
    'assets/js/login.js'
];

foreach($archivos as $archivo) {
    if(file_exists($archivo)) {
        echo "✓ $archivo existe<br>";
    } else {
        echo "✗ $archivo NO existe<br>";
    }
}

// Verificar permisos de escritura
echo "<h2>5. Permisos</h2>";
echo "Directorio actual: " . getcwd() . "<br>";
echo "Permisos de escritura: " . (is_writable('.') ? '✓ SI' : '✗ NO') . "<br>";

echo "<hr>";
echo "<h2>Siguiente Paso</h2>";
echo "<p>Si todo está correcto, acceda a: <a href='index.php'>index.php</a></p>";
?>
