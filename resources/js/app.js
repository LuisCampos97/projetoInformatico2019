require('./bootstrap');

window.Vue = require('vue');

import router from './routes/routes';
import store from './store/global-store';

// Components registration
Vue.component('master', require('./components/utils/Master.vue').default);
Vue.component('login', require('./components/auth/Login.vue'));

const app = new Vue({
    el: '#app',
    router,
    store
});
