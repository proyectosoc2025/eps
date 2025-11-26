<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug del Sistema de Login</h1>";

// Datos de prueba
$usuario_test = "jarodriguez11";
$password_test = "Blink182";

echo "<h2>1. Datos de Prueba</h2>";
echo "<p><strong>Usuario:</strong> $usuario_test</p>";
echo "<p><strong>Contraseña:</strong> $password_test</p>";

// Conectar a la base de datos
try {
    $conn = new PDO("mysql:host=localhost;dbname=EPS", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>2. Conexión a Base de Datos</h2>";
    echo "<p style='color: green;'>✓ Conexión exitosa</p>";
    
    // Buscar el usuario en administradores
    echo "<h2>3. Buscando Usuario en Tabla 'administradores'</h2>";
    $query = "SELECT * FROM administradores WHERE usuario = :usuario";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':usuario', $usuario_test);
    $stmt->execute();
    
    if($stmt->rowCount() > 0) {
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<p style='color: green;'>✓ Usuario encontrado</p>";
        
        echo "<h3>Información del Usuario:</h3>";
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
        echo "<tr><th>Campo</th><th>Valor</th></tr>";
        echo "<tr><td>ID</td><td>" . $admin['id'] . "</td></tr>";
        echo "<tr><td>Nombres</td><td>" . $admin['nombres'] . "</td></tr>";
        echo "<tr><td>Apellidos</td><td>" . $admin['apellidos'] . "</td></tr>";
        echo "<tr><td>Usuario</td><td>" . $admin['usuario'] . "</td></tr>";
        echo "<tr><td>Rol</td><td>" . $admin['rol'] . "</td></tr>";
        echo "<tr><td>Password Hash</td><td style='font-size: 10px; word-break: break-all;'>" . $admin['password'] . "</td></tr>";
        echo "</table>";
        
        // Verificar la contraseña
        echo "<h2>4. Verificación de Contraseña</h2>";
        
        $password_hash_db = $admin['password'];
        
        echo "<p><strong>Hash en BD:</strong> <code style='font-size: 10px;'>" . $password_hash_db . "</code></p>";
        echo "<p><strong>Longitud del hash:</strong> " . strlen($password_hash_db) . " caracteres</p>";
        
        // Verificar con password_verify
        if(password_verify($password_test, $password_hash_db)) {
            echo "<p style='color: green; font-size: 20px; font-weight: bold;'>✓ ¡CONTRASEÑA CORRECTA!</p>";
            echo "<p>El sistema debería permitir el login.</p>";
        } else {
            echo "<p style='color: red; font-size: 20px; font-weight: bold;'>✗ CONTRASEÑA INCORRECTA</p>";
            echo "<p>El hash en la base de datos no coincide con la contraseña.</p>";
            
            // Generar nuevo hash
            echo "<h3>Generando Nuevo Hash...</h3>";
            $nuevo_hash = password_hash($password_test, PASSWORD_DEFAULT);
            echo "<p><strong>Nuevo hash:</strong> <code style='font-size: 10px;'>" . $nuevo_hash . "</code></p>";
            
            // Actualizar en la base de datos
            echo "<h3>Actualizando Base de Datos...</h3>";
            $update_query = "UPDATE administradores SET password = :password WHERE usuario = :usuario";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bindParam(':password', $nuevo_hash);
            $update_stmt->bindParam(':usuario', $usuario_test);
            
            if($update_stmt->execute()) {
                echo "<p style='color: green; font-weight: bold;'>✓ Contraseña actualizada exitosamente</p>";
                
                // Verificar nuevamente
                $stmt->execute();
                $admin_updated = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if(password_verify($password_test, $admin_updated['password'])) {
                    echo "<p style='color: green; font-size: 18px; font-weight: bold;'>✓ ¡VERIFICACIÓN EXITOSA! Ahora puede iniciar sesión.</p>";
                }
            } else {
                echo "<p style='color: red;'>✗ Error al actualizar la contraseña</p>";
            }
        }
        
    } else {
        echo "<p style='color: red;'>✗ Usuario NO encontrado en la tabla 'administradores'</p>";
        
        // Crear el usuario
        echo "<h3>Creando Usuario Administrador...</h3>";
        $password_hash = password_hash($password_test, PASSWORD_DEFAULT);
        
        $insert_query = "INSERT INTO administradores (nombres, apellidos, identificacion, usuario, password, rol, cargo) 
                        VALUES ('Administrador', 'Principal', '1000000000', :usuario, :password, 'Administrador', 'Administrador del Sistema')";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bindParam(':usuario', $usuario_test);
        $insert_stmt->bindParam(':password', $password_hash);
        
        if($insert_stmt->execute()) {
            echo "<p style='color: green; font-weight: bold;'>✓ Usuario creado exitosamente</p>";
        } else {
            echo "<p style='color: red;'>✗ Error al crear el usuario</p>";
        }
    }
    
    // Verificar el API de login
    echo "<h2>5. Verificación del API de Login</h2>";
    if(file_exists('api/login.php')) {
        echo "<p style='color: green;'>✓ Archivo api/login.php existe</p>";
    } else {
        echo "<p style='color: red;'>✗ Archivo api/login.php NO existe</p>";
    }
    
    if(file_exists('config/security.php')) {
        echo "<p style='color: green;'>✓ Archivo config/security.php existe</p>";
    } else {
        echo "<p style='color: red;'>✗ Archivo config/security.php NO existe</p>";
    }
    
    echo "<hr>";
    echo "<h2>Resumen</h2>";
    echo "<div style='background: #d1ecf1; padding: 20px; border-radius: 5px; border-left: 4px solid #0c5460;'>";
    echo "<h3>Credenciales para Login:</h3>";
    echo "<p><strong>Usuario:</strong> jarodriguez11</p>";
    echo "<p><strong>Contraseña:</strong> Blink182</p>";
    echo "<p><a href='index.php' style='display: inline-block; padding: 10px 20px; background: #0d6efd; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px;'>Ir al Login</a></p>";
    echo "</div>";
    
} catch(PDOException $e) {
    echo "<p style='color: red;'><strong>Error de Base de Datos:</strong> " . $e->getMessage() . "</p>";
}
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
    h2 {
        color: #333;
        margin-top: 30px;
        background: #e9ecef;
        padding: 10px;
        border-radius: 5px;
    }
    code {
        background: #fff3cd;
        padding: 2px 6px;
        border-radius: 3px;
        font-family: monospace;
    }
    table {
        width: 100%;
        margin: 20px 0;
    }
    th {
        background: #0d6efd;
        color: white;
        text-align: left;
    }
</style>
