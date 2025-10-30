-- Reestructuración de menú del sistema
-- Objetivo: Renombrar "Transporte" a "Administración de transportes" y colocarlo segundo,
-- remover "Catálogo" del menú, ubicar "Usuarios" debajo de Transporte y "Config" al final.

-- 1) Remover completamente el módulo Catálogo (m3) y sus relaciones
-- Nota: Se respeta el orden para cumplir con las llaves foráneas.
DELETE rpp
FROM rel_perfilespermisos rpp
JOIN cat_permisos cp ON cp.eCodPermiso = rpp.eCodPermiso
JOIN cat_secciones cs ON cs.eCodSeccion = cp.eCodSeccion
JOIN cat_modulos cm ON cm.eCodModulo = cs.eCodModulo
WHERE cm.tCodModulo = 'm3';

DELETE cp
FROM cat_permisos cp
JOIN cat_secciones cs ON cs.eCodSeccion = cp.eCodSeccion
JOIN cat_modulos cm ON cm.eCodModulo = cs.eCodModulo
WHERE cm.tCodModulo = 'm3';

DELETE cs
FROM cat_secciones cs
JOIN cat_modulos cm ON cm.eCodModulo = cs.eCodModulo
WHERE cm.tCodModulo = 'm3';

DELETE FROM cat_modulos WHERE tCodModulo = 'm3';

-- 2) Asegurar presencia y renombrado del módulo Transporte
-- Si existe, actualizar nombre/posición; si no existe, insertarlo.
UPDATE cat_modulos
SET tNombre = 'Administración de transportes',
    tNombreCorto = 'Administración de transportes',
    tIcono = IFNULL(NULLIF(tIcono,''),'fa-bus'),
    tControlador = 'Transporte',
    ePosicion = 1
WHERE tCodModulo = 'm4' OR tControlador = 'Transporte';

INSERT INTO cat_modulos (tCodModulo, tNombre, tNombreCorto, tIcono, tControlador, ePosicion)
SELECT 'm4','Administración de transportes','Administración de transportes','fa-bus','Transporte',1
FROM (SELECT 1) AS x
WHERE NOT EXISTS (
  SELECT 1 FROM cat_modulos WHERE tCodModulo = 'm4' OR tControlador = 'Transporte'
);

-- 3) Reordenar posiciones de Usuarios y Configuración
UPDATE cat_modulos SET ePosicion = 2 WHERE tCodModulo = 'm2' OR tControlador = 'Usuario';
UPDATE cat_modulos SET ePosicion = 99 WHERE tCodModulo = 'm1' OR tControlador = 'Configuracion';

-- Fin: El menú quedará como: Inicio (estático) -> Administración de transportes -> Usuarios -> Config.