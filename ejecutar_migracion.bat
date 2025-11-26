@echo off
echo Ejecutando migracion de base de datos...
mysql -u root -p EPS < database/agregar_doctor_id_pacientes.sql
echo Migracion completada!
pause
