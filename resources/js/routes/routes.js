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
Vue.component('estatisticaProponente', require('../components/Estatistica/EstatisticaProponente.vue').default);
Vue.component('estatisticaDiretorUO', require('../components/Estatistica/EstatisticaDiretorUO.vue').default);
Vue.component('estatisticaCTC', require('../components/Estatistica/EstatisticaCTC.vue').default);
Vue.component('estatisticaSecretariadoDirecao', require('../components/Estatistica/EstatisticaSecretariadoDirecao.vue').default);
Vue.component('estatisticaRecursosHumanos', require('../components/Estatistica/EstatisticaRecursosHumanos.vue').default);
Vue.component('editarProposta', require('../components/Proponente/EditarProposta.vue').default);
const adminDashboard = Vue.component('adminDashboard', require('../components/Backoffice/AdminDashboard.vue').default);
const adminLogin =  Vue.component('adminLogin', require('../components/Backoffice/AdminLogin.vue').default);
Vue.component('adicionarCurso', require('../components/Backoffice/AdicionarCurso.vue').default);
Vue.component('adicionarUcs', require('../components/Backoffice/AdicionarUcs.vue').default);


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
    name: 'dashboard',
    meta: {
      forAuth: true,
    }
  },
  {
    path: '/adminDashboard',
    component: adminDashboard,
    name: 'adminDashboard',
    meta:{
      forAuth: true,
      forAdmin: true,
    }
  },
  {
    path: '/admin',
    component: adminLogin,
    name: 'adminLogin',
  }
];

export default new VueRouter({
  routes
});