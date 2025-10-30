# Plan de implementación Transporte (tipo Moovit)

Este documento describe la implementación incremental del módulo de transporte público dentro del sistema actual (CodeIgniter), reutilizando el inicio de sesión, permisos y layout.

## Objetivos
- Mostrar rutas, paradas y horarios de camiones.
- Permitir elegir origen/destino y generar rutas basadas en horarios y paradas establecidas.
- Proveer un panel administrativo para alta/baja/edición de rutas, paradas, formas (polylines), y horarios (viajes/stop_times).

## Fases

### Fase 1 — Normalización y esquema
- Unificar nomenclatura: `eCod*` para llaves, `t*` textos, `d*` decimales, `fh*` fechas/horas.
- Crear tablas: `cat_rutas`, `cat_paradas`, `rel_rutasparadas`, `pro_servicios` (calendarios), `pro_viajes`, `pro_tiemposparada`, `cat_formasruta`.
- Integrar estatus con `cat_estatus` (AC, EL, CA) y llaves foráneas.
- Preparar índices e integridad referencial.

### Fase 2 — CRUD administrativo
- Rutas: alta/edición/eliminación, color, código corto, sentido(s).
- Paradas: alta/edición, geolocalización (lat/lon), dirección y sentido.
- Relación rutas-paradas: orden/secuencia por ruta.
- Formas/Polylines: almacenaje y dibujo del trazo.
- Horarios: servicios (semana/fin/feriados), viajes por ruta y sus `stop_times`.
- Permisos/secciones: `Transporte` con `m4_s1` (Rutas), `m4_s2` (Paradas), `m4_s3` (Horarios).

### Fase 3 — Importación de datos
- Soporte de importación CSV/GTFS (opcional) para acelerar carga.
- Validaciones y reportes de inconsistencias.

### Fase 4 — Visualización y UX
- Mapas con paradas y rutas (Google Maps/Leaflet). Uso inicial de `assets/vendor/gmaps`.
- Búsqueda de rutas por origen/destino; selector de hora de salida.
- Páginas públicas y privadas (admin) diferenciadas por permisos.

### Fase 5 — Generación de rutas
- MVP: ruta directa sin transbordos (una ruta), en el próximo viaje disponible.
- Iteración: transbordos limitados (1–2), optimización por tiempo total usando un algoritmo tipo CSA/RAPTOR.
- Considerar tiempo de caminata entre paradas cercanas.

### Fase 6 — Performance y trazabilidad
- Cacheo de consultas, índices geoespaciales (si aplicable), paginación en vistas.
- Auditoría de acciones mediante `pro_logseventos`.

## Entregables iniciales
- Archivo `schema_transporte.sql` con DDL de tablas y sugerencias de inserciones de módulos/secciones.
- Controlador `Transporte` y modelo `Transporte_m` (esqueleto con consultas seguras).
- Vistas básicas: `rutas`, `paradas`, `horarios`.

## Próximos pasos sugeridos
1. Ejecutar `docs/transporte/schema_transporte.sql` en el esquema de base de datos.
2. Insertar módulo/sections en `cat_modulos`/`cat_secciones` para que el menú muestre Transporte.
3. CRUD de rutas y paradas (formularios y endpoints de guardado/actualización).
4. Dibujo de formas de rutas y posicionamiento de paradas en mapa.
5. Crear viajes y tiempos por parada; luego algoritmo de planificación.