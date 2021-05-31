<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/AsistenciaDao.php';
$asistenciaDao = new AsistenciaDao();
$rs = $asistenciaDao->select();
$array = array();
while ($r = mysqli_fetch_assoc($rs)) {
    $r['usuario_huella'] = "No Supported";
    $array[] = $r;
}
echo json_encode($array);
