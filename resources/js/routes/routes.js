/*jshint esversion: 6 */

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//------------------------------ Auth -------------------------------
Vue.component('master', require('../components/utils/Master.vue').default);
const login = Vue.component('login', require('../components/auth/Login.vue').default);
const proponente = Vue.component('proponente', require('../components/Proponente/Proponente.vue').default)


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

  {
    path: '/proponente',
    component: proponente,
    name: 'proponente',
  },
];

export default new VueRouter({
  routes
});