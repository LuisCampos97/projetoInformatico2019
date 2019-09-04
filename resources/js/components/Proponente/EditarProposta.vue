<template>
  <div>
    <button class="btn btn-danger" @click="voltar">Voltar</button>
    <br><br>
    <b-form-group
      description="Legislação: art. 8.º do ECPDESP na redacção que lhe foi dada pelo Decreto-Lei
      n.º 207/2009, de 31 de Agosto, alterado pela Lei nº 7/2010, de 13 de Maio e
      Regulamento de Contratação de Pessoal Docente Especialmente Contratado ao
      abrigo do art. 8.º do ECPDESP, do IPL"
    ><h3>Proposta de contratação</h3></b-form-group>
    <b-form-group label="Tipo de Proposta" v-show="isShow">
      <b-form-radio-group
        v-model="propostaSelecionada.tipo_contrato"
        :options="tipoContratosArray"
        stacked
      ></b-form-radio-group>
      <b-form-invalid-feedback id="input-1-live-feedback">O Tipo da Proposta é obrigatória!</b-form-invalid-feedback>
    </b-form-group>
    <div v-if="isShow">
      <b-form-group label="Propostas existentes" description="Campo opcional">
        <b-form-select
          :options="propostasExistentes"
          v-model="propostaExistente"
          @change="associarProposta()"
        >
          <template slot="first">
            <option
              :value="null"
              disabled
            >-- Por favor selecione uma proposta existente, caso exista --</option>
          </template>
        </b-form-select>
      </b-form-group>
      <b-form-group label="Currículo (PDF)">
        <b-form-file
          v-model="ficheiroCurriculoModel"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
          browse-text="Procurar"
          name="ficheiroCurriculo"
          v-validate="{ required: true }"
          :state="validateState('ficheiroCurriculo')"
          @change="onFileSelected"
        ></b-form-file>
        <b-form-invalid-feedback id="input-1-live-feedback">O Ficheiro de Currículo é obrigatório!</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group>
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroCurriculo"
          @click="downloadFicheiro(ficheiroCurriculo.proposta_id, 'Curriculo do docente a ser contratado')"
        >
        <i class="far fa-file-pdf"></i> Atual Curriculo do Docente
        </b-button>
      </b-form-group>
      <b-form-group label="Unidade Orgânica">
        <b-form-input :readonly="true" v-model="propostaSelecionada.unidade_organica"></b-form-input>
      </b-form-group>

      <b-form-group label="Nome completo">
        <b-form-input
          :state="!$v.propostaSelecionada.nome_completo.$error && null"
          v-model="propostaSelecionada.nome_completo"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">O Nome completo é obrigatório!</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Email" label-for="inputEmail">
        <b-form-input
          id="inputEmail"
          :state="!$v.propostaSelecionada.email.$error && null"
          v-model="propostaSelecionada.email"
        ></b-form-input>
        <b-form-invalid-feedback
          id="input-1-live-feedback"
        >O Email é obrigatório e deve ser um email válido!</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Numero Telefone" label-for="inputNumeroTelefone">
        <b-form-input
          id="inputNumeroTelefone"
          :state="!$v.propostaSelecionada.numero_telefone.$error && null"
          v-model="propostaSelecionada.numero_telefone"
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
                  :state="!$v.unidadeCurricular.codigo_curso.$error && null"
                  :options="cursos"
                  @change="getUcsDeCurso(unidadeCurricular.codigo_curso)"
                ></b-form-select>
                <b-form-invalid-feedback id="input-1-live-feedback">O Curso é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <b-form-group label="Unidade Curricular" label-for="inputNomeUC">
                <b-form-select
                  id="inputNomeUC"
                  v-model="unidadeCurricular.codigo_uc"
                  :state="!$v.unidadeCurricular.codigo_uc.$error && null"
                  :options="ucs"
                ></b-form-select>
                <b-form-invalid-feedback
                  id="input-1-live-feedback"
                >O Nome da Unidade Curricular é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <b-form-group label="Regime">
                <b-form-select
                  v-model="unidadeCurricular.regime"
                  :state="!$v.unidadeCurricular.regime.$error && null"
                  :options="regimesParaUC"
                ></b-form-select>
                <b-form-invalid-feedback
                  id="input-1-live-feedback"
                >O Regime da Unidade Curricular é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <b-form-group label="Tipo">
                <b-form-select
                  v-model="unidadeCurricular.tipo"
                  :state="!$v.unidadeCurricular.tipo.$error && null"
                  :options="tiposParaUC"
                ></b-form-select>
                <b-form-invalid-feedback
                  id="input-1-live-feedback"
                >O Tipo da Unidade Curricular é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <b-form-group label="Turno">
                <b-form-input
                  :state="!$v.unidadeCurricular.turno.$error && null"
                  v-model="unidadeCurricular.turno"
                ></b-form-input>
                <b-form-invalid-feedback
                  id="input-1-live-feedback"
                >O Turno da Unidade Curricular é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <b-form-group label="Número de horas" label-for="inputNumeroHoras">
                <b-form-input
                  id="inputNumeroHoras"
                  :state="!$v.unidadeCurricular.horas.$error && null"
                  v-model="unidadeCurricular.horas"
                ></b-form-input>
                <b-form-invalid-feedback
                  id="input-1-live-feedback"
                >O Número de horas semanais é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <b-form-group
                label="Número de horas (semestrais)"
                label-for="inputNumeroHorasSemestrais"
              >
                <b-form-input
                  id="inputNumeroHorasSemestrais"
                  :state="!$v.unidadeCurricular.horas_semestrais.$error && null"
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

              <div v-if="unidadesCurriculares.length">
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
              </div>
              <br />
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
                  v-model="propostaSelecionada.grau"
                  :options="grausArray"
                  :state="!$v.propostaSelecionada.grau.$error && null"
                  stacked
                ></b-form-radio-group>
                <b-form-invalid-feedback id="input-1-live-feedback">O Grau é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <b-form-group label="Curso" label-for="inputCursoHabilitacoesLiterarias">
                <b-form-input
                  id="inputCursoHabilitacoesLiterarias"
                  :state="!$v.propostaSelecionada.curso.$error && null"
                  v-model="propostaSelecionada.curso"
                ></b-form-input>
                <b-form-invalid-feedback id="input-1-live-feedback">O Curso é obrigatório!</b-form-invalid-feedback>
              </b-form-group>

              <b-form-group
                label="Área Científica"
                label-for="inputAreaCientificaHabilitacoesLiterarias"
              >
                <b-form-input
                  id="inputAreaCientificaHabilitacoesLiterarias"
                  :state="!$v.propostaSelecionada.area_cientifica.$error && null"
                  v-model="propostaSelecionada.area_cientifica"
                ></b-form-input>
                <b-form-invalid-feedback id="input-1-live-feedback">A Área Científica é obrigatória!</b-form-invalid-feedback>

                <b-form-group
                  label="Certificado de Habilitações (PDF)"
                  class="mt-3"
                >
                  <b-form-file
                    v-model="ficheiroHabilitacoesModel"
                    placeholder="Escolha um ficheiro"
                    drop-placeholder="Arraste para aqui um ficheiro"
                    browse-text="Procurar"
                    name="ficheiroHabilitacoes"
                    v-validate="{ required: true }"
                    :state="validateState('ficheiroHabilitacoes')"
                    @change="onFileSelected"
                  ></b-form-file>
                  <b-form-group>
                    <b-button
                      size="md"
                      variant="dark"
                      v-if="ficheiroHabilitacoes"
                      @click="downloadFicheiro(ficheiroHabilitacoes.proposta_id, 'Habilitacoes do docente a ser contratado')"
                    >
                      <i class="far fa-file-pdf"></i> Atual Ficheiro de Habilitacoes do Docente
                    </b-button>
                  </b-form-group>
                </b-form-group>
              </b-form-group>
            </b-card-text>
          </b-card-body>
        </b-collapse>
      </b-card>

      <b-form-group label="Relatório dos proponentes (PDF)" class="mt-3">
        <b-form-file
          v-model="ficheiroRelatorioModel"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
          browse-text="Procurar"
          name="ficheiroRelatorio"
          v-validate="{ required: true }"
          :state="validateState('ficheiroRelatorio')"
          @change="onFileSelected"
        ></b-form-file>
      </b-form-group>
      <b-form-group>
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroRelatorio"
          @click="downloadFicheiro(ficheiroRelatorio.proposta_id, 'Relatorio dos 2 proponentes')"
        >
          <i class="far fa-file-pdf"></i> Atual Relatório dos 2 proponentes
        </b-button>
      </b-form-group>

      <b-form-group
        label="Qual será o papel a desempenhar pelo docente a ser contratado?"
        class="mt-5"
      >
        <b-form-radio-group
          v-model="propostaSelecionada.role"
          :options="rolesArray"
          :state="!$v.propostaSelecionada.role.$error && null"
          stacked
        ></b-form-radio-group>
        <b-form-invalid-feedback
          id="input-1-live-feedback"
        >A seleção de uma unidade orgânica é obrigatória!</b-form-invalid-feedback>
      </b-form-group>

      <button
        class="btn btn-success mt-3 font-weight-bold"
        v-on:click.prevent="avancar(propostaSelecionada, unidadesCurriculares)"
      >
        Seguinte
        <i class="fas fa-arrow-right"></i>
      </button>
    </div>

    <proposta-proponente-professor
      :proposta="propostaSelecionada"
      :unidadesCurriculares="unidadesCurriculares"
      :ficheiro="ficheiro"
      v-on:mostrarProponente="showComponent"
      v-on:incrementarBarraProgresso="progresso.valor++"
      v-on:decrementarBarraProgresso="progresso.valor--"
      v-if="roleSelecionado == 'professor' && isFinalized"
    ></proposta-proponente-professor>

    <proposta-proponente-assistente
      :proposta="propostaSelecionada"
      :unidadesCurriculares="unidadesCurriculares"
      v-on:mostrarProponente="showComponent"
      :ficheiro="ficheiro"
      v-on:incrementarBarraProgresso="progresso.valor++"
      v-on:decrementarBarraProgresso="progresso.valor--"
      v-if="roleSelecionado == 'assistente' && isFinalized"
    ></proposta-proponente-assistente>

    <proposta-proponente-monitor
      :proposta="propostaSelecionada"
      :unidadesCurriculares="unidadesCurriculares"
      v-on:mostrarProponente="showComponent"
      v-on:incrementarBarraProgresso="progresso.valor++"
      v-on:decrementarBarraProgresso="progresso.valor--"
      :ficheiro="ficheiro"
      v-if="roleSelecionado == 'monitor' && isFinalized"
    ></proposta-proponente-monitor>

    <b-progress class="mt-3" :max="progresso.max" height="2rem">
      <b-progress-bar :value="progresso.valor" variant="success">
        Progresso:
        <strong>{{ progresso.valor }} / {{ progresso.max }}</strong>
      </b-progress-bar>
    </b-progress>
    <br />
     Os dados recolhidos no âmbito deste processo têm como finalidade a celebração de contrato de trabalho em funções públicas e serão objeto de
