require('./bootstrap');

window.Vue = require('vue');

import BootstrapVue from 'bootstrap-vue';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import VeeValidate from 'vee-validate';

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

import router from './routes/routes';
import store from './store/global-store';

import VueSocketIO from 'vue-socket.io';
Vue.use(new VueSocketIO({
    debug: true,
    connection: 'http://localhost:8080'
}));

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
