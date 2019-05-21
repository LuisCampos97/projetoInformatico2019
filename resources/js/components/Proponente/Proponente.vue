<template>
  <div>
    <link href="https://cdn.jsdelivr.net/npm/animate.css@3.5.1" rel="stylesheet" type="text/css">
    <h2 class="pb-4">Nova Proposta</h2>
    <b-form-group label="Tipo de Proposta" v-show="isShow">
      <b-form-radio-group v-model="proposta.tipo_contrato" :options="tipoContratosArray" stacked></b-form-radio-group>
    </b-form-group>

    <!-----------------CONTRATAÇÃO INICIAL-------------------------------------------->

    <div v-if="proposta.tipo_contrato == 'contratacao_inicial' && isShow">
      <b-form-group label="Currículo">
        <b-form-file
          v-model="ficheiroCurriculo"
          :state="Boolean(ficheiroCurriculo)"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
        ></b-form-file>
      </b-form-group>

      <b-form-group label="Unidade Orgânica">
        <b-form-input :readonly="true" v-model="proposta.unidade_organica"></b-form-input>
      </b-form-group>

      <b-form-group label="Nome completo" label-for="inputNomeCompleto">
        <b-form-input
          id="inputNomeCompleto"
          :state="$v.proposta.nome_completo.$dirty ? !$v.proposta.nome_completo.$error : null"
          v-model="proposta.nome_completo"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">O Nome completo é obrigatório!</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Email" label-for="inputEmail">
        <b-form-input
          id="inputEmail"
          :state="$v.proposta.email.$dirty ? !$v.proposta.email.$error : null"
          v-model="proposta.email"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">O Email é obrigatório!</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Numero Telefone" label-for="inputNumeroTelefone">
        <b-form-input
          id="inputNumeroTelefone"
          :state="$v.proposta.numero_telefone.$dirty ? !$v.proposta.numero_telefone.$error : null"
          v-model="proposta.numero_telefone"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">O Numero de telefone é obrigatório!</b-form-invalid-feedback>
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
                  v-model="unidadeCurricular.codigo_curso"
                  :state="$v.unidadeCurricular.codigo_curso.$dirty ? !$v.unidadeCurricular.codigo_curso.$error : null"
                  :options="cursos"
                  @change="getUcsDeCurso(unidadeCurricular.codigo_curso)"
                ></b-form-select>
                <b-form-invalid-feedback id="input-1-live-feedback">O Curso é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <b-form-group label="Nome unidade curricular" label-for="inputNomeUC">
                <b-form-select
                  id="inputNomeUC"
                  v-model="unidadeCurricular.codigo_uc"
                  :state="$v.unidadeCurricular.codigo_uc.$dirty ? !$v.unidadeCurricular.codigo_uc.$error : null"
                  :options="ucs"
                  @change="getTipo(unidadeCurricular.codigo_uc)"
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
                ></b-form-select>
                <b-form-invalid-feedback
                  id="input-1-live-feedback"
                >O Regime da Unidade Curricular é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <b-form-group label="Turno">
                <b-form-input
                  :state="$v.unidadeCurricular.turno.$dirty ? !$v.unidadeCurricular.turno.$error : null"
                  v-model="unidadeCurricular.turno"
                ></b-form-input>
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
                    <th>Código</th>
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
                      <td>{{ucAUX.codigo_uc.toString()}}</td>
                      <td>{{ucAUX.regime}}</td>
                      <td>{{ucAUX.turno}}</td>
                      <td>{{ucAUX.codigo_curso}}</td>
                      <td>{{ucAUX.horas}}</td>
                      <td>{{ucAUX.horas_semestrais}}</td>
                      <td>{{ucAUX.tipo}}</td>
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
                <b-form-radio-group
                  v-model="opcaoOutro"
                  :options="[{ text: 'Outro', value: 'outro' }]"
                  stacked
                ></b-form-radio-group>

                <b-form-input v-if="opcaoOutro == 'outro'" v-model="proposta.grau"></b-form-input>
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

                <b-form-group
                  label="Certificado de Habilitações"
                  v-if="proposta.tipo_contrato == 'contratacao_inicial'"
                  class="mt-3"
                >
                  <b-form-file
                    v-model="ficheiroHabilitacoes"
                    :state="Boolean(ficheiroHabilitacoes)"
                    placeholder="Escolha um ficheiro"
                    drop-placeholder="Arraste para aqui um ficheiro"
                  ></b-form-file>
                </b-form-group>
              </b-form-group>
            </b-card-text>
          </b-card-body>
        </b-collapse>
      </b-card>

      <b-form-group label="Relatório dos proponentes" class="mt-3">
        <b-form-file
          v-model="ficheiroRelatorio"
          :state="Boolean(ficheiroRelatorio)"
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

    <proposta-proponente-professor
      :proposta="proposta"
      :unidadesCurriculares="unidadesCurriculares"
      :ficheiro="ficheiro"
      v-on:mostrarProponente="showComponent"
      v-on:incrementarBarraProgresso="progresso.valor++"
      v-if="roleSelecionado == 'professor' && isFinalized"
    ></proposta-proponente-professor>

    <proposta-proponente-assistente
      :proposta="proposta"
      :unidadesCurriculares="unidadesCurriculares"
      v-on:mostrarProponente="showComponent"
      :ficheiro="ficheiro"
      v-on:incrementarBarraProgresso="progresso.valor++"
      v-if="roleSelecionado == 'assistente' && isFinalized"
    ></proposta-proponente-assistente>

    <proposta-proponente-monitor
      :proposta="proposta"
      :unidadesCurriculares="unidadesCurriculares"
      v-on:mostrarProponente="showComponent"
      v-on:incrementarBarraProgresso="progresso.valor++"
      :ficheiro="ficheiro"
      v-if="roleSelecionado == 'monitor' && isFinalized"
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
        { text: "Contratação Inicial", value: "contratacao_inicial" },
        { text: "Renovação", value: "renovacao" },
        { text: "Alteração", value: "alteracao" }
      ],
      grausArray: [
        { text: "Licenciatura", value: "licenciatura" },
        { text: "Mestrado", value: "mestrado" },
        { text: "Doutoramento", value: "doutoramento" }
      ],
      rolesArray: [
        { text: "Professor", value: "professor" },
        { text: "Assistente", value: "assistente" },
        { text: "Monitor", value: "monitor" }
      ],
      regimesParaUC: [
        { text: "Diurno", value: "Diurno" },
        { text: "Pós-laboral", value: "Pos-Laboral" }
      ],
      proposta: {
        tipo_contrato: "",
        unidade_organica: this.$store.state.user.unidade_organica,
        nome_completo: "",
        email:"",
        numero_telefone:"",
        role: "",
        data_de_assinatura_coordenador_departamento: "",
        data_de_assinatura_coordenador_de_curso: "",
        fundamentacao_coordenador_curso: "",
        fundamentacao_coordenador_departamento: "",
        grau: "",
        area_cientifica: "",
        curso: ""
      },
      unidadeCurricular: {
        codigo_uc: "",
        regime: "",
        horas: "",
        horas_semestrais: "",
        codigo_curso: "",
        turno: "",
        tipo: ""
      },
      unidadesCurriculares: [],
      cursos: [],
      ucs: [],
      roleSelecionado: "",
      isFinalized: false,
      isShow: true,
      progresso: {
        valor: 1,
        max: 3
      },
      opcaoOutro: "",
      ficheiro: {
        fileCurriculo: {
          nome: "",
          descricao: "Curriculo do docente a ser contratado",
          proposta_id: ""
        },
        fileRelatorio: {
          nome: "",
          descricao: "Relatorio dos 2 proponentes",
          proposta_id: ""
        },
        fileHabilitacoes: {
          nome: "",
          descricao: "Habilitacoes do docente a ser contratado",
          proposta_id: ""
        }
      },
      ficheiroCurriculo: "",
      ficheiroHabilitacoes: "",
      ficheiroRelatorio: ""
    };
  },
  //? Validations Vuelidate
  validations: {
    proposta: {
      unidade_organica: { required },
      nome_completo: { required },
      email: { required },
      numero_telefone: { required },
      grau: { required },
      curso: { required },
      area_cientifica: { required },
      role: { required }
    },
    unidadeCurricular: {
      codigo_curso: { required },
      codigo_uc: { required },
      regime: { required },
      turno: { required },
      horas: { required },
      horas_semestrais: { required }
    },

    ficheiro: {
      fileCurriculo: {
        nome: { required }
      },
      fileRelatorio: {
        nome: { required }
      },
      fileHabilitacoes: {
        nome: { required }
      }
    }
  },
  methods: {
    avancar: function(proposta, unidadesCurriculares) {
      this.ficheiro.fileCurriculo.nome = this.ficheiroCurriculo.name;
      this.ficheiro.fileRelatorio.nome = this.ficheiroRelatorio.name;
      this.ficheiro.fileHabilitacoes.nome = this.ficheiroHabilitacoes.name;
      this.roleSelecionado = proposta.role;
      this.$v.proposta.$touch();
      if (!this.$v.proposta.$invalid && unidadesCurriculares.length > 0) {
        this.$store.commit("setProposta", proposta);
        this.isFinalized = true;
        this.isShow = false;
        this.progresso.valor++;
      }
    },

    getUcsDeCurso(codigo_curso) {
      this.ucs = [];

      axios
        .get("/api/unidadesCurricularesDoCursoSelecionado/" + codigo_curso)
        .then(response => {
          response.data.forEach(uc => {
            this.ucs.push({ text: uc.nome, value: uc.codigo });
          });
        });
    },
    getTipo(codigo_uc) {
      axios
        .get("/api/tiposUnidadesCurriculares/" + codigo_uc)
        .then(response => {
          this.unidadeCurricular.tipo = response.data[0].tipo;
        });
    },
    adicionarUC() {
      this.$v.unidadeCurricular.$touch();
      if (!this.$v.unidadeCurricular.$invalid) {
        this.unidadesCurriculares.push(this.unidadeCurricular);

        this.$v.unidadeCurricular.$reset();

        //* Colocar os campos vazios
        this.unidadeCurricular = {};
        this.ucs = [];
      }
    },
    removerUC(index) {
      delete this.unidadesCurriculares[index];
      this.unidadesCurriculares.splice(index, 1);
    },
    showComponent() {
      this.isShow = true;
      this.isFinalized = false;
      this.progresso.valor--;
    }
  },

  mounted() {
    axios.get("/api/cursosDisponiveis").then(response => {
      response.data.forEach(curso => {
        this.cursos.push({
          value: curso.codigo,
          text: curso.nome_curso
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
