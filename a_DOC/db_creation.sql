DROP DATABASE biometric;

CREATE DATABASE biometric;

USE biometric;

CREATE TABLE informacion (
    informacion_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    informacion_nombre VARCHAR(100),
    informacion_logo VARCHAR(10),
    informacion_icon VARCHAR(10),
    informacion_pais VARCHAR(50),
    informacion_provincia VARCHAR(50),
    informacion_ciudad VARCHAR(50),
    informacion_direccion VARCHAR(100),
    informacion_telefono VARCHAR(11),
    informacion_celular VARCHAR(11),
    informacion_email VARCHAR(100),
    informacion_primary_background VARCHAR(50),
    informacion_primary_background_hover VARCHAR(50),
    informacion_primary_color VARCHAR(50),
    informacion_primary_color_hover VARCHAR(50),
    informacion_secondary_background VARCHAR(50),
    informacion_secondary_background_hover VARCHAR(50),
    informacion_secondary_color VARCHAR(50),
    informacion_secondary_color_hover VARCHAR(50),
    informacion_tertiary_background VARCHAR(50),
    informacion_tertiary_background_hover VARCHAR(50),
    informacion_tertiary_color VARCHAR(50),
    informacion_tertiary_color_hover VARCHAR(50),
    informacion_success VARCHAR(50),
    informacion_info VARCHAR(50),
    informacion_warnning VARCHAR(50),
    informacion_error VARCHAR(50)
) ENGINE INNODB;

CREATE TABLE departamento (
    departamento_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    departamento_nombre VARCHAR(45),
    departamento_descripcion VARCHAR(45),
    departamento_createat VARCHAR(25)
) ENGINE INNODB;

CREATE TABLE horario (
    horario_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    horario_nombre VARCHAR(50),
    horario_entrada VARCHAR(10),
    horario_salida VARCHAR(10),
    horario_createat VARCHAR(25)
) ENGINE INNODB;

CREATE TABLE privilegio (
    privilegio_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    privilegio_nombre VARCHAR(50),
    privilegio_descripcion VARCHAR(50),
    privilegio_administrador BOOLEAN,
    privilegio_informacion BOOLEAN,
    privilegio_departamento BOOLEAN,
    privilegio_horario BOOLEAN,
    privilegio_privilegio BOOLEAN,
    privilegio_usuario BOOLEAN,
    privilegio_asistencia BOOLEAN,
    privilegio_createat VARCHAR(25)
) ENGINE INNODB;

CREATE TABLE usuario (
    usuario_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    usuario_nombre VARCHAR(50),
    usuario_email VARCHAR(50),
    usuario_pass TEXT,
    usuario_foto VARCHAR(10),
    usuario_cedula VARCHAR(11),
    usuario_estado BOOLEAN,
    usuario_huella BLOB,
    usuario_createat VARCHAR(25),
    privilegio_id INT,
    departamento_id INT,
    horario_id INT,
    FOREIGN KEY (privilegio_id) REFERENCES privilegio (privilegio_id),
    FOREIGN KEY (departamento_id) REFERENCES departamento (departamento_id),
    FOREIGN KEY (horario_id) REFERENCES horario (horario_id)
) ENGINE INNODB;

CREATE TABLE asistencia (
    asistencia_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    asistencia_fecha_entrada VARCHAR(25),
    asistencia_fecha_salida VARCHAR(25),
    usuario_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuario (usuario_id)
) ENGINE INNODB;