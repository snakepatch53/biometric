const AsistenciaReportesMain = () => {
    AsistenciaReportes.view.button_desmarcar.onclick = () => AsistenciaReportes.fun.checkAll(false);
    AsistenciaReportes.view.button_marcar.onclick = () => AsistenciaReportes.fun.checkAll(true);
    AsistenciaReportes.view.search.onkeyup = () => AsistenciaReportes.fun.search();
}

const AsistenciaReportes = {
    view: {
        button_desmarcar: document.getElementById("navigate-reportes-button-desmarcar"),
        button_marcar: document.getElementById("navigate-reportes-button-marcar"),
        table: document.getElementById("navigate-reportes-table"),
        search: document.getElementById("navigate-reportes-input-search")
    },
    fun: {
        checkAll: (bool) => {
            let checks = document.querySelectorAll(".navigate-reportes-check");
            for (let i of checks) {
                i.checked = bool;
            }
        },
        printHtml: (ArrayUsuario) => {
            let html = '';
            for (let i of ArrayUsuario) {
                html += `
                    <tr>
                        <td>
                            <label for="usuario_check_${ i.usuario_id }" class="td-span">${ i.usuario_nombre }</label>
                        </td>
                        <td>
                            <label for="usuario_check_${ i.usuario_id}" class="td-action">
                                <input type="checkbox" name="usuario_check[]" value="${ i.usuario_id }" id="usuario_check_${ i.usuario_id }" class="navigate-reportes-check">
                            </label>
                        </td>
                    </tr>
                `;
            }
            AsistenciaReportes.view.table.innerHTML = html;
        },
        search: () => {
            let txt = AsistenciaReportes.view.search.value.toLowerCase();
            if (txt.trim() == "") {
                AsistenciaReportes.fun.printHtml(Asistencia.databaseUsuario);
            } else {
                let array = [];
                for (let i of Asistencia.databaseUsuario) {
                    if (txt == i.usuario_nombre.substring(0, txt.length).toLowerCase()) {
                        array.push(i);
                    }
                }
                AsistenciaReportes.fun.printHtml(array);
            }
        }
    }
}

AsistenciaReportesMain();