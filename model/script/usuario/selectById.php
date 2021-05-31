<?php
/*
_____________________________________________________________________________________________
- CREA UN ARCHIVO CON EL NOMBRE Y EXTENSION INDICADA.
- RUTA: proyect/model/script/usuario/selectById.php
*/
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/UsuarioDao.php';
$usuarioDao = new UsuarioDao();
if (isset($_POST['usuario_id'])) {
    $usuario_id = $_POST['usuario_id'];
    $usuario_rs = $usuarioDao->selectById($usuario_id);
    $usuario_array = array();
    if(mysqli_num_rows($usuario_rs)) {
        $usuario_r = mysqli_fetch_assoc($usuario_rs);
        $usuario_r['usuario_huella'] = "No Supported..";
        $usuario_array[] = $usuario_r;
        echo json_encode($usuario_array[0]);
    } else {
        echo json_encode(false);
    }
} else {
    echo json_encode(false);
}
