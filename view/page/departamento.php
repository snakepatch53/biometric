<?php
if (empty($proyect)) {
    header("location:/");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include('./view/component/head.php') ?>
    <title>Panel - Departamentos</title>
    <link rel="stylesheet" href="<?= $proyect['root'] ?>view/css/table.css">
    <link rel="stylesheet" href="<?= $proyect['root'] ?>view/css/departamento.css">
</head>

<body>
    <div class="state open" id="tool_toggle_menu"></div>
    <header> <?php include('./view/component/header.php') ?> </header>

    <content>
        <tool> <?php include('./view/component/tool.php') ?> </tool>

        <page>


            <section class="head ideasection open" id="sectionHead">
                <h3 class="tittle"><i class="fas fa-hospital-alt"></i> <span>Departamentos</span></h3>
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
                                <th>Nombre</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="tableData"></tbody>
                    </table>
                </div>
            </section>

            <section class="ideasection" id="sectionForm">
                <form class="ideaform" action="#" method="POST" onsubmit="return false" id="formData">
                    <input type="hidden" name="departamento_id" value="0">
                    <input type="hidden" name="departamento_createat" value="<?= $date ?>">
                    <div class="body">
                        <div class="campo">
                            <span>Nombre<b>*</b>:</span>
                            <input type="text" name="departamento_nombre" placeholder="Nombre">
                        </div>
                        <div class="campo">
                            <span>Descripción:</span>
                            <input type="text" name="departamento_descripcion" placeholder="Descripción">
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

        </page>

    </content>

</body>

<foot>
    <?php include('./view/component/foot.php') ?>
    <script src="<?= $proyect['root'] ?>control/library/validacion.js"></script>
    <script src="<?= $proyect['root'] ?>control/script/departamento.js"></script>
</foot>

</html>