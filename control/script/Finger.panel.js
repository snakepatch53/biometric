const FingerPanelMain = () => {
    window.onload = () => {
        FingerPanel.fun.ws_connect(null);
    }
    FingerPanel.view.button_close.onclick = () => FingerPanel.fun.showModal(false);
}

const FingerPanel = {
    ws_host: "ws://127.0.0.1:2015",
    ws_connection: null,
    ws_mode: 0, // 0 = ninguno || 1 = por confirmar registro || 2 = modo registro
    usuario: null,
    view: {
        fingerpanel: document.getElementById("fingerpanel"),
        fingerpanel_content: document.getElementById("fingerpanel-content"),
        button_close: document.getElementById("button-close")
    },
    fun: {
        ws_connect: (usuario_id) => {
            FingerPanel.fun.loadProgress();
            try {
                if (FingerPanel.ws_connection == null) {
                    FingerPanel.ws_connection = new WebSocket(FingerPanel.ws_host);
                } else {
                    FingerPanel.fun.register(usuario_id);
                }
                FingerPanel.ws_connection.onopen = () => {
                    try {
                        FingerPanel.fun.onmessage();
                    } catch (ex) {}
                }
                FingerPanel.ws_connection.onclose = () => {
                    FingerPanel.fun.loadDesconnect();
                }
                FingerPanel.ws_connection.onerror = () => {
                    FingerPanel.fun.loadDesconnect();
                }
            } catch (ex) {
                FingerPanel.fun.loadDesconnect();
            }
        },
        onmessage: () => {
            FingerPanel.ws_connection.onmessage = function (evt) {
                var msg = (evt.data);
                // console.log(msg);
                if (FingerPanel.ws_mode == 0 && msg == "false") {
                    FingerPanel.fun.loadDesconnect();
                }
                if (FingerPanel.ws_mode == 1 && msg == "false") {
                    FingerPanel.fun.loadDesconnect();
                } else if (FingerPanel.ws_mode == 1 && msg == "true") {
                    FingerPanel.fun.loadConnect(null);
                    FingerPanel.ws_mode = 2;
                } else if (FingerPanel.ws_mode == 2) {
                    FingerPanel.fun.loadConnect(msg);
                }
            }
        },
        register: (usuario_id) => {
            if (usuario_id != null) {
                const usuario = Usuario.databaseUsuario.find(element => element.usuario_id == usuario_id);
                FingerPanel.usuario = usuario;
                FingerPanel.fun.showModal(true);
                FingerPanel.ws_mode = 1;
                FingerPanel.ws_connection.send(JSON.stringify({
                    type: "register",
                    db_host: $proyect.db_host + "",
                    db_user: $proyect.db_user + "",
                    db_pass: $proyect.db_pass + "",
                    db_name: $proyect.db_name + "",
                    db_table_id: usuario_id + "",
                    db_table_name: "usuario",
                    db_table_key_id: "usuario_id",
                    db_table_key_huella: "usuario_huella"
                }));
            }
        },
        loadDesconnect: () => {
            FingerPanel.ws_connection = null;
            FingerPanel.usuario = null;
            FingerPanel.ws_mode = 0;
            FingerPanel.view.fingerpanel_content.innerHTML = `
                <div class="row">
                    <i class="fas fa-fingerprint error"></i>
                </div>
                <p class="row description aviso">NO SE PUDO CONECTAR CON EL LECTOR DE HUELLA DIGITAL, PUEDE HABER VARIAS RAZONES:</p>
                <ol>
                    <li>No tiene instalado el driver "<a href="${ $root }view/download/digitalpersona.rar">Digital Persona</a>".</li>
                    <li>No tiene instalado o iniciado el driver "<a href="${ $root }view/download/biometric.rar">Biometric Ideasoft</a>".</li>
                    <li>No tiene conectado un lector de huella digital "Digital Persona".</li>
                </ol>
            `;
        },
        loadConnect: (huella_numero) => {
            if (huella_numero == 0) {
                FingerPanel.view.fingerpanel_content.innerHTML = `
                    <div class="row">
                        <i class="fas fa-fingerprint success"></i>
                    </div>
                    <p class="row description">
                        SU HUELLA SE REGISTRO CORRECTAMENTE..
                    </p>
                `;
                setTimeout(() => {
                    FingerPanel.fun.showModal(false);
                }, 1000);
            } else {
                FingerPanel.view.fingerpanel_content.innerHTML = `
                    <div class="row">
                        <b>Usuario: </b>
                        <span>${ FingerPanel.usuario.usuario_nombre }</span>
                    </div>
                    <div class="row">
                        <i class="fas fa-fingerprint ini"></i>
                    </div>
                    <p class="row description">
                        Necesitamos que coloque su huella en el lector 4 veces..
                    </p>
                    <p class="row contador">
                        ${ huella_numero == null ? '' : `HUELLA NÚMERO <b>${ parseInt(huella_numero) }</b>` }
                    </p>
                `;
            }
        },
        loadProgress: () => {
            FingerPanel.view.fingerpanel_content.innerHTML = `
                <div class="row">
                    <i class="fas fa-fingerprint ini"></i>
                </div>
                <div class="row">
                    <img src="${ $root }view/img/load.gif" />
                </div>
            `;
        },
        showModal: (bool) => {
            if (bool) {
                FingerPanel.view.fingerpanel.classList.add("open");
            } else {
                FingerPanel.view.fingerpanel.classList.remove("open");
            }
        }
    }
}

FingerPanelMain();