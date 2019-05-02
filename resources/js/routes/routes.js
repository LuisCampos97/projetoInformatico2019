/*jshint esversion: 6 */

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//------------------------------ Auth -------------------------------
Vue.component('master', require('../components/utils/Master.vue').default);
const login = Vue.component('login', require('../components/auth/Login.vue').default);
const dashboard = Vue.component('dashboard', require('../components/Dashboard.vue').default);
const proponente = Vue.component('proponente', require('../components/Proponente/Proponente.vue').default);
Vue.component('propostaProponenteProfessor', require('../components/Proponente/PropostaProponenteProfessor.vue').default);
Vue.component('propostaProponenteAssistente', require('../components/Proponente/PropostaProponenteAssistente').default);
Vue.component('propostaProponenteMonitor', require('../components/Proponente/PropostaProponenteMonitor').default);
Vue.component('resumoProposta', require('../components/Proponente/ResumoProposta.vue').default);
const diretorUOProposta = Vue.component('diretor', require('../components/DiretorUO/DiretorUOProposta.vue').default);
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
    path: '/dashboard',
    component: dashboard,
    name: 'dashboard'
  },

  //-----------------------------------Proponente---------------------------
  {
    path: '/proponente',
    component: proponente,
    name: 'proponente',
  },

  //---------------------------------Diretor UO---------------------------------
  {
    path: '/diretorUOProposta',
    component: diretorUOProposta,
    name: diretorUOProposta
  },

];

export default new VueRouter({
  routes
});