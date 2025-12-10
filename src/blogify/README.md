# BLOGIFY - Red Social de Reseñas

Aplicación web desarrollada en PHP para gestionar reseñas de películas, series, videojuegos, libros, etc.

## Características Principales

- ✅ Sistema de autenticación con control de sesiones (expiración 5 minutos)
- ✅ Protección CSRF
- ✅ Patrón Singleton en Database y Session
- ✅ Uso de PDO y sentencias preparadas con bindValue
- ✅ CRUD completo de artículos y comentarios
- ✅ Sistema de votaciones (positivo/negativo)
- ✅ Comentarios anidados (respuestas a comentarios)
- ✅ Máquinas de estado para procesamiento de formularios
- ✅ Diseño Bootstrap 5 responsive

## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)

## Instalación

### 1. Crear la base de datos

```bash
mysql -u root -p < database/schema.sql
```

O manualmente:
- Acceder a phpMyAdmin
- Importar el archivo `database/schema.sql`

### 2. Configurar la conexión

Editar el archivo `database/Database.php` y ajustar las credenciales:

```php
private $host = 'localhost';
private $dbname = 'blogify';
private $username = 'root';
private $password = '';
```

### 3. Desplegar en servidor web

Copiar todos los archivos a la carpeta del servidor web:
- XAMPP: `C:\xampp\htdocs\blogify\`
- WAMP: `C:\wamp64\www\blogify\`
- Linux: `/var/www/html/blogify/`

### 4. Acceder a la aplicación

Abrir en el navegador: `http://localhost/blogify/`

## Credenciales de Prueba

```
Email: carmen@test.com
Password: password

Email: juan@test.com
Password: password

Email: maria@test.com
Password: password
```

## Estructura del Proyecto

```
blogify/
├── database/
│   ├── Database.php          # Clase Database (Singleton + PDO)
│   └── schema.sql            # Script SQL de creación
├── session/
│   └── Sesion.php            # Clase Sesion (Singleton)
├── interfaces/
│   └── DatabaseInterface.php # Interfaz para Database
├── index.php                 # Login
├── main.php                  # Pantalla principal
├── articulo.php              # Crear artículo
├── editarArticulo.php        # Editar artículo
├── borrar.php                # Eliminar artículo
├── leer.php                  # Ver artículo y comentarios
├── comentario.php            # Crear comentario/respuesta
├── editarComentario.php      # Editar comentario
├── borrarComentario.php      # Eliminar comentario
├── masPositivo.php           # Votar positivo
├── masNegativo.php           # Votar negativo
├── logout.php                # Cerrar sesión
├── config.php                # Configuración general
└── autoload.php              # Autoloader de clases
```

## Patrones de Diseño Implementados

### Singleton
- `Database`: Una única instancia de conexión a BD
- `Sesion`: Control centralizado de sesiones

### MVC Simplificado
- Modelos: Clase Database con métodos CRUD
- Vistas: Archivos PHP con HTML
- Controladores: Lógica en cada archivo PHP (máquinas de estado)

## Seguridad Implementada

✅ **Protección SQL Injection**: Sentencias preparadas con bindValue  
✅ **Protección XSS**: htmlspecialchars() en todas las salidas  
✅ **Protección CSRF**: Token en sesión  
✅ **Control de sesiones**: Expiración automática (5 minutos)  
✅ **Validación de permisos**: Usuarios solo pueden editar/borrar su contenido  
✅ **Contraseñas hasheadas**: password_hash() y password_verify()  

## Funcionalidades por Pantalla

### 1. Login (index.php)
- Validación de credenciales
- Redirección si ya está logueado
- Mensajes de error con Bootstrap alerts

### 2. Pantalla Principal (main.php)
- Listado de todos los artículos
- Votos formateados con 3 dígitos (001, 023, etc.)
- Botones activos/inactivos según autoría
- Opciones editar/borrar solo para artículos propios

### 3. Escribir Artículo (articulo.php)
- Campos: título, texto, fecha (readonly)
- Validación obligatoria
- Fecha automática del día
- Máquina de estados

### 4. Leer Artículo (leer.php)
- Muestra artículo completo
- Lista comentarios principales
- Lista respuestas anidadas con margen
- Botón "Responder" solo en comentarios principales
- Botones editar/borrar solo para comentarios propios

### 5. Comentarios
- Crear comentario o respuesta
- Editar comentarios propios
- Eliminar comentarios (cascada a respuestas)

### 6. Votaciones
- Incremento de votos positivos/negativos
- Validación: no votar artículos propios
- Redirección a pantalla principal

## Notas Técnicas

- Todas las consultas usan **bindValue()** en lugar de bindParam()
- Máquinas de estado en todos los formularios
- Control de errores con try-catch
- Logs de errores en archivos PHP
- Font: Roboto Flex weight 100 para tablas
- Bootstrap 5.3 + Bootstrap Icons

## Autor

Desarrollado como examen de PHP - 2DAW 2024/25
