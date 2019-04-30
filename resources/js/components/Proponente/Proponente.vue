<template>
  <div>
    <h2 class="pb-4">Nova Proposta</h2>
    <b-form-group label="Que tipo de proposta pretende efetuar?">
      <b-form-radio v-model="proposta.tipo_contrato" value="Contratacao Inicial">Contratação Inicial</b-form-radio>
      <b-form-radio v-model="proposta.tipo_contrato" value="Renovacao">Renovação</b-form-radio>
      <b-form-radio v-model="proposta.tipo_contrato" value="Alteracao">Alteração</b-form-radio>
    </b-form-group>
    <div
      class="help-block alert alert-danger"
      v-show="errors.has('Tipo Contrato')"
    >{{ errors.first('Tipo Contrato') }}</div> 

    <!-----------------CONTRATAÇÃO INICIAL-------------------------------------------->

    <div v-if="proposta.tipo_contrato == 'Contratacao Inicial'">
      <b-form-group label="Para que unidade organica será o docente contratado?">
        <b-form-radio v-model="proposta.unidade_organica" value="ESECS">ESECS</b-form-radio>
        <b-form-radio v-model="proposta.unidade_organica" value="ESTG">ESTG</b-form-radio>
        <b-form-radio v-model="proposta.unidade_organica" value="ESSLei">ESSLei</b-form-radio>
        <b-form-radio v-model="proposta.unidade_organica" value="ESTM">ESTM</b-form-radio>
        <b-form-radio v-model="proposta.unidade_organica" value="ESAD.CR">SAD.CR</b-form-radio>
      </b-form-group>
      <div
        class="help-block alert alert-danger"
        v-show="errors.has('unidade organica')"
      >{{ errors.first('unidade organica') }}</div>
      <br>
      <div class="form-group">
        <label class="label" for="inputNomeCompleto">Nome completo</label>
        <b-form-input
          id="inputNomeCompleto"
          type="text"
          class="form-control"
          placeholder="Insira o nome completo do docente"
          name="nome"
          v-validate="'required'"
          v-model="proposta.nome_completo"
        ></b-form-input>
        <div
          class="help-block alert alert-danger"
          v-show="errors.has('nome')"
        >{{ errors.first('nome') }}</div>
        <br>
      </div>
      
      <div class="jumbotron" id="ucs">
        <h5>Unidades Curriculares</h5>
        <br>
        <h5>Departamento</h5>
        <select
          class="custom-select"
          v-model="unidadeCurricular.departamento_id"
          name="departamento"
          v-validate="'required'"
          @change="getUcsDeDepartamento(unidadeCurricular.departamento_id)"
        >
          <option
            v-for="dep in departamentos"
            :value="dep.id"
            v-bind:key="dep.id"
          >{{dep.nome_departamento}}</option>
        </select>
        <div
          v-if="unidadesCurriculares.length ==0"
          class="help-block alert alert-danger"
          v-show="errors.has('departamento')"
        >{{ errors.first('departamento') }}</div>
        <br>
        <h5>Nome unidade curricular</h5>
        <select
          class="custom-select"
          v-model="unidadeCurricular.nome_unidade_curricular"
          name="unidade_curricular"
          v-validate="'required'"
          @change="getRegimes(unidadeCurricular.nome_unidade_curricular)"
        >
          <option v-for="uc in ucsDeDepartamento" :value="uc.nome" v-bind:key="uc.nome">{{uc.nome}}</option>
        </select>
        <div
          v-if="unidadesCurriculares.length == 0"
          class="help-block alert alert-danger"
          v-show="errors.has('unidade_curricular')"
        >{{ errors.first('unidade_curricular') }}</div>
        <br>
        <h5>Regime unidade curricular</h5>
        <select
          class="custom-select"
          v-model="unidadeCurricular.regime"
          name="regime"
          v-validate="'required'"
          @change="getTurnos(unidadeCurricular.nome_unidade_curricular, unidadeCurricular.regime)"
        >
          <option
            v-for="regime in regimesParaUC"
            :value="regime.regime"
            v-bind:key="regime.regime"
          >{{regime.regime}}</option>
        </select>
        <div
          v-if="unidadesCurriculares.length == 0"
          class="help-block alert alert-danger"
          v-show="errors.has('regime')"
        >{{ errors.first('regime') }}</div>
        <br>
        <h5>Turno</h5>
        <select
          class="custom-select"
          v-model="unidadeCurricular.turno"
          name="turno"
          v-validate="'required'"
          @change="getTipo(unidadeCurricular.nome_unidade_curricular)"
        >
          <option
            v-for="turno in turnosParaUCeRegime"
            :value="turno.turno"
            v-bind:key="turno.turno"
          >{{turno.turno}}</option>
        </select>
        <div
          v-if="unidadesCurriculares.length == 0"
          class="help-block alert alert-danger"
          v-show="errors.has('turno')"
        >{{ errors.first('turno') }}</div>
        <br>
        <h5>Numero de horas</h5>
        <input
          type="text"
          class="form-control"
          placeholder="Numero de horas semanais"
          name="horas"
          v-validate="'required|min_value:1'"
          v-model="unidadeCurricular.horas"
        >
        <div
          v-if="unidadesCurriculares.length == 0"
          class="help-block alert alert-danger"
          v-show="errors.has('horas')"
        >{{ errors.first('horas') }}</div>
        <br>
        <h5>Numero de horas (semestrais)</h5>
        <input
          type="text"
          class="form-control"
          name="horas_semestrais"
          v-validate="'required|min_value:1'"
          placeholder="Numero de horas semestrais"
          v-model="unidadeCurricular.horas_semestrais"
        >
        <div
          v-if="unidadesCurriculares.length == 0"
          class="help-block alert alert-danger"
          v-show="errors.has('horas_semestrais')"
        >{{ errors.first('horas_semestrais') }}</div>
        <br>
        <button type="button" class="btn btn-success" @click="adicionarOutraUC">Adicionar UC</button>
        <br>
        <span v-if="unidadesCurriculares.length">
          <table class="table">
            <thead>
              <th>Nome</th>
              <th>Regime</th>
              <th>Turno</th>
              <th>Departamento</th>
              <th>Horas</th>
              <th>Horas Semestrais</th>
              <th>Tipo</th>
              <th>Ações</th>
            </thead>
            <tbody>
              <tr v-for="(ucAUX, index) in unidadesCurriculares" :key="ucAUX.id">
                <td>{{ucAUX.nome_unidade_curricular}}</td>
                <td>{{ucAUX.regime}}</td>
                <td>{{ucAUX.turno}}</td>
                <td>{{ucAUX.departamento_id}}</td>
                <td>{{ucAUX.horas}}</td>
                <td>{{ucAUX.horas_semestrais}}</td>
                <td>{{ucAUX.tipo}}</td>
                <td>
                  <button
                    type="button"
                    class="btn btn-danger"
                    v-if="isClicked"
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
        <input
          name="papel"
          v-validate="'required'"
          type="radio"
          v-model="proposta.role"
          value="professor"
        > Professor
        <br>
        <input name="papel" type="radio" v-model="proposta.role" value="assistente"> Assistente
        <br>
        <input name="papel" type="radio" v-model="proposta.role" value="monitor"> Monitor
        <br>
      </div>
      <div
        class="help-block alert alert-danger"
        v-show="errors.has('papel')"
      >{{ errors.first('papel') }}</div>
      <br>
      <br>
      <button
        type="button"
        class="btn btn-success"
        v-on:click="avancar(proposta, unidadesCurriculares)"
        v-if="isClicked"
      >Seguinte</button>
    </div>
    <br>
    <proposta-proponente-professor
      :proposta="proposta"
      :unidadesCurriculares="unidadesCurriculares"
      v-if="roleSelecionado == 'professor' && isFinalized && unidadesCurriculares.length > 0"
    ></proposta-proponente-professor>
    <proposta-proponente-assistente
      :proposta="proposta"
      :unidadesCurriculares="unidadesCurriculares"
      v-if="roleSelecionado == 'assistente' && isFinalized && unidadesCurriculares.length > 0"
    ></proposta-proponente-assistente>
    <proposta-proponente-monitor
      :proposta="proposta"
      :unidadesCurriculares="unidadesCurriculares"
      v-if="roleSelecionado == 'monitor' && isFinalized && unidadesCurriculares.length > 0 "
    ></proposta-proponente-monitor>
    <b-progress class="mt-3" :max="progresso.max" height="2rem">
      <b-progress-bar :value="progresso.valor" variant="success">
        Progresso:
        <strong>{{ progresso.valor }} / {{ progresso.max }}</strong>
      </b-progress-bar>
    </b-progress>
    <!-----------------------------FIM CONTRATAÇÃO INICIAL-------------------------------------->
  </div>
