@echo off
echo ========================================
echo PREPARAR PROYECTO PARA HOSTING
echo ========================================
echo.

REM Crear carpeta de destino
set DESTINO=hospitalEPS_hosting
if exist %DESTINO% (
    echo Eliminando carpeta anterior...
    rmdir /s /q %DESTINO%
)

echo Creando carpeta %DESTINO%...
mkdir %DESTINO%

echo.
echo Copiando archivos necesarios...

REM Copiar archivos principales
copy index.php %DESTINO%\
copy dashboard.php %DESTINO%\
copy .htaccess %DESTINO%\

REM Copiar carpetas completas
echo Copiando carpeta api...
xcopy /E /I /Y api %DESTINO%\api

echo Copiando carpeta assets...
xcopy /E /I /Y assets %DESTINO%\assets

echo Copiando carpeta config...
xcopy /E /I /Y config %DESTINO%\config

echo Copiando carpeta includes...
xcopy /E /I /Y includes %DESTINO%\includes

echo Copiando carpeta pages...
xcopy /E /I /Y pages %DESTINO%\pages

REM Copiar archivos de database
echo Copiando base de datos...
mkdir %DESTINO%\database
copy database\eps_database.sql %DESTINO%\database\
copy database\importar_manual.php %DESTINO%\database\

REM Crear carpetas vacías necesarias
echo Creando carpetas necesarias...
mkdir %DESTINO%\logs
mkdir %DESTINO%\imagenes

REM Copiar imagenes si existen
if exist imagenes\*.* (
    xcopy /E /I /Y imagenes %DESTINO%\imagenes
)

echo.
echo ========================================
echo LIMPIEZA COMPLETADA
echo ========================================
echo.
echo La carpeta "%DESTINO%" contiene solo los archivos necesarios.
echo.
echo SIGUIENTE PASO:
echo 1. Revisa la carpeta %DESTINO%
echo 2. Edita %DESTINO%\config\database.php con los datos de tu hosting
echo 3. Sube todo el contenido de %DESTINO% a tu hosting via FTP
echo 4. Importa %DESTINO%\database\eps_database.sql en phpMyAdmin
echo.
echo IMPORTANTE:
echo - NO subas archivos .txt de documentacion
echo - NO subas archivos de prueba (test_*.php, debug_*.php)
echo - Cambia las credenciales en el hosting
echo.
pause
