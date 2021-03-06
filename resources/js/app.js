
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


window.Vue = require('vue');
require("./bootstrap");

/**
 * The following block of code may be used to automatically register your
 * Vue componentes. It will recursively scan this directory for the Vue
 * componentes and automatically register them with their "basename".
 *
 * Eg. ./componentes/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

//Vue.component('IndexPrincipal', () => import("./modulos/principal/paginas/_index"));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding componentes to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/**
 * Cargamos Element Ui como framework de componentes para Vue js
 */

import ElementUI from "element-ui";
import 'element-ui/lib/theme-chalk/index.css';
import router from "./rutas/main";
import "./modulos/main";

Vue.use(ElementUI);


const app = new Vue({
    el: '#app',
    router
});
