DROP DATABASE IF EXISTS `hauga`;

DROP TABLE IF EXISTS `hauga`.`usuario`;
DROP TABLE IF EXISTS `hauga`.`grupo_investigacion`;
DROP TABLE IF EXISTS `hauga`.`departamento`;
DROP TABLE IF EXISTS `hauga`.`edificio`;
DROP TABLE IF EXISTS `hauga`.`agrupacion_edificio`;
DROP TABLE IF EXISTS `hauga`.`centro`;
DROP TABLE IF EXISTS `hauga`.`espacio`;
DROP TABLE IF EXISTS `hauga`.`incidencia`;
DROP TABLE IF EXISTS `hauga`.`solicitud_responsabilidad`;


CREATE DATABASE `hauga`;


CREATE TABLE `hauga`.`usuario` (
	`usuario_id` int NOT NULL AUTO_INCREMENT,
	`login` VARCHAR(12) NOT NULL UNIQUE,
	`nombre` VARCHAR(15) NOT NULL,
	`apellidos` VARCHAR(25) NOT NULL,
	`password` VARCHAR(64) NOT NULL,
	`fecha_nacimiento` DATE NOT NULL,
	`email_usuario` VARCHAR(30) NOT NULL,
	`telef_usuario` int NOT NULL,
	`dni` VARCHAR(9) NOT NULL UNIQUE,
	`rol` enum('ADMIN', 'USUARIO_NORMAL') NOT NULL, 
	`afiliacion` enum('DOCENTE', 'INVESTIGADOR', 'ADMINISTRACION') NOT NULL,
	`nombre_puesto` VARCHAR(15) NOT NULL,
	`nivel_jerarquia` int NOT NULL,
	`depart_usuario` int NOT NULL,
	`grupo_usuario` int NOT NULL,
	`centro_usuario` int NOT NULL,
	PRIMARY KEY (`usuario_id`)
);


CREATE TABLE `hauga`.`grupo_investigacion` (
	`grupo_id` int NOT NULL AUTO_INCREMENT,
	`nombre_grupo` VARCHAR(20) NOT NULL,
	`telef_grupo` int NOT NULL,
	`lineas_investigacion` int NOT NULL,
	`area_conoc_grupo` VARCHAR(30) NOT NULL,
	`email_grupo` VARCHAR(30) NOT NULL,
	`responsable_grupo` int NOT NULL,
	PRIMARY KEY	(`grupo_id`)
 );


CREATE TABLE `hauga`.`departamento` (
	`depart_id` int NOT NULL AUTO_INCREMENT,
	`nombre_depart` VARCHAR(15) NOT NULL,
	`codigo_depart` VARCHAR(9) NOT NULL UNIQUE,
	`telef_depart` int NOT NULL,
	`email_depart` VARCHAR(30) NOT NULL,
	`area_conc_depart` VARCHAR(30) NOT NULL,
	`responsable_depart` int NOT NULL,
	`edificio_depart` int NOT NULL,
	PRIMARY KEY (`depart_id`)
);


CREATE TABLE `hauga`.`edificio` (
	`edificio_id` int NOT NULL AUTO_INCREMENT,
	`nombre_edif` VARCHAR(15) NOT NULL,
	`direccion_edif` VARCHAR(50) NOT NULL,
	`telef_edif` int NOT NULL,
	`num_plantas` int NOT NULL,
	`agrup_edificio` int NOT NULL,
	PRIMARY KEY (`edificio_id`)
);


CREATE TABLE `hauga`.`agrupacion_edificio` (
	`agrup_id` int NOT NULL AUTO_INCREMENT,
	`nombre_agrup` VARCHAR(15) NOT NULL,
	`ubicacion_agrup` VARCHAR(50) NOT NULL,
	PRIMARY KEY (`agrup_id`)
);


CREATE TABLE `hauga`.`centro` (
	`centro_id` int NOT NULL AUTO_INCREMENT,
	`nombre_centro` VARCHAR(15) NOT NULL,
	`edificio_centro` int NOT NULL,
	PRIMARY KEY	(`centro_id`)
);


CREATE TABLE `hauga`.`espacio` (
	`espacio_id` int NOT NULL AUTO_INCREMENT,
	`nombre_esp` VARCHAR(15) NOT NULL,
	`tarifa_esp` int NOT NULL,
	`categoria_esp` enum('DOCENCIA', 'INVESTIGACION', 'PAS', 'COMUN') NOT NULL,
	`planta_esp` int NOT NULL,
	`edificio_esp` int NOT NULL,
	PRIMARY	KEY (`espacio_id`)
);


CREATE TABLE `hauga`.`incidencia` (
	`incidencia_id` int NOT NULL AUTO_INCREMENT,
	`descripcion_incid` VARCHAR(500) NOT NULL,
	`estado_incid` enum('PEND', 'DENEG', 'ACEPT') NOT NULL,
	`espacio_afectado` int NOT NULL,
	`autor_incidencia` int NOT NULL,
	PRIMARY KEY	(`incidencia_id`)
);


CREATE TABLE `hauga`.`solicitud_responsabilidad` (
	`espacio_id` int NOT NULL,
	`usuario_id` int NOT NULL,
	`fecha` DATE NOT NULL,
	`estado_solic` enum('HISTOR', 'DEFIN', 'TEMP'),
	PRIMARY	KEY (`espacio_id`, `usuario_id`, `fecha`)
);


