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
    <link rel="stylesheet" href="<?= $proyect['root'] ?>view/css/config.css">
    <link rel="stylesheet" href="<?= $proyect['root'] ?>view/library/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?= $proyect['root'] ?>view/css/login.css">
    <title>Login - <?= $informacion_r['informacion_nombre'] ?></title>
</head>

<body>

    <form action="#" onsubmit="return false" id="element_form">
        <div class="container">
            <?php if ($informacion_r['informacion_logo'] != null and $informacion_r['informacion_logo'] != "") { ?>
                <img class="logo" src="<?= $proyect['root'] ?>view/file/informacion_logo/<?= $informacion_r['informacion_logo'] ?>?date=<?= $dateTime ?>" alt="Logo">
            <?php } else { ?>
                <img class="logo" src="<?= $proyect['root'] ?>view/img/logo.png" alt="Logo">
            <?php } ?>
            <span><?= strtoupper($informacion_r['informacion_nombre']) ?></span>
            <div class="input">
                <i class="fas fa-user-tie"></i>
                <input placeholder="Correo electrónico" type="text" name="usuario_email">
            </div>
            <div class="input">
                <i class="fas fa-unlock-alt"></i>
                <input placeholder="Contraseña" type="password" name="usuario_pass">
            </div>
            <label for="save_pass" class="input">
                <input type="checkbox" id="save_pass" name="save_pass">
                <span>Recordar contraseña</span>
            </label>
            <div class="input msg">
                <span class="msg" id="element_msg"></span>
            </div>
            <div class="input submit">
                <input type="submit" value="Iniciar sesion">
            </div>
        </div>
    </form>

    <section class="ideamodal _open" id="sectionProgress">
        <div class="modal-progress">
            <span id="sectionProgressText">Procesando..</span>
            <div class="progress_bar"></div>
        </div>
    </section>

</body>

<foot>
    <script src="control/dao/fetch.js"></script>
    <script src="control/script/login.js"></script>
    <script src="control/script/login.Finger.check.js"></script>
</foot>

</html>