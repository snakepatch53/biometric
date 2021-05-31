
            

<?php
/*
_____________________________________________________________________________________________
- CREA UN ARCHIVO CON EL NOMBRE Y EXTENSION INDICADA.
- RUTA: proyect/model/script/privilegio/insert.php
*/
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/PrivilegioDao.php';
$_entity = new PrivilegioDao();
if (isset($_POST['privilegio_nombre']) and isset($_POST['privilegio_descripcion']) and isset($_POST['privilegio_administrador']) and isset($_POST['privilegio_informacion']) and isset($_POST['privilegio_departamento']) and isset($_POST['privilegio_horario']) and isset($_POST['privilegio_privilegio']) and isset($_POST['privilegio_usuario']) and isset($_POST['privilegio_asistencia']) and isset($_POST['privilegio_createat'])) {
$privilegio_nombre = $_POST['privilegio_nombre']; 
$privilegio_descripcion = $_POST['privilegio_descripcion']; 
$privilegio_administrador = $_POST['privilegio_administrador']; 
$privilegio_informacion = $_POST['privilegio_informacion']; 
$privilegio_departamento = $_POST['privilegio_departamento']; 
$privilegio_horario = $_POST['privilegio_horario']; 
$privilegio_privilegio = $_POST['privilegio_privilegio']; 
$privilegio_usuario = $_POST['privilegio_usuario']; 
$privilegio_asistencia = $_POST['privilegio_asistencia']; 
$privilegio_createat = $_POST['privilegio_createat'];
$_entity->insert($privilegio_nombre, $privilegio_descripcion, $privilegio_administrador, $privilegio_informacion, $privilegio_departamento, $privilegio_horario, $privilegio_privilegio, $privilegio_usuario, $privilegio_asistencia, $privilegio_createat);

echo json_encode(["Success"]);
} else {
echo json_encode([null]);
}
?>