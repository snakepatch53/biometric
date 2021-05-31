const FingerCheckMain = () => {
    window.onload = () => {
        FingerCheck.fun.ws_connect();
    }

    // key comands
    window.onkeyup = (event) => {
        // Open login
        if (event.keyCode == 190 && event.ctrlKey) {
            window.location.href = `${ $root }login`;
        }
    }
}

const FingerCheck = {
    ws_host: "ws://127.0.0.1:2015",
    ws_connection: null,
    ws_mode: 0, // 0 = ninguno || 1 = Modo confirmacion || 2 = modo validate
    databaseUsuario: [],
    view: {
        fingermode: document.getElementById("fingermode"),
        fingercheck: document.getElementById("fingercheck"),
        fingercheck_img_container: document.getElementById("fingercheck_img_container"),
        fingercheck_img: document.getElementById("fingercheck_img"),
        fingercheck_icon: document.getElementById("fingercheck_icon"),
        fingercheck_text: document.getElementById("fingercheck_text")
    },
    crud: {
        check: async (usuario_id) => {
            let formData = new FormData();
            formData.append("usuario_id", usuario_id);
            return await fetch_query(formData, "asistencia", "check").then(async (res) => {
                return await res;
            }).catch(res => console.log("Error de conexión: " + res));
        },
    },
    fun: {
        ws_connect: () => {
            try {
                if (FingerCheck.ws_connection == null) {
                    FingerCheck.ws_connection = new WebSocket(FingerCheck.ws_host);
                }
                FingerCheck.ws_connection.onopen = () => {
                    try {
                        FingerCheck.fun.onmessage();
                        FingerCheck.fun.validate();
                    } catch (ex) {}
                }
                FingerCheck.ws_connection.onclose = () => {
                    FingerCheck.fun.loadDesconnect();
                }
                FingerCheck.ws_connection.onerror = () => {
                    FingerCheck.fun.loadDesconnect();
                }
            } catch (ex) {
                FingerCheck.fun.loadDesconnect();
            }
        },
        onmessage: () => {
            FingerCheck.ws_connection.onmessage = function (evt) {
                var msg = (evt.data);
                // console.log(msg);
                if (FingerCheck.ws_mode == 0 && msg == "false") {
                    FingerCheck.fun.loadDesconnect();
                }
                if (FingerCheck.ws_mode == 1 && msg == "true") {
                    FingerCheck.ws_mode = 2;
                } else if (FingerCheck.ws_mode == 2) {
                    FingerCheck.fun.loadConnect(msg);
                }
            }
        },
        validate: () => {
            FingerCheck.ws_mode = 1;
            FingerCheck.ws_connection.send(JSON.stringify({
                type: "validate",
                db_host: $proyect.db_host + "",
                db_user: $proyect.db_user + "",
                db_pass: $proyect.db_pass + "",
                db_name: $proyect.db_name + "",
                db_table_id: "0",
                db_table_name: "usuario",
                db_table_key_id: "usuario_id",
                db_table_key_huella: "usuario_huella"
            }));
            FingerCheck.view.fingermode.classList.remove("error");
        },
        loadDesconnect: () => {
            FingerCheck.ws_connection = null;
            FingerCheck.usuario = null;
            FingerCheck.ws_mode = 0;
            FingerCheck.view.fingermode.classList.add("error");
            setInterval(() => {
                FingerCheck.fun.ws_connect();
            }, 5000);
        },
        loadConnect: async (usuario_id) => {
            let usuario = false;
            if (usuario_id != 0) {
                usuario = await FingerCheck.crud.check(usuario_id);
            }
            if (usuario != false) {
                let src = $root + "view/img/user.png";
                if (usuario.usuario_foto != "" && usuario.usuario_foto != null) {
                    src = $root + "view/file/usuario_foto/" + usuario.usuario_foto;
                    FingerCheck.view.fingercheck_img_container.classList.add("foto");
                    FingerCheck.view.fingercheck_img.src = src;
                } else {
                    FingerCheck.view.fingercheck_icon.style.color = "var(--success)";
                }
                FingerCheck.view.fingercheck_text.style.color = "#fff";
                if (usuario.asistencia_ingreso == true) {
                    let dateTime = new Date(usuario.asistencia_fecha_entrada);
                    let time = `${ ("0" + dateTime.getHours()).slice(-2) }:${ ("0" + dateTime.getMinutes()).slice(-2) }:${ ("0" + dateTime.getSeconds()).slice(-2) }`;
                    FingerCheck.view.fingercheck_text.innerHTML = `
                        <h3 style="font-weight:normal;"><b>Bienvenido:</b> ${ usuario.usuario_nombre }</h3>
                        <br>
                        <h2><b>Hora: </b><span>${ time }</span></h2>
                    `;
                } else {
                    let dateTime = new Date(usuario.asistencia_fecha_salida);
                    let time = `${ ("0" + dateTime.getHours()).slice(-2) }:${ ("0" + dateTime.getMinutes()).slice(-2) }:${ ("0" + dateTime.getSeconds()).slice(-2) }`;
                    FingerCheck.view.fingercheck_text.innerHTML = `
                        <h3 style="font-weight:normal;"><b>Adios:</b> ${ usuario.usuario_nombre }</h3>
                        <br>
                        <h2><b>Hora: </b><span>${ time }</span></h2>
                    `;
                }
                setTimeout(() => {
                    FingerCheck.fun.validate();
                    FingerCheck.fun.setNormalHTML();
                }, 3000);
            } else {
                FingerCheck.view.fingercheck_text.style.color = "var(--error)";
                FingerCheck.view.fingercheck_text.innerText = "Usuario no encontrado";
                FingerCheck.view.fingercheck_icon.style.color = "var(--error)";
                setTimeout(() => {
                    FingerCheck.fun.validate();
                    FingerCheck.fun.setNormalHTML();
                }, 500);
            }
        },
        setNormalHTML: () => {
            FingerCheck.view.fingercheck_icon.style.color = "#fff";
            FingerCheck.view.fingercheck_img_container.classList.remove("foto");
            FingerCheck.view.fingercheck_text.style.color = "var(--info)";
            FingerCheck.view.fingercheck_text.innerText = "Por favor coloque su dedo en el lector de huella digital..";
        }
    }
}

FingerCheckMain();