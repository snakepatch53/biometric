const FingerCheckMain = () => {
    window.onload = () => {
        FingerCheck.fun.ws_connect();
    }

    // key comands
    window.onkeyup = (event) => {
        // Open login
        if (event.keyCode == 190 && event.ctrlKey) {
            window.location.href = `${ $root }`;
        }
    }
}

const FingerCheck = {
    ws_host: "ws://127.0.0.1:2015",
    ws_connection: null,
    ws_mode: 0, // 0 = ninguno || 1 = Modo confirmacion || 2 = modo validate
    view: {
        fingermode: document.getElementById("fingermode"),
        fingercheck: document.getElementById("fingercheck"),
        fingercheck_img_container: document.getElementById("fingercheck_img_container"),
        fingercheck_img: document.getElementById("fingercheck_img"),
        fingercheck_icon: document.getElementById("fingercheck_icon"),
        fingercheck_text: document.getElementById("fingercheck_text")
    },
    crud: {
        usuarioSelect: (usuario_id) => {
            let formData1 = new FormData();
            formData1.append("usuario_id", usuario_id);
            fetch_query(formData1, "usuario", "selectById").then(usuario => {
                let formData2 = new FormData();
                formData2.append("usuario_id", usuario.usuario_id);
                formData2.append("usuario_email", usuario.usuario_email);
                formData2.append("usuario_pass", usuario.usuario_pass);
                formData2.append("isdactilar_token", "qJB0rGtIn5UB1xG03efyCp");
                fetch_query(formData2, "usuario", "login").then(res => {
                    if (res == false) {
                        Login.fun.showMsg("Huella sin acceso!", 1000);
                    } else {
                        window.location.href = "./inicio";
                    }
                });
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
        },
        loadDesconnect: () => {
            FingerCheck.ws_connection = null;
            FingerCheck.usuario = null;
            FingerCheck.ws_mode = 0;
            setInterval(() => {
                FingerCheck.fun.ws_connect();
            }, 5000);
        },
        loadConnect: (usuario_id) => {
            let usuario = false;
            if (usuario_id != 0) {
                FingerCheck.crud.usuarioSelect(usuario_id);
                FingerCheck.fun.validate();
            } else {
                Login.fun.showMsg("Huella no reconocida!", 1000);
            }
            if (usuario == false) {
                setTimeout(() => {
                    FingerCheck.fun.validate();
                }, 500);
            }
        }
    }
}

FingerCheckMain();