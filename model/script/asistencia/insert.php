<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/AsistenciaDao.php';
$_entity = new AsistenciaDao();
if (isset($_POST['asistencia_fecha_entrada']) and isset($_POST['asistencia_fecha_salida']) and isset($_POST['usuario_id'])) {
    $asistencia_fecha_entrada = $_POST['asistencia_fecha_entrada'];
    $asistencia_fecha_salida = $_POST['asistencia_fecha_salida'];
    $usuario_id = $_POST['usuario_id'];
    $_entity->insert($asistencia_fecha_entrada, $asistencia_fecha_salida, $usuario_id);

    echo json_encode(true);
} else {
    echo json_encode(false);
}
