let HorarioMain = () => {
    Horario.crud.select();
    Horario.view.inputNewButton.onclick = () => Horario.fun.showForm(true, 0);
    Horario.view.formButtonCancel.onclick = () => Horario.fun.showForm(false, 0);
    Horario.view.formButtonSave.onclick = () => Horario.fun.submitForm();
    Horario.view.modalNo.onclick = () => Horario.fun.showConfirm(false, null);
    Horario.view.modalClose.onclick = () => Horario.fun.showConfirm(false, null);
    Horario.view.inputSearch.onkeyup = () => Horario.fun.search();
}

let Horario = {
    databaseHorario: [],
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
            fetch_query(null, "horario", "select").then(res => {
                Horario.databaseHorario = res;
                Horario.fun.loadTable(res);
                Horario.fun.showForm(false, 0);
            }).catch(res => console.log("Error de conexión: " + res));
        },
        insert: () => {
            let formData = new FormData(Horario.view.formData);
            fetch_query(formData, "horario", "insert").then(res => {
                Horario.crud.select();
            }).catch(res => console.log("Error de conexión: " + res));
        },
        update: () => {
            let formData = new FormData(Horario.view.formData);
            fetch_query(formData, "horario", "update").then(res => {
                Horario.crud.select();
            }).catch(res => console.log("Error de conexión: " + res));
        },
        delete: (horario_id) => {
            let formData = new FormData(Horario.view.formData);
            formData.append("horario_id", horario_id);
            fetch_query(formData, "horario", "delete").then(res => {
                Horario.crud.select();
            }).catch(res => console.log("Error de conexión: " + res));
        }
    },
    fun: {
        loadTable: (array) => {
            let html = '';
            for (let i of array) {
                html += `
                    <tr>
                        <td><span class="td-span">${ i.horario_nombre }</span></td>
                        <td><span class="td-span"><i class="fas fa-clock"></i> ${ i.horario_entrada }</span></td>
                        <td><span class="td-span"><i class="fas fa-clock"></i> ${ i.horario_salida }</span></td>
                        <td class="td-action">
                            <div class="buttons-flex">
                                <button class="edit ideabutton" onclick="Horario.fun.showForm(true, ${ i.horario_id })">
                                    <i class="fas fa-edit"></i>
                                    <span>Editar</span>
                                </button>
                                <button class="delete ideabutton" onclick="Horario.fun.showConfirm(true, () => Horario.crud.delete(${ i.horario_id }))">
                                    <i class="fas fa-trash-alt"></i>
                                    <span>Eliminar</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }
            Horario.view.tableData.innerHTML = html;
        },
        showForm: (bool, horario_id) => {
            if (bool) {
                Horario.view.sectionHead.classList.remove("open");
                Horario.view.sectionTable.classList.remove("open");
                Horario.view.sectionModal.classList.remove("open");
                Horario.view.sectionForm.classList.add("open");
                if (horario_id != 0) {
                    let horario = Horario.databaseHorario.find(element => element.horario_id == horario_id);
                    Horario.view.formData.horario_id.value = horario.horario_id;
                    Horario.view.formData.horario_nombre.value = horario.horario_nombre;
                    Horario.view.formData.horario_entrada.value = horario.horario_entrada;
                    Horario.view.formData.horario_salida.value = horario.horario_salida;
                }
            } else {
                Horario.view.sectionHead.classList.add("open");
                Horario.view.sectionTable.classList.add("open");
                Horario.view.sectionModal.classList.remove("open");
                Horario.view.sectionForm.classList.remove("open");
                Horario.fun.clearForm();
            }
        },
        submitForm: () => {
            let form = Horario.view.formData;
            if (
                form.horario_nombre.value == "" ||
                form.horario_entrada.value == "" ||
                form.horario_salida.value == ""
            ) {
                Horario.fun.showMsg("Debe llenar todos los campos!");
                return;
            }
            if (form.horario_id.value == 0) {
                Horario.crud.insert();
            } else {
                Horario.crud.update();
            }
        },
        search: () => {
            let txt = Horario.view.inputSearch.value.toLowerCase();
            if (txt.trim() == "") {
                Horario.fun.loadTable(Horario.databaseHorario);
            } else {
                let array = [];
                for (let i of Horario.databaseHorario) {
                    if (
                        txt == i.horario_nombre.substring(0, txt.length).toLowerCase() ||
                        txt == i.horario_entrada.substring(0, txt.length).toLowerCase() ||
                        txt == i.horario_salida.substring(0, txt.length).toLowerCase()
                    ) {
                        array.push(i);
                    }
                }
                Horario.fun.loadTable(array);
            }
        },
        // CAPSULA DE FUNCIONES
        clearForm: () => {
            Horario.view.formData.horario_id.value = 0;
            Horario.view.formData.horario_nombre.value = "";
            Horario.view.formData.horario_entrada.value = "";
            Horario.view.formData.horario_salida.value = "";
        },
        showMsg: (txt) => {
            Horario.view.formMsg.innerText = txt;
            setTimeout(() => {
                Horario.view.formMsg.innerText = "";
            }, 1000);
        },
        showConfirm: (bool, action) => {
            if (bool) {
                Horario.view.sectionModal.classList.add("open");
                Horario.view.modalYes.onclick = () => action();
            } else {
                Horario.view.sectionModal.classList.remove("open");
            }
        }
    }
}

HorarioMain();