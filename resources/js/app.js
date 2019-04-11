require('./bootstrap');

window.Vue = require('vue');

import router from './routes/routes';

const app = new Vue({
    el: '#app',
    router
});
