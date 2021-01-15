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
	`nombre_puesto` VARCHAR(60),
	`nivel_jerarquia` int,
	`depart_usuario` int,
	`grupo_usuario` int,
	`centro_usuario` int,
	PRIMARY KEY (`usuario_id`)
);


CREATE TABLE `hauga`.`grupo_investigacion` (
	`grupo_id` int NOT NULL AUTO_INCREMENT,
	`nombre_grupo` VARCHAR(70) NOT NULL,
	`telef_grupo` int NOT NULL,
	`lineas_investigacion` VARCHAR(200) NOT NULL,
	`area_conoc_grupo` VARCHAR(30) NOT NULL,
	`email_grupo` VARCHAR(30) NOT NULL,
	`responsable_grupo` int,
	PRIMARY KEY	(`grupo_id`)
 );


CREATE TABLE `hauga`.`departamento` (
	`depart_id` int NOT NULL AUTO_INCREMENT,
	`nombre_depart` VARCHAR(70) NOT NULL,
	`codigo_depart` VARCHAR(9) NOT NULL UNIQUE,
	`telef_depart` int NOT NULL,
	`email_depart` VARCHAR(30) NOT NULL,
	`area_conc_depart` VARCHAR(30) NOT NULL,
	`responsable_depart` int,
	`edificio_depart` int NOT NULL,
	PRIMARY KEY (`depart_id`)
);


CREATE TABLE `hauga`.`edificio` (
	`edificio_id` int NOT NULL AUTO_INCREMENT,
	`nombre_edif` VARCHAR(70) NOT NULL,
	`direccion_edif` VARCHAR(50) NOT NULL,
	`telef_edif` int NOT NULL,
	`num_plantas` int NOT NULL,
	`agrup_edificio` int,
	PRIMARY KEY (`edificio_id`)
);


CREATE TABLE `hauga`.`agrupacion_edificio` (
	`agrup_id` int NOT NULL AUTO_INCREMENT,
	`nombre_agrup` VARCHAR(50) NOT NULL,
	`ubicacion_agrup` VARCHAR(100) NOT NULL,
	PRIMARY KEY (`agrup_id`)
);


CREATE TABLE `hauga`.`centro` (
	`centro_id` int NOT NULL AUTO_INCREMENT,
	`nombre_centro` VARCHAR(70) NOT NULL,
	`edificio_centro` int NOT NULL,
	PRIMARY KEY	(`centro_id`)
);


CREATE TABLE `hauga`.`espacio` (
	`espacio_id` int NOT NULL AUTO_INCREMENT,
	`nombre_esp` VARCHAR(50) NOT NULL,
	`ruta_imagen` VARCHAR(50) NOT NULL,
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
	`autor_incidencia` int,
	PRIMARY KEY	(`incidencia_id`)
);


CREATE TABLE `hauga`.`solicitud_responsabilidad` (
    `solicitud_id` int NOT NULL AUTO_INCREMENT,
	`espacio_id` int NOT NULL,
	`usuario_id` int NOT NULL,
	`fecha_inicio` DATE NOT NULL,
	`fecha_fin` DATE,
	`estado_solic` enum('HISTOR', 'DEFIN', 'TEMP'),
	`tarifa_historica` int,
	PRIMARY	KEY (`solicitud_id`)
);


CREATE USER if not exists 'admin_hauga'@'localhost' IDENTIFIED BY 'admin_hauga';
GRANT ALL ON `hauga`.* TO 'admin_hauga'@'localhost';


INSERT INTO `hauga`.`usuario`
(`usuario_id`, `login`, `nombre`, `apellidos`, `password`, `fecha_nacimiento`, `email_usuario`, `telef_usuario`, `dni`, `rol`, `afiliacion`, `nombre_puesto`, `nivel_jerarquia`, `depart_usuario`, `grupo_usuario`, `centro_usuario`)
VALUES (null, 'rymartinez', 'Rubén', 'Yañez Martinez', '1234', '1998-07-27', 'rymartinez@gmail.com', '666100666', '22222222A', 'ADMIN', 'ADMINISTRACION', 'Jefe de asuntos económicos', 1, null, null, null);

