let UsuarioMain = () => {
    Usuario.crud.select();
    Usuario.crud.selectPrivilegio();
    Usuario.crud.selectDepartamento();
    Usuario.crud.selectHorario();
    Usuario.view.inputNewButton.onclick = () => Usuario.fun.showForm(true, 0);
    Usuario.view.formButtonCancel.onclick = () => Usuario.fun.showForm(false, 0);
    Usuario.view.formButtonSave.onclick = () => Usuario.fun.submitForm();
    Usuario.view.modalNo.onclick = () => Usuario.fun.showConfirm(false, null);
    Usuario.view.modalClose.onclick = () => Usuario.fun.showConfirm(false, null);
    Usuario.view.inputSearch.onkeyup = () => Usuario.fun.search();
    Usuario.view.buttonShowPass.onclick = () => Usuario.fun.showPass();
}

let Usuario = {
    databaseUsuario: [],
    view: {
        sectionHead: document.getElementById("sectionHead"),
        selectReport: document.getElementById("selectReport"),
        inputSearch: document.getElementById("inputSearch"),
        inputNewButton: document.getElementById("inputNewButton"),
        sectionTable: document.getElementById("sectionTable"),
        tableData: document.getElementById("tableData"),
        sectionForm: document.getElementById("sectionForm"),
        formData: document.getElementById("formData"),
        formButtonSave: document.getElementById("formButtonSave"),
        formButtonCancel: document.getElementById("formButtonCancel"),
        formMsg: document.getElementById("formMsg"),
        sectionModal: document.getElementById("sectionModal"),
        modalText: document.getElementById("modalText"),
        modalClose: document.getElementById("modalClose"),
        modalNo: document.getElementById("modalNo"),
        modalYes: document.getElementById("modalYes"),
        field_password: document.getElementById("field_password"),
        buttonShowPass: document.getElementById("buttonShowPass")
    },
    crud: {
        select: () => {
            fetch_query(null, "usuario", "select").then(res => {
                Usuario.databaseUsuario = res;
                Usuario.fun.loadTable(res);
                Usuario.fun.showForm(false, 0);
            }).catch(res => console.log("Error de conexión: " + res));
        },
        insert: () => {
            let formData = new FormData(Usuario.view.formData);
            fetch_query(formData, "usuario", "insert").then(res => {
                Usuario.crud.select();
            }).catch(res => console.log("Error de conexión: " + res));
        },
        update: () => {
            let formData = new FormData(Usuario.view.formData);
            fetch_query(formData, "usuario", "update").then(res => {
                Usuario.crud.select();
            }).catch(res => console.log("Error de conexión: " + res));
        },
        delete: (usuario_id) => {
            let formData = new FormData(Usuario.view.formData);
            formData.append("usuario_id", usuario_id);
            fetch_query(formData, "usuario", "delete").then(res => {
                Usuario.crud.select();
            }).catch(res => console.log("Error de conexión: " + res));
        },
        selectPrivilegio: () => {
            fetch_query(null, "privilegio", "select").then(res => {
                let html = '<option value="">Selecciona un perfil</option>';
                for (let i of res) {
                    html += `<option value="${ i.privilegio_id }">${ i.privilegio_nombre }</option>`;
                }
                Usuario.view.formData.privilegio_id.innerHTML = html;
            }).catch(res => console.log("Error de conexión: " + res));
        },
        selectDepartamento: () => {
            fetch_query(null, "departamento", "select").then(res => {
                let html = '<option value="">Selecciona un cargo</option>';
                for (let i of res) {
                    html += `<option value="${ i.departamento_id }">${ i.departamento_nombre }</option>`;
                }
                Usuario.view.formData.departamento_id.innerHTML = html;
            }).catch(res => console.log("Error de conexión: " + res));
        },
        selectHorario: () => {
            fetch_query(null, "horario", "select").then(res => {
                let html = '<option value="">Selecciona un cargo</option>';
                for (let i of res) {
                    html += `<option value="${ i.horario_id }">${ i.horario_nombre }</option>`;
                }
                Usuario.view.formData.horario_id.innerHTML = html;
            }).catch(res => console.log("Error de conexión: " + res));
        }
    },
    fun: {
        loadTable: (array) => {
            let html = '';
            for (let i of array) {
                html += `
                    <tr>
                        <td>
                            ${ i.usuario_foto == null ? `
                                <img src="view/img/user.png" class="td-photo" />
                            ` : `
                                <img src="view/file/usuario_foto/${ i.usuario_foto }?date=${ $dateTime }"" class="td-photo" />
                            ` }
                        </td>
                        <td>
                            <span class="td-span state ${ i.usuario_estado == 1 ? "active" : "" }">${ i.usuario_estado == 1 ? "Activo" : "Inactivo" }</span>
                        </td>
                        <td><span class="td-span">${ i.usuario_nombre }</span></td>
                        <td><span class="td-span">${ i.departamento_nombre }</span></td>
                        <td><span class="td-span">${ i.horario_nombre }</span></td>
                        <td><span class="td-span">${ i.privilegio_nombre }</span></td>
                        <td class="td-action">
                            <div class="buttons-flex">
                                <button class="finger ideabutton" onclick="FingerPanel.fun.ws_connect(${ i.usuario_id })">
                                    <i class="fas fa-fingerprint"></i>
                                    <span>Huella</span>
                                </button>
                                <button class="edit ideabutton" onclick="Usuario.fun.showForm(true, ${ i.usuario_id })">
                                    <i class="fas fa-edit"></i>
                                    <span>Editar</span>
                                </button>
                                <button class="delete ideabutton" onclick="Usuario.fun.showConfirm(true, () => Usuario.crud.delete(${ i.usuario_id }))">
                                    <i class="fas fa-trash-alt"></i>
                                    <span>Eliminar</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }
            Usuario.view.tableData.innerHTML = html;
        },
        showForm: (bool, usuario_id) => {
            if (bool) {
                Usuario.view.sectionHead.classList.remove("open");
                Usuario.view.sectionTable.classList.remove("open");
                Usuario.view.sectionModal.classList.remove("open");
                Usuario.view.sectionForm.classList.add("open");
                if (usuario_id != 0) {
                    let usuario = Usuario.databaseUsuario.find(element => element.usuario_id == usuario_id);
                    Usuario.view.formData.usuario_id.value = usuario.usuario_id;
                    Usuario.view.formData.usuario_nombre.value = usuario.usuario_nombre;
                    Usuario.view.formData.usuario_email.value = usuario.usuario_email;
                    // Usuario.view.formData.usuario_pass.value = usuario.usuario_pass;
                    // Usuario.view.formData.usuario_foto.value = usuario.usuario_foto;
                    Usuario.view.formData.usuario_cedula.value = usuario.usuario_cedula;
                    Usuario.view.formData.usuario_estado.value = usuario.usuario_estado;
                    // Usuario.view.formData.usuario_huella.value = usuario.usuario_huella;
                    Usuario.view.formData.usuario_createat.value = usuario.usuario_createat;
                    Usuario.view.formData.privilegio_id.value = usuario.privilegio_id;
                    Usuario.view.formData.departamento_id.value = usuario.departamento_id;
                    Usuario.view.formData.horario_id.value = usuario.horario_id;
                    Usuario.view.field_password.innerHTML = `Cambiar contraseña:`;
                }
            } else {
                Usuario.view.sectionHead.classList.add("open");
                Usuario.view.sectionTable.classList.add("open");
                Usuario.view.sectionModal.classList.remove("open");
                Usuario.view.sectionForm.classList.remove("open");
                Usuario.view.field_password.innerHTML = `Contraseña<b>*</b>:`;
                Usuario.fun.clearForm();
            }
        },
        submitForm: () => {
            let form = Usuario.view.formData;
            if (
                form.usuario_nombre.value == "" ||
                form.usuario_email.value == "" ||
                form.usuario_cedula.value == "" ||
                form.usuario_estado.value == "" ||
                // form.usuario_huella.value == "" ||
                form.privilegio_id.value == "" ||
                form.departamento_id.value == "" ||
                form.horario_id.value == ""
            ) {
                Usuario.fun.showMsg("Debe llenar todos los campos!");
                return;
            } else if (form.usuario_pass.value == "" && form.usuario_id.value == 0) {
                Usuario.fun.showMsg("Llene el campo contraseña!");
                return;
            }
            if (form.usuario_id.value == 0) {
                Usuario.crud.insert();
            } else {
                Usuario.crud.update();
            }
        },
        search: () => {
            let txt = Usuario.view.inputSearch.value.toLowerCase();
            if (txt.trim() == "") {
                Usuario.fun.loadTable(Usuario.databaseUsuario);
            } else {
                let array = [];
                for (let i of Usuario.databaseUsuario) {
                    if (
                        txt == i.usuario_nombre.substring(0, txt.length).toLowerCase() ||
                        txt == i.departamento_nombre.substring(0, txt.length).toLowerCase() ||
                        txt == i.horario_nombre.substring(0, txt.length).toLowerCase() ||
                        txt == i.privilegio_nombre.substring(0, txt.length).toLowerCase()
                    ) {
                        array.push(i);
                    }
                }
                Usuario.fun.loadTable(array);
            }
        },
        // CAPSULA DE FUNCIONES
        clearForm: () => {
            Usuario.view.formData.horario_id.value = 0;
            Usuario.view.formData.usuario_nombre.value = "";
            Usuario.view.formData.usuario_email.value = "";
            Usuario.view.formData.usuario_pass.value = "";
            Usuario.view.formData.usuario_foto.value = "";
            Usuario.view.formData.usuario_cedula.value = "";
            Usuario.view.formData.usuario_estado.value = "";
            // Usuario.view.formData.usuario_huella.value = "";
            Usuario.view.formData.usuario_createat.value = "";
            Usuario.view.formData.privilegio_id.value = "";
            Usuario.view.formData.departamento_id.value = "";
            Usuario.view.formData.horario_id.value = "";
        },
        showMsg: (txt) => {
            Usuario.view.formMsg.innerText = txt;
            setTimeout(() => {
                Usuario.view.formMsg.innerText = "";
            }, 1000);
        },
        showConfirm: (bool, action) => {
            if (bool) {
                Usuario.view.sectionModal.classList.add("open");
                Usuario.view.modalYes.onclick = () => action();
            } else {
                Usuario.view.sectionModal.classList.remove("open");
            }
        },

        showPass: () => {
            if (Usuario.view.formData.usuario_pass.type == "password") {
                Usuario.view.formData.usuario_pass.type = "text";
                Usuario.view.buttonShowPass.classList.add("show");
            } else {
                Usuario.view.formData.usuario_pass.type = "password";
                Usuario.view.buttonShowPass.classList.remove("show");
            }
        }
    }
}

UsuarioMain();