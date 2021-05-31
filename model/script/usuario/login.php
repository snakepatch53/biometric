<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include './../../dao/Mysql.php';
include './../../dao/UsuarioDao.php';
$usuarioDao = new UsuarioDao();
if (isset($_POST['usuario_email']) and isset($_POST['usuario_pass'])) {
    $usuario_email = $_POST['usuario_email'];
    $usuario_pass = md5($_POST['usuario_pass']);
    $dactilar_permission = false;
    if (isset($_POST['isdactilar_token'])) {
        $dactilar_permission = true;
    }
    $usuario_rs = $usuarioDao->login($usuario_email, $usuario_pass);
    if (mysqli_num_rows($usuario_rs)) {
        $usuario_r = mysqli_fetch_assoc($usuario_rs);
        if (
            $usuario_r['usuario_email'] == $usuario_email and
            $usuario_r['usuario_pass'] == $usuario_pass and
            $usuario_r['usuario_estado'] == 1 and
            $usuario_r['privilegio_administrador'] == 1
        ) {
            // print_r($usuario_r);
            // $usuario_r['usuario_huella'] = "No Supported..";
            // echo json_encode($usuario_r);
            echo json_encode(loadSession($usuario_r));
        } else {
            echo json_encode(false);
        }
    } else {
        if ($dactilar_permission == true) {
            if (isset($_POST['usuario_id'])) {
                $usuario_id = $_POST['usuario_id'];
                $usuario_rs = $usuarioDao->selectById($usuario_id);
                if (mysqli_num_rows($usuario_rs) > 0) {
                    if (
                        $usuario_r['usuario_estado'] == 1 and
                        $usuario_r['privilegio_administrador'] == 1
                    ) {
                        $usuario_r = mysqli_fetch_assoc($usuario_rs);
                        echo json_encode(loadSession($usuario_r));
                    } else {
                        echo json_encode(false);
                    }
                } else {
                    echo json_encode(false);
                }
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(false);
        }
    }
} else {
    echo json_encode(false);
}


function loadSession($usuario_r)
{
    $usuario_r['usuario_huella'] = "No Supported..";
    $_SESSION['usuario_id'] = $usuario_r['usuario_id'];
    $_SESSION['usuario_nombre'] = $usuario_r['usuario_nombre'];
    $_SESSION['usuario_email'] = $usuario_r['usuario_email'];
    $_SESSION['usuario_foto'] = $usuario_r['usuario_foto'];

    $_SESSION['privilegio_nombre'] = $usuario_r['privilegio_nombre'];
    $_SESSION['privilegio_descripcion'] = $usuario_r['privilegio_descripcion'];
    $_SESSION['privilegio_administrador'] = $usuario_r['privilegio_administrador'];
    $_SESSION['privilegio_informacion'] = $usuario_r['privilegio_informacion'];
    $_SESSION['privilegio_departamento'] = $usuario_r['privilegio_departamento'];
    $_SESSION['privilegio_horario'] = $usuario_r['privilegio_horario'];
    $_SESSION['privilegio_privilegio'] = $usuario_r['privilegio_privilegio'];
    $_SESSION['privilegio_usuario'] = $usuario_r['privilegio_usuario'];
    $_SESSION['privilegio_asistencia'] = $usuario_r['privilegio_asistencia'];
    $_SESSION['privilegio_createat'] = $usuario_r['privilegio_createat'];
    return $_SESSION;
}
