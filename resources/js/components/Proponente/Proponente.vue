<template>
  <div v-if="isShow">
    <h2 class="pb-4">Nova Proposta</h2>
    <b-form-group label="Tipo de Proposta">
      <b-form-radio-group v-model="proposta.tipo_contrato" :options="tipoContratosArray" stacked></b-form-radio-group>
    </b-form-group>

    <!-----------------CONTRATAÇÃO INICIAL-------------------------------------------->

    <div v-if="proposta.tipo_contrato == 'Contratacao Inicial'">
      <b-form-group label="Currículo">
        <b-form-file
          v-model="fileCurriculo"
          :state="Boolean(fileCurriculo)"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
        ></b-form-file>
      </b-form-group>
      <b-form-group label="Unidade Orgânica">
        <b-form-radio-group
          v-model="proposta.unidade_organica"
          :options="unidadesOrganicasArray"
          :state="$v.proposta.unidade_organica.$dirty ? !$v.proposta.unidade_organica.$error : null"
          stacked
        ></b-form-radio-group>
        <b-form-invalid-feedback
          id="input-1-live-feedback"
        >A seleção de uma unidade orgânica é obrigatória!</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Nome completo" label-for="inputNomeCompleto">
        <b-form-input
          id="inputNomeCompleto"
          :state="$v.proposta.nome_completo.$dirty ? !$v.proposta.nome_completo.$error : null"
          v-model="proposta.nome_completo"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">O Nome completo é obrigatório!</b-form-invalid-feedback>
      </b-form-group>

      <b-card no-body class="mb-1">
        <b-card-header header-tag="header" class="p-1" role="tab">
          <b-button block href="#" v-b-toggle.accordion-1 variant="dark">Unidades Curriculares</b-button>
        </b-card-header>
        <b-collapse id="accordion-1" accordion="accordion" role="tabpanel">
          <b-card-body>
            <b-card-text>
              <h3 class="pb-4">Unidades Curriculares</h3>

              <b-form-group label="Curso" label-for="inputCurso">
                <b-form-select
                  id="inputCurso"
                  v-model="unidadeCurricular.curso_id"
                  :state="$v.unidadeCurricular.curso_id.$dirty ? !$v.unidadeCurricular.curso_id.$error : null"
                  :options="cursos"
                  @change="getUcsDeCurso(unidadeCurricular.curso_id)"
                ></b-form-select>
                <b-form-invalid-feedback id="input-1-live-feedback">O Curso é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <b-form-group label="Nome unidade curricular" label-for="inputNomeUC">
                <b-form-select
                  id="inputNomeUC"
                  v-model="unidadeCurricular.nome_unidade_curricular"
                  :state="$v.unidadeCurricular.nome_unidade_curricular.$dirty ? !$v.unidadeCurricular.nome_unidade_curricular.$error : null"
                  :options="ucsDeDepartamento"
                  @change="getRegimes(unidadeCurricular.nome_unidade_curricular, unidadeCurricular.curso_id)"
                ></b-form-select>
                <b-form-invalid-feedback
                  id="input-1-live-feedback"
                >O Nome da Unidade Curricular é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <b-form-group label="Regime unidade curricular" label-for="inputRegimeUC">
                <b-form-select
                  id="inputRegimeUC"
                  v-model="unidadeCurricular.regime"
                  :state="$v.unidadeCurricular.regime.$dirty ? !$v.unidadeCurricular.regime.$error : null"
                  :options="regimesParaUC"
                  @change="getTurnos(unidadeCurricular.nome_unidade_curricular, unidadeCurricular.regime, unidadeCurricular.curso_id)"
                ></b-form-select>
                <b-form-invalid-feedback
                  id="input-1-live-feedback"
                >O Regime da Unidade Curricular é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <b-form-group label="Turno" label-for="inputTurno">
                <b-form-select
                  id="inputTurno"
                  v-model="unidadeCurricular.turno"
                  :state="$v.unidadeCurricular.turno.$dirty ? !$v.unidadeCurricular.turno.$error : null"
                  :options="turnosParaUCeRegime"
                  @change="getTipo(unidadeCurricular.nome_unidade_curricular)"
                ></b-form-select>
                <b-form-invalid-feedback
                  id="input-1-live-feedback"
                >O Turno da Unidade Curricular é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <b-form-group label="Numero de horas" label-for="inputNumeroHoras">
                <b-form-input
                  id="inputNumeroHoras"
                  :state="$v.unidadeCurricular.horas.$dirty ? !$v.unidadeCurricular.horas.$error : null"
                  v-model="unidadeCurricular.horas"
                ></b-form-input>
                <b-form-invalid-feedback
                  id="input-1-live-feedback"
                >O Número de horas semanais é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <b-form-group
                label="Numero de horas (semestrais)"
                label-for="inputNumeroHorasSemestrais"
              >
                <b-form-input
                  id="inputNumeroHorasSemestrais"
                  :state="$v.unidadeCurricular.horas_semestrais.$dirty ? !$v.unidadeCurricular.horas_semestrais.$error : null"
                  v-model="unidadeCurricular.horas_semestrais"
                ></b-form-input>
                <b-form-invalid-feedback
                  id="input-1-live-feedback"
                >O Número de horas semestrais é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <button
                class="btn btn-success mt-3 font-weight-bold"
                v-on:click.prevent="adicionarUC"
              >
                <i class="fas fa-plus"></i> Adicionar UC
              </button>

              <span v-if="unidadesCurriculares.length">
                <table class="table mt-3">
                  <thead>
                    <th>Nome</th>
                    <th>Regime</th>
                    <th>Turno</th>
                    <th>Curso</th>
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
            </b-card-text>
          </b-card-body>
        </b-collapse>
      </b-card>

      <b-card no-body class="mb-1">
        <b-card-header header-tag="header" class="p-1" role="tab">
          <b-button block href="#" v-b-toggle.accordion-2 variant="dark">Habilitações Literárias</b-button>
        </b-card-header>
        <b-collapse id="accordion-2" accordion="accordion" role="tabpanel">
          <b-card-body>
            <b-card-text>
              <h3 class="pb-4">Habilitações Literárias</h3>
              <b-form-group label="Grau">
                <b-form-radio-group
                  v-model="proposta.grau"
                  :options="grausArray"
                  :state="$v.proposta.grau.$dirty ? !$v.proposta.grau.$error : null"
                  stacked
                ></b-form-radio-group>
                <b-form-invalid-feedback id="input-1-live-feedback">O Grau é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <b-form-group label="Curso" label-for="inputCursoHabilitacoesLiterarias">
                <b-form-input
                  id="inputCursoHabilitacoesLiterarias"
                  :state="$v.proposta.curso.$dirty ? !$v.proposta.curso.$error : null"
                  v-model="proposta.curso"
                ></b-form-input>
                <b-form-invalid-feedback id="input-1-live-feedback">O Curso é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <b-form-group
                label="Área Científica"
                label-for="inputAreaCientificaHabilitacoesLiterarias"
              >
                <b-form-input
                  id="inputAreaCientificaHabilitacoesLiterarias"
                  :state="$v.proposta.area_cientifica.$dirty ? !$v.proposta.area_cientifica.$error : null"
                  v-model="proposta.area_cientifica"
                ></b-form-input>
                <b-form-invalid-feedback id="input-1-live-feedback">A Área Científica é obrigatória!</b-form-invalid-feedback>

                <b-form-group label="Certificado de Habilitações" v-if="proposta.tipo_contrato == 'Contratacao Inicial'">
                  <b-form-file
                    v-model="certificadoHabilitações"
                    :state="Boolean(certificadoHabilitações)"
                    placeholder="Escolha um ficheiro"
                    drop-placeholder="Arraste para aqui um ficheiro"
                  ></b-form-file>
                </b-form-group>
              </b-form-group>
            </b-card-text>
          </b-card-body>
        </b-collapse>
      </b-card>

      <b-form-group label="Relatório dos proponentes">
        <b-form-file
          v-model="fileRelatorio"
          :state="Boolean(fileRelatorio)"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
        ></b-form-file>
      </b-form-group>

      <b-form-group
        label="Qual será o papel a desempenhar pelo docente a ser contratado?"
        class="mt-5"
      >
        <b-form-radio-group
          v-model="proposta.role"
          :options="rolesArray"
          :state="$v.proposta.role.$dirty ? !$v.proposta.role.$error : null"
          stacked
        ></b-form-radio-group>
        <b-form-invalid-feedback
          id="input-1-live-feedback"
        >A seleção de uma unidade orgânica é obrigatória!</b-form-invalid-feedback>
      </b-form-group>

      <button
        class="btn btn-success mt-3 font-weight-bold"
        v-on:click.prevent="avancar(proposta, unidadesCurriculares)"
      >
        Seguinte
        <i class="fas fa-arrow-right"></i>
      </button>
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
import { required } from "vuelidate/lib/validators";

