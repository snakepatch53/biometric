
            

<?php
/*
_____________________________________________________________________________________________
- CREA UN ARCHIVO CON EL NOMBRE Y EXTENSION INDICADA.
- RUTA: proyect/model/script/departamento/selectById.php
*/
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/DepartamentoDao.php';
$_entity = new DepartamentoDao();
if (isset($_POST['departamento_id'])) {
$departamento_id = $_POST['departamento_id'];
$rs = $_entity->selectById($departamento_id);
$array = array();
while($r = mysqli_fetch_assoc($rs)) {
$array[] = $r;
}
echo json_encode($array);
} else {
echo json_encode([null]);
}
?>