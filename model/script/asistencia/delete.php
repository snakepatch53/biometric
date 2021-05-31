         

<?php
/*
_____________________________________________________________________________________________
- CREA UN ARCHIVO CON EL NOMBRE Y EXTENSION INDICADA.
- RUTA: proyect/model/script/asistencia/delete.php
*/
include './../../dao/Mysql.php';
include './../../dao/AsistenciaDao.php';
$_entity = new AsistenciaDao();
if(isset($_POST['asistencia_id'])){
$asistencia_id = $_POST['asistencia_id'];
$_entity->delete($asistencia_id);

echo json_encode(["Success"]);
} else {
echo json_encode([null]);
}
?>