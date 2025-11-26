<?php
// Script para generar el hash de la contraseña
$password = "Blink182";
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Contraseña: " . $password . "\n";
echo "Hash: " . $hash . "\n\n";

echo "Actualice el archivo eps_database.sql con este hash:\n";
echo "UPDATE administradores SET password = '$hash' WHERE usuario = 'jarodriguez11';\n";
?>
