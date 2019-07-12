// Se importa el ruteador de vue
import Router from "vue-router";
import Vue from "vue";

// Le digo a vue que use el ruteador
Vue.use(Router);

// Importo las rutas de los módulos
import archivos from "../rutas/modulos/archivos";
import reportes from "../rutas/modulos/reportes";
import mail from "../rutas/modulos/mail";

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
        archivos,
        mail,
        reportes
    ]
});

// Exporto el objeto ruteador para agregarlo a la instancia principal de Vue
export default router;