INSERT INTO `hauga`.`usuario`
(`usuario_id`, `login`, `nombre`, `apellidos`, `password`, `fecha_nacimiento`, `email_usuario`, `telef_usuario`, `dni`, `rol`, `afiliacion`, `nombre_puesto`, `nivel_jerarquia`, `depart_usuario`, `grupo_usuario`, `centro_usuario`)
VALUES (null, 'jqbergantino', 'Javier', 'Quintas Bergantiño', '1234', '1997-08-03', 'jqbergantinho@gmail.com', '637334410', '11111111A', 'USUARIO_NORMAL', 'ADMINISTRACION', 'Director de recursos humanos', 1, null, null, null);

INSERT INTO `hauga`.`usuario`
(`usuario_id`, `login`, `nombre`, `apellidos`, `password`, `fecha_nacimiento`, `email_usuario`, `telef_usuario`, `dni`, `rol`, `afiliacion`, `nombre_puesto`, `nivel_jerarquia`, `depart_usuario`, `grupo_usuario`, `centro_usuario`)
VALUES (null, 'ipgonzalez', 'Inés', 'Prieto González', '1234', '1997-08-03', 'ipgonzalez@gmail.com', '658694410', '55555555A', 'USUARIO_NORMAL', 'ADMINISTRACION', 'Directora de imagen', 3, null, null, null);

INSERT INTO `hauga`.`usuario`
(`usuario_id`, `login`, `nombre`, `apellidos`, `password`, `fecha_nacimiento`, `email_usuario`, `telef_usuario`, `dni`, `rol`, `afiliacion`, `nombre_puesto`, `nivel_jerarquia`, `depart_usuario`, `grupo_usuario`, `centro_usuario`)
VALUES (null, 'rcferradas', 'Rodrigo', 'Currás Ferradás', '1234', '1997-08-03', 'rcferradas@gmail.com', '637895210', '66666666A', 'USUARIO_NORMAL', 'ADMINISTRACION', 'Secretario de posgrado', 4, null, null, null);

INSERT INTO `hauga`.`usuario`
(`usuario_id`, `login`, `nombre`, `apellidos`, `password`, `fecha_nacimiento`, `email_usuario`, `telef_usuario`, `dni`, `rol`, `afiliacion`, `nombre_puesto`, `nivel_jerarquia`, `depart_usuario`, `grupo_usuario`, `centro_usuario`)
VALUES (null, 'mvaugusto', 'Manuel', 'Vazquez Augusto', '1234', '1998-12-31', 'mvaugusto@gmail.com', '777807117', '33333333A', 'USUARIO_NORMAL', 'DOCENTE', null, null, 1, null, 1);

INSERT INTO `hauga`.`usuario`
(`usuario_id`, `login`, `nombre`, `apellidos`, `password`, `fecha_nacimiento`, `email_usuario`, `telef_usuario`, `dni`, `rol`, `afiliacion`, `nombre_puesto`, `nivel_jerarquia`, `depart_usuario`, `grupo_usuario`, `centro_usuario`)
VALUES (null, 'nghervella', 'Noelia', 'García Hervella', '1234', '1998-12-31', 'nghervella@gmail.com', '875905218', '44444444A', 'USUARIO_NORMAL', 'INVESTIGADOR', null, null, null, 1, null);

INSERT INTO `hauga`.`grupo_investigacion`
(`grupo_id`, `nombre_grupo`, `telef_grupo`, `lineas_investigacion`, `area_conoc_grupo`, `email_grupo`, `responsable_grupo`)
VALUES (null, 'LIA2', '111111111', 2, 'Realidad virtual', 'lia2@gmail.com', 6);

INSERT INTO `hauga`.`departamento`
(`depart_id`, `nombre_depart`, `codigo_depart`, `telef_depart`, `email_depart`, `area_conc_depart`, `responsable_depart`, `edificio_depart`)
VALUES (null, 'Departamento de Informática', 'deptinfo', '222222222', 'informatica@gmail.com', 'sistemas informaticos', 5, 1);

INSERT INTO `hauga`.`edificio`
(`edificio_id`, `nombre_edif`, `direccion_edif`, `telef_edif`, `num_plantas`, `agrup_edificio`)
VALUES (null, 'Politécnico', 'direccion1', '333333333', 3, 1);

INSERT INTO `hauga`.`edificio`
(`edificio_id`, `nombre_edif`, `direccion_edif`, `telef_edif`, `num_plantas`, `agrup_edificio`)
VALUES (null, 'Ciencias', 'direccion2', '333333334', 4, 1);

