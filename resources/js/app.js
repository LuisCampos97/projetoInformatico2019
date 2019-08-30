require('./bootstrap');

window.Vue = require('vue');

import BootstrapVue from 'bootstrap-vue';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import VeeValidate from 'vee-validate';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import VueApexCharts from 'vue-apexcharts';

 
Vue.use(VueSweetalert2);

Vue.use(VeeValidate, {
    // This is the default
    inject: true,
    // Important to name this something other than 'fields'
    fieldsBagName: 'veeFields',
    // This is not required but avoids possible naming conflicts
    errorBagName: 'veeErrors'
  })
Vue.use(BootstrapVue);
Vue.use(Loading);
Vue.use(VueApexCharts);
Vue.component('apexchart', VueApexCharts)

import router from './routes/routes';
import store from './store/global-store';

import VueSocketIO from 'vue-socket.io';
Vue.use(new VueSocketIO({
    debug: true,
    connection: 'http://localhost:8080'
}));

// Para manter o utilizador logado depois de refrescar a pagina
store.state.user = store.getters.getAuthUser
store.state.token = store.getters.getToken
store.state.tokenType = store.getters.getTokenType
store.state.getExpiration = store.getters.getExpiration
axios.defaults.headers.common['Authorization'] = 'Bearer ' + store.getters.getToken

// interceptors - pre and post request
/*
axios.interceptors.response.use(
    (response) => {
        //console.log(response)
        return response;
    }, 
    (error) => {
        // error message
        // error.response.data.error
        // error status code
        // error.response.status
        //console.log(error.response.data.error)

        if (error.response.status == 400) {
            swal(error.response.status.toString(), error.response.data.error, 'error')
        }
        else if (error.response.status == 401) {
            swal(error.response.status.toString(), error.response.data.error, 'error')
        }
        else if (error.response.status == 404) {
            swal(error.response.status.toString(), 'Resource not found.', 'error')
        }
        else if (error.response.status == 422) {
            if (error.response.data.errors.email)
                swal(error.response.status.toString(), error.response.data.errors.email[0], 'error')
            else if (error.response.data.errors.name)
                swal(error.response.status.toString(), error.response.data.errors.name[0], 'error')
            else if (error.response.data.errors.username)
                swal(error.response.status.toString(), error.response.data.errors.username[0], 'error')
            else if (error.response.data.errors.description)
                swal(error.response.status.toString(), error.response.data.errors.description[0], 'error')
            else if (error.response.data.errors.price)
                swal(error.response.status.toString(), error.response.data.errors.price[0], 'error')
            else if (error.response.data.errors.photo_url)
                swal(error.response.status.toString(), error.response.data.errors.photo_url[0], 'error')
            else
                swal(error.response.status.toString(), 'Invalid data.', 'error')
        }
        else if (error.response.status == 500) {
            if (error.response.data.error)
                swal(error.response.status.toString(), error.response.data.error, 'error')
            else
                swal(error.response.status.toString(), 'We are expiriencing an internal problem.', 'error')
        }
    }
);
*/
/*
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.forAuth)) {
        if (!store.getters.loggedIn) {
            
            next({
                path: '/login'
            })
        } else next()
    }
    if (to.matched.some(record => record.meta.forProponenteDepartamento)) {
        if (!store.getters.isProponenteDepartamento) {
            next({
                path: '/dashboard'
            })
        } else next()
    }
    else if (to.matched.some(record => record.meta.forProponenteCurso)) {
        if (!store.getters.isProponenteCurso) {
            next({
                path: '/dashboard'
            })
        } else next()
    }
    else if (to.matched.some(record => record.meta.forDiretorUO)) {
        if (!store.getters.isDiretorUO) {
            next({
                path: '/dashboard'
            })
        } else next()
    }
    else if (to.matched.some(record => record.meta.forCTC)) {
        if (!store.getters.isCTC) {
            next({
                path: '/dashboard'
            })
        } else next()
    }
    else if (to.matched.some(record => record.meta.forSecretariadoDirecao)) {
        if (!store.getters.isSecretariadoDirecao) {
            next({
                path: '/dashboard'
            })
        } else next()
    }
    else if (to.matched.some(record => record.meta.forRecursosHumanos)) {
        if (!store.getters.isRecursosHumanos) {
            next({
                path: '/dashboard'
            })
        } else next()
    }
    else if (to.matched.some(record => record.meta.forAdmin)) {
        if (!store.getters.isAdmin) {
            next({
                path: '/admin'
            })
        } else next()
    } else next()
});
*/
const app = new Vue({
    el: '#app',
    router: router,
    store,
    created() {
        this.$store.commit('loadTokenAndUserFromSession');
    },
    sockets: {
        connect: function(){
            console.log('socket connected');
        },

    }
});
