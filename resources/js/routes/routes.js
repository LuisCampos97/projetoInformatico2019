/*jshint esversion: 6 */

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//------------------------------ Auth -------------------------------
const login = Vue.component('login', require('../components/auth/Login.vue').default);

const routes = [
    //---------------Auth----------------------
    {
      path: '/', 
      redirect: '/login',
  },
  {
      path: '/login', 
      component: login, 
      name: 'login',
  },
];

export default new VueRouter({
   routes
});