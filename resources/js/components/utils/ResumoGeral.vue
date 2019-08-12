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
      <label><strong>Unidade Orgânica:</strong> {{ propostaSelecionada.unidade_organica }}</label>
      <br />
      <label><strong>Nome do Docente:</strong> {{ propostaSelecionada.nome_completo}}</label>
      <br />
      <label><strong>Tipo de Contratação:</strong> {{ propostaSelecionada.tipo_contrato }}</label>
      <br />
      <label><strong>Email do docente:</strong> {{ propostaSelecionada.email }}</label>
      <br />
      <label><strong>Número de telefone do docente:</strong> {{ propostaSelecionada.numero_telefone }}</label>
      <br />
      <label><strong>Unidades Curriculares:</strong></label>
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
      <label><strong>Grau de Habilitações Académicas:</strong> {{ propostaSelecionada.grau }}</label>
      <br />
      <label><strong>Área Científica: </strong>{{ propostaSelecionada.area_cientifica }}</label>
      <br />
      <label><strong>Curso:</strong> {{ propostaSelecionada.curso }}</label>
      <br />
      <label><strong>Papel a desempenhar:</strong> {{ propostaSelecionada.role }}</label>
      <br />
      <div v-if="propostaSelecionada.role == 'professor'">
        <label><strong>Categoria de professor:</strong> {{ tipoPropostaRole.role_professor }}</label>
        <br />
        <label><strong>Regime de prestação de serviços:</strong> {{ tipoPropostaRole.regime_prestacao_servicos }}</label>
        <br />
        <label><strong>Percentagem de prestação de serviços:</strong> {{ tipoPropostaRole.percentagem_prestacao_servicos }}</label>
        <br />
        <label><strong>Período: </strong>{{ tipoPropostaRole.periodo }}</label>
        <br />
        <label><strong>Duração:</strong> {{ tipoPropostaRole.duracao }}</label>
        <br />
      </div>

      <label><strong>Fundamentação do Coordenador de Curso:</strong> {{ propostaSelecionada.fundamentacao_coordenador_curso }}</label>
      <br />
      <label><strong>Fundamentação do Coordenador de Departamento:</strong> {{ propostaSelecionada.fundamentacao_coordenador_departamento }}</label>
      <b-form-group>
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroCurriculo"
          @click="downloadFicheiro(ficheiroCurriculo.proposta_id, 'Curriculo do docente a ser contratado')"
        >
          <i class="far fa-file-pdf"></i> Clique para ver o currículo do docente proposto
        </b-button>
      </b-form-group>
      <b-form-group>
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroCertificadoHabilitacoes"
          @click="downloadFicheiro(ficheiroCertificadoHabilitacoes.proposta_id, 'Habilitacoes do docente a ser contratado')"
        >
          <i class="far fa-file-pdf"></i>Clique aqui para ver o certificado de habilitações do docente proposto
        </b-button>
      </b-form-group>
      
      <b-form-group>
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroRelatorioProponentes"
          @click="downloadFicheiro(ficheiroRelatorioProponentes.proposta_id, 'Relatorio dos 2 proponentes')"
        >
          <i class="far fa-file-pdf"></i> Clique aqui para ver o relatório dos proponentes
        </b-button>
      </b-form-group>
      
      <div
        v-if="propostaSelecionada.proposta_diretor_uo_id != null &&(this.$store.state.user.roleDB == 'diretor_uo' 
    || this.$store.state.user.roleDB == 'ctc' || this.$store.state.user.roleDB == 'secretariado_direcao' || 
    this.$store.state.user.roleDB == 'recursos_humanos' )"
      >
        <label><strong>Parecer sobre a proposta do Diretor da Unidade Orgânica: </strong>{{ propostaSelecionada.parecer }}</label>
        <br />
      </div>
      <div
        v-if="propostaSelecionada.proposta_ctc_id != null &&
        (this.$store.state.user.roleDB == 'ctc'
        || this.$store.state.user.roleDB == 'secretariado_direcao' 
        || this.$store.state.user.roleDB == 'recursos_humanos')"
      >
        <label><strong>Votos a favor do Conselho Tecnico-Cientifico:</strong> {{ propostaSelecionada.votos_a_favor }}</label>
        <br />
        <label><strong>Votos contra do Conselho Tecnico-Cientifico: </strong>{{ propostaSelecionada.votos_contra }}</label>
        <br />
        <label><strong>Votos brancos do Conselho Tecnico-Cientifico:</strong> {{ propostaSelecionada.votos_brancos }}</label>
        <br />
        <label><strong>Votos nulos do Conselho Tecnico-Cientifico:</strong> {{ propostaSelecionada.votos_nulos }}</label>

        <b-button
          size="md"
          variant="dark"
          v-if="ataCTC"
          @click="downloadFicheiro(ataCTC.proposta_id, 'Ata do CTC')"
        >
          <i class="far fa-file-pdf"></i> Ata do CTC
        </b-button>
      </div>

      <div
        v-if="propostaSelecionada.proposta_recursos_humanos_id != null &&
      this.$store.state.user.roleDB == 'recursos_humanos'"
      >
        <label><strong>Remuneração: </strong>{{ propostaSelecionada.remuneracao }} €</label>
        <br />
        <label><strong>Índice: </strong>{{ propostaSelecionada.indice }}</label>
        <br />
        <label><strong>Escalão: </strong>{{ propostaSelecionada.escalao }}</label>
        <br />
        <label><strong>Número do funcionário dos Recursos Humanos: </strong>{{ propostaSelecionada.numero_funcionario }}</label>
        <br />
        <label><strong>Inscrição (CGA ou SS): </strong>{{ propostaSelecionada.inscricao }}</label>
        <br />
        <label><strong>Despacho Sr. Presidente do IPL: </strong>{{ propostaSelecionada.despacho_presidente_ipl }}</label>
        <br />
        <label><strong>NISS ou nº CGA:</strong> {{ propostaSelecionada.NISS_ou_numero_CGA }}</label>
        <br />
        <label><strong>Data de nascimento:</strong> {{ propostaSelecionada.data_nascimento }}</label>
        <br />
        <label><strong>Número Cartão de Cidadão:</strong> {{ propostaSelecionada.numeroCC }}</label>
        <br />
        <label><strong>Email RH: </strong>{{ propostaSelecionada.email_recursos_humanos }}</label>
        <br />
        <label><strong>Dados carregados no GIAF por: </strong>{{ propostaSelecionada.dados_GIAF_carregados_por }}</label>
        <br />
        <label><strong>Data de carregamento de dados no GIAF: </strong>{{ propostaSelecionada.data_carregamento_dados_GIAF }}</label>
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
      v-if=" this.$store.state.user.roleDB == 'recursos_humanos'"
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
      doc.save("Proposta Contratação " + this.propostaSelecionada.nome_completo+".pdf");
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