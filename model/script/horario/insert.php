
            

<?php
/*
_____________________________________________________________________________________________
- CREA UN ARCHIVO CON EL NOMBRE Y EXTENSION INDICADA.
- RUTA: proyect/model/script/horario/insert.php
*/
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/HorarioDao.php';
$_entity = new HorarioDao();
if (isset($_POST['horario_nombre']) and isset($_POST['horario_entrada']) and isset($_POST['horario_salida']) and isset($_POST['horario_createat'])) {
$horario_nombre = $_POST['horario_nombre']; 
$horario_entrada = $_POST['horario_entrada']; 
$horario_salida = $_POST['horario_salida']; 
$horario_createat = $_POST['horario_createat'];
$_entity->insert($horario_nombre, $horario_entrada, $horario_salida, $horario_createat);

echo json_encode(["Success"]);
} else {
echo json_encode([null]);
}
?>