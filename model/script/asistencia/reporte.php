<?php
session_start();
date_default_timezone_set('America/Guayaquil');
include('../../dao/Mysql.php');

include('../../vendor/autoload.php');
$mpdf = new \Mpdf\Mpdf(['en-GB-x', 'A4', '', '', 0, 0, 0, 0, 0, 0]);

include('../../dao/UsuarioDao.php');
$usuarioDao = new UsuarioDao();
$usuario_rs = $usuarioDao->select();

include('../../dao/AsistenciaDao.php');
$asistenciaDao = new AsistenciaDao();
$asistencia_rs = $asistenciaDao->select();

if (isset(
    $_SESSION['usuario_id'],
    $_GET['reporte_desde'],
    $_GET['reporte_hasta']
)) {
    $fecha_desde = $_GET['reporte_desde'];
    $fecha_hasta = $_GET['reporte_hasta'];
    $usuario_rs = getUsers($usuario_rs);
    $tittle = 'Reporte de asistencia ';
    if($fecha_desde != "") {
        $tittle .= " Desde " . $fecha_desde;
    }
    if($fecha_hasta != "") {
        $tittle .= " Hasta " . $fecha_hasta;
    }
    $html = '
        <!DOCTYPE html>
        <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>' . $tittle . '</title>
                <style>
                    table {
                        border-collapse: collappse;
                        width: 100%;
                    }
                </style>
            </head>
            <body>
                <h1 style="text-align: center; font-family: sans-serif; font-size: 16px;">' . $tittle . '</h1>
    ';
    foreach ($usuario_rs as $usuario_index => $usuario_value) {
        $asistencia_array = getAsistencias($asistencia_rs, $usuario_value, $fecha_desde, $fecha_hasta);
        if (count($asistencia_array) > 0) {
            $tiempo_asistido_r = new DateInterval('P0000-00-00T00:00:00');
            $tiempo_fuera_r = new DateInterval('P0000-00-00T00:00:00');
            $tiempo_extra_r = new DateInterval('P0000-00-00T00:00:00');
            foreach ($asistencia_array as $asistencia_index => $asistencia_value) {
                $asistencia_desde = $asistencia_value['asistencia_fecha_entrada'];
                $asistencia_hasta = $asistencia_value['asistencia_fecha_salida'];
                $hora_entrada_tmp = (new DateTime($asistencia_desde))->format('Y-m-d') . " " . $usuario_value['horario_entrada'];
                $hora_salida_tmp = (new DateTime($asistencia_hasta))->format('Y-m-d') . " " . $usuario_value['horario_salida'];
                $horas_laborales = getTime($hora_entrada_tmp, $hora_salida_tmp);

                $horas_asistidas = getTime($asistencia_desde, $asistencia_hasta);
                $tiempo_asistido_r = getTimeSuma($tiempo_asistido_r, $horas_asistidas);

                $tiempo_fuera = getTimeResta($horas_laborales, $horas_asistidas);
                $tiempo_fuera_r = getTimeSuma($tiempo_fuera_r, $tiempo_fuera);

                $tiempo_extra = getTimeResta($horas_asistidas, $horas_laborales);
                $tiempo_extra_r = getTimeSuma($tiempo_extra_r, $tiempo_extra);
            }
            $html .= '
                <br>
                <br>
                <table border="1">
                    <tr>
                        <th colspan="2" style="color: #292D3E; font-size: 14px; border: solid 1px #292D3E; padding: 5px; font-family: sans-serif;">' . $usuario_value['usuario_nombre'] . '</th>
                    </tr>
                    <tr>
                        <th style="font-size: 13px; border: solid 1px #292D3E; color: #292D3E; padding: 5px; font-family: sans-serif;">Cargo:</th>
                        <td style="color: #595959; font-size: 12px; border: solid 1px #292D3E; padding: 5px; font-family: sans-serif;">Docente</td>
                    </tr>
                    <tr>
                        <th style="font-size: 13px; border: solid 1px #292D3E; color: #292D3E; padding: 5px; font-family: sans-serif;">Departamento:</th>
                        <td style="color: #595959; font-size: 12px; border: solid 1px #292D3E; padding: 5px; font-family: sans-serif;">Talento humano</td>
                    </tr>
                    <tr>
                        <th style="font-size: 13px; border: solid 1px #292D3E; color: #292D3E; padding: 5px; font-family: sans-serif;">Horario:</th>
                        <td style="color: #595959; font-size: 12px; border: solid 1px #292D3E; padding: 5px; font-family: sans-serif;">' . $usuario_value['horario_entrada'] . ' - ' . $usuario_value['horario_salida'] . '</td>
                    </tr>
                    <tr>
                        <th style="font-size: 13px; border: solid 1px #292D3E; color: #292D3E; padding: 5px; font-family: sans-serif;">Tiempo Fuera:</th>
                        <td style="color: #595959; font-size: 12px; border: solid 1px #292D3E; padding: 5px; font-family: sans-serif;">' . getTimeFormat($tiempo_fuera_r) . '</td>
                    </tr>
                    <tr>
                        <th style="font-size: 13px; border: solid 1px #292D3E; color: #292D3E; padding: 5px; font-family: sans-serif;">Tiempo Extra:</th>
                        <td style="color: #595959; font-size: 12px; border: solid 1px #292D3E; padding: 5px; font-family: sans-serif;">' . getTimeFormat($tiempo_extra_r) . '</td>
                    </tr>
                    <tr>
                        <th style="font-size: 13px; border: solid 1px #292D3E; color: #292D3E; padding: 5px; font-family: sans-serif;">Tiempo Total:</th>
                        <td style="color: #595959; font-size: 12px; border: solid 1px #292D3E; padding: 5px; font-family: sans-serif;">' . getTimeFormat($tiempo_asistido_r) . '</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: 0; border: solid 1px #292D3E;">
                            <table border="0">
                                <tr>
                                    <th style="border-bottom: solid 1px #292D3E; font-size: 13px; color: #292D3E; padding: 5px 5px; font-family: sans-serif;">Ingreso</th>
                                    <th style="border-bottom: solid 1px #292D3E; font-size: 13px; color: #292D3E; padding: 5px 5px; font-family: sans-serif;">Egreso</th>
                                    <th style="border-bottom: solid 1px #292D3E; font-size: 13px; color: #292D3E; padding: 5px 5px; font-family: sans-serif;">Tiempo Fuera</th>
                                    <th style="border-bottom: solid 1px #292D3E; font-size: 13px; color: #292D3E; padding: 5px 5px; font-family: sans-serif;">Tiempo Extra</th>
                                    <th style="border-bottom: solid 1px #292D3E; font-size: 13px; color: #292D3E; padding: 5px 5px; font-family: sans-serif;">Tiempo Total</th>
                                </tr>
            ';
            foreach ($asistencia_array as $asistencia_index => $asistencia_value) {
                $asistencia_desde = $asistencia_value['asistencia_fecha_entrada'];
                $asistencia_hasta = $asistencia_value['asistencia_fecha_salida'];
                $hora_entrada_tmp = (new DateTime($asistencia_desde))->format('Y-m-d') . " " . $usuario_value['horario_entrada'];
                $hora_salida_tmp = (new DateTime($asistencia_hasta))->format('Y-m-d') . " " . $usuario_value['horario_salida'];
                $horas_laborales = getTime($hora_entrada_tmp, $hora_salida_tmp);
                $horas_asistidas = getTime($asistencia_desde, $asistencia_hasta);
                $tiempo_fuera = getTimeResta($horas_laborales, $horas_asistidas);
                $tiempo_extra = getTimeResta($horas_asistidas, $horas_laborales);
                $html .= '
                    <tr>
                        <td style="border-bottom: solid 1px #ccc; color: #595959; font-size: 12px; text-align: center; padding: 2px 5px; font-family: sans-serif;">' . $asistencia_value['asistencia_fecha_entrada'] . '</td>
                        <td style="border-bottom: solid 1px #ccc; color: #595959; font-size: 12px; text-align: center; padding: 2px 5px; font-family: sans-serif;">' . $asistencia_value['asistencia_fecha_salida'] . '</td>
                        <td style="border-bottom: solid 1px #ccc; color: #595959; font-size: 12px; text-align: center; padding: 2px 5px; font-family: sans-serif;">' . getTimeFormat($tiempo_fuera) . '</td>
                        <td style="border-bottom: solid 1px #ccc; color: #595959; font-size: 12px; text-align: center; padding: 2px 5px; font-family: sans-serif;">' . getTimeFormat($tiempo_extra) . '</td>
                        <td style="border-bottom: solid 1px #ccc; color: #595959; font-size: 12px; text-align: center; padding: 2px 5px; font-family: sans-serif;">' . getTimeFormat($horas_asistidas) . '</td>
                    </tr>
                ';
            }
            $html .= '
                            </table>
                        </td>
                    </tr>
                </table>
            ';
        }
    }
    $html .= '
            </body>
        </html>
    ';
    // echo $html;


    $html =  mb_convert_encoding($html, 'UTF-8', 'UTF-8');
    $mpdf->WriteHTML($html);
    $mpdf->Output($tittle . '.pdf', 'I');
} else {
    header("location: ../../../login.php");
}