export default {
  data() {
    return {
      //? Array de Objetos para Radio Buttons
      tipoContratosArray: [
        { text: "Contratação Inicial", value: "Contratacao Inicial" },
        { text: "Renovação", value: "Renovacao" },
        { text: "Alteração", value: "Alteracao" }
      ],
      unidadesOrganicasArray: [
        { text: "ESECS", value: "ESECS" },
        { text: "ESTG", value: "ESTG" },
        { text: "ESSLei", value: "ESSLei" },
        { text: "ESTM", value: "ESTM" },
        { text: "ESAD.CR", value: "ESAD.CR" }
      ],
      grausArray: [
        { text: "Licenciatura", value: "Licenciatura" },
        { text: "Mestrado", value: "Mestrado" },
        { text: "Doutoramento", value: "Doutoramento" },
        { text: "Outro", value: "Outro"}
      ],
      rolesArray: [
        { text: "Professor", value: "professor" },
        { text: "Assistente", value: "assistente" },
        { text: "Monitor", value: "monitor" }
      ],
      proposta: {
        tipo_contrato: "",
        unidade_organica: "",
        nome_completo: "",
        role: "",
        data_de_assinatura_coordenador_departamento: "",
        data_de_assinatura_coordenador_de_curso: "",
        grau: "",
        area_cientifica: "",
        curso: ""
      },
      unidadeCurricular: {
        nome_unidade_curricular: "",
        regime: "",
        horas: "",
        horas_semestrais: "",
        departamento_id: "",
        curso_id: "",
        turno: "",
        proposta_proponente_id: "",
        tipo: ""
      },
      unidadesCurriculares: [],
      departamento_id: "",
      cursos: [],
      ucsDeDepartamento: [],
      roleSelecionado: "",
      regimesParaUC: [],
      turnosParaUCeRegime: [],
      isClicked: true,
      isFinalized: false,
      isShow: true,
      progresso: {
        valor: 1,
        max: 3
      },
      fileCurriculo: null,
      fileRelatorio: null,
      certificadoHabilitações: null
    };
  },
  //? Validations Vuelidate
  validations: {
    proposta: {
      unidade_organica: { required },
      nome_completo: { required },
      grau: { required },
      curso: { required },
      area_cientifica: { required },
      role: { required }
    },
    unidadeCurricular: {
      curso_id: { required },
      nome_unidade_curricular: { required },
      regime: { required },
      turno: { required },
      horas: { required },
      horas_semestrais: { required }
    }
  },
  methods: {
    avancar: function(proposta, unidadesCurriculares) {
      this.proposta.data_de_assinatura_coordenador_departamento = new Date()
        .toISOString()
        .slice(0, 19)
        .replace("T", " "); //Ver tipo de user autenticado
      this.roleSelecionado = proposta.role;
      this.$v.proposta.$touch();
      if (!this.$v.proposta.$invalid && unidadesCurriculares.length > 0) {
        this.isFinalized = true;
        this.isClicked = false;
        this.isShow = false;
        this.progresso.valor++; 
      }
    },

    getUcsDeCurso(curso_id) {
      this.ucsDeDepartamento = [];
      this.regimesParaUC = [];
      this.turnosParaUCeRegime = [];
      axios
        .get(
          "/api/unidadesCurricularesDoCursoSelecionado/" +
            curso_id +
            "/" +
            this.departamento_id
        )
        .then(response => {
          response.data.forEach(x => {
            this.ucsDeDepartamento.push({ text: x.nome });
          });
        });
    },
    getRegimes(uc_name, curso_id) {
      this.regimesParaUC = [];
      this.turnosParaUCeRegime = [];
      axios
        .get("/api/unidadesCurriculares/regime/" + uc_name + "/" + curso_id)
        .then(response => {
          response.data.forEach(x => {
            this.regimesParaUC.push({ text: x.regime });
          });
        });
    },
    getTurnos(uc_name, uc_regime, curso_id) {
      this.turnosParaUCeRegime = [];
      axios
        .get(
          "/api/unidadesCurriculares/" +
            uc_name +
            "/" +
            uc_regime +
            "/" +
            curso_id
        )
        .then(response => {
          response.data.forEach(x => {
            this.turnosParaUCeRegime.push({ text: x.turno });
          });
        });
    },
    getTipo(uc_name) {
      axios.get("/api/tiposUnidadesCurriculares/" + uc_name).then(response => {
        this.unidadeCurricular.tipo = response.data[0].tipo;
      });
    },
    adicionarUC() {
      this.$v.unidadeCurricular.$touch();
      if (!this.$v.unidadeCurricular.$invalid) {
        this.unidadesCurriculares.push(this.unidadeCurricular);

        //* Colocar os campos vazios
        this.$v.unidadeCurricular.$reset();
      }
    },
    removerUC(index) {
      delete this.unidadesCurriculares[index];
      this.unidadesCurriculares.splice(index, 1);
    },
    /*
    submitFile(){
            let formData = new FormData();
            formData.append('file', this.file);

            axios.post( '/single-file',
                formData,
                {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              }
            ).then(function(){
          console.log('SUCCESS!!');
        })
        .catch(function(){
          console.log('FAILURE!!');
        });
      },
      */
    handleFileUpload(file) {
      console.log(file);
      //this.file = this.$refs.file.files[0];
    }
  },

  mounted() {
    axios
      .get(
        "/api/departamento/" +
          "Coordenador do Departamento de Engenharia Informática"
      )
      .then(response => {
        this.departamento_id = response.data[0].id;
        this.unidadeCurricular.departamento_id = this.departamento_id;
        axios
          .get("/api/cursosDisponiveis/" + this.departamento_id)
          .then(response => {
            response.data.forEach(x => {
              this.cursos.push({ value: x.id, text: x.nome_curso });
            });
          });
      });
  }
};
</script>

<style >
.col-form-label,
.label,
.d-block {
  font-size: 20px;
  font-weight: 600;
}

.form-control:focus,
.custom-select:focus {
  color: #1a1a1a;
  background-color: #fff;
  border-color: #1a1a1a;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0);
}

.btn-dark {
  background-color: #1a1a1a;
}
</style>
