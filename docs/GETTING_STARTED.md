# Guía de Inicio (Quickstart)

Esta es una guía rápida para correr el proyecto. Para pasos detallados, solución de problemas y opciones avanzadas, consulta `docs/SETUP_GUIDE.md`.

## Prerrequisitos
- Windows 10/11, XAMPP (Apache/PHP/MySQL) o PHP con MySQL/MariaDB.
- PHP 7.4–8.1 con `mysqli`, `mbstring`, `openssl`.

## Pasos Rápidos
1. Base de datos `utma_academico`:
   - Crea la BD y carga `schema_bootstrap.sql` y `seed_bootstrap.sql`.
2. Configura `application/config/database.php`:
   - `hostname=localhost`, `username=root`, `password=""`, `database=utma_academico`.
3. Levanta el servidor embebido:
   - `php -S localhost:8000 -t . router.php`
4. Abre el login:
   - `http://localhost:8000/index.php/Sesion`.
5. Ingresa con credenciales de desarrollo:
   - Usuario `admin`, contraseña `admin`.

## Rutas útiles
- Panel: `http://localhost:8000/index.php/Administracion_de_sistema/Inicio`
- Transporte → Rutas: `http://localhost:8000/index.php/Administracion_de_transportes/Rutas`
- Transporte → Paradas: `http://localhost:8000/index.php/Administracion_de_transportes/Paradas`
- Transporte → Horarios: `http://localhost:8000/index.php/Administracion_de_transportes/Horarios`
- Configuración → Logs: `http://localhost:8000/index.php/Administracion_de_sistema/Logs_del_sistema`
- Configuración → Historial: `http://localhost:8000/index.php/Administracion_de_sistema/Historial_de_eventos`

## Más información
- Guía completa de instalación: `docs/SETUP_GUIDE.md`
- Arquitectura y referencias: `docs/DEVELOPER_GUIDE.md`

## UrbanRouteApi (ASP.NET Core) – Quickstart
- Requisitos: .NET 8 y acceso a la base `utma_academico`.
- Directorio: `aspnetcore/UrbanRouteApi`
- Ejecutar con creación habilitada:
  - En PowerShell: ``$env:URBANROUTE_ENABLE_CREATION_DELETION = "true"; dotnet run``
- Swagger: `http://localhost:5299/swagger`
- Respuestas esperadas en pruebas: `200`, `201` o `202`.
