<template>
  <div>
    <div v-if="this.$store.state.user.roleDB == 'proponente_departamento'">
      <button class="btn btn-danger" @click="voltarProponentes">Voltar</button>
      <h3>Resumo da proposta de contratação</h3>
    </div>

    <div v-if="this.$store.state.user.roleDB == 'proponente_curso'">
      <button class="btn btn-danger" @click="voltarProponentes">Voltar</button>
      <h3>Resumo da proposta de contratação</h3>
    </div>

    <div v-if="this.$store.state.user.roleDB == 'diretor_uo'">
      <button class="btn btn-danger" @click="voltarDiretor">Voltar</button>
      <h3>Resumo da proposta de contratação</h3>
    </div>

    <div v-if="this.$store.state.user.roleDB == 'ctc'">
      <button class="btn btn-danger" @click="voltarCTC">Voltar</button>
      <h3>Resumo da proposta de contratação</h3>
    </div>

    <div v-if="this.$store.state.user.roleDB == 'secretariado_direcao'">
      <button class="btn btn-danger" @click="voltarSecretariado">Voltar</button>
      <h3>Resumo da proposta de contratação</h3>
    </div>

    <div v-if="this.$store.state.user.roleDB == 'recursos_humanos'">
      <h3>Resumo da proposta de contratação</h3>
      <button class="btn btn-danger" @click="voltarRecursosHumanos">Voltar</button>
    </div>
    <div id="proposta">
      <label>Unidade Orgânica: {{ propostaSelecionada.unidade_organica }}</label>
      <br />
      <label>Nome do Docente: {{ propostaSelecionada.nome_completo}}</label>
      <br />
      <label>Tipo de Contratação: {{ propostaSelecionada.tipo_contratato }}</label>
      <br />
      <label>Email do docente: {{ propostaSelecionada.email }}</label>
      <br />
      <label>Número de telefone do docente: {{ propostaSelecionada.numero_telefone }}</label>
      <br />
      <label>Unidades Curriculares:</label>
      <br />
      <b-form-group>
        <table class="table mt-3">
          <thead>
            <th>Codigo UC</th>
            <th>Turno</th>
            <th>Regime</th>
            <th>Horas</th>
            <th>Horas Semestrais</th>
            <th>Tipo</th>
          </thead>
          <tbody>
            <tr v-for="uc in ucsDaPropostaSelecionada" :key="uc.ID">
              <td>{{ uc.codigo_uc }}</td>
              <td>{{ uc.turno }}</td>
              <td>{{ uc.regime }}</td>
              <td>{{ uc.horas }}</td>
              <td>{{ uc.horas_semestrais }}</td>
              <td>{{ uc.tipo }}</td>
            </tr>
          </tbody>
        </table>
      </b-form-group>
      <label>Grau de Habilitações Académicas: {{ propostaSelecionada.grau }}</label>
      <br />
      <label>Área Científica: {{ propostaSelecionada.area_cientifica }}</label>
      <br />
      <label>Curso: {{ propostaSelecionada.curso }}</label>
      <br />
      <label>Papel a desempenhar: {{ propostaSelecionada.role }}</label>
      <br />
      <div v-if="propostaSelecionada.role == 'professor'">
        <label>Categoria de professor: {{ tipoPropostaRole.role_professor }}</label>
        <br />
        <label>Regime de prestação de serviços: {{ tipoPropostaRole.regime_prestacao_servicos }}</label>
        <br />
        <label>Percentagem de prestação de serviços: {{ tipoPropostaRole.percentagem_prestacao_servicos }}</label>
        <br />
        <label>Período: {{ tipoPropostaRole.periodo }}</label>
        <br />
        <label>Duração: {{ tipoPropostaRole.duracao }}</label>
        <br />
      </div>

      <label>Fundamentação do Coordenador de Curso: {{ propostaSelecionada.fundamentacao_coordenador_curso }}</label>
      <br />
      <label>Fundamentação do Coordenador de Departamento: {{ propostaSelecionada.fundamentacao_coordenador_departamento }}</label>
      <br />

      <b-form-group label="Curriculo do docente">
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroCurriculo"
          @click="downloadFicheiro(ficheiroCurriculo.proposta_id, 'Curriculo do docente a ser contratado')"
        >
          <i class="far fa-file-pdf"></i> Atual Curriculo do Docente
        </b-button>
      </b-form-group>

      <b-form-group label="Certificado de Habilitações do docente">
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroCertificadoHabilitacoes"
          @click="downloadFicheiro(ficheiroCertificadoHabilitacoes.proposta_id, 'Habilitacoes do docente a ser contratado')"
        >
          <i class="far fa-file-pdf"></i> Atual Certificado de Habilitações do Docente
        </b-button>
      </b-form-group>

      <b-form-group label="Relatório dos dois proponentes">
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroRelatorioProponentes"
          @click="downloadFicheiro(ficheiroRelatorioProponentes.proposta_id, 'Relatorio dos 2 proponentes')"
        >
          <i class="far fa-file-pdf"></i> Atual Certificado de Habilitações do Docente
        </b-button>
      </b-form-group>

      <div
        v-if="propostaSelecionada.proposta_diretor_uo_id != null &&(this.$store.state.user.roleDB == 'diretor_uo' 
    || this.$store.state.user.roleDB == 'ctc' || this.$store.state.user.roleDB == 'secretariado_direcao' || 
    this.$store.state.user.roleDB == 'recursos_humanos' )"
      >
        <label>Parecer sobre a proposta do Diretor da Unidade Orgânica: {{ propostaSelecionada.parecer }}</label>
        <br />
      </div>
      <div
        v-if="propostaSelecionada.proposta_ctc_id != null &&
        (this.$store.state.user.roleDB == 'ctc'
        || this.$store.state.user.roleDB == 'secretariado_direcao' 
        || this.$store.state.user.roleDB == 'recursos_humanos')"
      >
        <label>Votos a favor do Conselho Tecnico-Cientifico: {{ propostaSelecionada.votos_a_favor }}</label>
        <br />
        <label>Votos contra do Conselho Tecnico-Cientifico: {{ propostaSelecionada.votos_contra }}</label>
        <br />
        <label>Votos brancos do Conselho Tecnico-Cientifico: {{ propostaSelecionada.votos_brancos }}</label>
        <br />
        <label>Votos nulos do Conselho Tecnico-Cientifico: {{ propostaSelecionada.votos_nulos }}</label>
        <br />
        <b-form-group label="Ata CTC">
          <b-button
            size="md"
            variant="dark"
            v-if="ataCTC"
            @click="downloadFicheiro(ataCTC.proposta_id, 'Ata do CTC')"
          >
            <i class="far fa-file-pdf"></i> Ata do CTC
          </b-button>
        </b-form-group>
      </div>

      <div
        v-if="propostaSelecionada.proposta_recursos_humanos_id != null &&
      this.$store.state.user.roleDB == 'recursos_humanos'"
      >
        <label>Remuneração: {{ propostaSelecionada.remuneracao }}</label>
        <br />
        <label>Índice: {{ propostaSelecionada.indice }}</label>
        <br />
        <label>Escalão: {{ propostaSelecionada.escalao }}</label>
        <br />
        <label>Número do funcionário dos Recursos Humanos: {{ propostaSelecionada.numero_funcionario }}</label>
        <br />
        <label>Inscrição (CGA ou SS): {{ propostaSelecionada.inscricao }}</label>
        <br />
        <label>Despacho Sr. Presidente do IPL: {{ propostaSelecionada.despacho_presidente_ipl }}</label>
        <br />
        <label>NISS ou nº CGA: {{ propostaSelecionada.NISS_ou_numero_CGA }}</label>
        <br />
        <label>Data de nascimento: {{ propostaSelecionada.data_nascimento }}</label>
        <br />
        <label>Número Cartão de Cidadão: {{ propostaSelecionada.numeroCC }}</label>
        <br />
        <label>Email RH: {{ propostaSelecionada.email_recursos_humanos }}</label>
        <br />
        <label>Dados carregados no GIAF por: {{ propostaSelecionada.dados_GIAF_carregados_por }}</label>
        <br />
        <label>Data de carregamento de dados no GIAF: {{ propostaSelecionada.data_carregamento_dados_GIAF }}</label>
        <br />

        <b-button size="md" variant="dark" @click="exportarPDF()">
          <i class="far fa-file-pdf"></i> Exportar para PDF
        </b-button>
      </div>
    </div>
    <fundamentacao-departamento
      v-if="this.$store.state.user.roleDB == 'proponente_departamento' &&
      this.propostaSelecionada.fundamentacao_coordenador_departamento == null"
      :propostaSelecionada="propostaSelecionada"
    ></fundamentacao-departamento>

    <fundamentacao-curso
      v-if="this.$store.state.user.roleDB == 'proponente_curso' &&
            this.propostaSelecionada.fundamentacao_coordenador_curso == null"
      :propostaSelecionada="propostaSelecionada"
    ></fundamentacao-curso>

    <diretor
      v-if="this.$store.state.user.roleDB == 'diretor_uo' && this.propostaSelecionada.proposta_diretor_uo_id == null"
      :propostaSelecionada="propostaSelecionada"
    ></diretor>
    <ctc
      v-if="propostaSelecionada.proposta_ctc_id == null && this.$store.state.user.roleDB == 'ctc'"
      :propostaSelecionada="propostaSelecionada"
    ></ctc>
    <proposta-secretariado
      v-if="propostaSelecionada.proposta_secretariado_direcao_id == null &&this.$store.state.user.roleDB == 'secretariado_direcao'"
      :propostaSelecionada="propostaSelecionada"
    ></proposta-secretariado>
    <proposta-recursos
      v-if="propostaSelecionada.proposta_recursos_humanos_id == null && this.$store.state.user.roleDB == 'recursos_humanos'"
      :propostaSelecionada="propostaSelecionada"
    ></proposta-recursos>
  </div>
