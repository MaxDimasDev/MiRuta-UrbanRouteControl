-- Seed mínimo para MiRuta (Transporte)
SET NAMES utf8mb4;

-- Estatus base
INSERT INTO `cat_estatus` (`tCodEstatus`,`tNombre`,`tClase`) VALUES
 ('AC','Activo','success'),
 ('IN','Inactivo','secondary'),
 ('EL','Eliminado','danger'),
 ('CA','Cancelado','warning')
ON DUPLICATE KEY UPDATE `tNombre`=VALUES(`tNombre`), `tClase`=VALUES(`tClase`);

-- Perfil administrador
INSERT INTO `cat_perfiles` (`tNombre`,`tCodEstatus`) VALUES ('Administrador','AC')
ON DUPLICATE KEY UPDATE `tNombre`=VALUES(`tNombre`);

-- Módulo y secciones de Transporte
INSERT INTO `cat_modulos` (`tCodModulo`,`tNombre`,`tNombreCorto`,`tIcono`,`tControlador`,`ePosicion`)
VALUES ('m4','Administración de transportes','Transporte','fa-bus','Transporte',4)
ON DUPLICATE KEY UPDATE `tNombre`=VALUES(`tNombre`),`tNombreCorto`=VALUES(`tNombreCorto`),`tIcono`=VALUES(`tIcono`),`tControlador`=VALUES(`tControlador`),`ePosicion`=VALUES(`ePosicion`);

INSERT INTO `cat_secciones` (`eCodModulo`,`tCodSeccion`,`tNombre`,`tNombreCorto`,`tIcono`,`ePosicion`)
VALUES
 ((SELECT `eCodModulo` FROM `cat_modulos` WHERE `tCodModulo`='m4' ORDER BY `eCodModulo` ASC LIMIT 1),'m4_s1','Administrar rutas','Rutas','fa-route',1),
 ((SELECT `eCodModulo` FROM `cat_modulos` WHERE `tCodModulo`='m4' ORDER BY `eCodModulo` ASC LIMIT 1),'m4_s2','Administrar paradas','Paradas','fa-map-marker-alt',2),
 ((SELECT `eCodModulo` FROM `cat_modulos` WHERE `tCodModulo`='m4' ORDER BY `eCodModulo` ASC LIMIT 1),'m4_s3','Administrar horarios','Horarios','fa-clock',3)
ON DUPLICATE KEY UPDATE `tNombre`=VALUES(`tNombre`),`tNombreCorto`=VALUES(`tNombreCorto`),`tIcono`=VALUES(`tIcono`),`ePosicion`=VALUES(`ePosicion`);

-- Permiso de acceso por sección
INSERT INTO `cat_permisos` (`eCodSeccion`,`tNombre`,`tNombreCorto`,`tIcono`,`ePosicion`)
SELECT `eCodSeccion`, 'Acceso', 'Acceso', 'fa-check', 1 FROM `cat_secciones`
ON DUPLICATE KEY UPDATE `tNombre`=VALUES(`tNombre`),`tNombreCorto`=VALUES(`tNombreCorto`),`tIcono`=VALUES(`tIcono`),`ePosicion`=VALUES(`ePosicion`);

-- Asignar todos los permisos al perfil Administrador
INSERT INTO `rel_perfilespermisos` (`eCodPerfil`,`eCodPermiso`)
SELECT (SELECT `eCodPerfil` FROM `cat_perfiles` WHERE `tNombre`='Administrador' ORDER BY `eCodPerfil` ASC LIMIT 1), `eCodPermiso` FROM `cat_permisos`
ON DUPLICATE KEY UPDATE `eCodPerfil`=`eCodPerfil`;

-- Datos de transporte mínimos
INSERT INTO `cat_rutas` (`tNombre`,`tCodigo`,`tColor`,`tSentido`,`tCodEstatus`) VALUES
 ('Ruta 1','R1','#0969da','N','AC')
ON DUPLICATE KEY UPDATE `tNombre`=VALUES(`tNombre`), `tColor`=VALUES(`tColor`);

