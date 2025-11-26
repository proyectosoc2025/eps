# Guía para Subir Hospital EPS a Hosting Gratuito

## Opción Recomendada: InfinityFree

### Paso 1: Registrarse en InfinityFree
1. Ve a: https://www.infinityfree.net/
2. Haz clic en "Sign Up"
3. Completa el registro con tu email
4. Verifica tu correo electrónico

### Paso 2: Crear una Cuenta de Hosting
1. Inicia sesión en InfinityFree
2. Haz clic en "Create Account"
3. Elige un subdominio (ejemplo: `hospitaleps.rf.gd`)
4. Espera 2-5 minutos a que se active

### Paso 3: Obtener Credenciales de Base de Datos
1. En el panel de control, ve a "MySQL Databases"
2. Crea una nueva base de datos
3. Anota estos datos:
   - **Hostname**: (ejemplo: sql123.epizy.com)
   - **Database Name**: (ejemplo: epiz_12345678_EPS)
   - **Username**: (ejemplo: epiz_12345678)
   - **Password**: (la que creaste)

### Paso 4: Subir Archivos por FTP

#### Opción A: FileZilla (Recomendado)
1. Descarga FileZilla: https://filezilla-project.org/
2. Instala y abre FileZilla
3. En InfinityFree, ve a "FTP Details"
4. Conecta con estos datos:
   - **Host**: ftpupload.net
   - **Usuario**: epiz_XXXXXXXX
   - **Contraseña**: tu contraseña FTP
   - **Puerto**: 21

5. En FileZilla:
   - Panel izquierdo: navega a tu carpeta `hospitalEPS`
   - Panel derecho: navega a `/htdocs/`
   - Selecciona TODOS los archivos y carpetas
   - Arrastra al panel derecho
   - Espera a que termine la subida (puede tardar 10-20 minutos)

#### Opción B: Administrador de Archivos Web
1. En InfinityFree, ve a "Online File Manager"
2. Navega a `/htdocs/`
3. Sube los archivos en lotes pequeños (máximo 10MB por vez)
4. Descomprime si subes un ZIP

### Paso 5: Importar Base de Datos
1. En InfinityFree, haz clic en "MySQL Databases"
2. Haz clic en "phpMyAdmin"
3. Selecciona tu base de datos en el panel izquierdo
4. Haz clic en la pestaña "Importar"
5. Selecciona el archivo `database/eps_database.sql`
6. Haz clic en "Continuar"
7. Espera a que termine la importación

### Paso 6: Configurar la Conexión a Base de Datos
1. En FileZilla o el File Manager, abre el archivo `config/database.php`
2. Edita con los datos de tu hosting:
```php
private $host = "sql123.epizy.com";  // Tu hostname
private $db_name = "epiz_12345678_EPS";  // Tu database name
private $username = "epiz_12345678";  // Tu username
private $password = "tu_password_mysql";  // Tu password
```
3. Guarda el archivo

### Paso 7: Probar el Sistema
1. Ve a tu URL: `http://tudominio.rf.gd`
2. Deberías ver la página de login
3. Inicia sesión con:
   - Usuario: `jarodriguez11`
   - Contraseña: `Blink182`

## Archivos que NO Debes Subir

Estos archivos son solo para desarrollo local:
- `COPIAR_A_WAMP.bat`
- `ejecutar_migracion.bat`
- `test.php`
- `test_write.php`
- `debug_login.php`
- `debug_logs.php`
- `generar_datos_prueba.php`
- `limpiar_datos_prueba.php`
- `verificar_errores.php`
- Todos los archivos `.txt` de documentación
- `GUIA_HOSTING_GRATUITO.md`
- `README.md` (opcional)
- `INSTALACION.md` (opcional)

## Solución de Problemas Comunes

### Error: "No se puede conectar a la base de datos"
- Verifica que los datos en `config/database.php` sean correctos
- Asegúrate de usar el hostname completo (ejemplo: sql123.epizy.com)
- Verifica que la base de datos esté creada e importada

### Error: "Internal Server Error 500"
- Revisa el archivo `.htaccess`
- Asegúrate de que todos los archivos PHP se subieron correctamente
- Verifica los permisos de carpetas (755 para carpetas, 644 para archivos)

### Las imágenes no se cargan
- Verifica que la carpeta `assets/images/` se haya subido
- Verifica que `hospital.jpg` exista
- Cambia las rutas a relativas si es necesario

### La página se ve sin estilos
- Verifica que la carpeta `assets/css/` se haya subido
- Abre la consola del navegador (F12) para ver errores
- Verifica las rutas en los archivos HTML/PHP

### Subida FTP muy lenta
- InfinityFree puede ser lento en horas pico
- Intenta subir en la madrugada
- Sube carpetas por separado

## Optimizaciones para Hosting Gratuito

### 1. Comprimir Imágenes
Las imágenes grandes ralentizan el sitio:
- Usa herramientas como TinyPNG.com
- Reduce el tamaño de `hospital.jpg` a máximo 500KB

### 2. Minimizar CSS y JS
- Usa herramientas online para minimizar archivos
- Reduce el tamaño de descarga

### 3. Habilitar Caché
Agrega al `.htaccess`:
```apache
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType image/jpg "access plus 1 year"
  ExpiresByType image/jpeg "access plus 1 year"
  ExpiresByType image/png "access plus 1 year"
  ExpiresByType text/css "access plus 1 month"
  ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

## Limitaciones del Hosting Gratuito

- **Velocidad**: Más lento que hosting pago
- **Uptime**: Puede tener caídas ocasionales
- **Soporte**: Limitado o inexistente
- **Recursos**: CPU y RAM limitados
- **Tráfico**: Límite de visitas diarias

## Alternativas si InfinityFree no Funciona

### 000webhost
1. Registrarse en: https://www.000webhost.com/
2. Crear sitio web
3. Subir archivos por FTP o File Manager
4. Importar base de datos en phpMyAdmin
5. Configurar `config/database.php`

### Awardspace
1. Registrarse en: https://www.awardspace.com/
2. Proceso similar a InfinityFree

## Consejos de Seguridad

1. **Cambia las contraseñas por defecto**
2. **Elimina archivos de prueba** antes de subir
3. **No subas archivos con contraseñas en texto plano**
4. **Habilita HTTPS** si el hosting lo ofrece
5. **Haz backups regulares** de la base de datos

## Contacto y Soporte

Si tienes problemas:
- Revisa los foros de InfinityFree
- Consulta la documentación de PHP/MySQL
- Verifica los logs de error del hosting

---

**Nota**: El hosting gratuito es ideal para proyectos de prueba o portafolio, pero para producción real se recomienda hosting pago.

