<?php
/**
 * Script para agregar logs al Hospital EPS - VERSIÓN MEJORADA
 */

$log_file = __DIR__ . '/logs/activity.log';
$log_dir = __DIR__ . '/logs';

// Crear directorio si no existe
if (!file_exists($log_dir)) {
    mkdir($log_dir, 0777, true);
}

// Crear archivo si no existe
if (!file_exists($log_file)) {
    file_put_contents($log_file, '');
}

// Función para agregar log
function agregarLog($accion, $descripcion) {
    global $log_file;
    $fecha = date('Y-m-d H:i:s');
    $linea = "[$fecha] [$accion] $descripcion\n";
    
    // Intentar escribir
    $result = file_put_contents($log_file, $linea, FILE_APPEND | LOCK_EX);
    
    if ($result === false) {
        return ['success' => false, 'error' => 'No se pudo escribir en el archivo'];
    }
    
    return ['success' => true, 'bytes' => $result];
}

$mensaje = '';
$tipo = '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];
    $descripcion = $_POST['descripcion'];
    
    $result = agregarLog($accion, $descripcion);
    
    if ($result['success']) {
        $mensaje = "Log agregado exitosamente ({$result['bytes']} bytes escritos)";
        $tipo = "success";
    } else {
        $mensaje = "Error: " . $result['error'];
        $tipo = "danger";
    }
}

// Leer logs existentes
$logs = [];
if (file_exists($log_file)) {
    $contenido = file_get_contents($log_file);
    $lineas = explode("\n", $contenido);
    $logs = array_reverse(array_filter($lineas));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Logs - Hospital EPS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <h1><i class="bi bi-hospital"></i> Generador de Logs - Hospital EPS</h1>
        <hr>
        
        <?php if ($mensaje): ?>
        <div class="alert alert-<?php echo $tipo; ?> alert-dismissible fade show">
            <?php echo $mensaje; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Agregar Nuevo Log</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Acción</label>
                                <select class="form-select" name="accion" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="login">login (Bajo)</option>
                                    <option value="failed_login">failed_login (Medio)</option>
                                    <option value="add_doctor">add_doctor (Medio)</option>
                                    <option value="add_user">add_user (Medio)</option>
                                    <option value="add_admin">add_admin (Alto)</option>
                                    <option value="delete_doctor">delete_doctor (Bajo)</option>
                                    <option value="delete_user">delete_user (Bajo)</option>
                                    <option value="delete_admin">delete_admin (Alto)</option>
                                    <option value="sql_injection_attempt">sql_injection_attempt (Crítico)</option>
                                    <option value="update_user">update_user (Medio)</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion" rows="3" required 
                                          placeholder="Ej: Usuario admin inició sesión desde IP 192.168.1.100"></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle"></i> Agregar Log
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">Información del Archivo</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Ruta:</strong><br><code><?php echo $log_file; ?></code></p>
                        <p><strong>Existe:</strong> <?php echo file_exists($log_file) ? '✓ Sí' : '✗ No'; ?></p>
                        <?php if (file_exists($log_file)): ?>
                        <p><strong>Tamaño:</strong> <?php echo filesize($log_file); ?> bytes</p>
                        <p><strong>Última modificación:</strong><br><?php echo date('Y-m-d H:i:s', filemtime($log_file)); ?></p>
                        <p><strong>Permisos:</strong> <?php echo substr(sprintf('%o', fileperms($log_file)), -4); ?></p>
                        <?php endif; ?>
                        <hr>
                        <p><strong>Total de logs:</strong> <?php echo count($logs); ?></p>
                        <p>
                            <a href="../CheckPointFirewall/modules/logs_hospital.php" class="btn btn-sm btn-success w-100" target="_blank">
                                <i class="bi bi-eye"></i> Ver en CheckPoint Firewall
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Últimos 15 Logs</h5>
                        <button onclick="location.reload()" class="btn btn-sm btn-light">
                            <i class="bi bi-arrow-clockwise"></i> Actualizar
                        </button>
                    </div>
                    <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                        <?php if (empty($logs)): ?>
                        <p class="text-muted">No hay logs registrados</p>
                        <?php else: ?>
                        <div class="list-group">
                            <?php foreach (array_slice($logs, 0, 15) as $log): ?>
                            <div class="list-group-item">
                                <small><code><?php echo htmlspecialchars($log); ?></code></small>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Auto-actualizar la lista de logs cada 5 segundos
    setInterval(function() {
        location.reload();
    }, 5000);
    </script>
</body>
</html>
