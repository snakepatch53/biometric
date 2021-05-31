let AsistenciaMain = () => {
    Asistencia.view.inputNewButton.onclick = () => Asistencia.fun.showForm(true, 0);
    Asistencia.view.formButtonCancel.onclick = () => Asistencia.fun.showForm(false, 0);
    Asistencia.view.formButtonSave.onclick = () => Asistencia.fun.submitForm();
    Asistencia.view.modalNo.onclick = () => Asistencia.fun.showConfirm(false, null);
    Asistencia.view.modalClose.onclick = () => Asistencia.fun.showConfirm(false, null);
    Asistencia.view.inputSearch.onkeyup = () => Asistencia.fun.search();
}

let Asistencia = {
    databaseAsistencia: [],
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
        modalYes: document.getElementById("modalYes")
    },
    crud: {
        select: async () => {
            await fetch_query(null, "asistencia", "select").then(res => {
                Asistencia.databaseAsistencia = res;
                Asistencia.fun.loadTable(res);
                Asistencia.fun.showForm(false, 0);
            }).catch(res => console.log("Error de conexión: " + res));
        },
        insert: () => {
            let formData = new FormData(Asistencia.view.formData);
            fetch_query(formData, "asistencia", "insert").then(res => {
                Asistencia.crud.select();
            }).catch(res => console.log("Error de conexión: " + res));
        },
        update: () => {
            let formData = new FormData(Asistencia.view.formData);
            fetch_query(formData, "asistencia", "update").then(res => {
                Asistencia.crud.select();
            }).catch(res => console.log("Error de conexión: " + res));
        },
        delete: (asistencia_id) => {
            let formData = new FormData(Asistencia.view.formData);
            formData.append("asistencia_id", asistencia_id);
            fetch_query(formData, "asistencia", "delete").then(res => {
                Asistencia.crud.select();
            }).catch(res => console.log("Error de conexión: " + res));
        },
        check: (usuario_id) => {
            let formData = new FormData();
            formData.append("usuario_id", usuario_id);
            fetch_query(formData, "asistencia", "check").then(res => {
                AsistenciaControlMain();
            }).catch(res => console.log("Error de conexión: " + res));
        },
        selectUsuario: async () => {
            await fetch_query(null, "usuario", "select").then(res => {
                Asistencia.databaseUsuario = res;
                let html = '<option value="">Selecciona un usuario</option>';
                for (let i of res) {
                    html += `<option value="${ i.usuario_id }">${ i.usuario_nombre }</option>`;
                }
                Asistencia.view.formData.usuario_id.innerHTML = html;
            }).catch(res => console.log("Error de conexión: " + res));
        }
    },
    fun: {
        loadTable: (array) => {
            let html = '';
            for (let i of array) {
                if (
                    i.asistencia_fecha_entrada != null &&
                    i.asistencia_fecha_entrada != "" &&
                    i.asistencia_fecha_salida != null &&
                    i.asistencia_fecha_salida != ""
                ) {
                    let dateTime_entrada = new Date(i.asistencia_fecha_entrada);
                    let time_entrada = `${ ("0" + dateTime_entrada.getHours()).slice(-2) }:${ ("0" + dateTime_entrada.getMinutes()).slice(-2) }:${ ("0" + dateTime_entrada.getSeconds()).slice(-2) }`;
                    let dateTime_salida = new Date(i.asistencia_fecha_salida);
                    let time_salida = `${ ("0" + dateTime_salida.getHours()).slice(-2) }:${ ("0" + dateTime_salida.getMinutes()).slice(-2) }:${ ("0" + dateTime_salida.getSeconds()).slice(-2) }`;
                    html += `
                        <tr>
                            <td><span class="td-span">${ i.usuario_nombre }</span></td>
                            <td><span class="td-span">${ i.asistencia_fecha_entrada }</span></td>
                            <td><span class="td-span">${ i.asistencia_fecha_salida }</span></td>
                            <td class="td-action">
                                <div class="buttons-flex">
                                    <button class="edit ideabutton" onclick="Asistencia.fun.showForm(true, ${ i.asistencia_id })">
                                        <i class="fas fa-edit"></i>
                                        <span>Editar</span>
                                    </button>
                                    <button class="delete ideabutton" onclick="Asistencia.fun.showConfirm(true, () => Asistencia.crud.delete(${ i.asistencia_id }))">
                                        <i class="fas fa-trash-alt"></i>
                                        <span>Eliminar</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                }
            }
            Asistencia.view.tableData.innerHTML = html;
        },
        showForm: (bool, asistencia_id) => {
            if (bool) {
                Asistencia.view.sectionHead.classList.remove("open");
                Asistencia.view.sectionTable.classList.remove("open");
                Asistencia.view.sectionModal.classList.remove("open");
                Asistencia.view.sectionForm.classList.add("open");
                if (asistencia_id != 0) {
                    let asistencia = Asistencia.databaseAsistencia.find(element => element.asistencia_id == asistencia_id);
                    Asistencia.view.formData.asistencia_id.value = asistencia.asistencia_id;
                    Asistencia.view.formData.usuario_id.value = asistencia.usuario_id;

                    let dateTime_entrada = new Date(asistencia.asistencia_fecha_entrada);
                    let time_entrada = `${ dateTime_entrada.getFullYear() }-${ ("0" + dateTime_entrada.getMonth()).slice(-2) }-${ ("0" + dateTime_entrada.getDay()).slice(-2) }T${ ("0" + dateTime_entrada.getHours()).slice(-2) }:${ ("0" + dateTime_entrada.getMinutes()).slice(-2) }`;
                    Asistencia.view.formData.asistencia_fecha_entrada.value = time_entrada;

                    let dateTime_salida = new Date(asistencia.asistencia_fecha_salida);
                    let time_salida = `${ dateTime_salida.getFullYear() }-${ ("0" + dateTime_salida.getMonth()).slice(-2) }-${ ("0" + dateTime_salida.getDay()).slice(-2) }T${ ("0" + dateTime_salida.getHours()).slice(-2) }:${ ("0" + dateTime_salida.getMinutes()).slice(-2) }`;
                    Asistencia.view.formData.asistencia_fecha_salida.value = time_salida;
                }
            } else {
                Asistencia.view.sectionHead.classList.add("open");
                Asistencia.view.sectionTable.classList.add("open");
                Asistencia.view.sectionModal.classList.remove("open");
                Asistencia.view.sectionForm.classList.remove("open");
                Asistencia.fun.clearForm();
            }
        },
        submitForm: () => {
            let form = Asistencia.view.formData;
            if (
                form.usuario_id.value == "" ||
                form.asistencia_fecha_entrada.value == "" ||
                form.asistencia_fecha_salida.value == ""
            ) {
                Asistencia.fun.showMsg("Debe llenar todos los campos!");
                return;
            }
            if (form.asistencia_id.value == 0) {
                Asistencia.crud.insert();
            } else {
                Asistencia.crud.update();
            }
        },
        search: () => {
            let txt = Asistencia.view.inputSearch.value.toLowerCase();
            if (txt.trim() == "") {
                Asistencia.fun.loadTable(Asistencia.databaseAsistencia);
            } else {
                let array = [];
                for (let i of Asistencia.databaseAsistencia) {
                    if (
                        txt == i.asistencia_fecha_entrada.substring(0, txt.length).toLowerCase() ||
                        txt == i.asistencia_fecha_salida.substring(0, txt.length).toLowerCase() ||
                        txt == i.usuario_nombre.substring(0, txt.length).toLowerCase()
                    ) {
                        array.push(i);
                    }
                }
                Asistencia.fun.loadTable(array);
            }
        },
        // CAPSULA DE FUNCIONES
        clearForm: () => {
            Asistencia.view.formData.asistencia_id.value = 0;
            Asistencia.view.formData.asistencia_fecha_entrada.value = "";
            Asistencia.view.formData.asistencia_fecha_salida.value = "";
            Asistencia.view.formData.usuario_id.value = "";
        },
        showMsg: (txt) => {
            Asistencia.view.formMsg.innerText = txt;
            setTimeout(() => {
                Asistencia.view.formMsg.innerText = "";
            }, 1000);
        },
        showConfirm: (bool, action) => {
            if (bool) {
                Asistencia.view.sectionModal.classList.add("open");
                Asistencia.view.modalYes.onclick = () => action();
            } else {
                Asistencia.view.sectionModal.classList.remove("open");
            }
        }
    }
}

AsistenciaMain();