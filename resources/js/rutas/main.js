// Se importa el ruteador de vue
import Router from "vue-router";
import Vue from "vue";

// Le digo a vue que use el ruteador
Vue.use(Router);

// Importo el componente home
const Home = () => import("../modulos/principal/paginas/_index");

// Importo las rutas de los módulos


// Agrego la ruta de la página principal
/*const ruta_home = {
    path: "/home",
    component: Home,
    name: "home"
};*/

// Instancio el objeto ruteador con las rutas definidas
const router = new Router({
    mode: 'history',
    /*routes: [
       ruta_home
    ]*/
});

// Exporto el objeto ruteador para agregarlo a la instancia principal de Vue
export default router;
