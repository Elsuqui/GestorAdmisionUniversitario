// Registramos las páginas de la aplicación
import Vue from "vue";
import { Loading } from 'element-ui';
Vue.component('IndexPrincipal', () => import("./paginas/index"));
Vue.component("Login", () => import("./paginas/login"));
Vue.component("ResetPassword", () => import("./paginas/resetPassword"));
Vue.component("ConfirmPassword", () => import("./paginas/confirmPassword"));