</template>
<script>
module.exports = {
  data() {
    return {
      proposta: {
        tipo_contrato: "",
        unidade_organica: "",
        nome_completo: "",
        role: "",
        data_de_assinatura_coordenador_departamento: "",
        data_de_assinatura_coordenador_de_curso: ""
      },
      unidadeCurricular: {
        nome_unidade_curricular: "",
        regime: "",
        horas: "",
        horas_semestrais: "",
        departamento_id: "",
        turno: "",
        proposta_proponente_id: "",
        tipo: ""
      },
      unidadesCurriculares: [],
      departamentos: [],
      ucsDeDepartamento: [],
      roleSelecionado: "",
      regimesParaUC: [],
      turnosParaUCeRegime: [],
      isClicked: true,
      isFinalized: false,
      progresso: {
        valor: 1,
        max: 3
      }
    };
  },
  methods: {
    avancar: function(proposta, unidadesCurriculares) {
      this.proposta.data_de_assinatura_coordenador_departamento = new Date()
        .toISOString()
        .slice(0, 19)
        .replace("T", " "); //Ver tipo de user autenticado
      this.roleSelecionado = proposta.role;
      console.log(this.errors);
      this.$validator.validateAll().then(() => {
        if (this.unidadesCurriculares.length > 0) {
          this.isFinalized = true;
          this.isClicked = false;
        }
      });
      this.progresso.valor++;
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
    getTipo(uc_name) {
      axios.get("/api/tiposUnidadesCurriculares/" + uc_name).then(response => {
        this.unidadeCurricular.tipo = response.data[0].tipo;
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
        this.unidadeCurricular.departamento_id = [];
      }
    },
    removerUC(index) {
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

<style >
 .col-form-label, .label {
  font-size: 20px;
}

.form-control:focus, .custom-select:focus {
  color: #1a1a1a;
  background-color: #fff;
  border-color: #1a1a1a;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(255, 255, 255,0);
}

.custom-control-label::after {
  
}
</style>
