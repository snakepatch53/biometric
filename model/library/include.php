<?php
session_start();

include('model/dao/Mysql.php');
include('model/vendor/autoload.php');
include('model/dao/InformacionDao.php');
include('model/dao/UsuarioDao.php');
$informacionDao = new InformacionDao();
$usuarioDao = new UsuarioDao();

$informacion_r = mysqli_fetch_assoc($informacionDao->select());

date_default_timezone_set('America/Guayaquil');
$date = date('Y-m-d');
$dateTime = date('Y-m-d H:i:s');

function permission($session_init)
{
    if ($session_init) {
        if (empty($_SESSION['usuario_id'])) {
            header('location: ./login');
        }
    } else {
        if (isset($_SESSION['usuario_id'])) {
            header('location: ./inicio');
        }
    }
}


function permissionPage($page)
{
    if ($_SESSION['privilegio_' . $page] == 0) {
        header('location: ./inicio');
    }
}

function isPageActive($currentPage, $optionTool)
{
    if (strtolower($currentPage) == strtolower($optionTool)) {
        return "active";
    } else {
        return "";
    }
}