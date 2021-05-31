const AsistenciaPresentesMain = () => {
    AsistenciaPresentes.view.search.onkeyup = () => AsistenciaPresentes.fun.search();
}

const AsistenciaPresentes = {
    view: {
        user_conteiner: document.getElementById("navigate-presentes-user-conteiner"),
        search: document.getElementById("navigate-presentes-search")
    },
    fun: {
        printHtml: (arrayAsistencia) => {
            let html = '';
            let cont = 0;
            for (let i of arrayAsistencia) {
                if (i.asistencia_fecha_salida == null || i.asistencia_fecha_salida == "") {
                    let src_foto = `${ $root }view/img/user.png`;
                    if (i.usuario_foto != null && i.usuario_foto != "") {
                        src_foto = `${ $root }view/file/usuario_foto/${ i.usuario_foto }`;
                    }
                    html += `
                        <div class="item">
                            <img src="${ src_foto }" alt="user Photo">
                            <h3>${ i.usuario_nombre }</h3>
                            <label>
                                <b>Cargo: </b>
                                <span>${ i.privilegio_nombre }</span>
                            </label>
                            <label>
                                <b>Ingresó: </b>
                                <span>${ i.asistencia_fecha_entrada }</span>
                            </label>
                            <button onclick="Asistencia.crud.check(${ i.usuario_id })">
                                <i class="fas fa-times"></i>
                                <span>Marcar salida</span>
                            </button>
                        </div>
                    `;
                    cont++;
                }
            }
            if (cont == 0) {
                AsistenciaPresentes.view.user_conteiner.innerHTML = `
                    <h4>Nadie esta trabajando actualmente..</h4>
                `;
            } else {
                AsistenciaPresentes.view.user_conteiner.innerHTML = html;
            }
        },
        search: () => {
            let txt = AsistenciaPresentes.view.search.value.toLowerCase();
            if (txt.trim() == "") {
                AsistenciaPresentes.fun.printHtml(Asistencia.databaseAsistencia);
            } else {
                let array = [];
                for (let i of Asistencia.databaseAsistencia) {
                    if (txt == i.usuario_nombre.substring(0, txt.length).toLowerCase()) {
                        array.push(i);
                    }
                }
                AsistenciaPresentes.fun.printHtml(array);
            }
        }
    }
}

AsistenciaPresentesMain();