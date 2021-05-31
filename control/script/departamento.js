let DepartamentoMain = () => {
    Departamento.crud.select();
    Departamento.view.inputNewButton.onclick = () => Departamento.fun.showForm(true, 0);
    Departamento.view.formButtonCancel.onclick = () => Departamento.fun.showForm(false, 0);
    Departamento.view.formButtonSave.onclick = () => Departamento.fun.submitForm();
    Departamento.view.modalNo.onclick = () => Departamento.fun.showConfirm(false, null);
    Departamento.view.modalClose.onclick = () => Departamento.fun.showConfirm(false, null);
    Departamento.view.inputSearch.onkeyup = () => Departamento.fun.search();
}

let Departamento = {
    databaseDepartamento: [],
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
            fetch_query(null, "departamento", "select").then(res => {
                Departamento.databaseDepartamento = res;
                Departamento.fun.loadTable(res);
                Departamento.fun.showForm(false, 0);
            }).catch(res => console.log("Error de conexión: " + res));
        },
        insert: () => {
            let formData = new FormData(Departamento.view.formData);
            fetch_query(formData, "departamento", "insert").then(res => {
                Departamento.crud.select();
            }).catch(res => console.log("Error de conexión: " + res));
        },
        update: () => {
            let formData = new FormData(Departamento.view.formData);
            fetch_query(formData, "departamento", "update").then(res => {
                Departamento.crud.select();
            }).catch(res => console.log("Error de conexión: " + res));
        },
        delete: (departamento_id) => {
            let formData = new FormData(Departamento.view.formData);
            formData.append("departamento_id", departamento_id);
            fetch_query(formData, "departamento", "delete").then(res => {
                Departamento.crud.select();
            }).catch(res => console.log("Error de conexión: " + res));
        }
    },
    fun: {
        loadTable: (array) => {
            let html = '';
            for (let i of array) {
                html += `
                    <tr>
                        <td><span class="td-span">${ i.departamento_nombre }</span></td>
                        <td class="td-action">
                            <div class="buttons-flex">
                                <button class="edit ideabutton" onclick="Departamento.fun.showForm(true, ${ i.departamento_id })">
                                    <i class="fas fa-edit"></i>
                                    <span>Editar</span>
                                </button>
                                <button class="delete ideabutton" onclick="Departamento.fun.showConfirm(true, () => Departamento.crud.delete(${ i.departamento_id }))">
                                    <i class="fas fa-trash-alt"></i>
                                    <span>Eliminar</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }
            Departamento.view.tableData.innerHTML = html;
        },
        showForm: (bool, departamento_id) => {
            if (bool) {
                Departamento.view.sectionHead.classList.remove("open");
                Departamento.view.sectionTable.classList.remove("open");
                Departamento.view.sectionModal.classList.remove("open");
                Departamento.view.sectionForm.classList.add("open");
                if (departamento_id != 0) {
                    let departamento = Departamento.databaseDepartamento.find(element => element.departamento_id == departamento_id);
                    Departamento.view.formData.departamento_id.value = departamento.departamento_id;
                    Departamento.view.formData.departamento_nombre.value = departamento.departamento_nombre;
                    Departamento.view.formData.departamento_descripcion.value = departamento.departamento_descripcion;
                }
            } else {
                Departamento.view.sectionHead.classList.add("open");
                Departamento.view.sectionTable.classList.add("open");
                Departamento.view.sectionModal.classList.remove("open");
                Departamento.view.sectionForm.classList.remove("open");
                Departamento.fun.clearForm();
            }
        },
        submitForm: () => {
            let form = Departamento.view.formData;
            if (form.departamento_nombre.value == "") {
                Departamento.fun.showMsg("Debe llenar todos los campos!");
                return;
            }
            if (form.departamento_id.value == 0) {
                Departamento.crud.insert();
            } else {
                Departamento.crud.update();
            }
        },
        search: () => {
            let txt = Departamento.view.inputSearch.value.toLowerCase();
            if (txt.trim() == "") {
                Departamento.fun.loadTable(Departamento.databaseDepartamento);
            } else {
                let array = [];
                for (let i of Departamento.databaseDepartamento) {
                    if (
                        txt == i.departamento_nombre.substring(0, txt.length).toLowerCase() ||
                        txt == i.departamento_user.substring(0, txt.length).toLowerCase()
                    ) {
                        array.push(i);
                    }
                }
                Departamento.fun.loadTable(array);
            }
        },
        // CAPSULA DE FUNCIONES
        clearForm: () => {
            Departamento.view.formData.departamento_id.value = 0;
            Departamento.view.formData.departamento_nombre.value = "";
            Departamento.view.formData.departamento_descripcion.value = "";
        },
        showMsg: (txt) => {
            Departamento.view.formMsg.innerText = txt;
            setTimeout(() => {
                Departamento.view.formMsg.innerText = "";
            }, 1000);
        },
        showConfirm: (bool, action) => {
            if (bool) {
                Departamento.view.sectionModal.classList.add("open");
                Departamento.view.modalYes.onclick = () => action();
            } else {
                Departamento.view.sectionModal.classList.remove("open");
            }
        }
    }
}

DepartamentoMain();