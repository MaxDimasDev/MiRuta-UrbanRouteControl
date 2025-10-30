# Guía de Desarrolladores (Arquitectura y Referencias)

Esta guía profundiza en cómo está organizado el proyecto, las responsabilidades de cada capa (MVC), y dónde encontrar el código para modificar funcionalidades específicas.

## Stack y Convenciones
- Framework: CodeIgniter 3 (PHP)
- BD: MySQL/MariaDB (`utma_academico`)
- Nomenclatura:
  - `cat_` → Catálogos/configuración.
  - `pro_` → Procesos/operación.
  - `rel_` → Relaciones M:N y orden.
  - Campos: `eCod*` (IDs), `t*` (textos), `d*` (decimales), `fh*` (fechas/horas).

## Estructura de Carpetas
- `application/controllers/` – Controladores (capa de orquestación).
- `application/models/` – Modelos (acceso a datos y lógica de consulta).
- `application/views/` – Vistas (presentación).
- `application/config/` – Configuración de rutas, base_url y conexión BD.
- `assets/` – Recursos estáticos CSS/JS/images/vendor.
- `docs/` – Documentación.

## Controladores Principales
- `Sesion` (default):
  - `index()` muestra login.
  - `login_simple()` establece sesión de desarrollo (`admin/admin`), siembra mínimos.
  - `visitante()` redirige a público `MiRuta`.
- `Panel` (dashboard autenticado):
  - `index()` carga header, menú y vista `Panel/panel`.
- `Transporte` (administración):
  - `m4_s1()` rutas.
  - `m4_s2()` paradas.
  - `m4_s3()` horarios.
- `MiRuta` (página pública):
  - `index()` muestra planificador básico (rutas/paradas públicas).
- `Configuracion`:
  - `m1_s1()` log de eventos.
  - `m1_s2()` preferencias del sistema.
- Controladores de diagnóstico:
  - `Test_db` – conectividad BD, tablas y muestra muestra de `cat_perfiles`.
  - `Test_menu` – sesión simulada y render lógico de menú con datos.

## Modelos Clave
- `Secciones_m` – Menú y permisos:
  - `con_menu($eCodPerfil)` arma el menú desde `rel_perfilespermisos` → `cat_permisos` → `cat_secciones` → `cat_modulos`.
  - `con_secciones(...)` y `con_permisos(...)` para consultas auxiliares.
- `Transporte_m` – Dominio Transporte:
  - Consultas seguras con `table_exists` para `cat_rutas`, `cat_paradas`, `rel_rutasparadas`, `pro_servicios`, `pro_viajes`, `pro_tiemposparada`.
  - Métodos: `con_rutas`, `con_paradas`, `con_viajes`, `con_paradas_ruta`, `con_rutas_entre_paradas`.
- `Catalogos_m` – Catálogos generales:
  - `con_usuarios(...)` usa `vUsuarios` si existe; si no, intenta `cat_usuarios`; si faltan, regresa lista vacía (evita 500).
  - `con_perfiles`, `con_empresas`, `con_departamentos`, etc.
- `Configuraciones_m` – Config/logs:
  - `con_logeventos` y `con_lognotificaciones` construyen queries solo si las tablas existen; si no, devuelven vacío.
- `Consultas_m` – Ejemplo de items/tipos (no crítico en bootstrap Transporte).

## Vistas y Menú
- `Encabezado/header` y `Encabezado/menu` componen el layout.
- `menu.php`:
  - Oculta módulos `Catalogo` y `Usuario`.
  - Ordena módulos como: `Transporte` → `Configuración`.
  - Usa `tControlador`, `tCodSeccion`, `tSeccionIcono` para pintar enlaces.

## Rutas y Configuración
- `application/config/routes.php`:
  - `default_controller` = `Sesion`.
- `application/config/config.php`:
  - `base_url` debe apuntar a `http://localhost/utma-academico/` en desarrollo.
- `application/config/database.php`:
  - Debe apuntar a la BD `utma_academico`.

## Base de Datos
- Esquema mínimo: `schema_bootstrap.sql` — tablas, FKs e índices para Transporte, menú y eventos.
- Datos mínimos: `seed_bootstrap.sql` — estatus, perfil administrador, módulos y secciones (Transporte/Configuración), permisos y datos de transporte.
- Referencia conceptual: `docs/system/BD_Explicacion.txt` — nomenclaturas, relaciones y ejemplos.
- Reordenación opcional de menú en BD: `docs/system/update_menu_structure.sql`.

## Cómo Agregar un Módulo/Sección
1. Insertar módulo en `cat_modulos` (controlador, icono, posición).
2. Insertar secciones en `cat_secciones` con relación al módulo.
3. Insertar permisos en `cat_permisos` (ej. `Acceso`).
4. Asociar perfil/permisos en `rel_perfilespermisos` (ej. Administrador).
5. Crear controlador y vistas respectivas; usar `Secciones_m->con_menu($perfil)` en controladores para menú.

## Puntos de Extensión
- Usuarios: `Catalogos_m->con_usuarios` permite usar `vUsuarios` o `cat_usuarios` si está presente. En bootstrap, se usa `login_simple()`.
- Logs: `Configuraciones_m` consulta `pro_logseventos`/`pro_logsnotificaciones` si existen; puedes crear tablas y seeds para auditoría.
- Mapas: Integración con `assets/vendor/gmaps` o librerías externas.

## Buenas Prácticas en el Proyecto
- Consultas defensivas con `table_exists` para evitar 500 por ausencia de tablas.
- Uso consistente de `tCodEstatus` y FKs con `CASCADE`.
- Orden del menú manejado en vista (`menu.php`) y opcionalmente en BD.
- Separación de dominios: Transporte (operación) vs Catálogos/Config (parámetros).

## Endpoints Principales (desarrollo)
- `Sesion/index` – login.
- `Sesion/login_simple` – siembra mínima y sesión admin.
- `Panel/index` – dashboard.
- `Transporte/m4_s1` – rutas.
- `Transporte/m4_s2` – paradas.
- `Transporte/m4_s3` – horarios.
- `Configuracion/m1_s1` – log eventos.
- `Test_db` – prueba BD.
- `Test_menu` – prueba menú.

## Limitaciones Conocidas
- Módulos `Catalogo` y `Usuario` se ocultan en el menú en bootstrap.
- Assets deben resolverse con `base_url` correcto para evitar errores JS.

## Referencias
- `docs/GETTING_STARTED.md` para instalación.
- `docs/transporte/roadmap.md` para planificación.