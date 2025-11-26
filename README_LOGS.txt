═══════════════════════════════════════════════════════════════════
  HOSPITAL EPS - SISTEMA DE LOGS
═══════════════════════════════════════════════════════════════════

Este directorio contiene los logs de actividad del Hospital EPS que
son monitoreados por el sistema CheckPoint Firewall.

═══════════════════════════════════════════════════════════════════
ARCHIVOS
═══════════════════════════════════════════════════════════════════

logs/activity.log
  - Archivo de logs en formato texto
  - Cada línea representa una actividad
  - Formato: [YYYY-MM-DD HH:MM:SS] [accion] descripcion

generar_logs.php
  - Interfaz web para agregar logs manualmente
  - Útil para pruebas y simulaciones
  - Acceso: http://localhost/hospitalEPS/generar_logs.php

═══════════════════════════════════════════════════════════════════
FORMATO DE LOGS
═══════════════════════════════════════════════════════════════════

Cada línea debe seguir este formato:
[YYYY-MM-DD HH:MM:SS] [accion] descripcion

Ejemplo:
[2025-11-18 10:30:45] [login] Usuario admin inició sesión

═══════════════════════════════════════════════════════════════════
ACCIONES DISPONIBLES Y SUS SEVERIDADES
═══════════════════════════════════════════════════════════════════

CRÍTICO:
- sql_injection_attempt

ALTO:
- add_admin
- delete_admin
- update_policy

MEDIO:
- failed_login
- add_doctor
- add_user
- create_policy

BAJO:
- login
- delete_doctor
- delete_user

═══════════════════════════════════════════════════════════════════
USO
═══════════════════════════════════════════════════════════════════

1. AGREGAR LOGS MANUALMENTE:
   http://localhost/hospitalEPS/generar_logs.php

2. VER LOGS EN CHECKPOINT FIREWALL:
   http://localhost/CheckPointFirewall/modules/logs_hospital.php

3. AGREGAR LOGS DESDE CÓDIGO PHP:
   
   $log_file = 'C:/wamp64/www/hospitalEPS/logs/activity.log';
   $fecha = date('Y-m-d H:i:s');
   $linea = "[$fecha] [login] Usuario test inició sesión\n";
   file_put_contents($log_file, $linea, FILE_APPEND);

═══════════════════════════════════════════════════════════════════
INTEGRACIÓN CON CHECKPOINT FIREWALL
═══════════════════════════════════════════════════════════════════

El sistema CheckPoint Firewall lee automáticamente este archivo
y clasifica cada log según su severidad.

Los logs se muestran en:
Logs > Logs Hospital EPS

═══════════════════════════════════════════════════════════════════
