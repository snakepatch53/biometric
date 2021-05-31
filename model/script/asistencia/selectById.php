<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/AsistenciaDao.php';
$_entity = new AsistenciaDao();
if (isset($_POST['asistencia_id'])) {
    $asistencia_id = $_POST['asistencia_id'];
    $rs = $_entity->selectById($asistencia_id);
    $array = array();
    while ($r = mysqli_fetch_assoc($rs)) {
        $array[] = $r;
    }
    echo json_encode($array);
} else {
    echo json_encode([null]);
}
?>