</template>
<script>
export default {
  props: ["propostaSelecionada"],
  data() {
    return {
      tipoPropostaRole: [],
      ucsDaPropostaSelecionada: [],
      ficheiros: [],
      ficheiroCurriculo: "",
      ficheiroRelatorioProponentes: "",
      ficheiroCertificadoHabilitacoes: "",
      ataCTC: "",
      propostaID: ""
    };
  },
  methods: {
    voltarProponentes() {
      this.$emit("mostrar-proponentes");
    },
    voltarDiretor() {
      this.$emit("mostrar-diretor");
    },
    voltarCTC() {
      this.$emit("mostrar-ctc");
    },
    voltarSecretariado() {
      this.$emit("mostrar-secretariado");
    },
    voltarRecursosHumanos() {
      this.$emit("mostrar-recursos");
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
    exportarPDF() {
      var doc = new jsPDF();
      doc.fromHTML($("#proposta").get(0), 20, 20);
      doc.save("proposta.pdf");
    }
  },
  mounted() {
    axios
      .get(
        "/api/propostaDePropostaProponente/" +
          this.propostaSelecionada.id_proposta_proponente
      )
      .then(response => {
        this.propostaID = response.data[0].id;
        axios.get("/api/ficheiros/" + this.propostaID).then(response => {
          this.ficheiros = response.data;
          this.ficheiroRelatorioProponentes = this.ficheiros[0];
          this.ficheiroCurriculo = this.ficheiros[1];
          this.ficheiroCertificadoHabilitacoes = this.ficheiros[2];
          this.ataCTC = this.ficheiros[3];
        });
      });
    axios
      .get(
        "/api/diretorUO/getPropostaProponente/" +
          this.propostaSelecionada.role +
          "/" +
          this.propostaSelecionada.id_proposta_proponente
      )
      .then(response => {
        this.tipoPropostaRole = response.data;
      });

    axios
      .get(
        "api/diretorUO/getUCSPropostaSelecionada/" +
          this.propostaSelecionada.id_proposta_proponente
      )
      .then(response => {
        this.ucsDaPropostaSelecionada = response.data;
      });
  }
};
</script>