-- Bootstrap de esquema mínimo para MiRuta (Transporte)
SET NAMES utf8mb4;

-- Tabla de estatus
CREATE TABLE IF NOT EXISTS `cat_estatus` (
  `tCodEstatus` CHAR(2) PRIMARY KEY,
  `tNombre` VARCHAR(50) NOT NULL,
  `tClase` VARCHAR(30) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Perfiles (para permisos del menú)
CREATE TABLE IF NOT EXISTS `cat_perfiles` (
  `eCodPerfil` INT NOT NULL AUTO_INCREMENT,
  `tNombre` VARCHAR(100) NOT NULL,
  `tCodEstatus` CHAR(2) NOT NULL DEFAULT 'AC',
  PRIMARY KEY (`eCodPerfil`),
  CONSTRAINT `fk_perfiles_estatus` FOREIGN KEY (`tCodEstatus`) REFERENCES `cat_estatus` (`tCodEstatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Módulos y secciones del panel (para menú de administración)
CREATE TABLE IF NOT EXISTS `cat_modulos` (
  `eCodModulo` INT NOT NULL AUTO_INCREMENT,
  `tCodModulo` VARCHAR(50) UNIQUE,
  `tNombre` VARCHAR(100),
  `tNombreCorto` VARCHAR(50),
  `tIcono` VARCHAR(50),
  `tControlador` VARCHAR(50),
  `ePosicion` INT,
  PRIMARY KEY (`eCodModulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `cat_secciones` (
  `eCodSeccion` INT NOT NULL AUTO_INCREMENT,
  `eCodModulo` INT,
  `tCodSeccion` VARCHAR(50) UNIQUE,
  `tNombre` VARCHAR(100),
  `tNombreCorto` VARCHAR(50),
  `tIcono` VARCHAR(50),
  `ePosicion` INT,
  PRIMARY KEY (`eCodSeccion`),
  INDEX `idx_secciones_modulo` (`eCodModulo`),
  CONSTRAINT `fk_secciones_modulo` FOREIGN KEY (`eCodModulo`) REFERENCES `cat_modulos` (`eCodModulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `cat_permisos` (
  `eCodPermiso` INT NOT NULL AUTO_INCREMENT,
  `eCodSeccion` INT,
  `tNombre` VARCHAR(100),
  `tNombreCorto` VARCHAR(50),
  `tIcono` VARCHAR(50),
  `ePosicion` INT,
  PRIMARY KEY (`eCodPermiso`),
  INDEX `idx_permisos_seccion` (`eCodSeccion`),
  CONSTRAINT `fk_permisos_seccion` FOREIGN KEY (`eCodSeccion`) REFERENCES `cat_secciones` (`eCodSeccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `rel_perfilespermisos` (
  `eCodPerfilPermiso` INT NOT NULL AUTO_INCREMENT,
  `eCodPerfil` INT,
  `eCodPermiso` INT,
  PRIMARY KEY (`eCodPerfilPermiso`),
  INDEX `idx_rel_perfil` (`eCodPerfil`),
  INDEX `idx_rel_permiso` (`eCodPermiso`),
  CONSTRAINT `fk_rel_perfil` FOREIGN KEY (`eCodPerfil`) REFERENCES `cat_perfiles` (`eCodPerfil`),
  CONSTRAINT `fk_rel_permiso` FOREIGN KEY (`eCodPermiso`) REFERENCES `cat_permisos` (`eCodPermiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Transporte: rutas
CREATE TABLE IF NOT EXISTS `cat_rutas` (
  `eCodRuta` INT NOT NULL AUTO_INCREMENT,
  `tNombre` VARCHAR(100) NOT NULL,
  `tCodigo` VARCHAR(20) NULL,
  `tColor` VARCHAR(7) NULL,
  `tSentido` VARCHAR(2) NULL,
  `tCodEstatus` CHAR(2) NOT NULL DEFAULT 'AC',
  `fhFechaRegistro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fhFechaActualizacion` DATETIME NULL,
  PRIMARY KEY (`eCodRuta`),
  INDEX `idx_rutas_estatus` (`tCodEstatus`),
  CONSTRAINT `fk_rutas_estatus` FOREIGN KEY (`tCodEstatus`) REFERENCES `cat_estatus` (`tCodEstatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Transporte: paradas
CREATE TABLE IF NOT EXISTS `cat_paradas` (
  `eCodParada` INT NOT NULL AUTO_INCREMENT,
  `tNombre` VARCHAR(100) NOT NULL,
  `tDireccion` VARCHAR(150) NULL,
  `tSentido` VARCHAR(2) NULL,
  `dLatitud` DECIMAL(10,7) NOT NULL,
  `dLongitud` DECIMAL(10,7) NOT NULL,
  `tCodEstatus` CHAR(2) NOT NULL DEFAULT 'AC',
  `fhFechaRegistro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fhFechaActualizacion` DATETIME NULL,
  PRIMARY KEY (`eCodParada`),
  INDEX `idx_paradas_estatus` (`tCodEstatus`),
  INDEX `idx_paradas_geo` (`dLatitud`, `dLongitud`),
  CONSTRAINT `fk_paradas_estatus` FOREIGN KEY (`tCodEstatus`) REFERENCES `cat_estatus` (`tCodEstatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Relación ruta-parada con orden
CREATE TABLE IF NOT EXISTS `rel_rutasparadas` (
  `eCodRutaParada` INT NOT NULL AUTO_INCREMENT,
  `eCodRuta` INT NOT NULL,
  `eCodParada` INT NOT NULL,
  `eOrden` INT NOT NULL DEFAULT 1,
  `tCodEstatus` CHAR(2) NOT NULL DEFAULT 'AC',
  PRIMARY KEY (`eCodRutaParada`),
  INDEX `idx_rel_ruta` (`eCodRuta`),
  INDEX `idx_rel_parada` (`eCodParada`),
  CONSTRAINT `fk_rel_ruta` FOREIGN KEY (`eCodRuta`) REFERENCES `cat_rutas` (`eCodRuta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_rel_parada` FOREIGN KEY (`eCodParada`) REFERENCES `cat_paradas` (`eCodParada`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Forma de rutas (polylines/JSON)
CREATE TABLE IF NOT EXISTS `cat_formasruta` (
  `eCodFormaRuta` INT NOT NULL AUTO_INCREMENT,
  `eCodRuta` INT NOT NULL,
  `tPolyline` TEXT NULL,
  `tCodEstatus` CHAR(2) NOT NULL DEFAULT 'AC',
  PRIMARY KEY (`eCodFormaRuta`),
  INDEX `idx_forma_ruta` (`eCodRuta`),
  CONSTRAINT `fk_forma_ruta` FOREIGN KEY (`eCodRuta`) REFERENCES `cat_rutas` (`eCodRuta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_forma_estatus` FOREIGN KEY (`tCodEstatus`) REFERENCES `cat_estatus` (`tCodEstatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Servicios (calendarios)
CREATE TABLE IF NOT EXISTS `pro_servicios` (
  `eCodServicio` INT NOT NULL AUTO_INCREMENT,
  `tNombre` VARCHAR(100) NOT NULL,
  `bLunes` TINYINT(1) NOT NULL DEFAULT 1,
  `bMartes` TINYINT(1) NOT NULL DEFAULT 1,
  `bMiercoles` TINYINT(1) NOT NULL DEFAULT 1,
  `bJueves` TINYINT(1) NOT NULL DEFAULT 1,
  `bViernes` TINYINT(1) NOT NULL DEFAULT 1,
  `bSabado` TINYINT(1) NOT NULL DEFAULT 0,
  `bDomingo` TINYINT(1) NOT NULL DEFAULT 0,
  `fhFechaInicio` DATE NOT NULL,
  `fhFechaFinal` DATE NOT NULL,
  `tCodEstatus` CHAR(2) NOT NULL DEFAULT 'AC',
  PRIMARY KEY (`eCodServicio`),
  CONSTRAINT `fk_servicios_estatus` FOREIGN KEY (`tCodEstatus`) REFERENCES `cat_estatus` (`tCodEstatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Viajes (trips)
CREATE TABLE IF NOT EXISTS `pro_viajes` (
  `eCodViaje` INT NOT NULL AUTO_INCREMENT,
  `eCodRuta` INT NOT NULL,
  `eCodServicio` INT NOT NULL,
  `tNombre` VARCHAR(100) NULL,
  `tSentido` VARCHAR(2) NULL,
  `tCodEstatus` CHAR(2) NOT NULL DEFAULT 'AC',
  PRIMARY KEY (`eCodViaje`),
  INDEX `idx_viaje_ruta` (`eCodRuta`),
  INDEX `idx_viaje_servicio` (`eCodServicio`),
  CONSTRAINT `fk_viaje_ruta` FOREIGN KEY (`eCodRuta`) REFERENCES `cat_rutas` (`eCodRuta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_viaje_servicio` FOREIGN KEY (`eCodServicio`) REFERENCES `pro_servicios` (`eCodServicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_viaje_estatus` FOREIGN KEY (`tCodEstatus`) REFERENCES `cat_estatus` (`tCodEstatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tiempos por parada (stop_times)
CREATE TABLE IF NOT EXISTS `pro_tiemposparada` (
  `eCodTiempoParada` INT NOT NULL AUTO_INCREMENT,
  `eCodViaje` INT NOT NULL,
  `eCodParada` INT NOT NULL,
  `fhHoraLlegada` TIME NOT NULL,
  `fhHoraSalida` TIME NOT NULL,
  `eOrden` INT NOT NULL,
  `tCodEstatus` CHAR(2) NOT NULL DEFAULT 'AC',
  PRIMARY KEY (`eCodTiempoParada`),
  INDEX `idx_tp_viaje` (`eCodViaje`),
  INDEX `idx_tp_parada` (`eCodParada`),
  CONSTRAINT `fk_tp_viaje` FOREIGN KEY (`eCodViaje`) REFERENCES `pro_viajes` (`eCodViaje`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tp_parada` FOREIGN KEY (`eCodParada`) REFERENCES `cat_paradas` (`eCodParada`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tp_estatus` FOREIGN KEY (`tCodEstatus`) REFERENCES `cat_estatus` (`tCodEstatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Catálogo de eventos del sistema (módulo Configuración)
CREATE TABLE IF NOT EXISTS `cat_eventos` (
  `eCodEvento` INT NOT NULL AUTO_INCREMENT,
  `tNombre` VARCHAR(150) NOT NULL,
  `tDescripcion` TEXT NULL,
  `tCodEstatus` CHAR(2) NOT NULL DEFAULT 'AC',
  PRIMARY KEY (`eCodEvento`),
  CONSTRAINT `fk_eventos_estatus` FOREIGN KEY (`tCodEstatus`) REFERENCES `cat_estatus` (`tCodEstatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
