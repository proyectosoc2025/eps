<?php
/**
 * IMPORTADOR MANUAL DE BASE DE DATOS
 * 
 * INSTRUCCIONES:
 * 1. Edita las credenciales de base de datos abajo
 * 2. Sube este archivo a tu hosting en la carpeta database/
 * 3. Sube también eps_database.sql a la misma carpeta
 * 4. Accede desde el navegador: http://tudominio.com/database/importar_manual.php
 * 5. ELIMINA este archivo después de usarlo por seguridad
 */

// ===== EDITA ESTOS DATOS CON LOS DE TU HOSTING =====
$host = "localhost";  // Normalmente es "localhost"
$username = "TU_USUARIO_MYSQL";  // Usuario de MySQL
$password = "TU_PASSWORD_MYSQL";  // Contraseña de MySQL
$database = "TU_NOMBRE_BASE_DATOS";  // Nombre de la base de datos
// ====================================================

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importador de Base de Datos - Hospital EPS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }
        h1 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .status {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.6;
        }
        .success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
        }
        .info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }
        .step {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 4px solid #667eea;
        }
        .step-title {
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        .code {
            background: #2d3748;
            color: #68d391;
            padding: 10px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            overflow-x: auto;
            margin: 10px 0;
        }
        .btn {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .progress {
            margin: 20px 0;
        }
        .progress-bar {
            background: #e9ecef;
            height: 30px;
            border-radius: 15px;
            overflow: hidden;
        }
        .progress-fill {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            transition: width 0.5s;
        }
        ul {
            margin-left: 20px;
            margin-top: 10px;
        }
        li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏥 Hospital EPS</h1>
        <p class="subtitle">Importador Automático de Base de Datos</p>

        <?php
        // Verificar si se enviaron las credenciales
        if ($username === "TU_USUARIO_MYSQL" || $password === "TU_PASSWORD_MYSQL" || $database === "TU_NOMBRE_BASE_DATOS") {
            ?>
            <div class="status warning">
                <strong>⚠️ Configuración Requerida</strong><br>
                Debes editar este archivo y configurar las credenciales de tu base de datos.
            </div>

            <div class="step">
                <div class="step-title">📝 Paso 1: Editar Credenciales</div>
                Abre este archivo (importar_manual.php) con un editor de texto y edita las líneas 14-17:
                <div class="code">
$host = "localhost";<br>
$username = "tu_usuario_mysql";<br>
$password = "tu_password_mysql";<br>
$database = "tu_nombre_base_datos";
                </div>
            </div>

            <div class="step">
                <div class="step-title">📍 Paso 2: Obtener Credenciales</div>
                Las credenciales las encuentras en:
                <ul>
                    <li><strong>000webhost:</strong> Panel > Manage Database</li>
                    <li><strong>InfinityFree:</strong> Panel > MySQL Databases</li>
                    <li><strong>Otros:</strong> Panel de control del hosting</li>
                </ul>
            </div>

            <div class="step">
                <div class="step-title">🔄 Paso 3: Recargar Página</div>
                Después de editar y guardar, recarga esta página.
            </div>
            <?php
            exit;
        }

        // Intentar conectar a la base de datos
        try {
            $conn = new PDO("mysql:host=$host", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            echo '<div class="status success">';
            echo '<strong>✅ Conexión Exitosa</strong><br>';
            echo 'Conectado al servidor MySQL correctamente.';
            echo '</div>';

            // Crear base de datos si no existe
            $conn->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $conn->exec("USE `$database`");
            
            echo '<div class="status success">';
            echo '<strong>✅ Base de Datos Creada</strong><br>';
            echo "Base de datos '$database' lista para usar.";
            echo '</div>';

            // Leer archivo SQL
            $sqlFile = __DIR__ . '/eps_database.sql';
            
            if (!file_exists($sqlFile)) {
                throw new Exception("No se encuentra el archivo eps_database.sql en la carpeta database/");
            }

            $sql = file_get_contents($sqlFile);
            
            // Eliminar comentarios y líneas vacías
            $sql = preg_replace('/^--.*$/m', '', $sql);
            $sql = preg_replace('/^\/\*.*?\*\//ms', '', $sql);
            
            // Separar por punto y coma
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            
            $total = count($statements);
            $success = 0;
            $errors = 0;
            
            echo '<div class="progress">';
            echo '<div class="progress-bar">';
            echo '<div class="progress-fill" style="width: 0%">0%</div>';
            echo '</div>';
            echo '</div>';
            
            echo '<div class="status info">';
            echo '<strong>⏳ Importando...</strong><br>';
            echo "Total de consultas: $total<br>";
            echo '</div>';

            // Ejecutar cada statement
            foreach ($statements as $index => $statement) {
                if (empty($statement)) continue;
                
                try {
                    $conn->exec($statement);
                    $success++;
                } catch (PDOException $e) {
                    // Ignorar errores de "tabla ya existe" o "base de datos ya existe"
                    if (strpos($e->getMessage(), 'already exists') === false) {
                        $errors++;
                        echo '<div class="status error">';
                        echo '<strong>❌ Error en consulta ' . ($index + 1) . '</strong><br>';
                        echo htmlspecialchars($e->getMessage());
                        echo '</div>';
                    } else {
                        $success++;
                    }
                }
                
                // Actualizar progreso
                $progress = round((($index + 1) / $total) * 100);
                echo "<script>document.querySelector('.progress-fill').style.width = '{$progress}%'; document.querySelector('.progress-fill').textContent = '{$progress}%';</script>";
                flush();
            }

            echo '<div class="status success">';
            echo '<strong>🎉 ¡Importación Completada!</strong><br>';
            echo "Consultas exitosas: $success<br>";
            if ($errors > 0) {
                echo "Errores: $errors<br>";
            }
            echo '</div>';

            echo '<div class="step">';
            echo '<div class="step-title">✅ Siguiente Paso</div>';
            echo 'La base de datos se importó correctamente. Ahora:';
            echo '<ul>';
            echo '<li>Elimina este archivo (importar_manual.php) por seguridad</li>';
            echo '<li>Verifica que config/database.php tenga las credenciales correctas</li>';
            echo '<li>Ve a tu sitio web e inicia sesión</li>';
            echo '</ul>';
            echo '<br>';
            echo '<a href="../index.php" class="btn">Ir al Login</a>';
            echo '</div>';

        } catch (PDOException $e) {
            echo '<div class="status error">';
            echo '<strong>❌ Error de Conexión</strong><br>';
            echo htmlspecialchars($e->getMessage());
            echo '</div>';

            echo '<div class="step">';
            echo '<div class="step-title">🔍 Posibles Soluciones</div>';
            echo '<ul>';
            echo '<li>Verifica que las credenciales sean correctas</li>';
            echo '<li>Verifica que el usuario tenga permisos para crear bases de datos</li>';
            echo '<li>Verifica que el host sea correcto (normalmente "localhost")</li>';
            echo '<li>Contacta al soporte de tu hosting si el problema persiste</li>';
            echo '</ul>';
            echo '</div>';
        } catch (Exception $e) {
            echo '<div class="status error">';
            echo '<strong>❌ Error</strong><br>';
            echo htmlspecialchars($e->getMessage());
            echo '</div>';
        }
        ?>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6; text-align: center; color: #666; font-size: 12px;">
            Hospital EPS - Sistema de Gestión Médica<br>
            Jonathan Alexis Rodriguez - 2025
        </div>
    </div>
</body>
</html>
