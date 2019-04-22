/*jshint esversion: 6 */

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//------------------------------ Auth -------------------------------
Vue.component('master', require('../components/utils/Master.vue').default);
const login = Vue.component('login', require('../components/auth/Login.vue').default);
const proponente = Vue.component('proponente', require('../components/Proponente/Proponente.vue').default);
const propostaProponenteProfessor = Vue.component('propostaProponenteProfessor', require('../components/Proponente/PropostaProponenteProfessor.vue').default);
const propostaProponenteAssistente = Vue.component('propostaProponenteAssistente', require('../components/Proponente/PropostaProponenteAssistente').default);
const propostaProponenteMonitor = Vue.component('propostaProponenteMonitor', require('../components/Proponente/PropostaProponenteMonitor').default);
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

  //-----------------------------------Proponente---------------------------
  {
    path: '/proponente',
    component: proponente,
    name: 'proponente',
  },

  {
    path: '/propostaProponenteProfessor',
    component: propostaProponenteProfessor,
    name: 'propostaProponenteProfessor',
  },
  {
    path: '/propostaProponenteAssistente',
    component: propostaProponenteAssistente,
    name: 'propostaProponenteAssistente',
  },
  {
    path: '/propostaProponenteMonitor',
    component: propostaProponenteMonitor,
    name: 'propostaProponenteMonitor',
  },
];

export default new VueRouter({
  routes
});