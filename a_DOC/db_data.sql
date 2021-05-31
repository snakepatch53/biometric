INSERT INTO informacion SET 
    informacion_id = 1,
    informacion_nombre = 'GAD',
    informacion_logo = null,
    informacion_icon = null,
    informacion_pais = 'Ecuador',
    informacion_provincia = 'Morona Santiago',
    informacion_ciudad = 'Sucua',
    informacion_direccion = '12 de octrubre y xD',
    informacion_telefono = null,
    informacion_celular = null,
    informacion_email = 'gad@email.com',
    informacion_primary_background = '#CF0302',
    informacion_primary_background_hover = '#b00302',
    informacion_primary_color = '#ffffff',
    informacion_primary_color_hover = '#f0f0f0',
    informacion_secondary_background = '#21292D',
    informacion_secondary_background_hover = '#1b2225',
    informacion_secondary_color = '#ffffff',
    informacion_secondary_color_hover = '#f0f0f0',
    informacion_tertiary_background = '#FFFFFF',
    informacion_tertiary_background_hover = '#d5d5d5',
    informacion_tertiary_color = '#585858',
    informacion_tertiary_color_hover = '#4d4d4d',
    informacion_success = '#19A15F',
    informacion_info = '#427ad5',
    informacion_warnning = '#FFCD42',
    informacion_error = '#DD5145';

INSERT INTO departamento SET
    departamento_id = 1,
    departamento_nombre = 'Administración',
    departamento_descripcion = null,
    departamento_createat = '2021-04-28 00:35:00';

INSERT INTO horario SET
    horario_id = 1,
    horario_nombre = 'Administrativo',
    horario_entrada = '00:00:00',
    horario_salida = '00:00:00',
    horario_createat = '2021-04-28 00:35:00';

INSERT INTO privilegio SET
    privilegio_id = 1,
    privilegio_nombre = 'Administrador',
    privilegio_descripcion = null,
    privilegio_administrador = 1,
    privilegio_informacion = 1,
    privilegio_departamento = 1,
    privilegio_horario = 1,
    privilegio_privilegio = 1,
    privilegio_usuario = 1,
    privilegio_asistencia = 1,
    privilegio_createat = '2021-04-28 00:35:00';

INSERT INTO usuario SET
    usuario_id = 1,
    usuario_nombre = 'Administrador',
    usuario_email = 'admin',
    usuario_pass = '21232f297a57a5a743894a0e4a801fc3', --admin
    usuario_foto = null,
    usuario_cedula = null,
    usuario_estado = 1,
    usuario_createat = '2021-04-28 00:35:00',
    privilegio_id = 1,
    departamento_id = 1,
    horario_id = 1;