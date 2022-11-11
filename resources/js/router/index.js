import Vue from 'vue'
import VueRouter from 'vue-router'


Vue.use(VueRouter)


const routes = [

    {
        path: '/profile',
        name: 'profile',
        component: require('../components/Profile.vue').default
    },

    {
        path: '/formulario-vendas',
        name: 'formulario-vendas',
        component: require('../components/views/FormularioVendas.vue').default
    },

    {
        path: '*',
        component: require('../components/NotFound.vue').default
    }
];


const router = new VueRouter({
    routes,
    mode: 'history'
})

export default router
