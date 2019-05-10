require('./bootstrap');

window.Vue = require('vue');

import BootstrapVue from 'bootstrap-vue';

Vue.use(BootstrapVue);

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
