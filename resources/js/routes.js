import Vue from "vue";
import Router from "vue-router";
import excel from "vue-excel-export";

// vistas de Administrador
import Users from "./views/admin/Users";
import Cities from "./views/admin/Cities";
import Clients from "./views/admin/Client";

Vue.use(Router);
Vue.use(excel);

export default new Router({
    routes: [
        // Routes Admin

        {
            path: "/admin/users",
            name: "users",
            component: Users
        },

        {
            path: "/admin/cities",
            name: "cities",
            component: Cities
        },

        {
            path: "/admin/clients",
            name: "clients",
            component: Clients
        },

        //Usuarios
    ],
    mode: "history"
});
