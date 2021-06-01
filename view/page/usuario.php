<?php
if (empty($proyect)) {
    header("location:/");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include('./view/component/head.php') ?>
    <title>Panel - Usuarios</title>
    <link rel="stylesheet" href="<?= $proyect['root'] ?>view/css/table.css">
    <link rel="stylesheet" href="<?= $proyect['root'] ?>view/css/usuario.css">
    <link rel="stylesheet" href="<?= $proyect['root'] ?>view/css/Finger.panel.css">
</head>

<body>
    <div class="state open" id="tool_toggle_menu"></div>
    <header> <?php include('./view/component/header.php') ?> </header>

    <content>
        <tool> <?php include('./view/component/tool.php') ?> </tool>

        <page>


            <section class="head ideasection open" id="sectionHead">
                <h3 class="tittle"><i class="fas fa-users"></i> <span>Usuarios</span></h3>
                <div class="search ideasearch">
                    <span>Buscar: </span>
                    <div class="content">
                        <i class="fas fa-search"></i>
                        <input type="search" placeholder="Busca por cualquier campo.." id="inputSearch">
                    </div>
                </div>
                <button class="ideabutton" id="inputNewButton">
                    <i class="fas fa-plus-circle"></i>
                    <span>Agregar</span>
                </button>
            </section>

            <section class="table ideasection open" id="sectionTable">
                <div class="content_table ideatable">
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Estado</th>
                                <th>Nombre</th>
                                <th><i class="fas fa-hospital-alt"></i> Departamento</th>
                                <th><i class="fas fa-clock"></i> Horario</th>
                                <th><i class="fas fa-users-cog"></i> Privilegio</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="tableData"></tbody>
                    </table>
                </div>
            </section>

            <section class="ideasection" id="sectionForm">
                <form class="ideaform" action="#" method="POST" onsubmit="return false" id="formData">
                    <input type="hidden" name="usuario_id" value="0">
                    <input type="hidden" name="usuario_createat" value="<?= $date ?>">
                    <div class="body">
                        <div class="campo">
                            <span>Nombre<b>*</b>:</span>
                            <input type="text" name="usuario_nombre" placeholder="Nombre">
                        </div>
                        <div class="campo"></div>
                        <div class="campo">
                            <span>Correo electrónico<b>*</b>:</span>
                            <input type="text" name="usuario_email" placeholder="Correo electrónico">
                        </div>
                        <div class="campo">
                            <span id="field_password">Contraseña<b>*</b>:</span>
                            <div class="inputpass">
                                <input type="password" name="usuario_pass" placeholder="Contraseña">
                                <button class="ideabutton showpass show_" id="buttonShowPass">
                                    <i class="fas fa-eye show"></i>
                                    <i class="fas fa-eye-slash hide"></i>
                                </button>
                            </div>
                        </div>
                        <div class="campo">
                            <span>Foto:</span>
                            <div class="inputfile">
                                <input class="placeholder_off" type="file" name="usuario_foto" placeholder="Foto" accept="image/png">
                                <i class="far fa-image"></i>
                            </div>
                        </div>
                        <div class="campo">
                            <span>Cedula<b>*</b>:</span>
                            <input type="text" name="usuario_cedula" placeholder="Cedula">
                        </div>
                        <div class="campo">
                            <span>Estado<b>*</b>:</span>
                            <div class="radios">
                                <label for="radio_usuario_estado_si">
                                    <input type="radio" name="usuario_estado" id="radio_usuario_estado_si" value="1">
                                    <span>Activo</span>
                                </label>
                                <label for="radio_usuario_estado_no">
                                    <input type="radio" name="usuario_estado" id="radio_usuario_estado_no" value="0" checked>
                                    <span>Inactivo</span>
                                </label>
                            </div>
                        </div>
                        <div class="campo">
                            <span><i class="fas fa-users-cog"></i> Privilegios<b>*</b>:</span>
                            <select name="privilegio_id"></select>
                        </div>
                        <div class="campo">
                            <span><i class="fas fa-users"></i> Departamento<b>*</b>:</span>
                            <select name="departamento_id"></select>
                        </div>
                        <div class="campo">
                            <span><i class="fas fa-clock"></i> Horario<b>*</b>:</span>
                            <select name="horario_id"></select>
                        </div>
                    </div>
                    <div class="foot">
                        <div class="msg" id="formMsg"></div>
                        <div class="buttons">
                            <button class="save ideabutton" id="formButtonSave">
                                <i class="fas fa-save"></i>
                                <span>Guardar</span>
                            </button>
                            <button class="cancel ideabutton" id="formButtonCancel">
                                <i class="fas fa-window-close"></i>
                                <span>Cancelar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </section>

            <section class="ideamodal" id="sectionModal">
                <div class="ideaconfirm">
                    <div class="head">
                        <p class="msg">¿Esta seguro de eliminar este dato?</p>
                        <button id="modalClose"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="foot">
                        <button class="cancel ideabutton" id="modalNo">
                            <i class="fas fa-window-close"></i>
                            <span>Cancelar</span>
                        </button>
                        <button class="delete ideabutton" id="modalYes">
                            <i class="fas fa-trash-alt"></i>
                            <span>Eliminar</span>
                        </button>
                    </div>
                </div>
            </section>

            <section><?php include('./view/component/Finger.panel.php') ?></section>

        </page>

    </content>

</body>

<foot>
    <?php include('./view/component/foot.php') ?>
    <script src="<?= $proyect['root'] ?>control/library/validacion.js"></script>
    <script src="<?= $proyect['root'] ?>control/script/usuario.js"></script>
    <script src="<?= $proyect['root'] ?>control/script/Finger.panel.js"></script>
</foot>

</html>