function getUsers($usuario_rs)
{
    $usuario_array = array();
    mysqli_data_seek($usuario_rs, 0);
    while ($usuario_value = mysqli_fetch_assoc($usuario_rs)) {
        $usuario_value['usuario_huella'] = "No Supported";
        if (isset($_GET['usuario_check'])) {
            $usuario_filter_rs = $_GET['usuario_check'];
            foreach ($usuario_filter_rs as $usuario_filter_index => $usuario_filter_value) {
                if ($usuario_filter_value == $usuario_value['usuario_id']) {
                    $usuario_array[] = $usuario_value;
                }
            }
        } else {
            $usuario_array[] = $usuario_value;
        }
    }
    return $usuario_array;
}

function getAsistencias($asistencia_rs, $usuario_r, $fecha_desde, $fecha_hasta)
{
    $asistencia_array = array();
    mysqli_data_seek($asistencia_rs, 0);
    while ($asistencia_value = mysqli_fetch_assoc($asistencia_rs)) {
        $asistencia_value['usuario_huella'] = "No supported";
        if (
            $asistencia_value['usuario_id'] == $usuario_r['usuario_id'] &&
            $asistencia_value['asistencia_fecha_salida'] != "" &&
            $asistencia_value['asistencia_fecha_salida'] != null &&
            (strtotime($asistencia_value['asistencia_fecha_entrada']) >= strtotime($fecha_desde) || $fecha_desde == "") &&
            (strtotime($asistencia_value['asistencia_fecha_salida']) <= strtotime($fecha_hasta) || $fecha_hasta == "")
        ) {
            $asistencia_array[] = $asistencia_value;
        }
    }
    return $asistencia_array;
}

