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
