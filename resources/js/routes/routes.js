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
Vue.component('fundamentacaoDepartamento', require('../components/Proponente/FundamentacaoDepartamento.vue').default);
Vue.component('fundamentacaoCurso', require('../components/Proponente/FundamentacaoCurso.vue').default);
Vue.component('tabelaDiretor', require('../components/utils/TabelaDiretor.vue').default);
Vue.component('diretor', require('../components/DiretorUO/DiretorUOProposta.vue').default);
Vue.component('resumoGeral', require('../components/utils/ResumoGeral.vue').default);
Vue.component('tabelaCtc', require('../components/CTC/TabelaCTC.vue').default);
Vue.component('ctc', require('../components/CTC/CTC.vue').default);
Vue.component('tabelaSecretariado', require('../components/SecretariadoDirecao/TabelaSecretariadoDirecao.vue').default);
Vue.component('propostaSecretariado', require('../components/SecretariadoDirecao/PropostaSecretariadoDirecao.vue').default);
Vue.component('tabelaRecursos', require('../components/RecursosHumanos/TabelaRecursosHumanos.vue').default);
Vue.component('ficheirosDocente', require('../components/NovosDocentes/FicheirosDocente.vue').default);
Vue.component('propostaRecursos', require('../components/RecursosHumanos/PropostaRecursosHumanos.vue').default);
const adminDashboard = Vue.component('adminDashboard', require('../components/Backoffice/AdminDashboard.vue').default);
const adminLogin =  Vue.component('adminLogin', require('../components/Backoffice/AdminLogin.vue').default);

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
  {
    path: '/ficheirosDocente',
    component: ficheirosDocente,
    name: 'ficheirosDocente'
  },
  {
    path: '/adminDashboard',
    component: adminDashboard,
    name: 'adminDashboard'
  },
  {
    path: '/admin',
    component: adminLogin,
    name: 'adminLogin'
  }
];

export default new VueRouter({
  routes
});