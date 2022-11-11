/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import VueRouter from "vue-router";
import Vuex from "vuex";
import './mensagens'
import {
    BootstrapVue,
    IconsPlugin
} from "bootstrap-vue";
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import VueProgressBar from "vue-progressbar";
import moment from "moment";
import Swal from "sweetalert2";
import VueMask from "v-mask";
import router from "./router";
import ViaCep from 'vue-viacep';
import Multiselect from 'vue-multiselect'
import VueExcelXlsx from "vue-excel-xlsx";
import money from 'v-money'

Vue.use(money, {precision: 4})


import {
    ValidationProvider,
    extend
} from 'vee-validate';
import {
    required
} from 'vee-validate/dist/rules';
import {
    VueMaskFilter
} from 'v-mask'
moment.locale("pt-br");
import {
    VueMaskDirective
} from 'v-mask'
import VueCharts from 'vue-chartjs'
import {
    Bar,
    Line
} from 'vue-chartjs'

const options = {
    color: "#bffaf3",
    failedColor: "#874b4b",
    thickness: "5px",
    transition: {
        speed: "0.2s",
        opacity: "0.6s",
        termination: 300
    },
    autoRevert: true,
    location: "top",
    inverse: false
};

require("./bootstrap");

import Vue from 'vue'

window.Fire = new Vue();


import Auth from "./Auth";

import showError from "./configuracaoGlobal";
Vue.prototype.$auth = new Auth(window.user);
window.showError = showError;

window.swal = Swal;
window.moment = moment;

//via cep
Vue.use(ViaCep);
Vue.component('multiselect', Multiselect)
Vue.use(VueExcelXlsx);

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: toast => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    }
});

extend('required', {
    ...required,
    message: 'Este campo é obrigatório'
});


window.Toast = Toast;
Vue.use(VueProgressBar, options);
Vue.use(VueMask);

Vue.filter('VMask', VueMaskFilter)

Vue.use(VueRouter);
Vue.use(Vuex);
// Install BootstrapVue
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);


Vue.directive('mask', VueMaskDirective);

// filters

Vue.filter("upText", function (text) {
    if(text!= undefined){
        return text === null ?"Não Informado" : text.charAt(0).toUpperCase() + text.slice(1);
    }
    return ;
});

Vue.filter("formatData", function (data) {
    return moment(data).format("LLL");
});

Vue.filter("corretora", function (data) {
    return (data=== null || data === undefined)?'Não se aplica' : data.name ;
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "passport-clients",
    require("./components/passport/Clients.vue").default
);

Vue.component(
    "passport-authorized-clients",
    require("./components/passport/AuthorizedClients.vue").default
);

Vue.component(
    "passport-personal-access-tokens",
    require("./components/passport/PersonalAccessTokens.vue").default
);

Vue.component("not-found", require("./components/NotFound.vue").default);

Vue.component("pagination", require("laravel-vue-pagination"));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    components: {
        ValidationProvider
    },
    el: "#app",
    data: {
        search: "",
        permissions: {}
    },
    methods: {
        searchit: _.debounce(() => {
            Fire.$emit("searching");
        }, 1000),
        printme() {
            window.print();
        },

        loadPermission() {
            axios
                .get("api/profile/permission", {
                    // params: {
                    //   permission: ['delete user', 'edit user']
                    // }
                })
                .then(({
                    data
                }) => (this.permissions = data))
                .catch(error => {
                    Toast.fire({
                        icon: "error",
                        title: "Falha Ao Verificar Do Usuário!"
                    })
                });
        },
        hasPermission(permission) {
            this.permissions.forEach(element => {
                console.log(element);
            });
        }


    },
    mounted() {
        // this.loadPermission();
    },
});
