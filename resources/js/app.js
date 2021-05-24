/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
import { BootstrapVue, IconsPlugin, BootstrapVueIcons } from "bootstrap-vue";

import VueSweetalert2 from "vue-sweetalert2";
// If you don't need the styles, do not connect
import "sweetalert2/dist/sweetalert2.min.css";

Vue.use(VueSweetalert2);

// Include bootstrap
import bootstrap from "bootstrap";

// Include jquery
const jQuery = require("jquery");
// Make it available globally
// DT editor seems to need this, so does the .vue component
window.jQuery = jQuery;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Install BootstrapVue
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);
// Icons
Vue.use(BootstrapVueIcons);

// This imports all the layout components such as <b-container>, <b-row>, <b-col>:
import { LayoutPlugin } from "bootstrap-vue";
Vue.use(LayoutPlugin);

// This imports <b-modal> as well as the v-b-modal directive as a plugin:
import { ModalPlugin } from "bootstrap-vue";
Vue.use(ModalPlugin);

// This imports <b-card> along with all the <b-card-*> sub-components as a plugin:
import { CardPlugin } from "bootstrap-vue";
Vue.use(CardPlugin);

// This imports directive v-b-scrollspy as a plugin:
import { VBScrollspyPlugin } from "bootstrap-vue";
Vue.use(VBScrollspyPlugin);

// This imports the dropdown and table plugins
import { DropdownPlugin, TablePlugin } from "bootstrap-vue";
Vue.use(DropdownPlugin);
Vue.use(TablePlugin);



Vue.component("appComponent", require("./components/AppComponent.vue").default);

Vue.component(
    "navbarComponent",
    require("./components/NavbarComponent").default
);
Vue.component("login-component", require("./components/auth/Login").default);

Vue.component(
    "register-component",
    require("./components/auth/Register").default
);

Vue.component(
    "validate-register-component",
    require("./components/auth/ValidateRegister.vue").default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import router from "./routes";

import { ServerTable, ClientTable, Event } from "vue-tables-2";
Vue.use(ClientTable, {}, false, "bootstrap4", "default");
Vue.use(ServerTable, {}, false, "bootstrap4", "default");

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import Vue from "vue";

const app = new Vue({
    el: "#app",
    router
});
