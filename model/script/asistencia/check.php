<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/AsistenciaDao.php';
$asistenciaDao = new AsistenciaDao();
date_default_timezone_set('America/Guayaquil');
$dateTime = date('Y-m-d H:i:s');
if (isset($_POST['usuario_id'])) {
    $usuario_id = $_POST['usuario_id'];
    $asistencia_rs = $asistenciaDao->selectByUsuario_id($usuario_id);
    if (mysqli_num_rows($asistencia_rs) == 0) {
        $asistenciaDao->insert(
            $dateTime,
            null,
            $usuario_id
        );
        $asistencia_id = $asistenciaDao->getLastId();
        $asistencia_rs = mysqli_fetch_assoc($asistenciaDao->selectById($asistencia_id));
        $asistencia_rs['asistencia_ingreso'] = true;
    } else {
        $asistencia_rs = mysqli_fetch_assoc($asistencia_rs);
        $asistenciaDao->update(
            $asistencia_rs['asistencia_fecha_entrada'],
            $dateTime,
            $usuario_id,
            $asistencia_rs['asistencia_id']
        );
        $asistencia_rs['asistencia_fecha_salida'] = $dateTime;
        $asistencia_rs['asistencia_ingreso'] = false;
    }
    $asistencia_rs['usuario_huella'] = "No supported";
    echo json_encode($asistencia_rs);
} else {
    echo json_encode(false);
}
