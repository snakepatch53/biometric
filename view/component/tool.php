<?php if ($_SESSION['usuario_foto'] == null) { ?>
    <img src="<?= $proyect['root'] ?>view/img/user.png" alt="user photo" class="user_img">
<?php } else { ?>
    <img src="<?= $proyect['root'] ?>view/file/usuario_foto/<?= $_SESSION['usuario_foto'] ?>?date=<?= $dateTime ?>" alt="user photo" class="user_img">
<?php } ?>
<span class="user_name"><?= $_SESSION['usuario_nombre'] ?></span>
<a class="option <?= isPageActive($currentPage, 'inicio') ?>" href="./inicio">
    <i class="fas fa-home"></i>
    <span>Inicio</span>
</a>
<?php if ($_SESSION['privilegio_informacion'] == 1) { ?>
    <hr>
    <a class="option <?= isPageActive($currentPage, 'informacion') ?>" href="./informacion">
        <i class="fas fa-question-circle"></i>
        <span>Información</span>
    </a>
<?php }
if ($_SESSION['privilegio_departamento'] == 1) { ?>
    <hr>
    <a class="option <?= isPageActive($currentPage, 'departamento') ?>" href="./departamento">
        <i class="fas fa-hospital-alt"></i>
        <span>Departamentos</span>
    </a>
<?php }
if ($_SESSION['privilegio_horario'] == 1) { ?>
    <hr>
    <a class="option <?= isPageActive($currentPage, 'horario') ?>" href="./horario">
        <i class="fas fa-clock"></i>
        <span>Horarios</span>
    </a>
<?php }
if ($_SESSION['privilegio_privilegio'] == 1) { ?>
    <hr>
    <a class="option <?= isPageActive($currentPage, 'privilegio') ?>" href="./privilegio">
        <i class="fas fa-users-cog"></i>
        <span>Privilegios</span>
    </a>
<?php }
if ($_SESSION['privilegio_usuario'] == 1) { ?>
    <hr>
    <a class="option <?= isPageActive($currentPage, 'usuario') ?>" href="./usuario">
        <i class="fas fa-users"></i>
        <span>Usuarios</span>
    </a>
<?php }
if ($_SESSION['privilegio_asistencia'] == 1) { ?>
    <hr>
    <a class="option <?= isPageActive($currentPage, 'asistencia') ?>" href="./asistencia">
        <i class="fas fa-check-circle"></i>
        <span>Asistencia</span>
    </a>
<?php } ?>