INSERT INTO `hauga`.`edificio`
(`edificio_id`, `nombre_edif`, `direccion_edif`, `telef_edif`, `num_plantas`, `agrup_edificio`)
VALUES (null, 'Facultades', 'direccion3', '333333335', 4, 1);

INSERT INTO `hauga`.`agrupacion_edificio`
(`agrup_id`, `nombre_agrup`, `ubicacion_agrup`)
VALUES (null, 'Campus de Ourense', 'Edificio Facultades Campus As Lagoas Ourense');

INSERT INTO `hauga`.`agrupacion_edificio`
(`agrup_id`, `nombre_agrup`, `ubicacion_agrup`)
VALUES (null, 'Campus de Vigo', 'Circunvalación ao Campus Universitario Vigo Pontevedra');

INSERT INTO `hauga`.`agrupacion_edificio`
(`agrup_id`, `nombre_agrup`, `ubicacion_agrup`)
VALUES (null, 'Campus de Pontevedra', 'Campus Universitario A Xunqueira Calle Don Filiberto Pontevedra');

INSERT INTO `hauga`.`centro`
(`centro_id`, `nombre_centro`, `edificio_centro`)
VALUES (null, 'ESEI', 1);

INSERT INTO `hauga`.`espacio`
(`espacio_id`, `nombre_esp`, `ruta_imagen`, `tarifa_esp`, `categoria_esp`, `planta_esp`, `edificio_esp`)
VALUES (null, 'Aula 2.1','../Models/Imagenes_Espacios/Aula_2_1.PNG', 300, 'DOCENCIA', 2, 1);

INSERT INTO `hauga`.`espacio`
(`espacio_id`, `nombre_esp`, `ruta_imagen`, `tarifa_esp`, `categoria_esp`, `planta_esp`, `edificio_esp`)
VALUES (null, 'Aula 2.2','../Models/Imagenes_Espacios/Aula_2_2.PNG', 400, 'DOCENCIA', 2, 1);

INSERT INTO `hauga`.`espacio`
(`espacio_id`, `nombre_esp`, `ruta_imagen`, `tarifa_esp`, `categoria_esp`, `planta_esp`, `edificio_esp`)
VALUES (null, 'Aula Libre Acceso','../Models/Imagenes_Espacios/Aula_Libre_Acceso.PNG', 600, 'DOCENCIA', -1, 2);

INSERT INTO `hauga`.`espacio`
(`espacio_id`, `nombre_esp`, `ruta_imagen`, `tarifa_esp`, `categoria_esp`, `planta_esp`, `edificio_esp`)
VALUES (null, 'Aula SO5','../Models/Imagenes_Espacios/Aula_Sotano_5.PNG', 210, 'DOCENCIA', -1, 2);

INSERT INTO `hauga`.`espacio`
(`espacio_id`, `nombre_esp`, `ruta_imagen`, `tarifa_esp`, `categoria_esp`, `planta_esp`, `edificio_esp`)
VALUES (null, 'Laboratorio L39','../Models/Imagenes_Espacios/Aula_2_1.PNG', 800, 'INVESTIGACION', 2, 3);

INSERT INTO `hauga`.`incidencia`
(`incidencia_id`, `descripcion_incid`, `estado_incid`, `espacio_afectado`, `autor_incidencia`)
VALUES (null, 'incidencia con el proyector', 'ACEPT', 1, 1);

INSERT INTO `hauga`.`solicitud_responsabilidad`
(`solicitud_id`, `espacio_id`, `usuario_id`, `fecha_inicio`, `fecha_fin`, `estado_solic`, `tarifa_historica`)
VALUES (null, 1, 5, '2020-11-29', null, 'DEFIN', 100);

INSERT INTO `hauga`.`solicitud_responsabilidad`
(`solicitud_id`, `espacio_id`, `usuario_id`, `fecha_inicio`, `fecha_fin`, `estado_solic`, `tarifa_historica`)
VALUES (null, 2, 5, '2018-12-05', null, 'DEFIN', 250);

INSERT INTO `hauga`.`solicitud_responsabilidad`
(`solicitud_id`, `espacio_id`, `usuario_id`, `fecha_inicio`, `fecha_fin`, `estado_solic`, `tarifa_historica`)
VALUES (null, 3, 5, '2020-09-24', null,  'DEFIN', 250);

