
<?php
/*
_____________________________________________________________________________________________
- CREA UN ARCHIVO CON EL NOMBRE Y EXTENSION INDICADA.
- RUTA: proyect/model/script/departamento/insert.php
*/
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/DepartamentoDao.php';
$_entity = new DepartamentoDao();
if (isset($_POST['departamento_nombre']) and isset($_POST['departamento_descripcion']) and isset($_POST['departamento_createat'])) {
$departamento_nombre = $_POST['departamento_nombre']; 
$departamento_descripcion = $_POST['departamento_descripcion']; 
$departamento_createat = $_POST['departamento_createat'];
$_entity->insert($departamento_nombre, $departamento_descripcion, $departamento_createat);

echo json_encode(["Success"]);
} else {
echo json_encode([null]);
}
?>