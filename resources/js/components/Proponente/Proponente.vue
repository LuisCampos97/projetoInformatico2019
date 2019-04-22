<template>
  <div>
    <h2>Vista de Proponente</h2>
    <br>
    <h5>Que tipo de proposta pretende efetuar?</h5>
    <br>
    <div id="radioTipoProposta" class="radio">
      <input type="radio" v-model="proposta.tipoProposta" value="contratacaoInicial"> Contratacao Inicial
      <br>
      <input type="radio" v-model="proposta.tipoProposta" value="renovacao"> Renovação
      <br>
      <input type="radio" v-model="proposta.tipoProposta" value="alteracao"> Alteração
      <br>
    </div>
    <br>
    <!-----------------CONTRATAÇÃO INICIAL-------------------------------------------->

    <div v-if="proposta.tipoProposta == 'contratacaoInicial'">
      <h5>Para que unidade organica será o docente contratado?</h5>
      <br>
      <div id="radioUnidadeOrganica" class="radio">
        <input type="radio" v-model="proposta.unidadeOrganica" value="ESECS"> ESECS
        <br>
        <input type="radio" v-model="proposta.unidadeOrganica" value="ESTG"> ESTG
        <br>
        <input type="radio" v-model="proposta.unidadeOrganica" value="ESSLei"> ESSLei
        <br>
        <input type="radio" v-model="proposta.unidadeOrganica" value="ESTM"> ESTM
        <br>
        <input type="radio" v-model="proposta.unidadeOrganica" value="ESAD.CR"> ESAD.CR
        <br>
      </div>
      <br>
      <br>
      <div class="form-group">
        <h5>Nome completo</h5>
        <input
          type="text"
          class="form-control"
          placeholder="Insira o nome completo do docente"
          v-model="proposta.nomeCompleto"
        >
        <br>
        <h5>Departamento</h5>
        <select
          class="custom-select"
          v-model="proposta.departamento"
          @change="getUcsDeDepartamento(proposta.departamento)"
        >
          <option
            v-for="dep in departamentos"
            :value="dep.id"
            v-bind:key="dep.id"
          >{{dep.nome_departamento}}</option>
        </select>
        <br>
        <br>
        <h5>Unidade Curricular</h5>
        <select
          class="custom-select"
          v-model="proposta.unidadeCurricular"
          @change="getUC(proposta.unidadeCurricular)"
        >
          <option v-for="uc in ucsDeDepartamento" :value="uc.id" v-bind:key="uc.id">{{uc.nome}}</option>
        </select>
        <h5>Regime</h5>
        <input type="text" class="form-control" readonly :value="regimeUCSelecionada">
        <h5>Tipo</h5>
        <input type="text" class="form-control" readonly :value="tipoUCSelecionada">
        <h5>Horas</h5>
        <input type="text" class="form-control" readonly :value="horasUC">
        <h5>Horas Semestrais</h5>
        <input type="text" class="form-control" readonly :value="horasSemestraisUC">
        <br>
      </div>
      <h5>Qual será o papel a desempenhar pelo docente a ser contratado?</h5>
      <br>
      <div id="radioRole" class="radio">
        <input type="radio" v-model="proposta.role" value="professor"> Professor
        <br>
        <input type="radio" v-model="proposta.role" value="assistente"> Assistente
        <br>
        <input type="radio" v-model="proposta.role" value="monitor"> Monitor
        <br>
      </div>
      <button
        type="button"
        class="btn btn-outline-success"
        v-on:click="verificarErrosOuAvançar(proposta)"
      >Seguinte</button>
      <div v-if="errors.length">
        <b>Please correct the following error(s):</b>
        <ul>
          <li v-for="error in errors" v-bind:key="error">{{ error }}</li>
        </ul>
      </div>
    </div>
    <proposta-proponente-professor v-if="roleSelecionado == 'professor'"></proposta-proponente-professor>
    <proposta-proponente-assistente v-if="roleSelecionado == 'assistente'"></proposta-proponente-assistente>
    <proposta-proponente-monitor v-if="roleSelecionado == 'monitor'"></proposta-proponente-monitor>
    <!-----------------------------FIM CONTRATAÇÃO INICIAL-------------------------------------->
  </div>
</template>
<script>
module.exports = {
  data() {
    return {
      proposta: {
        tipoProposta: "",
        unidadeOrganica: "",
        nomeCompleto: "",
        departamento: "",
        role: "",
        unidadeCurricular: "",
        regime: "",
        tipo: "",
        horas: "",
        horasSemestrais: ""
      },
      departamentos: [],
      ucsDeDepartamento: [],
      ucSelecionada: {},
      regimeUCSelecionada: "",
      tipoUCSelecionada: "",
      horasUC: "",
      horasSemestraisUC: "",
      roleSelecionado: "",
      errors: []
    };
  },
  methods: {
    verificarErrosOuAvançar: function(proposta) {
      if (proposta.nomeCompleto == "") {
        this.errors.push("Nome nao pode ser vazio");
      }

      //e.preventDefault();

      this.roleSelecionado = proposta.role;
    },

    getUcsDeDepartamento(dep_id) {
      axios
        .get("/api/unidadesCurricularesDoDepartamentoSelecionado/" + dep_id)
        .then(response => {
          this.ucsDeDepartamento = response.data;
          this.regimeUCSelecionada = "";
          this.tipoUCSelecionada = "";
          this.horasUC = "";
          this.horasSemestraisUC = "";
        });
    },
    getUC(uc_id) {
      axios.get("/api/unidadesCurriculares/" + uc_id).then(response => {
        this.ucSelecionada = response.data;
        this.regimeUCSelecionada = this.ucSelecionada[0].regime;
        this.tipoUCSelecionada = this.ucSelecionada[0].tipo;
        this.horasUC = this.ucSelecionada[0].horas;
        this.horasSemestraisUC = this.ucSelecionada[0].horas_semestrais;
      });
    }
  },
  mounted() {
    axios.get("/api/departamentos").then(response => {
      this.departamentos = response.data;
    });
  }
};
</script>