INSERT INTO `hauga`.`solicitud_responsabilidad`
(`solicitud_id`, `espacio_id`, `usuario_id`, `fecha_inicio`, `fecha_fin`, `estado_solic`, `tarifa_historica`)
VALUES (null, 4, 5, '2020-05-25', null,  'DEFIN', 300);

INSERT INTO `hauga`.`solicitud_responsabilidad`
(`solicitud_id`, `espacio_id`, `usuario_id`, `fecha_inicio`, `fecha_fin`, `estado_solic`, `tarifa_historica`)
VALUES (null, 5, 6, '2020-09-18', null, 'DEFIN', 450);

INSERT INTO `hauga`.`solicitud_responsabilidad`
(`solicitud_id`, `espacio_id`, `usuario_id`, `fecha_inicio`, `fecha_fin`, `estado_solic`, `tarifa_historica`)
VALUES (null, 1, 2, '2018-10-01', '2018-12-31', 'HISTOR', 300);

INSERT INTO `hauga`.`solicitud_responsabilidad`
(`solicitud_id`, `espacio_id`, `usuario_id`, `fecha_inicio`, `fecha_fin`, `estado_solic`, `tarifa_historica`)
VALUES (null, 1, 3, '2019-01-01', '2019-07-01', 'HISTOR', 400);

INSERT INTO `hauga`.`solicitud_responsabilidad`
(`solicitud_id`, `espacio_id`, `usuario_id`, `fecha_inicio`, `fecha_fin`, `estado_solic`, `tarifa_historica`)
VALUES (null, 1, 4, '2019-08-01', '2020-10-01', 'HISTOR', 500);


ALTER TABLE `hauga`.`usuario` ADD FOREIGN KEY (`depart_usuario`) REFERENCES `hauga`.`departamento`(`depart_id`) ON DELETE SET NULL;
ALTER TABLE `hauga`.`usuario` ADD FOREIGN KEY (`grupo_usuario`) REFERENCES `hauga`.`grupo_investigacion`(`grupo_id`) ON DELETE SET NULL;
ALTER TABLE `hauga`.`usuario` ADD FOREIGN KEY (`centro_usuario`) REFERENCES `hauga`.`centro`(`centro_id`) ON DELETE SET NULL;

ALTER TABLE `hauga`.`grupo_investigacion` ADD FOREIGN KEY (`responsable_grupo`) REFERENCES `hauga`.`usuario`(`usuario_id`) ON DELETE SET NULL;

ALTER TABLE `hauga`.`departamento` ADD FOREIGN KEY (`responsable_depart`) REFERENCES `hauga`.`usuario`(`usuario_id`);
ALTER TABLE `hauga`.`departamento` ADD FOREIGN KEY	(`edificio_depart`) REFERENCES `hauga`.`edificio`(`edificio_id`) ON DELETE CASCADE;

ALTER TABLE `hauga`.`edificio` ADD FOREIGN KEY	(`agrup_edificio`) REFERENCES `hauga`.`agrupacion_edificio`(`agrup_id`) ON DELETE SET NULL;

ALTER TABLE `hauga`.`centro` ADD FOREIGN KEY (`edificio_centro`) REFERENCES `hauga`.`edificio`(`edificio_id`) on DELETE CASCADE;

ALTER TABLE `hauga`.`espacio` ADD FOREIGN KEY	(`edificio_esp`) REFERENCES `hauga`.`edificio`(`edificio_id`) ON DELETE CASCADE;

ALTER TABLE `hauga`.`incidencia` ADD FOREIGN KEY (`espacio_afectado`) REFERENCES `hauga`.`espacio`(`espacio_id`) ON DELETE CASCADE;
ALTER TABLE `hauga`.`incidencia` ADD FOREIGN KEY (`autor_incidencia`) REFERENCES `hauga`.`usuario`(`usuario_id`) ON DELETE CASCADE;

ALTER TABLE `hauga`.`solicitud_responsabilidad` ADD FOREIGN KEY	(`espacio_id`) REFERENCES `hauga`.`espacio`(`espacio_id`) ON DELETE CASCADE;
ALTER TABLE `hauga`.`solicitud_responsabilidad` ADD FOREIGN KEY (`usuario_id`) REFERENCES `hauga`.`usuario`(`usuario_id`) ON DELETE CASCADE;
