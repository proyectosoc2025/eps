@echo off
echo ========================================
echo HOSPITAL EPS - COPIAR A WAMP
echo ========================================
echo.
echo Este script copiara el proyecto a C:\wamp64\www\
echo.
pause

echo Copiando archivos...
xcopy /E /I /Y "%~dp0" "C:\wamp64\www\hospitalEPS\"

echo.
echo ========================================
echo COPIA COMPLETADA
echo ========================================
echo.
echo Ahora:
echo 1. Inicie WAMP Server
echo 2. Abra phpMyAdmin: http://localhost/phpmyadmin
echo 3. Importe: database/eps_database.sql
echo 4. Acceda a: http://localhost/hospitalEPS
echo.
echo Usuario: jarodriguez11
echo Contraseña: Blink182
echo.
pause