-- Paradas visibles siempre en el mapa
INSERT INTO `cat_paradas` (`tNombre`,`tDireccion`,`tSentido`,`dLatitud`,`dLongitud`,`tCodEstatus`) VALUES
 ('Parada A','Centro','N',19.7040,-103.4610,'AC'),
 ('Parada B','Mercado','N',19.7052,-103.4605,'AC'),
 ('Parada C','Plaza','N',19.7064,-103.4598,'AC'),
 ('Parada D','Hospital','N',19.7076,-103.4592,'AC'),
 ('Parada E','Escuela','N',19.7088,-103.4586,'AC');

-- Asignación a la Ruta 1 con orden
INSERT INTO `rel_rutasparadas` (`eCodRuta`,`eCodParada`,`eOrden`,`tCodEstatus`)
VALUES
 ((SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R1' ORDER BY `eCodRuta` ASC LIMIT 1), 1, 1, 'AC'),
 ((SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R1' ORDER BY `eCodRuta` ASC LIMIT 1), 2, 2, 'AC'),
 ((SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R1' ORDER BY `eCodRuta` ASC LIMIT 1), 3, 3, 'AC'),
 ((SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R1' ORDER BY `eCodRuta` ASC LIMIT 1), 4, 4, 'AC'),
 ((SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R1' ORDER BY `eCodRuta` ASC LIMIT 1), 5, 5, 'AC');

-- Forma/Polyline de la Ruta 1 (JSON de puntos)
INSERT INTO `cat_formasruta` (`eCodRuta`,`tPolyline`,`tCodEstatus`)
VALUES ((SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R1' ORDER BY `eCodRuta` ASC LIMIT 1), '{"points":[[19.7040,-103.4610],[19.7052,-103.4605],[19.7064,-103.4598],[19.7076,-103.4592],[19.7088,-103.4586]]}', 'AC');

-- Servicios
INSERT INTO `pro_servicios` (`tNombre`,`bLunes`,`bMartes`,`bMiercoles`,`bJueves`,`bViernes`,`bSabado`,`bDomingo`,`fhFechaInicio`,`fhFechaFinal`,`tCodEstatus`)
VALUES
 ('Lunes a Viernes', 1,1,1,1,1,0,0, '2025-01-01', '2025-12-31', 'AC'),
 ('Sábado',           0,0,0,0,0,1,0, '2025-01-01', '2025-12-31', 'AC');

-- Viajes (trips) usando Ruta 1
INSERT INTO `pro_viajes` (`eCodRuta`,`eCodServicio`,`tNombre`,`tSentido`,`tCodEstatus`)
VALUES
 ((SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R1' ORDER BY `eCodRuta` ASC LIMIT 1), 1, 'Mañana','N','AC'),
 ((SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R1' ORDER BY `eCodRuta` ASC LIMIT 1), 1, 'Mediodía','S','AC');

-- Stop times para el viaje 1 (08:00 cada 5 min)
INSERT INTO `pro_tiemposparada` (`eCodViaje`,`eCodParada`,`fhHoraLlegada`,`fhHoraSalida`,`eOrden`,`tCodEstatus`) VALUES
 (1, 1, '08:00:00','08:00:00',1,'AC'),
 (1, 2, '08:05:00','08:05:00',2,'AC'),
 (1, 3, '08:10:00','08:10:00',3,'AC'),
 (1, 4, '08:15:00','08:15:00',4,'AC'),
 (1, 5, '08:20:00','08:20:00',5,'AC');

-- Stop times para el viaje 2 (12:00 cada 5 min)
INSERT INTO `pro_tiemposparada` (`eCodViaje`,`eCodParada`,`fhHoraLlegada`,`fhHoraSalida`,`eOrden`,`tCodEstatus`) VALUES
 (2, 5, '12:00:00','12:00:00',1,'AC'),
 (2, 4, '12:05:00','12:05:00',2,'AC'),
 (2, 3, '12:10:00','12:10:00',3,'AC'),
 (2, 2, '12:15:00','12:15:00',4,'AC'),
 (2, 1, '12:20:00','12:20:00',5,'AC');

-- Módulo y secciones de Configuración
INSERT INTO `cat_modulos` (`tCodModulo`,`tNombre`,`tNombreCorto`,`tIcono`,`tControlador`,`ePosicion`)
VALUES ('m1','Configuración del sistema','Configuración','fa-cogs','Configuracion',1)
ON DUPLICATE KEY UPDATE `tNombre`=VALUES(`tNombre`),`tNombreCorto`=VALUES(`tNombreCorto`),`tIcono`=VALUES(`tIcono`),`tControlador`=VALUES(`tControlador`),`ePosicion`=VALUES(`ePosicion`);

INSERT INTO `cat_secciones` (`eCodModulo`,`tCodSeccion`,`tNombre`,`tNombreCorto`,`tIcono`,`ePosicion`)
VALUES
 ((SELECT `eCodModulo` FROM `cat_modulos` WHERE `tCodModulo`='m1' ORDER BY `eCodModulo` ASC LIMIT 1),'m1_s1','Log de eventos','Eventos','fa-list',1),
 ((SELECT `eCodModulo` FROM `cat_modulos` WHERE `tCodModulo`='m1' ORDER BY `eCodModulo` ASC LIMIT 1),'m1_s2','Preferencias del sistema','Preferencias','fa-sliders-h',2)
ON DUPLICATE KEY UPDATE `tNombre`=VALUES(`tNombre`),`tNombreCorto`=VALUES(`tNombreCorto`),`tIcono`=VALUES(`tIcono`),`ePosicion`=VALUES(`ePosicion`);

-- Permisos de Configuración (Acceso)
INSERT INTO `cat_permisos` (`eCodSeccion`,`tNombre`,`tNombreCorto`,`tIcono`,`ePosicion`)
SELECT `eCodSeccion`, 'Acceso', 'Acceso', 'fa-check', 1 FROM `cat_secciones` WHERE `tCodSeccion` IN ('m1_s1','m1_s2')
ON DUPLICATE KEY UPDATE `tNombre`=VALUES(`tNombre`),`tNombreCorto`=VALUES(`tNombreCorto`),`tIcono`=VALUES(`tIcono`),`ePosicion`=VALUES(`ePosicion`);

-- Asignar permisos de Configuración al Administrador
INSERT INTO `rel_perfilespermisos` (`eCodPerfil`,`eCodPermiso`)
SELECT (SELECT `eCodPerfil` FROM `cat_perfiles` WHERE `tNombre`='Administrador' ORDER BY `eCodPerfil` ASC LIMIT 1), `eCodPermiso`
FROM `cat_permisos` WHERE `eCodPermiso` IN (
  SELECT cp.`eCodPermiso` FROM `cat_permisos` cp
  INNER JOIN `cat_secciones` cs ON cs.`eCodSeccion`=cp.`eCodSeccion`
  INNER JOIN `cat_modulos` cm ON cm.`eCodModulo`=cs.`eCodModulo`
  WHERE cm.`tCodModulo`='m1'
)
ON DUPLICATE KEY UPDATE `eCodPerfil`=`eCodPerfil`;

-- Catálogo de eventos
INSERT INTO `cat_eventos` (`eCodEvento`,`tNombre`,`tDescripcion`,`tCodEstatus`) VALUES
 (1,'Acceso al sistema','Un usuario accedió al sistema','AC'),
 (2,'Alta de ruta','Creación/actualización de una ruta','AC'),
 (3,'Alta de parada','Creación/actualización de una parada','AC'),
 (4,'Alta de servicio','Creación/actualización de un calendario de servicio','AC'),
 (5,'Alta de viaje','Creación/actualización de un viaje','AC'),
 (8,'Login simple (admin)','Acceso rápido con admin/admin','AC')
ON DUPLICATE KEY UPDATE `tNombre`=VALUES(`tNombre`),`tDescripcion`=VALUES(`tDescripcion`),`tCodEstatus`=VALUES(`tCodEstatus`);

-- Datos de transporte adicionales
-- Rutas extra
INSERT INTO `cat_rutas` (`tNombre`,`tCodigo`,`tColor`,`tSentido`,`tCodEstatus`) VALUES
 ('Ruta 2','R2','#ef6a00','N','AC'),
 ('Ruta 3','R3','#2ca02c','S','AC')
ON DUPLICATE KEY UPDATE `tNombre`=VALUES(`tNombre`), `tColor`=VALUES(`tColor`), `tSentido`=VALUES(`tSentido`);

-- Paradas para Ruta 2 (Aguascalientes centro)
INSERT INTO `cat_paradas` (`tNombre`,`tDireccion`,`tSentido`,`dLatitud`,`dLongitud`,`tCodEstatus`) VALUES
 ('Parada F','Centro Histórico','N',21.8820,-102.2826,'AC'),
 ('Parada G','Plaza Patria','N',21.8825,-102.2820,'AC'),
 ('Parada H','Hospital Hidalgo','N',21.8830,-102.2814,'AC'),
 ('Parada I','Parque Tres Centurias','N',21.8835,-102.2808,'AC'),
 ('Parada J','UTMA','N',21.8840,-102.2802,'AC')
ON DUPLICATE KEY UPDATE `tDireccion`=VALUES(`tDireccion`),`tSentido`=VALUES(`tSentido`),`dLatitud`=VALUES(`dLatitud`),`dLongitud`=VALUES(`dLongitud`);

-- Asignación a la Ruta 2 con orden
INSERT INTO `rel_rutasparadas` (`eCodRuta`,`eCodParada`,`eOrden`,`tCodEstatus`)
SELECT (SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R2' ORDER BY `eCodRuta` ASC LIMIT 1), p.`eCodParada`, x.`eOrden`, 'AC'
FROM (
  SELECT 'Parada F' AS `tNombre`, 1 AS `eOrden` UNION ALL
  SELECT 'Parada G', 2 UNION ALL
  SELECT 'Parada H', 3 UNION ALL
  SELECT 'Parada I', 4 UNION ALL
  SELECT 'Parada J', 5
) x
INNER JOIN `cat_paradas` p ON p.`tNombre`=x.`tNombre`
ON DUPLICATE KEY UPDATE `eOrden`=VALUES(`eOrden`);

-- Polyline de Ruta 2 (JSON)
INSERT INTO `cat_formasruta` (`eCodRuta`,`tPolyline`,`tCodEstatus`)
VALUES ((SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R2' ORDER BY `eCodRuta` ASC LIMIT 1), '{"points":[[21.8820,-102.2826],[21.8825,-102.2820],[21.8830,-102.2814],[21.8835,-102.2808],[21.8840,-102.2802]]}', 'AC')
ON DUPLICATE KEY UPDATE `tPolyline`=VALUES(`tPolyline`);

-- Servicio Domingo
INSERT INTO `pro_servicios` (`tNombre`,`bLunes`,`bMartes`,`bMiercoles`,`bJueves`,`bViernes`,`bSabado`,`bDomingo`,`fhFechaInicio`,`fhFechaFinal`,`tCodEstatus`)
VALUES ('Domingo', 0,0,0,0,0,0,1, '2025-01-01', '2025-12-31', 'AC')
ON DUPLICATE KEY UPDATE `fhFechaInicio`=VALUES(`fhFechaInicio`),`fhFechaFinal`=VALUES(`fhFechaFinal`);

-- Viajes para Ruta 2
INSERT INTO `pro_viajes` (`eCodRuta`,`eCodServicio`,`tNombre`,`tSentido`,`tCodEstatus`)
VALUES
 ((SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R2' ORDER BY `eCodRuta` ASC LIMIT 1), (SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1), 'Matutino','N','AC'),
 ((SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R2' ORDER BY `eCodRuta` ASC LIMIT 1), (SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Sábado' ORDER BY `eCodServicio` ASC LIMIT 1), 'Vespertino','S','AC')
ON DUPLICATE KEY UPDATE `tNombre`=`tNombre`;

-- Stop times de Ruta 2 (Matutino 07:00 cada ~5 min)
INSERT INTO `pro_tiemposparada` (`eCodViaje`,`eCodParada`,`fhHoraLlegada`,`fhHoraSalida`,`eOrden`,`tCodEstatus`) VALUES
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R2' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Matutino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada F' ORDER BY `eCodParada` ASC LIMIT 1), '07:00:00','07:00:00',1,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R2' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Matutino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada G' ORDER BY `eCodParada` ASC LIMIT 1), '07:05:00','07:05:00',2,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R2' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Matutino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada H' ORDER BY `eCodParada` ASC LIMIT 1), '07:10:00','07:10:00',3,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R2' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Matutino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada I' ORDER BY `eCodParada` ASC LIMIT 1), '07:15:00','07:15:00',4,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R2' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Matutino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada J' ORDER BY `eCodParada` ASC LIMIT 1), '07:20:00','07:20:00',5,'AC');

-- Stop times de Ruta 2 (Vespertino 18:00 cada ~5 min)
INSERT INTO `pro_tiemposparada` (`eCodViaje`,`eCodParada`,`fhHoraLlegada`,`fhHoraSalida`,`eOrden`,`tCodEstatus`) VALUES
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R2' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Sábado' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Vespertino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada J' ORDER BY `eCodParada` ASC LIMIT 1), '18:00:00','18:00:00',1,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R2' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Sábado' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Vespertino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada I' ORDER BY `eCodParada` ASC LIMIT 1), '18:05:00','18:05:00',2,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R2' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Sábado' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Vespertino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada H' ORDER BY `eCodParada` ASC LIMIT 1), '18:10:00','18:10:00',3,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R2' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Sábado' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Vespertino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada G' ORDER BY `eCodParada` ASC LIMIT 1), '18:15:00','18:15:00',4,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R2' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Sábado' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Vespertino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada F' ORDER BY `eCodParada` ASC LIMIT 1), '18:20:00','18:20:00',5,'AC');

-- -------------------------------
-- Ruta 3: Av. Convención (norte-sur) sobre calles
-- -------------------------------
-- Paradas para Ruta 3
INSERT INTO `cat_paradas` (`tNombre`,`tDireccion`,`tSentido`,`dLatitud`,`dLongitud`,`tCodEstatus`) VALUES
 ('Parada K','Av. Convención','S',21.8950,-102.2950,'AC'),
 ('Parada L','Av. Convención','S',21.8900,-102.2950,'AC'),
 ('Parada M','Av. Convención','S',21.8850,-102.2950,'AC'),
 ('Parada N','Av. Convención','S',21.8800,-102.2950,'AC'),
 ('Parada O','Av. Convención','S',21.8750,-102.2950,'AC'),
 ('Parada P','Av. Convención','S',21.8700,-102.2950,'AC');

-- Asignación a la Ruta 3 con orden
INSERT INTO `rel_rutasparadas` (`eCodRuta`,`eCodParada`,`eOrden`,`tCodEstatus`)
SELECT (SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R3' ORDER BY `eCodRuta` ASC LIMIT 1), p.`eCodParada`, x.`eOrden`, 'AC'
FROM (
  SELECT 'Parada K' AS `tNombre`, 1 AS `eOrden` UNION ALL
  SELECT 'Parada L', 2 UNION ALL
  SELECT 'Parada M', 3 UNION ALL
  SELECT 'Parada N', 4 UNION ALL
  SELECT 'Parada O', 5 UNION ALL
  SELECT 'Parada P', 6
) x
INNER JOIN `cat_paradas` p ON p.`tNombre`=x.`tNombre`
ON DUPLICATE KEY UPDATE `eOrden`=VALUES(`eOrden`);

-- Polyline de Ruta 3 (JSON) sobre Av. Convención
INSERT INTO `cat_formasruta` (`eCodRuta`,`tPolyline`,`tCodEstatus`)
VALUES ((SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R3' ORDER BY `eCodRuta` ASC LIMIT 1), '{"points":[[21.8950,-102.2950],[21.8900,-102.2950],[21.8850,-102.2950],[21.8800,-102.2950],[21.8750,-102.2950],[21.8700,-102.2950]]}', 'AC')
ON DUPLICATE KEY UPDATE `tPolyline`=VALUES(`tPolyline`);

-- Viajes para Ruta 3
INSERT INTO `pro_viajes` (`eCodRuta`,`eCodServicio`,`tNombre`,`tSentido`,`tCodEstatus`) VALUES
 ((SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R3' ORDER BY `eCodRuta` ASC LIMIT 1), (SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1), 'Matutino','S','AC'),
 ((SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R3' ORDER BY `eCodRuta` ASC LIMIT 1), (SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Sábado' ORDER BY `eCodServicio` ASC LIMIT 1), 'Vespertino','N','AC')
ON DUPLICATE KEY UPDATE `tNombre`=`tNombre`;

-- Stop times Ruta 3 (Matutino)
INSERT INTO `pro_tiemposparada` (`eCodViaje`,`eCodParada`,`fhHoraLlegada`,`fhHoraSalida`,`eOrden`,`tCodEstatus`) VALUES
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R3' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Matutino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada K' ORDER BY `eCodParada` ASC LIMIT 1), '07:00:00','07:00:00',1,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R3' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Matutino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada L' ORDER BY `eCodParada` ASC LIMIT 1), '07:06:00','07:06:00',2,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R3' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Matutino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada M' ORDER BY `eCodParada` ASC LIMIT 1), '07:12:00','07:12:00',3,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R3' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Matutino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada N' ORDER BY `eCodParada` ASC LIMIT 1), '07:18:00','07:18:00',4,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R3' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Matutino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada O' ORDER BY `eCodParada` ASC LIMIT 1), '07:24:00','07:24:00',5,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R3' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Matutino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada P' ORDER BY `eCodParada` ASC LIMIT 1), '07:30:00','07:30:00',6,'AC');

-- Stop times Ruta 3 (Vespertino, regreso)
INSERT INTO `pro_tiemposparada` (`eCodViaje`,`eCodParada`,`fhHoraLlegada`,`fhHoraSalida`,`eOrden`,`tCodEstatus`) VALUES
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R3' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Sábado' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Vespertino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada P' ORDER BY `eCodParada` ASC LIMIT 1), '18:00:00','18:00:00',1,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R3' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Sábado' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Vespertino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada O' ORDER BY `eCodParada` ASC LIMIT 1), '18:06:00','18:06:00',2,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R3' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Sábado' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Vespertino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada N' ORDER BY `eCodParada` ASC LIMIT 1), '18:12:00','18:12:00',3,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R3' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Sábado' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Vespertino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada M' ORDER BY `eCodParada` ASC LIMIT 1), '18:18:00','18:18:00',4,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R3' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Sábado' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Vespertino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada L' ORDER BY `eCodParada` ASC LIMIT 1), '18:24:00','18:24:00',5,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R3' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Sábado' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Vespertino' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada K' ORDER BY `eCodParada` ASC LIMIT 1), '18:30:00','18:30:00',6,'AC');

-- -------------------------------
-- Ruta 4: Av. López Mateos (este-oeste) sobre calles
-- -------------------------------
-- Definir Ruta 4
INSERT INTO `cat_rutas` (`tNombre`,`tCodigo`,`tColor`,`tSentido`,`tCodEstatus`) VALUES
 ('Ruta 4','R4','#d62728','N','AC')
ON DUPLICATE KEY UPDATE `tNombre`=VALUES(`tNombre`), `tColor`=VALUES(`tColor`), `tSentido`=VALUES(`tSentido`);

-- Paradas para Ruta 4
INSERT INTO `cat_paradas` (`tNombre`,`tDireccion`,`tSentido`,`dLatitud`,`dLongitud`,`tCodEstatus`) VALUES
 ('Parada Q','Av. López Mateos','N',21.8810,-102.3040,'AC'),
 ('Parada R','Av. López Mateos','N',21.8810,-102.3000,'AC'),
 ('Parada S','Av. López Mateos','N',21.8810,-102.2960,'AC'),
 ('Parada T','Av. López Mateos','N',21.8810,-102.2920,'AC'),
 ('Parada U','Av. López Mateos','N',21.8810,-102.2880,'AC'),
 ('Parada V','Av. López Mateos','N',21.8810,-102.2840,'AC');

-- Asignación a la Ruta 4 con orden
INSERT INTO `rel_rutasparadas` (`eCodRuta`,`eCodParada`,`eOrden`,`tCodEstatus`)
SELECT (SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R4' ORDER BY `eCodRuta` ASC LIMIT 1), p.`eCodParada`, x.`eOrden`, 'AC'
FROM (
  SELECT 'Parada Q' AS `tNombre`, 1 AS `eOrden` UNION ALL
  SELECT 'Parada R', 2 UNION ALL
  SELECT 'Parada S', 3 UNION ALL
  SELECT 'Parada T', 4 UNION ALL
  SELECT 'Parada U', 5 UNION ALL
  SELECT 'Parada V', 6
) x
INNER JOIN `cat_paradas` p ON p.`tNombre`=x.`tNombre`
ON DUPLICATE KEY UPDATE `eOrden`=VALUES(`eOrden`);

-- Polyline de Ruta 4 (JSON) sobre Av. López Mateos
INSERT INTO `cat_formasruta` (`eCodRuta`,`tPolyline`,`tCodEstatus`)
VALUES ((SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R4' ORDER BY `eCodRuta` ASC LIMIT 1), '{"points":[[21.8810,-102.3040],[21.8810,-102.3000],[21.8810,-102.2960],[21.8810,-102.2920],[21.8810,-102.2880],[21.8810,-102.2840]]}', 'AC')
ON DUPLICATE KEY UPDATE `tPolyline`=VALUES(`tPolyline`);

-- Viajes para Ruta 4
INSERT INTO `pro_viajes` (`eCodRuta`,`eCodServicio`,`tNombre`,`tSentido`,`tCodEstatus`) VALUES
 ((SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R4' ORDER BY `eCodRuta` ASC LIMIT 1), (SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1), 'Expreso','N','AC'),
 ((SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R4' ORDER BY `eCodRuta` ASC LIMIT 1), (SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Domingo' ORDER BY `eCodServicio` ASC LIMIT 1), 'Domingo tarde','S','AC')
ON DUPLICATE KEY UPDATE `tNombre`=`tNombre`;

-- Stop times Ruta 4 (Expreso)
INSERT INTO `pro_tiemposparada` (`eCodViaje`,`eCodParada`,`fhHoraLlegada`,`fhHoraSalida`,`eOrden`,`tCodEstatus`) VALUES
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R4' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Expreso' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada Q' ORDER BY `eCodParada` ASC LIMIT 1), '08:00:00','08:00:00',1,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R4' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Expreso' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada R' ORDER BY `eCodParada` ASC LIMIT 1), '08:05:00','08:05:00',2,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R4' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Expreso' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada S' ORDER BY `eCodParada` ASC LIMIT 1), '08:10:00','08:10:00',3,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R4' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Expreso' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada T' ORDER BY `eCodParada` ASC LIMIT 1), '08:15:00','08:15:00',4,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R4' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Expreso' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada U' ORDER BY `eCodParada` ASC LIMIT 1), '08:20:00','08:20:00',5,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R4' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Lunes a Viernes' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Expreso' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada V' ORDER BY `eCodParada` ASC LIMIT 1), '08:25:00','08:25:00',6,'AC');

-- Stop times Ruta 4 (Domingo tarde, regreso)
INSERT INTO `pro_tiemposparada` (`eCodViaje`,`eCodParada`,`fhHoraLlegada`,`fhHoraSalida`,`eOrden`,`tCodEstatus`) VALUES
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R4' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Domingo' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Domingo tarde' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada V' ORDER BY `eCodParada` ASC LIMIT 1), '17:00:00','17:00:00',1,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R4' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Domingo' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Domingo tarde' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada U' ORDER BY `eCodParada` ASC LIMIT 1), '17:05:00','17:05:00',2,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R4' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Domingo' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Domingo tarde' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada T' ORDER BY `eCodParada` ASC LIMIT 1), '17:10:00','17:10:00',3,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R4' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Domingo' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Domingo tarde' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada S' ORDER BY `eCodParada` ASC LIMIT 1), '17:15:00','17:15:00',4,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R4' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Domingo' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Domingo tarde' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada R' ORDER BY `eCodParada` ASC LIMIT 1), '17:20:00','17:20:00',5,'AC'),
 ((SELECT `eCodViaje` FROM `pro_viajes` WHERE `eCodRuta`=(SELECT `eCodRuta` FROM `cat_rutas` WHERE `tCodigo`='R4' ORDER BY `eCodRuta` ASC LIMIT 1) AND `eCodServicio`=(SELECT `eCodServicio` FROM `pro_servicios` WHERE `tNombre`='Domingo' ORDER BY `eCodServicio` ASC LIMIT 1) AND `tNombre`='Domingo tarde' ORDER BY `eCodViaje` ASC LIMIT 1), (SELECT `eCodParada` FROM `cat_paradas` WHERE `tNombre`='Parada Q' ORDER BY `eCodParada` ASC LIMIT 1), '17:25:00','17:25:00',6,'AC');