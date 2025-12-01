# Setup Guide (Instalación y Configuración)

Esta guía te lleva paso a paso desde clonar el repositorio hasta tener la aplicación corriendo en tu máquina, con la base de datos preparada y las rutas funcionando.

## Requisitos
- Windows 10/11 con XAMPP (recomendado) o PHP independiente.
- PHP 7.4–8.1 con extensiones `mysqli`, `mbstring`, `openssl` habilitadas.
- MySQL/MariaDB (incluido en XAMPP).

## 1) Clonar el repositorio
- Clona el proyecto en `c:\xampp\htdocs\utma-academico`:
  - `git clone <URL_DEL_REPOSITORIO> c:\xampp\htdocs\utma-academico`
- Asegúrate de que la carpeta final se llame `utma-academico`.

## 2) Configurar la base de datos
1. Crea la base de datos `utma_academico` (UTF8):
   - phpMyAdmin → Crear BD con `utf8mb4_general_ci`.
   - CLI:
     - `"c:\xampp\mysql\bin\mysql.exe" -u root -p -e "CREATE DATABASE IF NOT EXISTS utma_academico CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"`
2. Importa esquema y datos mínimos:
   - `"c:\xampp\mysql\bin\mysql.exe" -u root utma_academico < c:\xampp\htdocs\utma-academico\schema_bootstrap.sql`
   - `"c:\xampp\mysql\bin\mysql.exe" -u root utma_academico < c:\xampp\htdocs\utma-academico\seed_bootstrap.sql`

## 3) Revisar configuración de aplicación
- Archivo `application/config/database.php`:
  - `hostname` = `localhost`
  - `username` = `root`
  - `password` = `""` (vacío por defecto en XAMPP)
  - `database` = `utma_academico`
- Archivo `application/config/config.php`:
  - `base_url` se calcula dinámicamente; no requiere edición en desarrollo.
- Archivo `application/config/routes.php`:
  - `default_controller` = `Sesion` (pantalla de login).

## 4) Levantar el servidor
### Opción A: Apache (XAMPP)
- Inicia Apache y MySQL desde XAMPP Control Panel.
- Abre `http://localhost/utma-academico/index.php/Sesion`.

### Opción B: Servidor embebido de PHP
- Abre una consola en `c:\xampp\htdocs\utma-academico` y ejecuta:
  - `php -S localhost:8000 -t . router.php`
- Abre `http://localhost:8000/index.php/Sesion`.

## 5) Primer acceso y rutas
- En desarrollo, el login simplificado permite acceder con:
  - Usuario: `admin`
  - Contraseña: `admin`
- Rutas amigables disponibles (definidas en `routes.php`):
  - `http://localhost/utma-academico/index.php/Administracion_de_sistema/Inicio` (Panel)
  - `http://localhost/utma-academico/index.php/Administracion_de_transportes/Rutas`
  - `http://localhost/utma-academico/index.php/Administracion_de_transportes/Paradas`
  - `http://localhost/utma-academico/index.php/Administracion_de_transportes/Horarios`
  - `http://localhost/utma-academico/index.php/Administracion_de_sistema/Logs_del_sistema`
  - `http://localhost/utma-academico/index.php/Administracion_de_sistema/Historial_de_eventos`

## 6) Ajustes opcionales de entorno
- Logs: en `application/config/config.php` puedes reducir `log_threshold` para producción.
- Idioma: `language = 'spanish'` ya está configurado.
- Composición de menú: puedes aplicar `docs/system/update_menu_structure.sql` si deseas ajustar nombres/orden.

## 7) Verificación rápida
- Accede al Panel y confirma que el menú muestra Transporte y Configuración.
- En Transporte, verifica Rutas/Paradas/Horarios.
- En Configuración, abre Logs del sistema.

## 8) Solución de problemas
- Assets no cargan o errores JS:
  - Verifica `base_url` (debería resolverse automáticamente).
  - Usa el servidor embebido con `router.php` para servir estáticos.
- Error de conexión a BD:
  - Revisa credenciales en `application/config/database.php`.
  - Confirma que importaste `schema_bootstrap.sql` y `seed_bootstrap.sql`.
- Página en blanco o 404:
  - Asegúrate de acceder con `index.php` en la URL (`.../index.php/Sesion`).

## Recursos
- Guía rápida: `docs/GETTING_STARTED.md`
- Arquitectura y referencias: `docs/DEVELOPER_GUIDE.md`
- Explicación de BD: `docs/system/BD_Explicacion.txt`
