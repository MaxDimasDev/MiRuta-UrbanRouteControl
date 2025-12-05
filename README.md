# MiRuta (UTMA Académico)

MiRuta es un módulo de transporte público integrado en una aplicación CodeIgniter, pensado para administrar y visualizar rutas, paradas y horarios. Incluye un panel de administración con permisos por perfil, y páginas públicas para consulta.

## Características
- Administración de rutas, paradas, formas (polylines) y horarios (viajes y tiempos por parada).
- Menú dinámico por perfil/permisos utilizando catálogos de módulos/secciones.
- Inicio de sesión rápido para entorno de desarrollo (`admin/admin`).
- Esquema y datos mínimos listos para bootstrap: `schema_bootstrap.sql` y `seed_bootstrap.sql`.
- Base URL se configura dinámicamente; servidor embebido usa `router.php`.

## Estructura General
- `application/controllers/`: Controladores principales (`Sesion`, `Panel`, `Transporte`, `MiRuta`, `Configuracion`).
- `application/models/`: Modelos (`Secciones_m`, `Transporte_m`, `Catalogos_m`, `Configuraciones_m`, `Consultas_m`).
- `application/views/`: Vistas del panel, intranet y principal.
- `assets/`: CSS/JS/vendor e imágenes.
- `docs/`: Documentación técnica y guías.

## Módulos Clave
- **Transporte** (`Transporte`): Rutas (`m4_s1`), Paradas (`m4_s2`), Horarios (`m4_s3`).
- **Configuración** (`Configuracion`): Log de eventos (`m1_s1`) y preferencias (`m1_s2`).

## Estado del Proyecto
- El backend y la base de datos se encuentran funcionales con el bootstrap mínimo.
- Algunos errores de JavaScript pueden aparecer si faltan assets o `base_url` no está correcto; no afectan conectividad.

## Primeros Pasos
Consulta `docs/SETUP_GUIDE.md` para pasos detallados de instalación y configuración.
Para una guía rápida, revisa `docs/GETTING_STARTED.md`.

## Ejecución Rápida
- Servidor embebido: `php -S localhost:8000 -t . router.php`
- Login: `http://localhost:8000/index.php/Sesion` (usuario `admin`, contraseña `admin`).
- Rutas amigables:
  - `Administracion_de_sistema/Inicio` (Panel)
  - `Administracion_de_transportes/Rutas`, `Paradas`, `Horarios`
  - `Administracion_de_sistema/Logs_del_sistema`, `Historial_de_eventos`

## Documentación
- Quickstart: `docs/GETTING_STARTED.md`
- Setup Guide: `docs/SETUP_GUIDE.md`
- Arquitectura: `docs/DEVELOPER_GUIDE.md`

## Licencia
Proyecto académico; revisar condiciones internas de uso. No se incluye licencia open source por defecto.

---

## UrbanRouteApi (ASP.NET Core)

API REST en .NET 8 para gestionar rutas, paradas, servicios y viajes, utilizada durante la migración del módulo MiRuta.

### Descripción breve
- Exposición de endpoints `Rutas`, `Paradas`, `Servicios` y `Viajes` sobre MySQL.
- Documentación integrada con Swagger/OpenAPI, con summaries, tags y ejemplos básicos.
- Colección de Postman y ambiente listos para pruebas locales.

### Requisitos
- `SDK .NET 8` o superior.
- Motor de base de datos `MySQL` (probado con MySQL 8 / MariaDB).
- Cadena de conexión configurada en `aspnetcore/UrbanRouteApi/appsettings.json` bajo `ConnectionStrings:Default`.

### Pasos para levantar la API en local
1. Abrir una terminal en el proyecto raíz.
2. Ir al directorio de la API: `cd aspnetcore/UrbanRouteApi`
3. Restaurar paquetes (opcional): `dotnet restore`
4. Ejecutar la API: `dotnet run`
5. Base URL: `http://localhost:5299`
6. Swagger UI: `http://localhost:5299/swagger`

### Endpoints principales
- `GET /api/rutas`, `GET /api/rutas/{id}`, `GET /api/rutas/{id}/paradas`, `GET /api/rutas/{id}/viajes`, `GET /api/rutas/{id}/forma`
- `GET /api/paradas`, `GET /api/paradas/{id}`
- `GET /api/servicios`, `GET /api/servicios/{id}`
- `GET /api/viajes/{id}`, `GET /api/viajes/{id}/tiempos`
- `POST/PATCH/DELETE` en `rutas`, `paradas`, `servicios`, `viajes` (crear/eliminar puede estar deshabilitado por flags de migración).

### Postman
- Colección: `aspnetcore/UrbanRouteApi/UrbanRouteApi.postman_collection.json`
- Ambiente: `aspnetcore/UrbanRouteApi/UrbanRouteApi.postman_environment.json` (variable `baseUrl` = `http://localhost:5299`)

### Notas
- Swagger está habilitado en todos los entornos para facilitar pruebas.
- Si la API no abre conexión, revisar `ConnectionStrings:Default` y que MySQL esté disponible.
