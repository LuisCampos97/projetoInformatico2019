/*jshint esversion: 6 */

import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import Vuelidate from 'vuelidate';

Vue.use(Vuex);
Vue.use(Vuelidate);

export default new Vuex.Store({
    state: {
        token: '',
        user: null,
        proposta: null,
        propostaProponenteProfessor: null,
        propostaProponenteAssistente: null,
        propostaProponenteMonitor: null,
        propostaExistente: false
    },
    getters: {
        loggedIn(state) {
            return state.token !== '';
        },
        isProponenteDepartamento(state) {
            if(state.user)
                return state.user.roleDB == "proponente_departamento" ? true : false;
            return false    
        },
        isProponenteCurso(state) {
            if(state.user)
                return state.user.roleDB == "proponente_curso" ? true : false;
            return false    
        },
        isDiretorUO(state) {
            if(state.user)
                return state.user.roleDB == "diretor_uo" ? true : false;
            return false    
        },
        isCTC(state) {
            if(state.user)
                return state.user.roleDB == "ctc" ? true : false;
            return false    
        },
        isSecretariadoDirecao(state) {
            if(state.user)
                return state.user.roleDB == "secretariado_direcao" ? true : false;
            return false    
        },
        isRecursosHumanos(state) {
            if(state.user)
                return state.user.roleDB == "recursos_humanos" ? true : false;
            return false    
        },
        isAdmin(state) {
            if(state.user)
                return state.user.roleDB == "admin" ? true : false;
            return false    
        },
    },
    mutations: {
        //* Informação sobre o USER
        clearUserAndToken: state => {
            state.user = null;
            state.token = '';
            localStorage.removeItem('user');
            localStorage.removeItem('token');
            axios.defaults.headers.common.Authorization = undefined;
        },
        clearUser: state => {
            state.user = null;
            localStorage.removeItem('user');
        },
        clearToken: state => {
            state.token = '';
            localStorage.removeItem('token');
            axios.defaults.headers.common.Authorization = undefined;
        },
        setUser: (state, user) => {
            state.user = user;
            localStorage.setItem('user', JSON.stringify(user));
        },
        setToken: (state, token) => {
            state.token = token;
            localStorage.setItem('token', token);
            axios.defaults.headers.common.Authorization = 'Bearer ' + token;
        },
        loadTokenAndUserFromSession: state => {
            state.token = '';
            state.user = null;
            let token = localStorage.getItem('token');
            let user = localStorage.getItem('user');
            if (token) {
                state.token = token;
                axios.defaults.headers.common.Authorization = 'Bearer ' + token;
            }
            if (user) {
                state.user = JSON.parse(user);
            }
        },
        //* Informação sobre a PROPOSTA
        setPropostaExistente(state) {
            state.propostaExistente = true;
        },
        resetPropostaExistente(state) {
            state.propostaExistente = false;
        },
        setProposta: (state, proposta) => {
            state.proposta = proposta;
        },
        setPropostaProponenteProfessor(state, propostaProponenteProfessor) {
            state.propostaProponenteProfessor = propostaProponenteProfessor;
        },
        setPropostaProponenteAssistente(state, propostaProponenteAssistente) {
            state.propostaProponenteAssistente = propostaProponenteAssistente;
        },
        setPropostaProponenteMonitor(state, propostaProponenteMonitor) {
            state.propostaProponenteMonitor = propostaProponenteMonitor;
        }
    }
});
