require('./bootstrap');

window.Vue = require('vue');

import router from './routes/routes';
import store from './store/global-store';

const app = new Vue({
    el: '#app',
    router : router,
    store
});
