<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/UsuarioDao.php';
$usuarioDao = new UsuarioDao();
if (
    isset($_POST['usuario_nombre']) and
    isset($_POST['usuario_email']) and
    isset($_POST['usuario_pass']) and
    isset($_POST['usuario_cedula']) and
    isset($_POST['usuario_estado']) and
    isset($_POST['privilegio_id']) and
    isset($_POST['departamento_id']) and
    isset($_POST['horario_id']) and
    isset($_POST['usuario_id'])
) {
    $usuario_nombre = $_POST['usuario_nombre'];
    $usuario_email = $_POST['usuario_email'];
    $usuario_pass = $_POST['usuario_pass'];
    $usuario_cedula = $_POST['usuario_cedula'];
    $usuario_estado = $_POST['usuario_estado'];
    $privilegio_id = $_POST['privilegio_id'];
    $departamento_id = $_POST['departamento_id'];
    $horario_id = $_POST['horario_id'];
    $usuario_id = $_POST['usuario_id'];
    $usuarioDao->update(
        $usuario_nombre,
        $usuario_email,
        $usuario_cedula,
        $usuario_estado,
        $privilegio_id,
        $departamento_id,
        $horario_id,
        $usuario_id
    );

    if ($usuario_pass != "" or $usuario_pass != null) {
        $usuarioDao->updatePassword(
            md5($usuario_pass),
            $usuario_id
        );
    }

    if (isset($_FILES['usuario_foto'])) {
        $usuario_foto = $_FILES['usuario_foto'];
        if ($usuario_foto['tmp_name'] != "" or $usuario_foto['tmp_name'] != null) {
            if (!file_exists('../../../view/file/usuario_foto')) {
                mkdir("../../../view/file/usuario_foto", 0700);
            }
            $desde = $usuario_foto['tmp_name'];
            $hasta = "../../../view/file/usuario_foto/" . $usuario_id . ".png";
            copy($desde, $hasta);
            $usuarioDao->updateUsuario_foto($usuario_id . ".png", $usuario_id);
        }
    }
    echo json_encode(true);
} else {
    echo json_encode(false);
}
