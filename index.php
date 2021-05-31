<?php
// ob_start();
$proyect = json_decode(file_get_contents('http://localhost/biometric/config.json'), true);
if(substr($_SERVER['REMOTE_ADDR'], 0, 12) != $proyect['octeto_local']) {
    $proyect['root'] = $proyect['root_alternative'];
}

include 'model/library/Router/Route.php';
include 'model/library/Router/Router.php';
include 'model/library/Router/RouteNotFoundException.php';
$router = new Router\Router('/' . $proyect['name']);

// INDEX
$router->add('/(|index|panel|index.php)', function () {
    global $proyect;
    include('./model/library/include.php');
    include('./model/library/loadInformacion.php');
    $currentPage = 'marcar';
    permission(false);
    include('./view/page/checkin.php');
}, ['GET']);

// INICIO
$router->add('/inicio', function () {
    global $proyect;
    include('./model/library/include.php');
    include('./model/library/loadInformacion.php');
    $currentPage = 'inicio';
    permission(true);
    include('./view/page/inicio.php');
}, ['GET']);

// INFORMACION
$router->add('/informacion', function () {
    global $proyect;
    include('./model/library/include.php');
    include('./model/library/loadInformacion.php');
    $currentPage = 'informacion';
    permission(true);
    permissionPage($currentPage);
    include('./view/page/informacion.php');
}, ['GET']);

// DEPARTAMENTO
$router->add('/departamento', function () {
    global $proyect;
    include('./model/library/include.php');
    include('./model/library/loadInformacion.php');
    $currentPage = 'departamento';
    permission(true);
    permissionPage($currentPage);
    include('./view/page/departamento.php');
}, ['GET']);

// HORARIO
$router->add('/horario', function () {
    global $proyect;
    include('./model/library/include.php');
    include('./model/library/loadInformacion.php');
    $currentPage = 'horario';
    permission(true);
    permissionPage($currentPage);
    include('./view/page/horario.php');
}, ['GET']);

// PRIVILEGIO
$router->add('/privilegio', function () {
    global $proyect;
    include('./model/library/include.php');
    include('./model/library/loadInformacion.php');
    $currentPage = 'privilegio';
    permission(true);
    permissionPage($currentPage);
    include('./view/page/privilegio.php');
}, ['GET']);

// USUARIO
$router->add('/usuario', function () {
    global $proyect;
    include('./model/library/include.php');
    include('./model/library/loadInformacion.php');
    $currentPage = 'usuario';
    permission(true);
    permissionPage($currentPage);
    include('./view/page/usuario.php');
}, ['GET']);

// ASISTENCIA
$router->add('/asistencia', function () {
    global $proyect;
    include('./model/library/include.php');
    include('./model/library/loadInformacion.php');
    $currentPage = 'asistencia';
    permission(true);
    permissionPage($currentPage);
    include('./view/page/asistencia.php');
}, ['GET']);

// LOGIN
$router->add('/login', function () {
    global $proyect;
    include('./model/library/include.php');
    include('./model/library/loadInformacion.php');
    $currentPage = 'login';
    permission(false);
    include('./view/page/login.php');
}, ['GET']);

// CHECKIN
$router->add('/marcar', function () {
    global $proyect;
    include('./model/library/include.php');
    include('./model/library/loadInformacion.php');
    $currentPage = 'marcar';
    permission(false);
    include('./view/page/checkin.php');
}, ['GET']);



// $router->add('/ventas/pdf/([0-9]+)', function ($producto_venta_id) {
// }, ['GET']);

// ERROR 404
$router->add('/.*', function () {
    global $proyect;
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    echo '<h1>404 - El sitio solicitado no existe</h1>';
});

// EJECUTAR RUTAS
$router->route();
