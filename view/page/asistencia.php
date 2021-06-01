<?php
if (empty($proyect)) {
    header("location:/");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include('./view/component/head.php') ?>
    <title>Panel - Asistencia</title>
    <link rel="stylesheet" href="<?= $proyect['root'] ?>view/css/table.css">
    <link rel="stylesheet" href="<?= $proyect['root'] ?>view/css/asistencia.css">
    <link rel="stylesheet" href="<?= $proyect['root'] ?>view/css/asistencia.presentes.css">
    <link rel="stylesheet" href="<?= $proyect['root'] ?>view/css/asistencia.ausentes.css">
    <link rel="stylesheet" href="<?= $proyect['root'] ?>view/css/asistencia.reportes.css">
    <link rel="stylesheet" href="<?= $proyect['root'] ?>view/css/asistencia.control.css">
</head>

<body>
    <div class="state open" id="tool_toggle_menu"></div>
    <header> <?php include('./view/component/header.php') ?> </header>

    <content>
        <tool> <?php include('./view/component/tool.php') ?> </tool>

        <page>

            <div class="_asistencia" id="nav-control"></div>

            <section class="menu_navigate">
                <button id="button-navigate-asistencia"><i class="fas fa-check-circle"></i><span>Registro</span></button>
                <button id="button-navigate-reportes"><i class="fas fa-file-pdf"></i><span>Reportes</span></button>
                <button id="button-navigate-presentes"><i class="fas fa-user-tie"></i><span>Presentes</span></button>
                <button id="button-navigate-ausentes"><i class="fas fa-user-slash"></i><span>Ausentes</span></button>
            </section>

            <div class="navigate-asistencia">
                <section class="head ideasection open" id="sectionHead">
                    <h3 class="tittle"><i class="fas fa-check-circle"></i> <span>Registro</span></h3>
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
                                    <th><i class="fas fa-user-tie"></i> Usuario</th>
                                    <th><i class="fas fa-clock"></i> Ingreso</th>
                                    <th><i class="fas fa-clock"></i> Egreso</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="tableData"></tbody>
                        </table>
                    </div>
                </section>

                <section class="ideasection" id="sectionForm">
                    <form class="ideaform" action="#" method="POST" onsubmit="return false" id="formData">
                        <input type="hidden" name="asistencia_id" value="0">
                        <input type="hidden" name="asistencia_createat" value="<?= $date ?>">
                        <div class="body">
                            <div class="campo">
                                <span><i class="fas fa-users-cog"></i> Usuario<b>*</b>:</span>
                                <select name="usuario_id"></select>
                            </div>
                            <div class="campo">
                                <span>Ingreso<b>*</b>:</span>
                                <input type="datetime-local" name="asistencia_fecha_entrada" placeholder="Ingreso">
                            </div>
                            <div class="campo">
                                <span>Egreso<b>*</b>:</span>
                                <input type="datetime-local" name="asistencia_fecha_salida" placeholder="Egreso">
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
            </div>

            <form class="navigate-reportes" target="_blank" method="GET" action="<?= $proyect['root'] ?>model/script/asistencia/reporte.php">
                <section class="head ideasection open generar-form">
                    <div class="search ideasearch">
                        <span>Desde: </span>
                        <div class="content">
                            <input type="date" name="reporte_desde">
                        </div>
                    </div>
                    <div class="search ideasearch">
                        <span>Hasta: </span>
                        <div class="content">
                            <input type="date" name="reporte_hasta">
                        </div>
                    </div>
                    <div class="search ideasearch">
                        <span>Buscar: </span>
                        <div class="content">
                            <input type="search" placeholder="Busca un usuario.." id="navigate-reportes-input-search">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    <button type="submit" class="ideabutton generar" id="">
                        <i class="fas fa-file-pdf"></i>
                        <span>Generar Reporte</span>
                    </button>
                </section>

                <section class="head ideasection open">
                    <b></b>
                    <b></b>
                    <button type="button" class="ideabutton desmarcar" id="navigate-reportes-button-desmarcar">
                        <i class="far fa-check-square"></i>
                        <span>Desmarcar Todos</span>
                    </button>
                    <button type="button" class="ideabutton marcar" id="navigate-reportes-button-marcar">
                        <i class="fas fa-check-square"></i>
                        <span>Marcar Todos</span>
                    </button>
                </section>

                <section class="table ideasection open">
                    <div class="content_table ideatable">
                        <table border="1">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-user-tie"></i> Usuario</th>
                                    <th><i class="fas fa-check-square"></i> Selección</th>
                                </tr>
                            </thead>
                            <tbody id="navigate-reportes-table"></tbody>
                        </table>
                    </div>
                </section>
            </form>

            <div class="navigate-presentes">
                <section class="head ideasection open">
                    <h3 class="tittle"><i class="fas fa-user-tie"></i> <span>Presentes</span></h3>
                    <div class="search ideasearch">
                        <span>Buscar: </span>
                        <div class="content">
                            <i class="fas fa-search"></i>
                            <input type="search" placeholder="Busca un empleado.." id="navigate-presentes-search">
                        </div>
                    </div>
                </section>
                <section class="table ideasection open user-container" id="navigate-presentes-user-conteiner"></section>
            </div>

            <div class="navigate-ausentes">
                <section class="head ideasection open">
                    <h3 class="tittle"><i class="fas fa-user-slash"></i> <span>Ausentes</span></h3>
                    <div class="search ideasearch">
                        <span>Buscar: </span>
                        <div class="content">
                            <i class="fas fa-search"></i>
                            <input type="search" placeholder="Busca un empleado.." id="navigate-ausentes-search">
                        </div>
                    </div>
                </section>
                <section class="table ideasection open user-container" id="navigate-ausentes-user-conteiner"></section>
            </div>

        </page>

    </content>

</body>

<foot>
    <?php include('./view/component/foot.php') ?>
    <script src="<?= $proyect['root'] ?>control/library/validacion.js"></script>
    <script src="<?= $proyect['root'] ?>control/script/asistencia.js"></script>
    <script src="<?= $proyect['root'] ?>control/script/asistencia.presentes.js"></script>
    <script src="<?= $proyect['root'] ?>control/script/asistencia.ausentes.js"></script>
    <script src="<?= $proyect['root'] ?>control/script/asistencia.reportes.js"></script>
    <script src="<?= $proyect['root'] ?>control/script/asistencia.control.js"></script>
</foot>

</html>