tratamento nos termos da legislação de proteção de dados em vigor. 

  </div>
</template>

<script>
import { required, email, minLength } from "vuelidate/lib/validators";

export default {
  props: ["propostaSelecionada"],
  data() {
    return {
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
      tiposParaUC: [
        { text: "Semestral", value: "Semestral" },
        { text: "Anual", value: "Anual" }
      ],
      propostaExistente: {},
      propostasExistentes: [],
      unidadesCurriculares: [],
      unidadeCurricular: {
        codigo_uc: "",
        regime: "",
        horas: "",
        horas_semestrais: "",
        codigo_curso: "",
        turno: "",
        tipo: ""
      },
      cursos: [],
      ucs: [],
      roleSelecionado: "",
      isFinalized: false,
      isShow: true,
      progresso: {
        valor: 1,
        max: 3
      },
      ficheiro: {
        fileCurriculo: {},
        fileRelatorio: {},
        fileHabilitacoes: {}
      },
      ficheiros: [],
      ficheiroCurriculo: "",
      ficheiroHabilitacoes: "",
      ficheiroRelatorio: "",
      ficheiroCurriculoModel: "",
      ficheiroHabilitacoesModel: "",
      ficheiroRelatorioModel: "",
    }
  },
  validations: {
    propostaSelecionada: {
      tipo_contrato: { required },
      unidade_organica: { required },
      nome_completo: { required },
      email: { required, email },
      numero_telefone: { required, minLength: minLength(9) },
      grau: { required },
      curso: { required },
      area_cientifica: { required },
      role: { required }
    },
    unidadeCurricular: {
      codigo_curso: { required },
      codigo_uc: { required },
      regime: { required },
      tipo: { required },
      turno: { required },
      horas: { required },
      horas_semestrais: { required }
    }
  },
  methods: {
    voltar() {
      this.$emit('voltar');
    },
    validateState(ref) {
      return this.veeErrors.has(ref) ? false : null;
    },
    onFileSelected(event) {
      this.ficheiros[event.target.name] = event.target.files[0];
    },
    downloadFicheiro(proposta_id, descricao) {
      axios
        .get("/api/downloadFicheiro/" + proposta_id + "/" + descricao, {
          responseType: "arraybuffer"
        })
        .then(response => {
          let blob = new Blob([response.data]);
          let link = document.createElement("a");
          link.href = window.URL.createObjectURL(blob);
          link.download = descricao + ".pdf";
          link.click();
        });
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
    showComponent() {
      this.isShow = true;
      this.isFinalized = false;
      this.progresso.valor--;
      this.voltarVar = true;
       if(this.propostaSelecionada.fundamentacao_coordenador_departamento != null || this.propostaSelecionada.fundamentacao_coordenador_curso != null){
         this.voltar();
       }
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
    associarProposta() {
      //* Limpar Objectos
      this.unidadesCurriculares = [];
      Object.assign(this.propostaExistente, {});

      //* Associar proposta atual à proposta existente selecionada
      Object.assign(this.propostaSelecionada, this.propostaExistente);
      this.propostaSelecionada.data_de_assinatura_coordenador_de_curso = null;
      this.propostaSelecionada.data_de_assinatura_coordenador_departamento = null;
      this.propostaSelecionada.fundamentacao_coordenador_curso = null;
      this.propostaSelecionada.fundamentacao_coordenador_departamento = null;

      axios
        .get("/api/ficheiros/" + this.propostaExistente.id_proposta_proponente)
        .then(response => {
          response.data.forEach(ficheiro => {
            if (ficheiro.descricao == "Curriculo do docente a ser contratado"){
              this.ficheiroCurriculo = ficheiro;
            }   
            
            if (ficheiro.descricao == "Relatorio dos 2 proponentes")
              this.ficheiroRelatorio = ficheiro;

            if (
              this.propostaSelecionada.tipo_contrato == "contratacao_inicial" &&
              ficheiro.descricao == "Habilitacoes do docente a ser contratado"
            ) {
              this.ficheiroHabilitacoes = ficheiro;
            }
          });
        });

      axios
        .get("/api/getUcsPropostaProponente/" + this.propostaExistente.id_proposta_proponente)
        .then(response => {
          response.data.forEach(uc => {
            this.unidadesCurriculares.push(uc);
          });
        });

        this.$store.commit('setPropostaExistente');
    },
    avancar: function(proposta, unidadesCurriculares) {
      //? Necessário o FormData para passar a informção do ficheiro para o backend "Laravel"
      this.ficheiro.fileCurriculo = new FormData();
      this.ficheiro.fileCurriculo.append(
        "file",
        this.ficheiros["ficheiroCurriculo"]
      );
      this.ficheiro.fileCurriculo.append(
        "descricao",
        "Curriculo do docente a ser contratado"
      );
      
      if (this.propostaSelecionada.tipo_contrato == "contratacao_inicial") {
        this.ficheiro.fileHabilitacoes = new FormData();
        this.ficheiro.fileHabilitacoes.append(
          "file",
          this.ficheiros["ficheiroHabilitacoes"]
        );
        this.ficheiro.fileHabilitacoes.append(
          "descricao",
          "Habilitacoes do docente a ser contratado"
        );
      }

      this.ficheiro.fileRelatorio = new FormData();
      this.ficheiro.fileRelatorio.append(
        "file",
        this.ficheiros["ficheiroRelatorio"]
      );
      this.ficheiro.fileRelatorio.append(
        "descricao",
        "Relatorio dos 2 proponentes"
      );

      this.roleSelecionado = proposta.role;
      this.$v.propostaSelecionada.$touch();
      this.$validator.validateAll().then(result => {
        if (result) {
          if (!this.$v.propostaSelecionada.$invalid && unidadesCurriculares.length > 0) {
            this.$store.commit("setProposta", proposta);
            this.isFinalized = true;
            this.isShow = false;
            this.progresso.valor++;
            this.voltarVar = false;
          }
        } else {
          this.$bvToast.toast('O formulário possui erros, por favor verifique!', {
          title: 'Mensagem de Erro',
          variant: 'danger',
          appendToast: true,
          solid: true
        })
        }
      });
    },
  },
  mounted() {
    this.$store.commit('setEditarProposta');

    axios.get("/api/cursosDisponiveis").then(response => {
      response.data.forEach(curso => {
        this.cursos.push({
          value: curso.codigo,
          text: curso.nome_curso
        });
      });
    });

    axios.get("/api/allPropostasProponente").then(response => {
      response.data.forEach(proposta => {
        this.propostasExistentes.push({
          value: proposta,
          text:
            proposta.unidade_organica +
            " - " +
            proposta.nome_completo +
            " - " +
            proposta.role +
            " - " +
            proposta.tipo_contrato
        });
      });
    });

    axios
        .get("/api/getUcsPropostaProponente/" + this.propostaSelecionada.id_proposta_proponente)
        .then(response => {
          response.data.forEach(uc => {
            this.unidadesCurriculares.push(uc);
          });
        });

    axios
        .get("/api/ficheiros/" + this.propostaSelecionada.id_proposta_proponente)
        .then(response => {
          response.data.forEach(ficheiro => {
            if (ficheiro.descricao == "Curriculo do docente a ser contratado"){
              this.ficheiroCurriculo = ficheiro;
            }   
            
            if (ficheiro.descricao == "Relatorio dos 2 proponentes")
              this.ficheiroRelatorio = ficheiro;

            if (
              this.propostaSelecionada.tipo_contrato == "contratacao_inicial" &&
              ficheiro.descricao == "Habilitacoes do docente a ser contratado"
            ) {
              this.ficheiroHabilitacoes = ficheiro;
            }
          });
        });
  }
}
</script>