         
            

<?php
/*
_____________________________________________________________________________________________
- CREA UN ARCHIVO CON EL NOMBRE Y EXTENSION INDICADA.
- RUTA: proyect/model/script/privilegio/delete.php
*/
include './../../dao/Mysql.php';
include './../../dao/PrivilegioDao.php';
$_entity = new PrivilegioDao();
if(isset($_POST['privilegio_id'])){
$privilegio_id = $_POST['privilegio_id'];
$_entity->delete($privilegio_id);

echo json_encode(["Success"]);
} else {
echo json_encode([null]);
}
?>