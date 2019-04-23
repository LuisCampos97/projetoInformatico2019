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
      <div class="form-group" id="departamento">
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
      </div>
      <div class="jumbotron" id="ucs">
        <h5>Unidades Curriculares</h5>
        <br>
        <!-- A COLODAR NA DIV ANTERIOR??
        v-for="unidadeCurricular in unidadesCurriculares"
        v-bind:key="unidadeCurricular.id"
        -->

        <h5>Nome unidade curricular</h5>
        <select
          class="custom-select"
          v-model="unidadeCurricular.nome"
          @change="getRegimes(unidadeCurricular.nome)"
        >
          <option v-for="uc in ucsDeDepartamento" :value="uc.nome" v-bind:key="uc.nome">{{uc.nome}}</option>
        </select>
        <br>
        <h5>Regime unidade curricular</h5>
        <select
          class="custom-select"
          v-model="unidadeCurricular.regime"
          @change="getTurnos(unidadeCurricular.nome, unidadeCurricular.regime)"
        >
          <option
            v-for="regime in regimesParaUC"
            :value="regime.regime"
            v-bind:key="regime.regime"
          >{{regime.regime}}</option>
        </select>
        <br>
        <h5>Turno</h5>
        <select class="custom-select" v-model="unidadeCurricular.turno">
          <option
            v-for="turno in turnosParaUCeRegime"
            :value="turno.id"
            v-bind:key="turno.turno"
          >{{turno.turno}}</option>
        </select>
        <br>
        <h5>Numero de horas</h5>
        <input
          type="text"
          class="form-control"
          placeholder="Numero de horas semanais"
          v-model="unidadeCurricular.horas"
        >
        <br>
        <h5>Numero de horas (semestrais)</h5>
        <input
          type="text"
          class="form-control"
          placeholder="Numero de horas semestrais"
          v-model="unidadeCurricular.horas_semestrais"
        >
        <button @click="adicionarOutraUC">Mais</button>
        <br>
        <span v-if="unidadesCurriculares.length">
          <table class="table">
            <thead>
              <th>Nome</th>
              <th>Regime</th>
              <th>Turno</th>
              <th>Horas</th>
              <th>Horas Semestrais</th>
              <th>Ações</th>
            </thead>
            <tbody>
              <tr v-for="(ucAUX, index) in unidadesCurriculares" :key="ucAUX.id">
                <td>{{ucAUX.nome}}</td>
                <td>{{ucAUX.regime}}</td>
                <td>{{ucAUX.turno}}</td>
                <td>{{ucAUX.horas}}</td>
                <td>{{ucAUX.horas_semestrais}}</td>
                <td>
                  <button
                    type="button"
                    class="btn btn-danger"
                    v-on:click="removerUC(ucAUX, index)"
                  >Remover UC</button>
                </td>
              </tr>
            </tbody>
          </table>
        </span>
      </div>

      <br>
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
        class="btn btn-success"
        v-on:click="verificarErrosOuAvançar(proposta, unidadesCurriculares)"
      >Seguinte</button>
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
        role: ""
      },
      unidadeCurricular: {
        nome: "",
        regime: "",
        horas: "",
        horas_semestrais: "",
        turno: ""
      },
      unidadesCurriculares: [],
      departamentos: [],
      ucsDeDepartamento: [],
      roleSelecionado: "",
      regimesParaUC: [],
      turnosParaUCeRegime: []
    };
  },
  methods: {
    verificarErrosOuAvançar: function(proposta, unidadesCurriculares) {
      this.roleSelecionado = proposta.role;
    },

    getUcsDeDepartamento(dep_id) {
      axios
        .get("/api/unidadesCurricularesDoDepartamentoSelecionado/" + dep_id)
        .then(response => {
          this.ucsDeDepartamento = response.data;
        });
    },
    getRegimes(uc_name) {
      axios
        .get("/api/unidadesCurriculares/regime/" + uc_name)
        .then(response => {
          this.regimesParaUC = response.data;
        });
    },
    getTurnos(uc_name, uc_regime) {
      axios
        .get("/api/unidadesCurriculares/" + uc_name + "/" + uc_regime)
        .then(response => {
          this.turnosParaUCeRegime = response.data;
        });
    },
    adicionarOutraUC() {
      if (
        this.unidadeCurricular.nome == "" ||
        this.unidadeCurricular.regime == "" ||
        this.unidadeCurricular.turno == "" ||
        this.unidadeCurricular.horas == "" ||
        this.unidadeCurricular.horas_semestrais == ""
      ) {
        console.log("ERROR!!!!");
      } else {
        this.unidadesCurriculares.push(this.unidadeCurricular);
        this.unidadeCurricular = {};
        this.ucsDeDepartamento = [];
        this.regimesParaUC = [];
        this.turnosParaUCeRegime = [];
        this.proposta.departamento = [];
      }
    },
    removerUC(index){
        delete this.unidadesCurriculares[index];
        this.unidadesCurriculares.splice(index, 1);
    }
  },
  mounted() {
    axios.get("/api/departamentos").then(response => {
      this.departamentos = response.data;
    });
  }
};
</script>