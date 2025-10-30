# Guía de Inicio (Getting Started)

Esta guía explica cómo configurar, iniciar y probar el proyecto en Windows usando XAMPP o el servidor embebido de PHP.

## Prerrequisitos
- Windows 10/11 (o equivalente con PHP y MySQL/MariaDB).
- PHP 7.4–8.1 (CodeIgniter 3 compatible).
- Extensiones PHP habilitadas: `mysqli`, `mbstring`, `openssl`.
- MySQL/MariaDB (XAMPP recomendado).

## Estructura de Proyecto
- Directorio base: `c:\xampp\htdocs\utma-academico`
- Framework: CodeIgniter 3
- Base de datos de trabajo: `utma_academico`

## Configuración de Base de Datos
1. Crear la base de datos `utma_academico`:
   - phpMyAdmin: Crear BD con `utf8mb4`.
   - CLI (ajusta ruta a tu MySQL):
     - `"c:\xampp\mysql\bin\mysql.exe" -u root -p -e "CREATE DATABASE IF NOT EXISTS utma_academico CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"`
2. Importar esquema y seed mínimos:
   - `"c:\xampp\mysql\bin\mysql.exe" -u root utma_academico < c:\xampp\htdocs\utma-academico\schema_bootstrap.sql`
   - `"c:\xampp\mysql\bin\mysql.exe" -u root utma_academico < c:\xampp\htdocs\utma-academico\seed_bootstrap.sql`
3. Configurar credenciales en `application/config/database.php`:
   - `hostname`: `localhost`
   - `username`: `root`
   - `password`: `""` (vacío en XAMPP por defecto)
   - `database`: `utma_academico`

## Configuración de URLs
- Edita `application/config/config.php`:
  - `base_url` → `http://localhost/utma-academico/`
- Verifica rutas en `application/config/routes.php`:
  - `default_controller` → `Sesion`

## Ejecutar el Proyecto
### Opción A: Apache (XAMPP)
- Copia el proyecto en `c:\xampp\htdocs\utma-academico`.
- Inicia Apache y MySQL desde XAMPP Control Panel.
- Abre `http://localhost/utma-academico/index.php/Sesion`.

### Opción B: Servidor embebido de PHP
- En `c:\xampp\htdocs\utma-academico` ejecuta:
  - `php -S localhost:8000 -t . index.php`
- Accede a `http://localhost:8000/index.php/Sesion`.

## Login y Pruebas
- Login de desarrollo: usuario `admin`, contraseña `admin`.
- Rutas útiles:
  - `http://localhost/utma-academico/index.php/Test_db` – prueba de conexión BD.
  - `http://localhost/utma-academico/index.php/Test_menu` – validación del menú.
  - `http://localhost/utma-academico/index.php/Panel` – panel principal.
  - `http://localhost/utma-academico/index.php/Transporte/m4_s1` – rutas.
  - `http://localhost/utma-academico/index.php/Transporte/m4_s2` – paradas.
  - `http://localhost/utma-academico/index.php/Transporte/m4_s3` – horarios.
  - `http://localhost/utma-academico/index.php/Configuracion/m1_s1` – log de eventos.

## Assets y Errores Comunes
- Si ves `SyntaxError: Unexpected token '<'` o `$ is not defined`:
  - Confirma `base_url` correcto.
  - Valida que `assets/vendor/jquery` y demás estén presentes.
  - Abre `application/views/Encabezado/header` y `Panel/panel.php` para rutas CSS/JS.

## Servicios Externos
- No se requiere ningún servicio externo para el bootstrap.
- Mapas pueden usar `assets/vendor/gmaps` o integrarse con Google/Leaflet en fases posteriores.

## Semillas Opcionales
- `docs/system/update_menu_structure.sql` reordena módulos en BD si deseas reflejar el orden en consultas.

## Soporte y Desarrollo
- Para detalles técnicos consulta `docs/DEVELOPER_GUIDE.md`.
- Roadmap de transporte: `docs/transporte/roadmap.md`.