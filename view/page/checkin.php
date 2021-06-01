<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ($informacion_r['informacion_icon'] != null and $informacion_r['informacion_icon'] != "") { ?>
        <link rel="icon" href="<?= $proyect['root'] ?>view/file/informacion_icon/<?= $informacion_r['informacion_icon'] ?>?date=<?= $dateTime ?>">
    <?php } else { ?>
        <link rel="icon" href="<?= $proyect['root'] ?>view/img/logo.png">
    <?php } ?>
    <link rel="stylesheet" href="<?= $proyect['root'] ?>view/library/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?= $proyect['root'] ?>view/css/config.css">
    <link rel="stylesheet" href="<?= $proyect['root'] ?>view/css/checkin.css">
    <title>Registro de asistencia - <?= $informacion_r['informacion_nombre'] ?></title>
</head>

<body>

    <div class="mode _error" id="fingermode"></div>

    <section class="checkin" id="fingercheck">
        <h1>CONTROL DE ASISTENCIA - <?= $informacion_r['informacion_nombre'] ?></h1>
        <div class="img_foto _foto" id="fingercheck_img_container">
            <img src="<?= $proyect['root'] ?>view/img/user.png" alt="User Photo" id ="fingercheck_img">
            <i class="fas fa-fingerprint" id="fingercheck_icon"></i>
        </div>
        <p id="fingercheck_text">Por favor coloque su dedo en el lector de huella digital..</p>
    </section>

    <section class="error" id="fingererror">
        <h1>CONTROL DE ASISTENCIA - <?= $informacion_r['informacion_nombre'] ?></h1>
        <div class="row">
            <i class="fas fa-fingerprint"></i>
        </div>
        <p class="row description aviso">NO SE PUDO CONECTAR CON EL LECTOR DE HUELLA DIGITAL, PUEDE HABER VARIAS RAZONES:</p>
        <ol>
            <li>No tiene instalado el driver "<a href="${ $root }view/download/digitalpersona.rar">Digital Persona</a>".</li>
            <li>No tiene instalado o iniciado el driver "<a href="${ $root }view/download/biometric.rar">Biometric Ideasoft</a>".</li>
            <li>No tiene conectado un lector de huella digital "Digital Persona".</li>
        </ol>
    </section>

</body>
<foot>
    <script src="control/dao/fetch.js"></script>
    <script src="<?= $proyect['root'] ?>control/script/Finger.check.js"></script>
</foot>

</html>