CREATE USER if not exists 'admin_hauga'@'localhost' IDENTIFIED WITH mysql_native_password BY 'admin_hauga';
GRANT ALL ON `hauga`.* TO 'admin_hauga'@'localhost';


INSERT INTO `hauga`.`usuario` 
(`usuario_id`, `login`, `nombre`, `apellidos`, `password`, `fecha_nacimiento`, `email_usuario`, `telef_usuario`, `dni`, `rol`, `afiliacion`, `nombre_puesto`, `nivel_jerarquia`, `depart_usuario`, `grupo_usuario`, `centro_usuario`)
VALUES (null, 'Zabo', 'Javier', 'Quintas Bergantiño', '1234', '1997-08-03', 'jqbergantinho@gmail.com', '637334410', '11111111A', 'USUARIO_NORMAL', 'ADMINISTRACION', 'puesto', 1, 1, 1, 1);

INSERT INTO `hauga`.`grupo_investigacion`
(`grupo_id`, `nombre_grupo`, `telef_grupo`, `lineas_investigacion`, `area_conoc_grupo`, `email_grupo`, `responsable_grupo`)
VALUES (null, 'LIA2', '111111111', 2, 'Realidad virtual', 'lia2@gmail.com', 1);

INSERT INTO `hauga`.`departamento`
(`depart_id`, `nombre_depart`, `codigo_depart`, `telef_depart`, `email_depart`, `area_conc_depart`, `responsable_depart`, `edificio_depart`)
VALUES (null, 'departamento 1', 'dept1', '222222222', 'dept1@gmail.com', 'conocimiento 2', 1, 1);

INSERT INTO `hauga`.`edificio`
(`edificio_id`, `nombre_edif`, `direccion_edif`, `telef_edif`, `num_plantas`, `agrup_edificio`)
VALUES (null, 'edificio1', 'direccion1', '333333333', 3, 1);

INSERT INTO `hauga`.`agrupacion_edificio`
(`agrup_id`, `nombre_agrup`, `ubicacion_agrup`)
VALUES (null, 'agrupacion1', 'ubicacion1');

INSERT INTO `hauga`.`centro`
(`centro_id`, `nombre_centro`, `edificio_centro`)
VALUES (null, 'centro1', 1);

INSERT INTO `hauga`.`espacio`
(`espacio_id`, `nombre_esp`, `tarifa_esp`, `categoria_esp`, `planta_esp`, `edificio_esp`)
VALUES (null, 'espacio1', 300, 'DOCENCIA', 2, 1);

INSERT INTO `hauga`.`incidencia`
(`incidencia_id`, `descripcion_incid`, `estado_incid`, `espacio_afectado`, `autor_incidencia`)
VALUES (null, 'incidencia con el proyector', 'ACEPT', 1, 1);

INSERT INTO `hauga`.`solicitud_responsabilidad`
(`espacio_id`, `usuario_id`, `fecha`, `estado_solic`)
VALUES (1, 1, '2020-11-29', 'TEMP');


ALTER TABLE `hauga`.`usuario` ADD FOREIGN KEY (`depart_usuario`) REFERENCES `hauga`.`departamento`(`depart_id`);
ALTER TABLE `hauga`.`usuario` ADD FOREIGN KEY (`grupo_usuario`) REFERENCES `hauga`.`grupo_investigacion`(`grupo_id`);
ALTER TABLE `hauga`.`usuario` ADD FOREIGN KEY (`centro_usuario`) REFERENCES `hauga`.`centro`(`centro_id`);

ALTER TABLE `hauga`.`grupo_investigacion` ADD FOREIGN KEY (`responsable_grupo`) REFERENCES `hauga`.`usuario`(`usuario_id`);

ALTER TABLE `hauga`.`departamento` ADD FOREIGN KEY (`responsable_depart`) REFERENCES `hauga`.`usuario`(`usuario_id`);
ALTER TABLE `hauga`.`departamento` ADD FOREIGN KEY	(`edificio_depart`) REFERENCES `hauga`.`edificio`(`edificio_id`);

ALTER TABLE `hauga`.`edificio` ADD FOREIGN KEY	(`agrup_edificio`) REFERENCES `hauga`.`agrupacion_edificio`(`agrup_id`);

ALTER TABLE `hauga`.`centro` ADD FOREIGN KEY (`edificio_centro`) REFERENCES `hauga`.`edificio`(`edificio_id`);

ALTER TABLE `hauga`.`espacio` ADD FOREIGN KEY	(`edificio_esp`) REFERENCES `hauga`.`edificio`(`edificio_id`);

ALTER TABLE `hauga`.`incidencia` ADD FOREIGN KEY (`espacio_afectado`) REFERENCES `hauga`.`espacio`(`espacio_id`);
ALTER TABLE `hauga`.`incidencia` ADD FOREIGN KEY (`autor_incidencia`) REFERENCES `hauga`.`usuario`(`usuario_id`);

ALTER TABLE `hauga`.`solicitud_responsabilidad` ADD FOREIGN KEY	(`espacio_id`) REFERENCES `hauga`.`espacio`(`espacio_id`);
ALTER TABLE `hauga`.`solicitud_responsabilidad` ADD FOREIGN KEY (`usuario_id`) REFERENCES `hauga`.`usuario`(`usuario_id`);
