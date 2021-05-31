let PrivilegioMain = () => {
    Privilegio.crud.select();
    Privilegio.view.inputNewButton.onclick = () => Privilegio.fun.showForm(true, 0);
    Privilegio.view.formButtonCancel.onclick = () => Privilegio.fun.showForm(false, 0);
    Privilegio.view.formButtonSave.onclick = () => Privilegio.fun.submitForm();
    Privilegio.view.modalNo.onclick = () => Privilegio.fun.showConfirm(false, null);
    Privilegio.view.modalClose.onclick = () => Privilegio.fun.showConfirm(false, null);
    Privilegio.view.inputSearch.onkeyup = () => Privilegio.fun.search();
    Privilegio.fun.changeType(false);
    Privilegio.fun.eventChangeType();
}

let Privilegio = {
    databasePrivilegio: [],
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
        modalYes: document.getElementById("modalYes")
    },
    crud: {
        select: () => {
            fetch_query(null, "privilegio", "select").then(res => {
                Privilegio.databasePrivilegio = res;
                Privilegio.fun.loadTable(res);
                Privilegio.fun.showForm(false, 0);
            }).catch(res => console.log("Error de conexión: " + res));
        },
        insert: () => {
            let formData = new FormData(Privilegio.view.formData);
            fetch_query(formData, "privilegio", "insert").then(res => {
                Privilegio.crud.select();
            }).catch(res => console.log("Error de conexión: " + res));
        },
        update: () => {
            let formData = new FormData(Privilegio.view.formData);
            fetch_query(formData, "privilegio", "update").then(res => {
                Privilegio.crud.select();
            }).catch(res => console.log("Error de conexión: " + res));
        },
        delete: (privilegio_id) => {
            let formData = new FormData(Privilegio.view.formData);
            formData.append("privilegio_id", privilegio_id);
            fetch_query(formData, "privilegio", "delete").then(res => {
                Privilegio.crud.select();
            }).catch(res => console.log("Error de conexión: " + res));
        }
    },
    fun: {
        loadTable: (array) => {
            let html = '';
            for (let i of array) {
                html += `
                    <tr>
                        <td><span class="td-span">${ i.privilegio_nombre }</span></td>
                        <td class="td-action">
                            <div class="buttons-flex">
                                <button class="edit ideabutton" onclick="Privilegio.fun.showForm(true, ${ i.privilegio_id })">
                                    <i class="fas fa-edit"></i>
                                    <span>Editar</span>
                                </button>
                                <button class="delete ideabutton" onclick="Privilegio.fun.showConfirm(true, () => Privilegio.crud.delete(${ i.privilegio_id }))">
                                    <i class="fas fa-trash-alt"></i>
                                    <span>Eliminar</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }
            Privilegio.view.tableData.innerHTML = html;
        },
        showForm: (bool, privilegio_id) => {
            if (bool) {
                Privilegio.view.sectionHead.classList.remove("open");
                Privilegio.view.sectionTable.classList.remove("open");
                Privilegio.view.sectionModal.classList.remove("open");
                Privilegio.view.sectionForm.classList.add("open");
                if (privilegio_id != 0) {
                    let privilegio = Privilegio.databasePrivilegio.find(element => element.privilegio_id == privilegio_id);
                    Privilegio.view.formData.privilegio_id.value = privilegio.privilegio_id;
                    Privilegio.view.formData.privilegio_nombre.value = privilegio.privilegio_nombre;
                    Privilegio.view.formData.privilegio_descripcion.value = privilegio.privilegio_descripcion;
                    Privilegio.view.formData.privilegio_administrador.value = privilegio.privilegio_administrador;
                    Privilegio.view.formData.privilegio_informacion.value = privilegio.privilegio_informacion;
                    Privilegio.view.formData.privilegio_departamento.value = privilegio.privilegio_departamento;
                    Privilegio.view.formData.privilegio_horario.value = privilegio.privilegio_horario;
                    Privilegio.view.formData.privilegio_privilegio.value = privilegio.privilegio_privilegio;
                    Privilegio.view.formData.privilegio_usuario.value = privilegio.privilegio_usuario;
                    Privilegio.view.formData.privilegio_asistencia.value = privilegio.privilegio_asistencia;
                }
            } else {
                Privilegio.view.sectionHead.classList.add("open");
                Privilegio.view.sectionTable.classList.add("open");
                Privilegio.view.sectionModal.classList.remove("open");
                Privilegio.view.sectionForm.classList.remove("open");
                Privilegio.fun.clearForm();
            }
            Privilegio.view.formData.privilegio_administrador.value == true ? Privilegio.fun.changeType(true) : Privilegio.fun.changeType(false);
        },
        submitForm: () => {
            let form = Privilegio.view.formData;
            if (form.privilegio_nombre.value == "") {
                Privilegio.fun.showMsg("Ingrese el nombre!");
                return;
            }
            if (form.privilegio_id.value == 0) {
                Privilegio.crud.insert();
            } else {
                Privilegio.crud.update();
            }
        },
        search: () => {
            let txt = Privilegio.view.inputSearch.value.toLowerCase();
            if (txt.trim() == "") {
                Privilegio.fun.loadTable(Privilegio.databasePrivilegio);
            } else {
                let array = [];
                for (let i of Privilegio.databasePrivilegio) {
                    if (
                        txt == i.privilegio_nombre.substring(0, txt.length).toLowerCase() ||
                        txt == i.privilegio_descripcion.substring(0, txt.length).toLowerCase()
                    ) {
                        array.push(i);
                    }
                }
                Privilegio.fun.loadTable(array);
            }
        },
        // CAPSULA DE FUNCIONES
        clearForm: () => {
            Privilegio.view.formData.privilegio_id.value = 0;
            Privilegio.view.formData.privilegio_nombre.value = "";
            Privilegio.view.formData.privilegio_descripcion.value = "";
            Privilegio.view.formData.privilegio_administrador.value = 0;
            Privilegio.view.formData.privilegio_informacion.value = 0;
            Privilegio.view.formData.privilegio_departamento.value = 0;
            Privilegio.view.formData.privilegio_horario.value = 0;
            Privilegio.view.formData.privilegio_privilegio.value = 0;
            Privilegio.view.formData.privilegio_usuario.value = 0;
            Privilegio.view.formData.privilegio_asistencia.value = 0;
        },
        showMsg: (txt) => {
            Privilegio.view.formMsg.innerText = txt;
            setTimeout(() => {
                Privilegio.view.formMsg.innerText = "";
            }, 1000);
        },
        showConfirm: (bool, action) => {
            if (bool) {
                Privilegio.view.sectionModal.classList.add("open");
                Privilegio.view.modalYes.onclick = () => action();
            } else {
                Privilegio.view.sectionModal.classList.remove("open");
            }
        },
        changeType: (bool) => {
            if (bool == false) {
                Privilegio.view.formData.privilegio_informacion[0].parentElement.parentElement.parentElement.style.display = "none";
                Privilegio.view.formData.privilegio_departamento[0].parentElement.parentElement.parentElement.style.display = "none";
                Privilegio.view.formData.privilegio_horario[0].parentElement.parentElement.parentElement.style.display = "none";
                Privilegio.view.formData.privilegio_privilegio[0].parentElement.parentElement.parentElement.style.display = "none";
                Privilegio.view.formData.privilegio_usuario[0].parentElement.parentElement.parentElement.style.display = "none";
                Privilegio.view.formData.privilegio_asistencia[0].parentElement.parentElement.parentElement.style.display = "none";
            } else {
                Privilegio.view.formData.privilegio_informacion[0].parentElement.parentElement.parentElement.style.display = "flex";
                Privilegio.view.formData.privilegio_departamento[0].parentElement.parentElement.parentElement.style.display = "flex";
                Privilegio.view.formData.privilegio_horario[0].parentElement.parentElement.parentElement.style.display = "flex";
                Privilegio.view.formData.privilegio_privilegio[0].parentElement.parentElement.parentElement.style.display = "flex";
                Privilegio.view.formData.privilegio_usuario[0].parentElement.parentElement.parentElement.style.display = "flex";
                Privilegio.view.formData.privilegio_asistencia[0].parentElement.parentElement.parentElement.style.display = "flex";
            }
        },
        eventChangeType: () => {
            let radios = Privilegio.view.formData.privilegio_administrador;
            for (let i of radios) {
                i.onchange = (evt) => {
                    Privilegio.fun.changeType(evt.target.value);
                }
            }
        }
    }
}

PrivilegioMain();