function getTime($date1, $date2)
{
    $date1 = new DateTime($date1);
    $date2 = new DateTime($date2);
    $diff = $date1->diff($date2);
    // var_dump($date1);
    // var_dump($diff);
    return $diff;
}

function getTimeSuma($diff1, $diff2)
{
    $e = new DateTime('00:00');
    $f = clone $e;
    $e->add($diff1);
    $e->add($diff2);
    $diff = $f->diff($e);
    if ($diff->invert == 1) {
        return (new DateTime('00:00'))->diff(new DateTime('00:00'));
    } else {
        return $f->diff($e);
    }
}

function getTimeResta($diff1, $diff2)
{
    $e = new DateTime('00:00');
    $f = clone $e;
    $e->add($diff1);
    $e->sub($diff2);
    $diff = $f->diff($e);
    if ($diff->invert == 1) {
        return (new DateTime('00:00'))->diff(new DateTime('00:00'));
    } else {
        return $diff;
    }
}

function getTimeFormat($time)
{
    $str = '';
    $str .= ($time->invert == 1) ? ' - ' : '';
    if ($time->y > 0) {
        $str .= ($time->y > 1) ? $time->y . ' Años ' : $time->y . ' Año ';
    }
    if ($time->m > 0) {
        $str .= ($time->m > 1) ? $time->m . ' Meses ' : $time->m . ' Mes ';
    }
    if ($time->d > 0) {
        $str .= ($time->d > 1) ? $time->d . ' Dias ' : $time->d . ' Dia ';
    }
    if ($time->h > 0) {
        $str .= ($time->h > 1) ? $time->h . ' Horas ' : $time->h . ' Hora ';
    }
    if ($time->i > 0) {
        $str .= ($time->i > 1) ? $time->i . ' Minutos ' : $time->i . ' Minuto ';
    }
    if ($time->s > 0) {
        $str .= ($time->s > 1) ? $time->s . ' Segundos ' : $time->s . ' Segundo ';
    }
    if ($str == '') {
        $str = 'Sin tiempo..';
    }
    return $str;
}
