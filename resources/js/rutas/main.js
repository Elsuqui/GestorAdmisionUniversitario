// Se importa el ruteador de vue
import Router from "vue-router";
import Vue from "vue";

// Le digo a vue que use el ruteador
Vue.use(Router);

// Importo las rutas de los módulos
import admision from "../rutas/modulos/admision";
import archivos from "../rutas/modulos/archivos";
import reportes from "../rutas/modulos/reportes";
import mail from "../rutas/modulos/mail";
import llamadas from "../rutas/modulos/llamadas";
import usuarios from "../rutas/modulos/usuarios";
import plantillas from "./modulos/plantillas";

// Instancio el objeto ruteador con las rutas definidas
const router = new Router({
    mode: 'history',
    routes: [
        {
          path: "/home",
          component: () => import("../modulos/principal/paginas/principal"),
          name: "index-principal",
          props: false
        },
        admision,
        archivos,
        mail,
        reportes,
        llamadas,
        usuarios,
        plantillas,
    ]
});

// Exporto el objeto ruteador para agregarlo a la instancia principal de Vue
export default router;
