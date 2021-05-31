<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/UsuarioDao.php';
$_entity = new UsuarioDao();
if (
    isset($_POST['usuario_huella']) and
    isset($_POST['usuario_id'])
) {
    $usuario_huella = $_POST['usuario_huella'];
    $usuario_id = $_POST['usuario_id'];
    $res = $_entity -> updataUsuario_huellaByUsuario_id(
        $usuario_huella,
        $usuario_id
    );
    echo json_encode(true);
} else {
    echo json_encode(false);
}
