          
            

<?php
/*
_____________________________________________________________________________________________
- CREA UN ARCHIVO CON EL NOMBRE Y EXTENSION INDICADA.
- RUTA: proyect/model/script/departamento/delete.php
*/
include './../../dao/Mysql.php';
include './../../dao/DepartamentoDao.php';
$_entity = new DepartamentoDao();
if(isset($_POST['departamento_id'])){
$departamento_id = $_POST['departamento_id'];
$_entity->delete($departamento_id);

echo json_encode(["Success"]);
} else {
echo json_encode([null]);
}
?>