// Registramos las páginas de la aplicación
import Vue from "vue";
Vue.component('IndexPrincipal', () => import("./paginas/_index"));
Vue.component("Login", () => import("./paginas/_login"));

