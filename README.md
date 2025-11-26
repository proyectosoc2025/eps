# Hospital EPS - Sistema de Gestión Médica

## Descripción
Sistema completo de gestión hospitalaria con roles de Administrador, Doctor y Paciente.

## Características
- Login seguro con detección de inyección SQL
- Dashboard personalizado por rol
- Gestión de pacientes, doctores y administradores
- Historias clínicas completas
- Sistema de logs de actividad
- Tablas con paginación (10, 20, 50, 100 registros)
- Diseño responsive con Bootstrap
- Colores llamativos de hospital

## Instalación

### 1. Copiar archivos
Copie la carpeta `hospitalEPS` a `C:\wamp64\www\`

### 2. Crear base de datos
1. Abra phpMyAdmin (http://localhost/phpmyadmin)
2. Importe el archivo `database/eps_database.sql`
3. O ejecute el script SQL manualmente

### 3. Configuración
La configuración de base de datos está en `config/database.php`:
- Host: localhost
- Usuario: root
- Contraseña: (vacía)
- Base de datos: EPS

### 4. Acceso
URL: http://localhost/hospitalEPS

## Credenciales por defecto

### Administrador
- Usuario: jarodriguez11
- Contraseña: Blink182

## Estructura del Proyecto

```
hospitalEPS/
├── api/                    # APIs REST
│   ├── login.php
│   ├── logout.php
│   ├── pacientes/
│   ├── doctores/
│   └── historias/
├── assets/                 # Recursos estáticos
│   ├── css/
│   ├── js/
│   └── images/
├── config/                 # Configuración
│   ├── database.php
│   └── security.php
├── database/              # Scripts SQL
│   └── eps_database.sql
├── includes/              # Componentes reutilizables
│   ├── sidebar.php
│   ├── navbar.php
│   └── footer.php
├── pages/                 # Páginas por rol
│   ├── admin/
│   ├── doctor/
│   └── paciente/
├── index.php             # Página de login
└── dashboard.php         # Dashboard principal
```

## Roles y Permisos

### Administrador
- Ver todos los datos del sistema
- Gestionar pacientes, doctores y administradores
- Crear historias clínicas
- Ver logs del sistema
- Eliminar y modificar cualquier registro

### Doctor
- Ver su perfil
- Gestionar sus pacientes
- Crear, modificar y eliminar sus historias clínicas
- Ver solo sus pacientes registrados

### Paciente
- Ver su perfil
- Ver sus historias clínicas
- Ver sus visitas médicas
- Modificar: contraseña, dirección, correo y teléfono

## Seguridad
- Detección de inyección SQL
- Contraseñas hasheadas con bcrypt
- Sanitización de inputs
- Logs de todas las acciones
- Control de acceso por roles

## Tecnologías
- PHP 7.4+
- MySQL 5.7+
- Bootstrap 5.3
- jQuery 3.7
- DataTables 1.13

## Autor
Jonathan Alexis Rodriguez
Especialización en Seguridad de la Información
Proyecto de Grado
jarodriguez11@libertadores.edu.co
2025
