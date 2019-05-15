/*jshint esversion: 6 */

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//------------------------------ Auth -------------------------------
Vue.component('master', require('../components/utils/Master.vue').default);
const login = Vue.component('login', require('../components/auth/Login.vue').default);
const dashboard = Vue.component('dashboard', require('../components/Dashboard.vue').default);
Vue.component('proponente', require('../components/Proponente/Proponente.vue').default);
Vue.component('propostaProponenteProfessor', require('../components/Proponente/PropostaProponenteProfessor.vue').default);
Vue.component('propostaProponenteAssistente', require('../components/Proponente/PropostaProponenteAssistente').default);
Vue.component('propostaProponenteMonitor', require('../components/Proponente/PropostaProponenteMonitor').default);
Vue.component('resumoProposta', require('../components/Proponente/ResumoProposta.vue').default);
Vue.component('separator-table', require('../components/utils/Separator_Table.vue').default);
Vue.component('diretor', require('../components/DiretorUO/DiretorUOProposta.vue').default);
Vue.component('resumoDiretor', require('../components/DiretorUO/ResumoDiretor.vue').default);
const ctc = Vue.component('ctc', require('../components/CTC/CTC.vue').default);
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

  //---------------------------------Diretor UO---------------------------------

  {
    path: '/ctc',
    component: ctc,
    name: 'ctc'
  },
];

export default new VueRouter({
  routes
});