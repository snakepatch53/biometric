let _____cont____ = 0;
const AsistenciaControlMain = async () => {
    AsistenciaControl.view.button_navigate_asistencia.onclick = () => AsistenciaControl.fun.navigate("asistencia");
    AsistenciaControl.view.button_navigate_reportes.onclick = () => AsistenciaControl.fun.navigate("reportes");
    AsistenciaControl.view.button_navigate_presentes.onclick = () => AsistenciaControl.fun.navigate("presentes");
    AsistenciaControl.view.button_navigate_ausentes.onclick = () => AsistenciaControl.fun.navigate("ausentes");

    await Asistencia.crud.select();
    await Asistencia.crud.selectUsuario();
    await AsistenciaPresentes.fun.printHtml(Asistencia.databaseAsistencia);
    await AsistenciaAusentes.fun.printHtml(Asistencia.databaseUsuario);
    if (_____cont____ == 0) {
        await AsistenciaReportes.fun.printHtml(Asistencia.databaseUsuario);
    }

    if (localStorage.getItem("asistencia-navigate-tab") != "null") {
        AsistenciaControl.fun.navigate(localStorage.getItem("asistencia-navigate-tab"));
    }
    _____cont____++;
}

const AsistenciaControl = {
    view: {
        button_navigate_asistencia: document.getElementById("button-navigate-asistencia"),
        button_navigate_reportes: document.getElementById("button-navigate-reportes"),
        button_navigate_presentes: document.getElementById("button-navigate-presentes"),
        button_navigate_ausentes: document.getElementById("button-navigate-ausentes"),
        nav_control: document.getElementById("nav-control")
    },
    fun: {
        navigate: (tab) => {
            AsistenciaControl.view.nav_control.className = "";
            AsistenciaControl.view.nav_control.classList.add(tab);
            localStorage.setItem("asistencia-navigate-tab", tab);
        },
        observarCambios: () => {
            setInterval(() => {
                AsistenciaControl.databaseAsistencia_length = Asistencia.databaseAsistencia.length;
                AsistenciaControl.ausentes_int = AsistenciaAusentes.ausentes_int;
                AsistenciaControl.presentes_int = AsistenciaPresentes.presentes_int;
                AsistenciaControlMain();
            }, 60000);
        }
    }
}

AsistenciaControlMain();
AsistenciaControl.fun.observarCambios();