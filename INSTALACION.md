# Guía de Instalación - Hospital EPS

## Requisitos Previos
- WAMP Server instalado (Apache, MySQL, PHP 7.4+)
- Navegador web moderno (Chrome, Firefox, Edge)

## Pasos de Instalación

### 1. Copiar Archivos
1. Copie toda la carpeta `hospitalEPS` a `C:\wamp64\www\`
2. La ruta final debe ser: `C:\wamp64\www\hospitalEPS\`

### 2. Iniciar WAMP
1. Inicie WAMP Server
2. Espere a que el ícono se ponga verde
3. Verifique que Apache y MySQL estén corriendo

### 3. Crear Base de Datos

#### Opción A: Importar SQL (Recomendado)
1. Abra su navegador
2. Vaya a: `http://localhost/phpmyadmin`
3. Haga clic en "Nueva" en el panel izquierdo
4. Nombre de la base de datos: `EPS`
5. Cotejamiento: `utf8mb4_unicode_ci`
6. Haga clic en "Crear"
7. Seleccione la base de datos `EPS`
8. Haga clic en la pestaña "Importar"
9. Seleccione el archivo: `hospitalEPS/database/eps_database.sql`
10. Haga clic en "Continuar"

#### Opción B: Ejecutar SQL Manualmente
1. Abra phpMyAdmin
2. Haga clic en la pestaña "SQL"
3. Copie y pegue el contenido de `eps_database.sql`
4. Haga clic en "Continuar"

### 4. Generar Contraseña del Administrador
1. Abra su navegador
2. Vaya a: `http://localhost/hospitalEPS/database/generar_password.php`
3. Copie el hash generado
4. En phpMyAdmin, ejecute:
```sql
UPDATE administradores SET password = 'HASH_COPIADO' WHERE usuario = 'jarodriguez11';
```

### 5. Verificar Configuración
Abra el archivo `config/database.php` y verifique:
```php
private $host = "localhost";
private $db_name = "EPS";
private $username = "root";
private $password = "";
```

### 6. Agregar Imagen de Hospital
1. Busque una imagen de hospital (recomendado: 1920x1080px)
2. Guárdela como: `assets/images/hospital.jpg`
3. O use una imagen de stock gratuita de sitios como Unsplash o Pexels

### 7. Acceder al Sistema
1. Abra su navegador
2. Vaya a: `http://localhost/hospitalEPS`
3. Use las credenciales:
   - Usuario: `jarodriguez11`
   - Contraseña: `Blink182`

## Solución de Problemas

### Error: "No se puede conectar a la base de datos"
- Verifique que MySQL esté corriendo en WAMP
- Verifique las credenciales en `config/database.php`
- Asegúrese de que la base de datos `EPS` exista

### Error: "Call to undefined function password_verify()"
- Su versión de PHP es muy antigua
- Actualice PHP a 7.4 o superior

### Error 404: "Página no encontrada"
- Verifique que la carpeta esté en `C:\wamp64\www\hospitalEPS\`
- Verifique que Apache esté corriendo
- Intente: `http://localhost/hospitalEPS/index.php`

### La imagen del login no se muestra
- Agregue una imagen real en `assets/images/hospital.jpg`
- Verifique los permisos de la carpeta

### Las tablas no muestran datos
- Verifique que la base de datos tenga las tablas creadas
- Ejecute el script SQL nuevamente
- Revise la consola del navegador (F12) para errores

## Configuración Adicional

### Cambiar Puerto de Apache
Si el puerto 80 está ocupado:
1. Abra WAMP
2. Click izquierdo en el ícono
3. Apache > httpd.conf
4. Busque: `Listen 80`
5. Cambie a: `Listen 8080`
6. Reinicie Apache
7. Acceda con: `http://localhost:8080/hospitalEPS`

### Habilitar Errores PHP (Solo para desarrollo)
En `config/database.php`, agregue al inicio:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## Datos de Prueba

### Crear un Doctor de Prueba
```sql
INSERT INTO doctores (nombres, apellidos, identificacion, usuario, password, telefono, profesion, rol) 
VALUES ('Juan', 'Pérez', '123456789', 'doctor1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '3001234567', 'Médico General', 'Doctor');
```
Usuario: doctor1 / Contraseña: password

### Crear un Paciente de Prueba
```sql
INSERT INTO pacientes (nombre, primer_apellido, identificacion, usuario, password, edad, sexo, grupo_sanguineo, telefono, rol) 
VALUES ('María', 'González', '987654321', 'paciente1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 30, 'Femenino', 'O+', '3009876543', 'Paciente');
```
Usuario: paciente1 / Contraseña: password

## Seguridad

### Cambiar Contraseña del Administrador
1. Inicie sesión como administrador
2. Vaya a su perfil
3. O ejecute en phpMyAdmin:
```sql
UPDATE administradores SET password = 'NUEVO_HASH' WHERE usuario = 'jarodriguez11';
```

### Proteger en Producción
1. Cambie las credenciales de la base de datos
2. Elimine el archivo `generar_password.php`
3. Configure HTTPS
4. Actualice `.htaccess` para forzar HTTPS

## Soporte
Para problemas o preguntas:
- Email: jarodriguez11@libertadores.edu.co
- Revise el archivo README.md para más información

## Licencia
Proyecto de Grado - 2025
Todos los derechos reservados
