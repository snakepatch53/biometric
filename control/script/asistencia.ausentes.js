const AsistenciaAusentesMain = () => {
    AsistenciaAusentes.view.search.onkeyup = () => AsistenciaAusentes.fun.search();
}

const AsistenciaAusentes = {
    view: {
        user_conteiner: document.getElementById("navigate-ausentes-user-conteiner"),
        search: document.getElementById("navigate-ausentes-search")
    },
    fun: {
        printHtml: (usuarioArray) => {
            let html = '';
            let cont = 0;
            for (let usuario of usuarioArray) {
                let asistencias = Asistencia.databaseAsistencia.filter(element =>
                    element.usuario_id == usuario.usuario_id &&
                    (element.asistencia_fecha_salida == null || element.asistencia_fecha_salida == "")
                );
                if (asistencias.length == 0) {
                    asistencias = Asistencia.databaseAsistencia.filter(element =>
                        element.usuario_id == usuario.usuario_id &&
                        element.asistencia_fecha_entrada != null &&
                        element.asistencia_fecha_entrada != "" &&
                        element.asistencia_fecha_salida != null &&
                        element.asistencia_fecha_salida != ""
                    );
                    let src_foto = `${ $root }view/img/user.png`;
                    let date_salida = 'Sin actividad';
                    if (asistencias.length > 0) {
                        let asistencia = asistencias[0];
                        for (let asistencia_tmp of asistencias) {
                            if (parseInt(asistencia_tmp.asistencia_id) > parseInt(asistencia.asistencia_id)) {
                                asistencia = asistencia_tmp;
                                console.log(asistencia);
                            }
                        }
                        if (asistencia.usuario_foto != null && asistencia.usuario_foto != "") {
                            src_foto = `${ $root }view/file/usuario_foto/${ asistencia.usuario_foto }`;
                        }
                        date_salida = asistencia.asistencia_fecha_salida;
                    }
                    html += `
                        <div class="item">
                            <img src="${ src_foto }" alt="user Photo">
                            <h3>${ usuario.usuario_nombre }</h3>
                            <label>
                                <b>Cargo: </b>
                                <span>${ usuario.privilegio_nombre }</span>
                            </label>
                            <label>
                                <b>Engresó: </b>
                                <span>${ date_salida }</span>
                            </label>
                            <button onclick="Asistencia.crud.check(${ usuario.usuario_id })">
                                <i class="fas fa-check"></i>
                                <span>Marcar entrada</span>
                            </button>
                        </div>
                    `;
                    cont++;
                }
            }
            if (cont == 0) {
                AsistenciaAusentes.view.user_conteiner.innerHTML = `
                    <h4>Todos se encuentran trabajando actualmente..</h4>
                `;
            } else {
                AsistenciaAusentes.view.user_conteiner.innerHTML = html;
            }
        },
        search: () => {
            let txt = AsistenciaAusentes.view.search.value.toLowerCase();
            if (txt.trim() == "") {
                AsistenciaAusentes.fun.printHtml(Asistencia.databaseUsuario);
            } else {
                let array = [];
                for (let i of Asistencia.databaseUsuario) {
                    if (txt == i.usuario_nombre.substring(0, txt.length).toLowerCase()) {
                        array.push(i);
                    }
                }
                AsistenciaAusentes.fun.printHtml(array);
            }
        }
    }
}

AsistenciaAusentesMain();